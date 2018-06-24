<?php

namespace ProdeIAW\Http\Controllers;

use Illuminate\Http\Request;
use ProdeIAW\routes\routes;
use ProdeIAW\Encuentro;
use ProdeIAW\Fecha;
use Illuminate\Support\Facades\Redirect;
use ProdeIAW\Http\Requests\EncuentroFormRequest;
use DB;

class EncuentroController extends Controller
{
    public function __construct(){

    }

    public function show($id){
    	return view('encuentro.show',[
    		'encuentro'=>Encuentro::findOrFail($id)
    	]);
    }

    public function update(EncuentroFormRequest $request,$id){
    	$encuentro = Encuentro::findOrFail($id);
    	$encuentro->puntosL = $request->get('puntosL');
        $encuentro->puntosV = $request->get('puntosV');
        $encuentro->dia = $request->get('dia');
        //$encuentro->fecha = $request->get('fecha');
        $encuentro->update();
        $this->buscarGanador($encuentro);
        $this->crearCruces($encuentro);
        $this->crearCruces2($encuentro);
    	return redirect()->action(
            'TorneoController@edit', ['id'=>$encuentro->torneo_id]
        );
    }
    
    public function crearCruces2($encuentro){
        // Si el encuentro corresponde a fase de grupos o a la final, no se ejecuta
        if($encuentro->tipo=='F'){
            if($encuentro->ident==0){
                $ganador = $encuentro->equipoL;
                if($encuentro->puntosL<$encuentro->puntosV)
                    $ganador = $encuentro->equipoV;
                $encuentro->torneo->ganador_id = $ganador->id;
                $encuentro->torneo->update();
                return;
            }else{
                return;
            }
        }
        if($encuentro->tipo=='G'){
            return;
        }

        $torneo = $encuentro->torneo;

        $encuentros = Encuentro::where('torneo_id',$torneo->id)
                        ->where('tipo',$encuentro->tipo)
                        ->get();

        // Si hay algun partido sin resultado o empatado (no se podría), no se ejecuta
        foreach ($encuentros as $key => $enc) {
            if($enc->puntosL == -1 || $enc->puntosL == $enc->puntosV){
                return;
            }
        }


        // A partir de aca, asumo que se tienen los resultados de todos los encuentros de la fase
        $faseSig = ['O'=>'C','C'=>'S','S'=>'F'];
        $fase = $faseSig[$encuentro->tipo];
        //Se borran todos los partidos de la fase siguiente
        $fechaFD = Fecha::where('torneo_id',$torneo->id)
                    ->where('tipo',$fase)
                    ->get();

        foreach ($fechaFD as $key => $value) {
            $value->delete();
        }

        $fecha = new Fecha;
        $fecha->nombre = sizeOf($torneo->fechas)+1;
        $fecha->torneo_id = $torneo->id;
        $fecha->fechaInicio = today();
        $fecha->fechaFin = today();
        $fecha->tipo = $fase;
        $fecha->id = str_random(32);
        $fecha->save();



        $encs = $encuentros->sortBy('ident')->values()->all();

        if($fase == 'F'){
            $ganador1 = $encs[0]->equipoL;
            $ganador2 = $encs[1]->equipoL;
            $perdedor1 = $encs[0]->equipoV;
            $perdedor2 = $encs[1]->equipoV;
            if($encs[0]->puntosV>$encs[0]->puntosL){
                $ganador1 = $encs[0]->equipoV;
                $perdedor1 = $encs[0]->equipoL;
            }
            if($encs[1]->puntosV>$encs[1]->puntosL){
                $ganador2 = $encs[1]->equipoV;
                $perdedor2 = $encs[1]->equipoL;
            }
            $this->crearEncuentro($torneo,$fase,0,$ganador1,$ganador2,$fecha);
            $this->crearEncuentro($torneo,$fase,1,$perdedor1,$perdedor2,$fecha);
        }else{
            for($i=0;$i<sizeOf($encs);$i+=4){
                for($j=0;$j<2;$j++){
                    $ganador1 = $encs[$i+$j]->equipoL;
                    $ganador2 = $encs[$i+$j+2]->equipoL;
                    if($encs[$i+$j]->puntosV>$encs[$i+$j]->puntosL)
                        $ganador1 = $encs[$i+$j]->equipoV;
                    if($encs[$i+$j+2]->puntosV>$encs[$i+$j+2]->puntosL)
                        $ganador2 = $encs[$i+$j+2]->equipoV;
                    $this->crearEncuentro($torneo,$fase,($i/2)+$j,$ganador1,$ganador2,$fecha);
                }
            }
        }
    }
    public function crearCruces($encuentro){
        //Si el encuentro no corresponde a un partido de la fase de grupos no se ejecuta
        if($encuentro->tipo!='G'){
            return;
        }
        $torneo = $encuentro->torneo;

        $fases = [2=>'S',4=>'C',8=>'O'];
        $fase = $fases[$torneo->cantGrupos];

        $fechaFD = Fecha::where('torneo_id',$torneo->id)
                    ->where('tipo','!=','G')
                    ->get();

        foreach ($fechaFD as $key => $value) {
            $value->delete();
        }

        foreach ($torneo->encuentros as $key => $value) {
            if($value->puntosV == -1){
                return false;
            }
        }
        // Obtengo los ganadores del grupo correspondiente al encuentro y al grupo contrincante
        $grupos = $torneo->grupos->sortBy('nombre')->values()->all();

        $fecha = new Fecha;
        $fecha->nombre = sizeOf($torneo->fechas)+1;
        $fecha->torneo_id = $torneo->id;
        $fecha->fechaInicio = today();
        $fecha->fechaFin = today();
        $fecha->tipo = $fase;
        $fecha->id = str_random(32);
        $fecha->save();

        for($i = 0;$i<sizeOf($grupos);$i+=2){
            $grupo1 = $grupos[$i];
            $grupo2 = $grupos[$i+1];


            // Genero los encuentros. Puede ser octavo, cuartos o semis, segun la cantidad de grupos
            $gan1 = $this->getClasificados($grupo1);
            $gan2 = $this->getClasificados($grupo2);
            $this->crearEncuentro($torneo,$fase,$i,$gan1[0][0],$gan2[1][0],$fecha);
            $this->crearEncuentro($torneo,$fase,$i+1,$gan2[0][0],$gan1[1][0],$fecha);
        }
    }

    public function buscarGanador($enc){
        $fecha = $enc->fechaO;
        $puntos = [];
        foreach ($fecha->participaciones as $participacion) {
            $puntos[$participacion->user->id] = [$participacion->user,'e'=>$participacion,'p'=>0];
        }
        foreach($fecha->encuentros as $encuentro){
            if($encuentro->puntosV == -1){
                return;
            }else{
                foreach ($encuentro->pronosticos as $pronostico) {
                    if(($pronostico->ganador == 0 && $encuentro->puntosL > $encuentro->puntosV)||
                        ($pronostico->ganador == 1 && $encuentro->puntosL < $encuentro->puntosV)){
                        $puntos[$pronostico->participacion->user->id]['p'] += 1;
                    }
                }
            }
        }  

        usort($puntos, function($a,$b){
            $retval = $a['p'] <=> $b['p'];
            if ($retval == 0) {
                $retval = ($a['e']->updated_at <=> $b['e']->updated_at)*-1;
            }
            return $retval*-1;
        });


        if(sizeOf($puntos)>0){
            $fecha->user_id = $puntos[0][0]->id;
            $fecha->update();
        }
    }


    public function getClasificados($grupo){
        $encuentros1 = Encuentro::where('torneo_id',$grupo->torneo->id)
                    ->where('ident',$grupo->nombre)
                    ->get();

        $jugados = true;

        foreach ($grupo->equipos as $equipo) {
            $puntos[$equipo->id] = [$equipo,'p'=>0,'g'=>0,'pp'=>0,'pg'=>0,'pe'=>0];
        }
        foreach ($encuentros1 as $key => $encuentro) {
            if($encuentro->puntosV == -1){
                $jugados = false;
            }else{
                $puntos[$encuentro->equipoV->id]['g'] += $encuentro->puntosV-$encuentro->puntosL;
                $puntos[$encuentro->equipoL->id]['g'] += $encuentro->puntosL-$encuentro->puntosV;
                if($encuentro->puntosL > $encuentro->puntosV){
                    $puntos[$encuentro->equipoL->id]['p'] += 3;
                    $puntos[$encuentro->equipoL->id]['pg'] += 1;
                    $puntos[$encuentro->equipoV->id]['pp'] += 1;
                }
                if($encuentro->puntosL < $encuentro->puntosV){
                    $puntos[$encuentro->equipoV->id]['p'] += 3;
                    $puntos[$encuentro->equipoV->id]['pg'] += 1;
                    $puntos[$encuentro->equipoL->id]['pp'] += 1;
                }
                if($encuentro->puntosL == $encuentro->puntosV){
                    $puntos[$encuentro->equipoV->id]['p'] += 1;
                    $puntos[$encuentro->equipoL->id]['p'] += 1;
                    $puntos[$encuentro->equipoL->id]['pe'] += 1;
                    $puntos[$encuentro->equipoV->id]['pe'] += 1;
                }
            }
        }

        if($jugados == false){
            //return null;
        }


        $toR = [1=>null,2=>null];


        usort($puntos, function($a,$b){
            $retval = $a['p'] <=> $b['p'];
            if ($retval == 0) {
                $retval = $a['g'] <=> $b['g'];
            }
            return $retval*-1;
        });
        return $puntos;
    }


    public function crearEncuentro($torneo,$fase,$ident,$equipo1,$equipo2,$fecha){
        $encuentro = new Encuentro;
        $encuentro->id = str_random(32);
        $encuentro->fecha = $fecha->nombre;
        $encuentro->fecha_id = $fecha->id;
        $encuentro->equipoL_id = $equipo1->id;
        $encuentro->equipoV_id = $equipo2->id;
        $encuentro->torneo_id = $torneo->id;
        $encuentro->dia = today();
        $encuentro->puntosL = -1;
        $encuentro->puntosV = -1;
        $encuentro->ident = $ident;
        $encuentro->tipo = $fase;
        $encuentro->save();
    }
}
