<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $fecha->nombre }}" class="collapsed">Fecha {{ $fecha->nombre }}</a>
        </h4>
    </div>
    <div id="collapse{{ $fecha->nombre }}" class="panel-collapse collapse" style="height: 0px;">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#info{{ $fecha->nombre }}" data-toggle="tab">Info</a>
                </li>
                <li class=""><a href="#encuentros{{ $fecha->nombre }}" data-toggle="tab">Encuentros</a>
                </li>
                <li class=""><a href="#usuarios{{ $fecha->nombre }}" data-toggle="tab">Usuarios</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="info{{ $fecha->nombre }}">

                    Fecha:              {{ $fecha->nombre }}<br>
                    Cant. encuentros:   {{ sizeOf($fecha->encuentros) }}<br>
                    Usuarios partic:    3<br>
                    Inicio:             {{ $fecha->fechaInicio }}<br>
                    Fin:                {{ $fecha->fechaFin }}<br>
                    Fin Inscripcion:    {{ date('Y-m-d', strtotime($fecha->fechaInicio.' -1 days')) }}<br>
                </div>
                <div class="tab-pane fade in" id="encuentros{{ $fecha->nombre }}">
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
                            @foreach ($fecha->encuentros as $encuentro)
                                <tr>
                                    <td>#</td>
                                    <td @if($encuentro->puntosL > $encuentro->puntosV)
                                        class="success"
                                        @endif
                                    >{{ $encuentro->equipoL->nombre }}</td>
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
                                        >{{ $encuentro->equipoV->nombre }}</td>
                                    <td>{{ $encuentro->dia }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade in" id="usuarios{{ $fecha->nombre }}">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Aciertos</th>
                            <th>Errores</th>
                            <th>Promedio</th>
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
        @if (Auth::user())
            @if (today()<$fecha->fechaFin)
                <div class="panel-footer">
                    <a href="#"  class="btn btn-primary">Participar</a>
                </div>
            @endif
        @endif
    </div>
</div>