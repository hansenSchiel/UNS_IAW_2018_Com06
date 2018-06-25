@extends('layouts.base')
@section('contenido')
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>{{ $equipo->nombre }}</h2>  
        </div>
    </div>              
     <!-- /. ROW  -->
     <hr />
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Informacion
                </div>
                <div class="panel-body">
					 @php
						 $jugados = 0; $ganados = 0; $empatados = 0; $perdidos = 0; $promedio = 0;$pendientes = 0;

                         foreach( $equipo->encuentrosV as $encuentro){
                         	if($encuentro->puntosL == -1){
                         		$pendientes++;
                         	}else{
                 				$jugados ++; 
                     			if($encuentro->puntosV >$encuentro->puntosL){
                     				$ganados ++; 
							 	}
                     			if($encuentro->puntosV <$encuentro->puntosL){
                     				$perdidos ++; 
							 	}
                     			if($encuentro->puntosV ==$encuentro->puntosL){
                     				$empatados ++; 
							 	}
                         	}
						 }
                         foreach( $equipo->encuentrosL as $encuentro){
                         	if($encuentro->puntosL == -1){
                         		$pendientes++;
                         	}else{
                 				$jugados ++; 
                     			if($encuentro->puntosV <$encuentro->puntosL){
                     				$ganados ++; 
							 	}
                     			if($encuentro->puntosV >$encuentro->puntosL){
                     				$perdidos ++; 
							 	}
                     			if($encuentro->puntosV ==$encuentro->puntosL){
                     				$empatados ++; 
							 	}
                         	}
						 }
					@endphp
                    Torneos: {{ sizeOf($equipo->grupos) }}<br>
                    Torneos Ganados: {{ sizeOf($equipo->ganados) }}<br>
                    Encuentros Ganados:  {{ $ganados }}<br>
                    Encuentros Empatados:  {{ $empatados }}<br>
                    Encuentros Perdidos:  {{ $perdidos }}<br>
                    Encuentros Pendientes:  {{ $pendientes }}<br>
                    Promedio:  @if($jugados> 0) {{ number_format((($ganados*3+$empatados)/$jugados),2) }} @else 0 @endif puntos p/partido<br>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12">
        	<div class="panel panel-primary">
                <div class="panel-heading">
                    Pronosticos
                </div>
                <div class="panel-body">
                	<table class="table table-striped table-bordered table-hover">
                		<thead>
                			<tr>
                				<th>#</th>
                				<th>Local</th>
                				<th></th>
                				<th>vs</th>
                				<th></th>
                				<th>Visitante</th>
                				<th>Favor</th>
                				<th>Contra</th>
                				<th>Deporte</th>
                			</tr>
                		</thead>
                		<tbody>
							@foreach(($equipo->encuentrosL->merge($equipo->encuentrosV)) as $key=>$encuentro)
								@php
									$favor = 0;$contra = 0;
									foreach($encuentro->pronosticos as $pronostico){
										if($pronostico->ganador==0){
										 	if($encuentro->equipoL->id == $equipo->id){
												$favor++;
											}else{
												$contra++;
											}
										}else{
											if($encuentro->equipoV->id == $equipo->id){
												$favor++;
											}else{
												$contra++;
											}
										}
									}
								@endphp
                                <tr>
                					<th>{{ $key+1 }}</th>
                                    <td @if($encuentro->puntosL > $encuentro->puntosV)
                                        class="success"
                                        @endif
                                    >@include('layouts.links.equipo', ['item' => $encuentro->equipoL])</td>
                                    @if($encuentro->puntosL >= 0)
                                        <td>{{ $encuentro->puntosL }}</td>
                                        <td>vs</td>
                                        <td>{{ $encuentro->puntosV }}</td>
                                    @else
                                        <td>-</td>
                                        <td>vs</td>
                                        <td>-</td>
                                    @endif
                                    <td @if($encuentro->puntosL < $encuentro->puntosV)
                                        class="success"
                                        @endif
                                        >@include('layouts.links.equipo', ['item' => $encuentro->equipoV])</td>
                                    <td>{{ $favor }}</td>
                                    <td>{{ $contra }}</td>
                                    <td>{{ $encuentro->torneo->deporte }}</td>
                                </tr>
            				@endforeach
                		</tbody>
                	</table>
        		</div>
        	</div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Encuentros
                </div>
                <div class="panel-body">
                	<table class="table table-striped table-bordered table-hover">
                		<thead>
                			<tr>
                				<th>#</th>
                				<th>Local</th>
                				<th></th>
                				<th>vs</th>
                				<th></th>
                				<th>Visitante</th>
                				<th>Fecha</th>
                				<th>Torneo</th>
                				<th>Deporte</th>
                			</tr>
                		</thead>
                		<tbody>
            				@foreach(($equipo->encuentrosL->merge($equipo->encuentrosV)) as $key=>$encuentro)
                                <tr>
                					<th>{{ $key+1 }}</th>
                                    <td @if($encuentro->puntosL > $encuentro->puntosV)
                                        class="success"
                                        @endif
                                    >@include('layouts.links.equipo', ['item' => $encuentro->equipoL])</td>
                                    @if($encuentro->puntosL >= 0)
                                        <td>{{ $encuentro->puntosL }}</td>
                                        <td>vs</td>
                                        <td>{{ $encuentro->puntosV }}</td>
                                    @else
                                        <td>-</td>
                                        <td>vs</td>
                                        <td>-</td>
                                    @endif
                                    <td @if($encuentro->puntosL < $encuentro->puntosV)
                                        class="success"
                                        @endif
                                        >@include('layouts.links.equipo', ['item' => $encuentro->equipoV])</td>
                                    <td>{{ $encuentro->dia }}</td>
                                    <td>@include('layouts.links.torneo', ['item' => $encuentro->torneo])</td>
                                    <td>{{ $encuentro->torneo->deporte }}</td>
                                </tr>
            				@endforeach
                		</tbody>
                	</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection