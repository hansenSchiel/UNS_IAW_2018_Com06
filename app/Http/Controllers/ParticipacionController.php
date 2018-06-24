<?php

namespace ProdeIAW\Http\Controllers;

use Illuminate\Http\Request;
use ProdeIAW\routes\routes;
use ProdeIAW\Equipo;
use ProdeIAW\Participacion;
use ProdeIAW\Fecha;
use ProdeIAW\Pronostico;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use ProdeIAW\Http\Requests\ParticipacionFormRequest;


class ParticipacionController extends Controller
{




    public function update(ParticipacionFormRequest $request,$id){


    	foreach( $request->get("pronosticos") as $key => $ganador )
		{
		    $pronostico = Pronostico::findOrFail($key);
		    $pronostico->ganador = $ganador;
		    $pronostico->save();
		    $pronostico->participacion->touch();
		}
    	return $this->show($id);
    }




    public function participar($id){

    	$fecha = Fecha::findOrFail($id);
    	$user = Auth::user();

    	$participacion = Participacion::where('fecha_id', $fecha->id)
    									->where('user_id',$user->id)
										->get()->first();

		if($participacion == null){
	    	$participacion = new Participacion;
	    	$participacion->id = str_random(32);
	    	$participacion->fecha_id = $fecha->id;
	    	$participacion->user_id = $user->id;
		    foreach ($fecha->encuentros as $encuentro) {
		    	$pronostico = new Pronostico;
		    	$pronostico->participacion_id = $participacion->id;
		    	$pronostico->ganador = 0;
		    	$pronostico->encuentro_id = $encuentro->id;
		    	$pronostico->id = str_random(32);
		    	$pronostico->save();
		    }
	    	$participacion->save();
	    }

	    

	    return $this->show($participacion->id);
    }

    public function show($id){
    	$participacion = Participacion::findOrFail($id);

    	return view('participacion.show',[
    		'participacion'=> $participacion,
    	]);
    }
}
