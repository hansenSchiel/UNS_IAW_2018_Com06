@extends('layouts.base')
@section('contenido')
	<div id="page-wrapper" ng-app = "equipo" ng-controller = "EquipoController" >
	    <div id="page-inner">
	        <div class="row">
	            <div class="col-lg-12">
					<h1>Equipos</h1>
	                @if (Auth::user() && Auth::user()->admin )
	                    <a href="/equipo/create" class="btn btn-primary">Nuevo Torneo</a>
	                @endif
	            </div>
	        </div>              
	         <!-- /. ROW  -->
	         <hr />
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<br>
					@include('equipo.search')
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Torneos</th>
								<th>Encuentros Ganados</th>
								<th>Encuentros Empatados</th>
								<th>Encuentros Perdidos</th>
								<th>Promedio</th>
								<th>Campeón</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($equipos as $index => $equipo)
							<tr>
								<td>{{ $index+1 }}</td>
								<td><a href="/equipo/equipo/{{ $equipo->id }}">{{ $equipo->nombre }}</a></td>
								<td>2</td>
								<td>7</td>
								<td>2</td>
								<td>1</td>
								<td>0.7</td>
								<td>1</td>
								<td>
									@if (Auth::user() && Auth::user()->admin )
										<a href="{{URL::action('EquipoController@edit',$equipo->id)}}">Editar</a>
									@else
										-
									@endif
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				{{ $equipos->render() }}
				</div>
			</div>
		</div>
	</div>
@endsection