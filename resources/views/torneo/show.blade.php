@extends('layouts.base')
@section('contenido')
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Torneo</h2><h4>{{ $torneo->nombre }}  <span> En Edicion</span></h4>
                <a href="{{URL::action('TorneoController@edit',$torneo->id)}}" class="btn btn-primary">
                    Editar
                </a>             
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
                    Mejor Usuario: Juan<br>
                    Descripcion: {{ $torneo->descripcion }}<br>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <h5>Fechas</h5>
            <div class="panel-group" id="accordion">
                @each('layouts/fecha', $torneo->fechas, 'fecha')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <h5>Grupos y Equipos</h5>
            <div class="panel-group" id="accordion">
                @foreach($torneo->grupos->sortBy("nombre") as $grupo)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $grupo->nombre }}" class="collapsed">Grupo "{{ $grupo->nombre }}"</a>
                        </h4>
                    </div>
                    <div id="collapse{{ $grupo->nombre }}" class="panel-collapse collapse" style="height: 0px;">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($grupo->equipos as $equipo)
                                    <tr>
                                        <td>1</td>
                                        <td><a href="/equipo/equipo.html">{{ $equipo->nombre }}</a></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
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