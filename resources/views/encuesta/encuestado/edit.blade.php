@extends('template.main')

@section('title', 'Agregar Un Insumo')

@section('content')
<div class="panel panel-widget">
	<div class="panel-title">

	</div>
	<div class="col col-lg-3"></div>
	<div class="col col-lg-6">
	{!! Form::open(['route' =>['encuesta.encuestado.update', $encuestado], 'method' => 'PUT']) !!}
		<div class="form-group">
			<h4>Encuesta</h4>
			{!! Form::select('encuesta_id', $encuestas, $encuestado->encuesta_id, [ 'class' => 'form-control select-category1', 'required']) !!}
			<h4>Area</h4>
			{!! Form::select('area_id', $areas, $encuestado->area_id, [ 'class' => 'form-control select-category', 'id' => 'area' , 
			'required']) !!}
			
			<h4>Sector</h4>
			<div id= "sector">
			

			</div>

			<h4>Puesto</h4>
			{!! Form::select('puesto_id', $puestos, $encuestado->puesto_id, [ 'class' => 'form-control select-category', 'required']) !!}

			<h4>Antiguedad</h4>
			{!! Form::select('antiguedad_id', $antiguedades, $encuestado->antiguedad_id, [ 'class' => 'form-control select-category', 'required']) !!}
			<h4>Edad</h4>
			{!! Form::select('rangoedad_id', $rangoedades, $encuestado->rangoedad_id, [  'class' => 'form-control select-category', 'required']) !!}
			<h4>Estudio</h4>
			{!! Form::select('estudio_id', $estudios, $encuestado->estudios_id, [  'class' => 'form-control select-category', 'required']) !!}
			<h4>Sede</h4>
			{!! Form::select('sede_id', $sedes, $encuestado->sede_id, [  'class' => 'form-control select-category', 'required']) !!}

			<h4>Genero</h4>
			{!! Form::select('genero_id', $generos, $encuestado->genero_id, [  'class' => 'form-control select-category', 'required']) !!}
			<h4>Contrato</h4>
			{!! Form::select('contrato_id', $contratos, $encuestado->contrato_id, [ 'class' => 'form-control select-category', 'required']) !!}
		</div>
		<div class="form-group">
			{!!	Form::submit('Registrar',['class' =>'btn btn-primary']) !!}
		</div>
	{!!Form::close()!!}
	</div>

</div>

</div>

{!! Form::open(['route' => ['encuesta.sector.show', ':ID'], 'method' => 'POST' , 'id' => 'form-sector' ]) !!}
{!! Form::close() !!}
@endsection


@section('js')


<script type="text/javascript">

	  $('.select-category').prepend('<option value="" selected> </option>');
	  	  $('.select-category').attr('selected','0');

	$('.select-category').each(function(l,m){
		// l es la cantida de objetos
		// m es el objeto en si
		console.log($(this))
	});	

	$('#area').change(function(){
		console.log($('#area').val());
	  var form = $('#form-sector');
	  var id_area = $('#area').val();
	  var url = form.attr('action').replace(':ID', id_area);
//para imprimir form2 lista vieja, form3 lista nueva

//	  var token = form.serialize();
	  console.log(id_area);
//recupero lista vieja
/*
	  data = {
	    token: token
	  };
*/
		data = {};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector').show().fadeOut().html(listasector).fadeIn();
	   });



});

</script>


@endsection