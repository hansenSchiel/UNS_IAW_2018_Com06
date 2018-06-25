@extends('layouts.base')
@section('contenido')
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Torneo</h2><h4>{{ $torneo->nombre }}  <span> @if ($torneo->step <2 ) (En Edicion)@endif</span></h4>
                @if (Auth::user() && Auth::user()->admin )
                    {!! Form::open(array(
                        'route'=>['torneo.destroy',$torneo->id],
                        'method'=>'DELETE',
                        )) !!}
                    <a href="{{URL::action('TorneoController@edit',$torneo->id)}}" class="btn btn-primary">
                        Editar
                    </a> 
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    {!! Form::close() !!}
                @endif
            
        </div>
    </div>              
     <!-- /. ROW  -->
     <hr />
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    {{ $torneo->nombre }}
                </div>
                <div class="panel-body">
                    Deporte: {{ $torneo->deporte }}<br>
                    Fecha Inicio:  {{ $torneo->fechaInicio }}<br>
                    Fecha Fin: {{ $torneo->fechaFin }}<br>
                    Cant Grupos: {{ sizeof($torneo->grupos) }}<br>
                    Fechas: {{ sizeOf($torneo->fechas) }}<br>
                    Cant Encuentros: {{ sizeOf($torneo->encuentros) }}<br>
                    Ganador: @if ($torneo->ganador!=null )@include('layouts.links.equipo', ['item' => $torneo->ganador])@endif<br>
                    Descripcion: {{ $torneo->descripcion }}<br>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <h5>Fechas</h5>
            <div class="panel-group" id="accordion">
                @each('layouts/fecha', $torneo->fechas->sortBy("nombre"), 'fecha')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <h5>Grupos y Equipos</h5>
            <div class="panel-group" id="accordion">
                @foreach($grupos as $key=>$grupo)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key }}" class="collapsed">Grupo "{{ $key }}"</a>
                        </h4>
                    </div>
                    <div id="collapse{{ $key }}" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Equipo</th>
                                        <th>PJ</th>
                                        <th>PG</th>
                                        <th>PE</th>
                                        <th>PP</th>
                                        <th>DG</th>
                                        <th>Puntos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grupo as $equipo)
                                    <tr>
                                        <td>1</td>
                                        <td>@include('layouts.links.equipo', ['item' => $equipo[0]])</td>
                                        <td>{{ $equipo['pg']+$equipo['pe']+$equipo['pp'] }}</td>
                                        <td>{{ $equipo['pg'] }}</td>
                                        <td>{{ $equipo['pe'] }}</td>
                                        <td>{{ $equipo['pp'] }}</td>
                                        <td>{{ $equipo['g'] }}</td>
                                        <td>{{ $equipo['p'] }}</td>
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
    </div>
</div>
@endsection