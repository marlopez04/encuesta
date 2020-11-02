
<?php $encu = 5; ?>

<?php $descripcion = array('sede', 'participacion x demog', 'favorabilidad demografico','indice dimension factor', 'respuesta multiple','preguntas'); ?>

<?php $direccion = array(route('estadistica.sede', $encu),route('estadistica.demografico', $encu),route('estadistica.favorabilidaddemografico', $encu),route('estadistica.indicedimensionfactor', $encu),route('estadistica.multiple', $encu), route('estadistica.preguntas', $encu)); ?>


<?php $i = 0; ?>


{!! Form::select('encuesta_id', $encuestas, null, [ 'class' => 'form-control select-category', 'style'=>'background-color:rgb(173,219,173);']) !!}
<!-- la variable menuitem indicaba que boton estaba seleccionado-->

<br>

@for ($i = 0; $i < sizeof($descripcion); $i++)

	@if ($i == $menuitem)
		<a class="btn" style="background-color:rgb(173,219,173);" href="{{$direccion[$i]}}" role="button">{{ $descripcion[$i]}}</a>
	@else
		<a class="btn btn-success" href="{{$direccion[$i]}}" role="button">{{ $descripcion[$i]}}</a>
	@endif

@endfor