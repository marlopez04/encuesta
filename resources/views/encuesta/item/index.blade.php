@extends('template.main')

@section('title', 'Agregar Un Insumo')

@section('content')
<div class="panel panel-widget">
	<div class="panel-title">
	</div>
		<div class="form-group">
			<table class="table table-hover table-striped">
				<th>Area</th>
				<th>Antiguedad</th>
				<th>Edad</th>
				<th>Estudio</th>
				<th>Sede</th>
				<th>Sector</th>
				<th>Genero</th>
				<th>Contrato</th>
				<th>Puesto</th>
				<tr>
					<td>{{$encuestado->area->descripcion}}</td>
					<td>{{$encuestado->antiguedad->rango}}</td>
					<td>{{$encuestado->rangoedad->descripcion}}</td>
					<td>{{$encuestado->estudio->descripcion}}</td>
					<td>{{$encuestado->sede->descripcion}}</td>
					<td>{{$encuestado->sector->descripcion}}</td>
					<td>{{$encuestado->genero->descripcion}}</td>
					<td>{{$encuestado->contrato->descripcion}}</td>				
					<td>{{$encuestado->puesto->descripcion}}</td>					
				</tr>
			</table>

		<div class="form-group">
			<table class="table table-hover table-striped">
				<th>id</th>
				<th>pregunta</th>
					@foreach ($items as $pregunta)
					<tr>
						<td>{{$pregunta->id}}</td>
						<td>{{$pregunta->contenido}}</td>
					</tr>

					<tr>
						<td colspan="2">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
							@foreach ($opciones as $opcion)
								@if($opcion->codigo == $pregunta->tipo_id)				
  								<label class="btn btn-primary">
    							<input type="radio" name="options" id="option1" autocomplete="off"> {{$opcion->opcion}}
  								</label>
								@endif
							@endforeach
							</div>
						</td>
					</tr>

					@endforeach
			
			</table>			
		</div>

</div>

@endsection


@section('js')


<script type="text/javascript">

	  $('.select-category').prepend('<option value="0" selected> </option>');
	  	  $('.select-category').attr('selected','0');
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