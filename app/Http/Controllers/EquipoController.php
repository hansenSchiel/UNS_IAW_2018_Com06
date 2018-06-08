<?php

namespace ProdeIAW\Http\Controllers;

use Illuminate\Http\Request;
use ProdeIAW\routes\routes;
use ProdeIAW\Equipo;
use Illuminate\Support\Facades\Redirect;
use ProdeIAW\Http\Requests\EquipoFormRequest;
use DB;

class EquipoController extends Controller
{
    public function __construct(){

    }
    public function index(Request $request){
    	if($request){
    		$query = trim($request->get('searchText'));
    		$equipos = DB::table('equipos')->where('nombre','LIKE','%'.$query.'%')
    		->where('condicion','=','1')
    		->orderBy('nombre','asc')
    		->paginate(15);

    		return view('equipo.index',[
    			'equipos'=>$equipos,
    			'searchText'=>$query,
    		]);
    	}
    }

    public function create(){
    	return view('equipo.create');
    }

    public function store(EquipoFormRequest $request){
    	$equipo = new Equipo;
    	$equipo->nombre = $request->get('nombre');
    	$equipo->descripcion = $request->get('descripcion');
    	$equipo->id = str_random(32);
        $equipo->condicion = true;
    	$equipo->save();
    	return Redirect::to('equipo');
    }

    public function show($id){
    	return view('equipo.show',[
    		'equipo'=>Equipo::findOrFail($id)
    	]);
    }

    public function edit($id){
    	return view('equipo.edit',[
    		'equipo'=>Equipo::findOrFail($id)
    	]);
    }

    public function update(EquipoFormRequest $request,$id){
    	$equipo = Equipo::findOrFail($id);
    	$equipo->nombre = $request->get('nombre');
    	$equipo->descripcion = $request->get('descripcion');
    	$equipo->update();
    	return Redirect::to('equipo');
    }
    
    public function destroy($id){
    	$equipo = Equipo::findOrFail($id);
    	$equipo->condicion = 0;
    	$equipo->update();
    	return Redirect::to('equipo');
    }
}
