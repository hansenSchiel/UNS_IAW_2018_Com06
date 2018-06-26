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
    	@foreach($user->participaciones->sortBy('created_at') as $participacion)
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    {{ $participacion->fecha->torneo->nombre }} - Fecha {{ $participacion->fecha->nombre }}
                </div>
                <div class="panel-body">
                	<table class="table table-striped table-bordered table-hover">
                		<thead>
                			<tr>
                				<th>#</th>
                				<th>Local</th>
                				<th></th>
                				<th>-</th>
                				<th></th>
                				<th>Visitante</th>
                				<th>Prediccion</th>
            				</tr>
                		</thead>
                		<tbody>
                			@foreach($participacion->pronosticos as $key => $pronostico)
                				@php
                				$class = "";
                				if($pronostico->encuentro->puntosL > $pronostico->encuentro->puntosV){
                					if($pronostico->ganador==0)
                						$class = "success";
                					else
                						$class = "danger";
                				}
                				if($pronostico->encuentro->puntosL < $pronostico->encuentro->puntosV){
                					if($pronostico->ganador==1)
                						$class = "success";
	            					else
	            						$class = "danger";
	        					}
            					@endphp
                			<tr class="{{ $class }}">
            					<td>{{ $key }}</td>
            					<td>{{ $pronostico->encuentro->equipoL->nombre }}</td>
            					<td>{{ $pronostico->encuentro->puntosL }}</td>
            					<td>vs</td>
            					<td>{{ $pronostico->encuentro->puntosV }}</td>
            					<td>{{ $pronostico->encuentro->equipoV->nombre }}</td>
            					<td>@if ($pronostico->ganador == 0){{ $pronostico->encuentro->equipoL->nombre }}@else {{ $pronostico->encuentro->equipoV->nombre }}@endif</td>
                			</tr>
                			@endforeach
                		</tbody>
                	</table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection