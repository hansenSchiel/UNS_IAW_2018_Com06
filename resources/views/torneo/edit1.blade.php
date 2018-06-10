@extends('layouts.base')
@section('contenido')
<div id="page-wrapper">
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Torneo</h2><h4>Nuevo Torneo (Paso 2) - Equipos</h4>   
        </div>
    </div>              
     <!-- /. ROW  -->
     <hr />
    <div class="row">               
        @if (count($errors)>0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        {!! Form::open(array(
        'route'=>['torneo.update',$torneo->id],
        'method'=>'PATCH',
        'autocomplete'=>'off'
        )) !!}
        {{ Form::token() }}

        <input type="hidden" name="nombre" value="{{ $torneo->nombre}}">
        <input type="hidden" name="deporte" value="{{ $torneo->deporte}}">
        <input type="hidden" name="fechaInicio" value="{{ $torneo->fechaInicio}}">
        <input type="hidden" name="fechaFin" value="{{ $torneo->fechaFin}}">


        <div class="col-xs-4">
            <h5>Grupos</h5>
            <div class="panel-group" id="accordion">

                @foreach ($torneo->grupos as $grupo)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" onClick="setGrupo('{{ $grupo->id }}')" data-parent="#accordion" href="#collapse{{ $grupo->nombre }}" class="">Grupo "{{ $grupo->nombre }}"</a>
                        </h4>
                    </div>
                    <div id="collapse{{ $grupo->nombre }}" class="panel-collapse collapse grupos" val="{{ $grupo->nombre }}">
                        <div class="panel-body">
                            <fieldset class="form-group">
                                @foreach ($grupo->equipos as $index => $equipo)
                                <div class="form-check">
                                    <label class="form-check-label">{{ $equipo->nombre }}
                                    </label>
                                    <input onclick="return quitarEquipo('{{$equipo->id}}')"type="submit" value="x" class="btn btn-secondary btn-sm pull-right">
                                </div>
                                @endforeach   
                            </fieldset>
                        </div>
                    </div>
                </div>  
                @endforeach           
            </div>
        </div>
        <div class="col-xs-4"><br><br><br><br>
        </div>
        <div class="col-xs-4" >
            <h5>Equipos</h5>
            <fieldset class="form-group">
                 @foreach ($equipos as $index => $equipo)
                <div class="form-check">
                    <label class="form-check-label" >
                        <input onclick=" return agregarEquipo('{{$equipo->id}}')"type="submit" value="<<" class="btn btn-primary">
                        {{ $equipo->nombre }}
                    </label>
                </div>
                @endforeach       
            </fieldset>
        </div>
        <input type="hidden" id="grupo" name="grupo" value="">
        <input type="hidden" id="equipo" name="equipo" value="">
        <input type="hidden" id="mode" name="mode" value="add">
        {!! Form::close() !!}
    </div>
    {!! Form::open(array(
    'route'=>['torneo.update',$torneo->id],
    'method'=>'PATCH',
    'autocomplete'=>'off'
    )) !!}
    {{ Form::token() }}

    <input type="hidden" name="nombre" value="{{ $torneo->nombre}}">
    <input type="hidden" name="deporte" value="{{ $torneo->deporte}}">
    <input type="hidden" name="fechaInicio" value="{{ $torneo->fechaInicio}}">
    <input type="hidden" name="fechaFin" value="{{ $torneo->fechaFin}}">


    <a href="{{URL::action('TorneoController@back',$torneo->id)}}" class="btn btn-primary">Atras</a>
    <input type="hidden" name="siguiente" value="ok">
    <input type="submit" value="Siguiente" class="btn btn-primary">
    {!! Form::close() !!}
</div>
<script type="text/javascript">
    var grupoSelect = "";
    function agregarEquipo(idEquipo){
        if(grupoSelect == ""){
            return false;
        }else{
            $("#grupo").val(grupoSelect);
            $("#equipo").val(idEquipo);
            $("#mode").val("add");
            return true;
        }
    }
    function quitarEquipo(idEquipo){
        if(grupoSelect == ""){
            return false;
        }else{
            $("#grupo").val(grupoSelect);
            $("#equipo").val(idEquipo);
            $("#mode").val("del");
            return true;
        }
    }

    function setGrupo(idGrupo){
        grupoSelect = idGrupo;
    }

</script>
@endsection