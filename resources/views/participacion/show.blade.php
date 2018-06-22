@extends('layouts.base')
@section('contenido')
<div id="page-wrapper" >
<div id="page-inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Participacion</h2><h4>{{ $participacion->fecha->torneo->nombre }} </h4>
            <h5>Fecha {{ $participacion->fecha->nombre}} </h5>
            
        </div>
    </div>              
     <!-- /. ROW  -->
     <hr />
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <table class="table table-striped table-bordered table-hover">

                {!! Form::open(array(
                'route'=>['participacion.update',$participacion->id],
                'method'=>'PATCH',
                'autocomplete'=>'off'
                )) !!}
                {{ Form::token() }}
                <thead>
                    <tr>
                        <th>Local</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Visitante</th>
                        <th>Dia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($participacion->pronosticos as $key => $pronostico)
                        {!! Form::setModel($pronostico) !!}
                            <tr> 
                                <td>{{ $pronostico->encuentro->equipoL->nombre }}</td>
                                <td>{!! Form::radio('pronosticos['.$pronostico->id.']',  0, $pronostico->ganador==0,array('class' => 'form-control' )) !!}</td>
                                <td>vs</td>
                                <td>{!! Form::radio('pronosticos['.$pronostico->id.']',  1, $pronostico->ganador==1,array('class' => 'form-control' )) !!}</td>
                                <td>{{ $pronostico->encuentro->equipoV->nombre }}</td>
                                <td>{{ $pronostico->encuentro->dia }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
            <input type="submit" value="Confirmar" class="btn btn-primary">
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection