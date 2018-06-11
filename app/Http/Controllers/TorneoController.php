<?php

namespace ProdeIAW\Http\Controllers;

use Illuminate\Http\Request;
use ProdeIAW\routes\routes;
use ProdeIAW\Torneo;
use ProdeIAW\Equipo;
use ProdeIAW\Grupo;
use ProdeIAW\Encuentro;
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
    	return view('torneo.show',[
    		'torneo'=>Torneo::findOrFail($id)
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
            return Redirect::to('torneo');
        }
        if($torneo->step == 1){
            if($request->get('siguiente')=="ok"){
                $torneo->step = 2;
                $this->crearEncuentros($torneo);
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
    	$torneo = Torneo::findOrFail($id);
    	$torneo->condicion = 0;
    	$torneo->update();
    	return Redirect::to('torneo');
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
            foreach ($grupo->equipos as $i => $equipo1) {
                foreach ($grupo->equipos as $j => $equipo2) {
                    if($i<$j){
                        $encuentro = new Encuentro;
                        $encuentro->id = str_random(32);
                        $encuentro->fecha = 1;
                        $encuentro->equipoL_id = $equipo1->id;
                        $encuentro->equipoV_id = $equipo2->id;
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
}
