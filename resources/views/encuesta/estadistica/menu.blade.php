<!-- Se quita multiple por la encuesta 2020, se debe incorporar de nuevo para la encuesta 2021
<?php $descripcion = array('sede', 'participacion x demog', 'favorabilidad demografico','indice dimension factor', 'respuesta multiple','preguntas'); ?>

<?php $direccion = array(route('estadistica.sede'),route('estadistica.demografico'),route('estadistica.favorabilidaddemografico'),route('estadistica.indicedimensionfactor'),route('estadistica.multiple'), route('estadistica.preguntas')); ?>
-->
<?php $descripcion = array('sede', 'participacion x demog', 'favorabilidad demografico','indice dimension factor','preguntas'); ?>

<?php $direccion = array(route('estadistica.sede'),route('estadistica.demografico'),route('estadistica.favorabilidaddemografico'),route('estadistica.indicedimensionfactor'), route('estadistica.preguntas')); ?>

<!--//actualizar -->

<?php $i = 0; ?>

@for ($i = 0; $i < sizeof($descripcion); $i++)

	@if ($i == $menuitem)
		<a class="btn" style="background-color:rgb(173,219,173);" href="{{$direccion[$i]}}" role="button">{{ $descripcion[$i]}}</a>
	@else
		<a class="btn btn-success" href="{{$direccion[$i]}}" role="button">{{ $descripcion[$i]}}</a>
	@endif

@endfor