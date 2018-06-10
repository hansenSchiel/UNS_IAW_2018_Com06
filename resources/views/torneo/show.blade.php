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
            <h5>Próxima Fecha</h5>
            <div class="">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#info" data-toggle="tab">Info</a>
                    </li>
                    <li class=""><a href="#encuentros" data-toggle="tab">Encuentros</a>
                    </li>
                    <li class=""><a href="#usuarios" data-toggle="tab">Usuarios</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="info">
                    </div>
                    <div class="tab-pane fade in" id="encuentros">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Local</th>
                                    <th></th>
                                    <th>Visitante</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="encuentro in proximaFecha.encuentros  track by $index">
                                </tr>
                            </tbody>
                        </table>
                        <% if (locals.user) {  %>
                            <div class="panel-footer">
                                <a href="#" ng-click="participar(proximaFecha,torneo)" class="btn btn-primary">Participar</a>
                            </div>
                        <% } %> 
                    </div>
                    <div class="tab-pane fade in" id="usuarios">
                        <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nombre</td>
                                <td>Aciertos</td>
                                <td>Errores</td>
                                <td>Promedio</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#</td>
                                <td><a href="/usuario/usuario.html">Juan</a></td>
                                <td>15</td>
                                <td>9</td>
                                <td>0.625</td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td><a href="/usuario/usuario.html">Matias</a></td>
                                <td>4</td>
                                <td>1</td>
                                <td>0.8</td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td><a href="/usuario/usuario.html">Roberto</a></td>
                                <td>31</td>
                                <td>12</td>
                                <td>0.72</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <h5>Grupos y Equipos</h5>
            <div class="panel-group" id="accordion">
                <div class="panel panel-default" ng-repeat="grupo in torneo.grupos  track by $index">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseA" class="collapsed">Grupo "A"</a>
                        </h4>
                    </div>
                    <div id="collapseA" class="panel-collapse collapse" style="height: 0px;">
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
                                    <tr ng-repeat="equipo in grupo.equipos  track by $index">
                                        <td>1</td>
                                        <td><a href="/equipo/equipo.html">Equipo</a></td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8" ng-show="ultimaFecha">
            <h5>Última Fecha</h5>
            <div class="">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#info2" data-toggle="tab">Info</a>
                    </li>
                    <li class=""><a href="#encuentros2" data-toggle="tab">Encuentros</a>
                    </li>
                    <li class=""><a href="#usuarios2" data-toggle="tab">Usuarios</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="info2">
                    </div>
                    <div class="tab-pane fade in" id="encuentros2">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Local</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Visitante</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="encuentro in ultimaFecha.encuentros  track by $index">
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade in" id="usuarios2">
                        <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Nombre</td>
                                <td>Aciertos</td>
                                <td>Errores</td>
                                <td>Promedio</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#</td>
                                <td><a href="/usuario/usuario.html">Juan</a></td>
                                <td>3</td>
                                <td>1</td>
                                <td>0.75</td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td><a href="/usuario/usuario.html">Matias</a></td>
                                <td>2</td>
                                <td>2</td>
                                <td>0.5</td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td><a href="/usuario/usuario.html">Roberto</a></td>
                                <td>2</td>
                                <td>2</td>
                                <td>0.5</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                    Ganador: <a href="/usuario/usuario.html">Juan</a>
                </div>
            </div>
        </div>
        
    </div>
</div>
<script type="text/javascript" src="/torneo/torneo.js"></script>
<script type="text/javascript" src="/torneo/torneosController.js"></script>
@endsection