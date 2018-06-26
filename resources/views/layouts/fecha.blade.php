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
                    Usuarios partic:    {{ sizeOf($fecha->participaciones) }}<br>
                    Inicio:             {{ $fecha->fechaInicio }}<br>
                    Fin:                {{ $fecha->fechaFin }}<br>
                    Fin Inscripcion:    {{ date('Y-m-d', strtotime($fecha->fechaInicio.' -1 days')) }}<br>
                    @if($fecha->ganador != null)
                        Ganador: {{ $fecha->ganador->name}}<br>
                    @endif
                </div>
                <div class="tab-pane fade in cpanel" id="encuentros{{ $fecha->nombre }}">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Local</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Visitante</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fecha->encuentros->sortBy("dia") as $encuentro)
                                <tr>
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
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade in cpanel" id="usuarios{{ $fecha->nombre }}">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Pronostico</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fecha->participaciones as $key => $participacion)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>@include('layouts.links.user', ['item' => $participacion->user])</td>
                            <td>{{ $participacion->updated_at }}</td>
                            <td>
                                <a type="button" role="button" class="btn btn-sm btn-btn btn-primary" data-toggle="popover" data-placement="left" title="Pronostico" data-html = true data-content="
                                @foreach($participacion->pronosticos as $pronostico)
                                    @if($pronostico->ganador == 0)
                                        <b>{{ $pronostico->encuentro->equipoL->nombre }}</b> - {{ $pronostico->encuentro->equipoV->nombre }}
                                    @else
                                        {{ $pronostico->encuentro->equipoL->nombre }} - <b>{{ $pronostico->encuentro->equipoV->nombre }}</b>
                                    @endif
                                    <br>
                                @endforeach
                                ">Pronostico</a>
                            </td>
                        </tr>
                        <tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if (Auth::user())
            @if (today()<$fecha->fechaFin || true)
                <div class="panel-footer">                
                    <a href="{{URL::action('ParticipacionController@participar',$fecha->id)}}" class="btn btn-primary">Participar</a>
                </div>
            @endif
        @endif
    </div>
</div>