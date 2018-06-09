@extends('layouts.base')
@section('contenido')
	<div id="page-wrapper" ng-app = "torneo" ng-controller = "TorneosController" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Torneos</h2>   
	                    <div class="col-lg-4 col-md-4">
	                        <a href="/torneos/register" class="btn btn-primary">Nuevo Torneo</a>
	                    </div>
                </div>
            </div>              
             <!-- /. ROW  -->
             <hr />
            <div class="row" >
            	@foreach ($torneos as $index => $torneo)
                <div class="col-lg-4 col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a class="hlink" href="/torneos/{{ $torneo->id }}">{{ $torneo->nombre }} <span> (En Edicion)</span></a>
                        </div>
                        <div class="panel-body">
                            Fecha Inicio:  {{ $torneo->fechaInicio }}<br>
                            Fecha Fin: {{ $torneo->fechaFin }}<br>
                            Cant Grupos: {{ sizeof($torneo->grupos) }}<br>
                            Fechas: {{ sizeOf($torneo->fechas) }}<br>
                            Cant Encuentros: {{ sizeOf($torneo->encuentros) }}<br>
                        </div>
                    </div>
                </div>
				@endforeach
            </div>
        </div>
         <!-- /. PAGE INNER  -->
    </div>
@endsection