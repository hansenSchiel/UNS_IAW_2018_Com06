<?php

namespace ProdeIAW\Http\Controllers;

use Illuminate\Http\Request;
use ProdeIAW\routes\routes;
use ProdeIAW\Torneo;
use ProdeIAW\Equipo;
use ProdeIAW\Grupo;
use ProdeIAW\Encuentro;
use ProdeIAW\Fecha;
use ProdeIAW\User;
use ProdeIAW\Participacion;
use ProdeIAW\Pronostico;
use Illuminate\Support\Facades\Redirect;
use ProdeIAW\Http\Requests\TorneoFormRequest;
use DB;

class TorneoController extends Controller
{
    public function __construct(){

    }
    public function index(Request $request){
    	if($request){
    		$query = trim($request->get('searchText'));
            $torneos = Torneo::where('condicion', 1)
               ->orderBy('fechaInicio', 'asc')
               ->take(10)
               ->get();

            foreach ($torneos as $key => $torneo) {
            }
    		return view('torneo.index',[
    			'torneos'=>$torneos,
    			'searchText'=>$query,
    		]);
    	}
    }

    public function create(){
    	return view('torneo.create');
    }

    public function store(TorneoFormRequest $request){
        $step = $request->get('step');
        if($step == 1){
        	$torneo = new Torneo;
        	$torneo->nombre = $request->get('nombre');
        	$torneo->descripcion = $request->get('descripcion');
            $torneo->fechaInicio = $request->get('fechaInicio');
            $torneo->fechaFin = $request->get('fechaFin');
            $torneo->deporte = $request->get('deporte');
            $torneo->cantGrupos = $request->get('cantGrupos');
        	$torneo->id = str_random(32);
            $torneo->condicion = true;
            $this->crearGrupos($torneo);

        	$torneo->save();
        }

        return $this->edit($torneo->id);
    }

    public function show($id){
        $torneo = Torneo::findOrFail($id);
        $grupos = [];
        foreach ($torneo->grupos->sortBy('nombre') as $key => $grupo) {
            $controler = new EncuentroController;
            $grupos[$grupo->nombre] = $controler->getClasificados($grupo);
        }


    	return view('torneo.show',[
    		'torneo'=> $torneo,
            'grupos'=> $grupos,
    	]);
    }

    public function back($id){
        $torneo = Torneo::findOrFail($id);
        $torneo->step = $torneo->step-1;
        $torneo->update();

        return $this->edit($torneo->id);
    }
    public function edit($id){
        $torneo = Torneo::findOrFail($id);
        $params = [];
        $params['torneo']=$torneo;
        if($torneo->step == 0){

        }

        if($torneo->step == 1){
            $equiposT = Equipo::where('condicion', 1)
               ->orderBy('nombre', 'asc')
               ->get();



            $equiposU = DB::table('equipos')
                ->join('participa', 'equipos.id', '=', 'participa.equipo_id')
                ->join('grupos', 'grupos.id', '=', 'participa.grupo_id')
                ->join('torneos', 'torneos.id', '=', 'grupos.torneo_id')
                ->where('torneos.id','=',$id)
                ->select('equipos.*')
                ->get();

            $equipos = $equiposT->filter(function ($value, $key) use ($equiposU) {
                
                if($equiposU->contains('id',$value->id)){
                    return false;
                }else{
                    return true;
                }
            });

            $params['equipos']=$equipos;
        }

        if($torneo->step == 2){

        }
    	return view('torneo.edit'.$torneo->step,$params);
    }

    public function update(TorneoFormRequest $request,$id){
    	$torneo = Torneo::findOrFail($id);
        if($torneo->step == 2){
            $this->editarFechas($torneo);
            return Redirect::to('torneo');
        }
        if($torneo->step == 1){
            if($request->get('siguiente')=="ok"){
                $torneo->step = 2;
                $this->crearEncuentros($torneo);
                $this->crearFechas($torneo);
                $torneo->update();
            }
            if($request->get('grupo')){

                $grupoId = $request->get('grupo');
                $equipoId = $request->get('equipo');
                $grupo = Grupo::findOrFail($grupoId);
                $equipo = Equipo::findOrFail($equipoId);

                if($request->get('mode')=="add"){
                    if($grupo->equipos->contains($equipo)){
                        return $this->edit($torneo->id)
                            ->withErrors(['equipo_duplicado' => 'Equipo duplicado en grupo']);
                    }   
                    $grupo->equipos()->attach($equipo);
                }else{
                    $grupo->equipos()->detach($equipo);
                }
            }
        }
        if($torneo->step == 0){
            $torneo->nombre = $request->get('nombre');
            $torneo->descripcion = $request->get('descripcion');
            $torneo->fechaInicio = $request->get('fechaInicio');
            $torneo->fechaFin = $request->get('fechaFin');
            $torneo->deporte = $request->get('deporte');
            $torneo->descripcion = $request->get('descripcion');
            $torneo->cantGrupos = $request->get('cantGrupos');
            $torneo->step = 1;
            $this->crearGrupos($torneo);
            $torneo->update();
        }
        return $this->edit($torneo->id);
    }
    
    public function destroy($id){
        echo $id;
    	$torneo = Torneo::findOrFail($id)->delete();
    	return Redirect::to('torneo');
    }


    public function editarFechas($torneo){        
        foreach ($torneo->fechas as $key => $fecha) {
            $fecha->fechaInicio = null;
            $fecha->fechaFin = null;
            foreach($fecha->encuentros as $encuentro){
                if($fecha->fechaInicio ==null ||$fecha->fechaInicio>$encuentro->dia){
                    $fecha->fechaInicio = $encuentro->dia;
                }
                if($fecha->fechaFin == null ||$fecha->fechaFin<$encuentro->dia){
                    $fecha->fechaFin = $encuentro->dia;
                }
            }
            $fecha->update();
        }
    }

    public function crearFechas($torneo){        
        Fecha::where('torneo_id', $torneo->id)->delete();
        $fechas = [];
        foreach ($torneo->encuentros as $key => $encuentro) {
            if(!array_key_exists($encuentro->fecha ,$fechas)){
                $fechas[$encuentro->fecha]=[];
            }
            $fechas[$encuentro->fecha][]=$encuentro;
        }
        foreach ($fechas as $key => $value) {
            $fecha = new Fecha;
            $fecha->nombre = $key;
            $fecha->torneo_id = $torneo->id;
            $fecha->fechaInicio = null;
            $fecha->fechaFin = null;
            $fecha->id = str_random(32);
            foreach($value as $encuentro){
                if($fecha->fechaInicio ===null ||$fecha->fechaInicio>$encuentro->dia){
                    $fecha->fechaInicio = $encuentro->dia;
                }
                if($fecha->fechaFin === null ||$fecha->fechaFin<$encuentro->dia){
                    $fecha->fechaFin = $encuentro->dia;
                }
                $fecha->save();
                $encuentro->fecha_id=$fecha->id;
                $encuentro->save();
            }
            $fecha->save();
        }
    }

    function scheduler($teams){
        if (count($teams)%2 != 0){
            array_push($teams,null);
        }
        $away = array_splice($teams,(count($teams)/2));
        $home = $teams;
        for ($i=0; $i < count($home)+count($away)-1; $i++){
            for ($j=0; $j<count($home); $j++){
                $round[$i][$j]["L"]=$home[$j];
                $round[$i][$j]["V"]=$away[$j];
            }
            if(count($home)+count($away)-1 > 2){
                $a = array_splice($home,1,1);
                array_unshift($away,array_shift($a));
                array_push($home,array_pop($away));
            }
        }
        return $round;
    }



    public function crearGrupos($torneo){
        $grupos = Grupo::where('torneo_id', $torneo->id)
               ->get();

        if(sizeOf($grupos)==$torneo->cantGrupos)
            return;
        foreach ($grupos as $grupo) {
            foreach ($grupo->equipos as $equipo) {
                $equipo->pivot->delete();
            }
        }
        Grupo::where('torneo_id', $torneo->id)->delete();

        $letras = ["A","B","C","D","E","F","G","H"];
        for ($i = 0; $i < $torneo->cantGrupos; $i++) { 
            $grupo = new Grupo;
            $grupo->nombre = $letras[$i];
            $grupo->torneo_id = $torneo->id;
            $grupo->id = str_random(32);
            $grupo->save();
        }
    }


    public function crearEncuentros($torneo){
        Encuentro::where('torneo_id', $torneo->id)->delete();
        foreach($torneo->grupos as  $grupo){
            $fechasF = $this->scheduler($grupo->equipos->toArray());
            foreach($fechasF AS $round => $games){
                foreach($games AS $play){
                    if($play["L"]!=null && $play["V"]!=null){
                        $encuentro = new Encuentro;
                        $encuentro->id = str_random(32);
                        $encuentro->fecha = $round+1;
                        $encuentro->equipoL_id = $play["L"]['id'];
                        $encuentro->equipoV_id = $play["V"]['id'];
                        $encuentro->torneo_id = $torneo->id;
                        $encuentro->dia = today();
                        $encuentro->puntosL = -1;
                        $encuentro->puntosV = -1;
                        $encuentro->ident = $grupo->nombre;
                        $encuentro->save();
                    }
                }
            }
        }
    }


    public function crearEjemplo(){
        $torneos = Torneo::get();

        $torneo = new Torneo;
        $torneo->nombre = "Torneo Ejemplo (".sizeOf($torneos).")";
        $torneo->deporte = "Futbol";
        $torneo->cantGrupos = 8;
        $torneo->fechaInicio = "15/06/18";
        $torneo->fechaFin = "15/07/18";
        $torneo->step = 2;
        $torneo->descripcion = "Torneo creado automáticamente";
        $torneo->id = str_random(32);
        $torneo->condicion = true;
        $torneo->save();
        $this->crearGrupos($torneo);

        $equipos = Equipo::get();
        if (sizeOf($equipos)<32)
            return;

        $equiposP = $equipos->chunk(4);

        foreach ($torneo->grupos as $key => $grupo) {
            foreach ($equiposP[$key] as $equipo) {
                $grupo->equipos()->attach($equipo);
            }
        }


        $this->crearEncuentros($torneo);
        $this->crearFechas($torneo);
        $this->crearPredicciones($torneo);
        $this->crearResultados($torneo);
        return Redirect::to('torneo');
    }

    public function crearPredicciones($torneo){
        $users = User::get();
        foreach ($torneo->fechas as $fecha) {
            foreach ($users as $user) {
                $participacion = new Participacion;
                $participacion->id = str_random(32);
                $participacion->fecha_id = $fecha->id;
                $participacion->user_id = $user->id;
                $participacion->save();
                foreach ($fecha->encuentros as $encuentro) {
                    $pronostico = new Pronostico;
                    $pronostico->participacion_id = $participacion->id;
                    $pronostico->ganador = rand(0,1);
                    $pronostico->encuentro_id = $encuentro->id;
                    $pronostico->id = str_random(32);
                    $pronostico->save();
                }
            }
        }
    }
    public function crearResultados($torneo){
        $users = User::get();
        foreach ($torneo->encuentros as $encuentro) {
            $encuentro->puntosL = rand(0,6);
            $encuentro->puntosV = rand(0,6);
            $encuentro->save();
        }
    }
}
