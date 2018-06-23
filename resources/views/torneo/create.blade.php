@extends('layouts.base')
@section('contenido')
	<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">
				<h2>Nuevo Torneo</h2>   
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

				<a href="{{URL::action('TorneoController@crearEjemplo')}}" class="btn btn-primary">Crear Ejemplo</a>

				{!! Form::open(array(
					'url'=>'torneo',
					'method'=>'POST',
					'autocomplete'=>'off'
					)) !!}
					{{ Form::token() }}
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	                    <h5>Nombre</h5>
	                    <div class="input-group">
	                        <input type="text" class="form-control" required placeholder="Nombre" name="nombre">
	                    </div>
	                    <h5>Deporte</h5>
	                    <div class="input-group">
	                        <input type="text" class="form-control" required  placeholder="Deporte" name="deporte">
	                    </div>
	                    <h5>Cantidad de Grupos</h5>
	                    <div class="input-group">
	                    <select class="form-control" name="cantGrupos">
	                        <option selected value = 2>2</option>
	                        <option  value = 4>4</option>
	                        <option  value = 8>8</option>
	                    </select>
	                    </div>
	                </div>
	                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	                    <h5>Fecha Inicio</h5>
	                    <div class="input-group">
	                        <input type="date" class="form-control" required name="fechaInicio">
	                    </div>
	                    <h5>Fecha Fin</h5>
	                    <div class="input-group">
	                        <input type="date" class="form-control" required name="fechaFin">
	                    </div>
	                    <h5>Descripcion</h5>
	                    <div class="input-group">
	                        <input type="text" class="form-control" placeholder="Descripcion" name="descripcion">
	                    </div>
	                    <br>
	                    <input type="hidden" value ="1" name="step">
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