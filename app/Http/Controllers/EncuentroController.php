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
        $this->crearCruces($encuentro);
    	return redirect()->action(
            'TorneoController@edit', ['id'=>$encuentro->torneo_id]
        );
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
                    ->where('tipo',$fase)
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
        $grupos = $torneo->grupos->sortBy('nombre')->all();
        for($i = 0;$i<sizeOf($grupos);$i+=2){
            $grupo1 = $grupos[$i];
            $grupo2 = $grupos[$i+1];


            // Genero los encuentros. Puede ser octavo, cuartos o semis, segun la cantidad de grupos
            $fecha = new Fecha;
            $fecha->nombre = sizeOf($torneo->fechas)+1;
            $fecha->torneo_id = $torneo->id;
            $fecha->fechaInicio = today();
            $fecha->fechaFin = today();
            $fecha->tipo = $fase;
            $fecha->id = str_random(32);

            $fecha->save();

            $gan1 = $this->getClasificados($grupo1);
            $gan2 = $this->getClasificados($grupo2);
            $this->crearEncuentro($torneo,$fase,$i,$gan1[0][0],$gan2[1][0],$fecha);
            $this->crearEncuentro($torneo,$fase,$i+1,$gan2[0][0],$gan1[1][0],$fecha);
        }
    }




    public function getClasificados($grupo){
        $encuentros1 = Encuentro::where('torneo_id',$grupo->torneo->id)
                    ->where('ident',$grupo->nombre)
                    ->get();

        $jugados = true;

        foreach ($grupo->equipos as $equipo) {
            $puntos[$equipo->id] = [$equipo,'p'=>0,'g'=>0];
        }
        foreach ($encuentros1 as $key => $encuentro) {
            if($encuentro->puntosV == -1){
                $jugados = false;
            }else{
                $puntos[$encuentro->equipoV->id]['g'] += $encuentro->puntosV-$encuentro->puntosL;
                $puntos[$encuentro->equipoL->id]['g'] += $encuentro->puntosL-$encuentro->puntosV;
                if($encuentro->puntosL > $encuentro->puntosV){
                    $puntos[$encuentro->equipoL->id]['p'] += 3;
                }
                if($encuentro->puntosL < $encuentro->puntosV){
                    $puntos[$encuentro->equipoV->id]['p'] += 3;
                }
                if($encuentro->puntosL == $encuentro->puntosV){
                    $puntos[$encuentro->equipoV->id]['p'] += 1;
                    $puntos[$encuentro->equipoL->id]['p'] += 1;
                }
            }
        }

        if($jugados == false){
            return null;
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
