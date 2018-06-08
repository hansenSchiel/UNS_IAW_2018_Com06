@extends('layouts.base')
@section('contenido')
	<div id="page-wrapper" ng-app = "equipo" ng-controller = "EquipoController" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">
				<h2>Editar Equipo</h2>   
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
				{!! Form::model($equipo,[
					'route'=>['equipo.update',$equipo->id],
					'method'=>'PATCH',
					'autocomplete'=>'off'
					]) !!}
					{{ Form::token() }}
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" class="form-control" name="nombre" value="{{ $equipo->nombre }}">
					</div>
					<div class="form-group">
						<label for="nombre">Descripcion</label>
						<input type="text" class="form-control" name="descripcion" value="{{ $equipo->descripcion }}">
					</div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Guardar</button>
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