@extends('layouts.base')
@section('contenido')
	<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">
				<h2>Editar Torneo</h2>   
            </div>
        </div>              
         <!-- /. ROW  -->
         <hr />
		<div class="row">
			<div class="col-lg-12 col-md-12">
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
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	                    <h5>Nombre</h5>
	                    <div class="input-group">
	                        <input type="text" class="form-control" required placeholder="Nombre" name="nombre"
	                        value="{{ $torneo->nombre }}">
	                    </div>
	                    <h5>Deporte</h5>
	                    <div class="input-group">
	                        <input type="text" class="form-control" required  placeholder="Deporte" name="deporte"
	                        value="{{ $torneo->deporte }}">
	                    </div>
	                    <h5>Cantidad de Grupos</h5>
	                    <div class="input-group">
	                    <select class="form-control" name="cantGrupos" >
	                        <option @if ($torneo->cantGrupos==2) selected @endif value = 2>2</option>
	                        <option @if ($torneo->cantGrupos==4) selected @endif value = 4>4</option>
	                        <option @if ($torneo->cantGrupos==8) selected @endif value = 8>8</option>
	                    </select>
	                    </div>
	                </div>
	                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	                    <h5>Fecha Inicio</h5>
	                    <div class="input-group">
	                        <input type="date" class="form-control" required name="fechaInicio" value="{{ $torneo->fechaInicio }}">
	                    </div>
	                    <h5>Fecha Fin</h5>
	                    <div class="input-group">
	                        <input type="date" class="form-control" required name="fechaFin" value="{{ $torneo->fechaFin }}">
	                    </div>
	                    <h5>Descripcion</h5>
	                    <div class="input-group">
	                        <input type="text" class="form-control" placeholder="Descripcion" name="descripcion" value="{{ $torneo->descripcion }}">
	                    </div>
	                    <br>

	                    <input type="submit" value="Siguiente" class="btn btn-primary">
	                </div>
					{!! Form::close() !!}
			</div>
		</div>
	</div>
     <!-- /. PAGE INNER  -->
</div>
 <!-- /. PAGE WRAPPER  -->
</div>
@endsection