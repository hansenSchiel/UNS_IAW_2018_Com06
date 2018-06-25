@extends('layouts.base')
@section('contenido')
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>{{ $user->name }}</h2>

        </div>
    </div>              
     <!-- /. ROW  -->
     <hr />
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Librerias
                </div>
                <div class="panel-body">
                    <a href="https://laravel.com/docs/5.6" target="_blank">
                        Info general de Lavavel
                    </a><br>
                    <a href="https://www.youtube.com/watch?v=Zj0pshSSlEo" target="_blank">
                        Video curso Laravel con mysql
                    </a><br>
                    
                    <a href="https://appdividend.com/2017/07/21/laravel-5-twitter-login/" target="_blank">
                    Login con twitter
                    </a><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection