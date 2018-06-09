<?php

namespace ProdeIAW\Http\Controllers;

use Illuminate\Http\Request;
use ProdeIAW\routes\routes;
use ProdeIAW\Torneo;
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


    		$torneos = DB::table('torneos')->where('nombre','LIKE','%'.$query.'%')
    		->where('condicion','=','1')
    		->orderBy('nombre','asc')
    		->paginate(15);

            $torneos = Torneo::where('condicion', 1)
               ->orderBy('nombre', 'desc')
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
    	$torneo = new Torneo;
    	$torneo->nombre = $request->get('nombre');
    	$torneo->descripcion = $request->get('descripcion');
    	$torneo->id = str_random(32);
        $torneo->condicion = true;
    	$torneo->save();


        return view('torneo.edit',[
            'torneo'=>$torneo
        ]);
    }

    public function show($id){
    	return view('torneo.show',[
    		'torneo'=>Torneo::findOrFail($id)
    	]);
    }

    public function edit($id){
    	return view('torneo.edit',[
    		'torneo'=>Torneo::findOrFail($id)
    	]);
    }

    public function update(TorneoFormRequest $request,$id){
    	$torneo = Torneo::findOrFail($id);
    	$torneo->nombre = $request->get('nombre');
    	$torneo->descripcion = $request->get('descripcion');
    	$torneo->update();
    	return Redirect::to('torneo');
    }
    
    public function destroy($id){
    	$torneo = Torneo::findOrFail($id);
    	$torneo->condicion = 0;
    	$torneo->update();
    	return Redirect::to('torneo');
    }
}
