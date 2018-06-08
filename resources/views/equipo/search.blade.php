{!! Form::open(array(
	'url'=>'equipo',
	'method'=>'GET',
	'autocomplete'=>'off',
	'role'=>'search'
)) !!}
<div class="form-group">
	<div class="input-group">
		<input type="text" class="form-control" name="searchText" placeholder="Buscar.." value="{{ $searchText }}">
		<span class="input-group-btn">
			<button type="submit" class="btn">Buscar</button>
		</span>
	</div>
</div>

{{ Form::close()}}