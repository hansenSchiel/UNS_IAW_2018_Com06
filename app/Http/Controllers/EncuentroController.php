<?php

namespace ProdeIAW\Http\Controllers;

use Illuminate\Http\Request;
use ProdeIAW\routes\routes;
use ProdeIAW\Encuentro;
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
        $encuentro->fecha = $request->get('fecha');
    	$encuentro->update();
    	return redirect()->action(
            'TorneoController@edit', ['id'=>$encuentro->torneo_id]
        );
    }
    

}
