<?php

namespace ProdeIAW\Http\Controllers;

use ProdeIAW\User;
use Auth;


class GeneralController extends Controller
{




    public function readme(){
    	return view('layouts.readme');
    }

    public function show($id){
    	return view('user.show',['user'=>User::findOrFail($id)]);
    }
}
