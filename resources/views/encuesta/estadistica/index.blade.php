@extends('template.main')

@section('title', 'Estadisticas')

@section('head')

<link href="{{asset('plugin/MDB-Free/css/mdb.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/MDB-Free/css/style.css')}}" rel="stylesheet">

@endsection

@section('content')



<div class="panel panel-widget">
	<div class="panel-title">

<div class="col col-lg-1"></div>
	<div class="col col-lg-10">

	<table>
		<th><h5>Encuesta</h5></th>
		<th><h5>Area</h5></th>
		<th><h5>Sector</h5></th>
		<th><h5>Puesto</h5></th>
		<th><h5>Antiguedad</h5></th>
		
		<tr>
			<td>
			{!! Form::select('encuesta_id', $encuestas, null, [ 'id' => 'encuesta', 'class' => 'form-control select-category1']) !!}
			</td>
			<td>
			{!! Form::select('area_id', $areas, null, [ 'class' => 'form-control select-category', 'id' => 'area']) !!}
			</td>
			<td>
				<div id= "sector1">
					{!! Form::select('sector',$sectores, null, [ 'class' => 'form-control select-category']) !!}
				</div>
				<div id= "sector2"></div>
			</td>
			<td>
				{!! Form::select('puesto_id', $puestos, null, [ 'id' => 'puesto', 'class' => 'form-control select-category', 'required']) !!}
			</td>
			<td>
			{!! Form::select('antiguedad_id', $antiguedades, null, [ 'id' => 'antiguedad', 'class' => 'form-control select-category']) !!}
			</td>
		</tr>

		<th><h5>Edad</h5></th>
		<th><h5>Estudio</h5></th>
		<th><h5>Sede</h5></th>
		<th><h5>Genero</h5></th>
		<th><h5>Contrato</h5></th>

		<tr>
			<td>
			{!! Form::select('rangoedad_id', $rangoedades, null, [ 'id' => 'rangoedad', 'class' => 'form-control select-category']) !!}
			</td>
			<td>
			{!! Form::select('estudio_id', $estudios, null, [ 'id' => 'estudio', 'class' => 'form-control select-category']) !!}
			</td>
			<td>
			{!! Form::select('sede_id', $sedes, null, [ 'id' => 'sede',  'class' => 'form-control select-category']) !!}
			</td>
			<td>
			{!! Form::select('genero_id', $generos, null, [ 'id' => 'genero', 'class' => 'form-control select-category']) !!}
			</td>
			<td>
			{!! Form::select('contrato_id', $contratos, null, [ 'id' => 'contrato', 'class' => 'form-control select-category']) !!}
			</td>
		</tr>
	</table>
	<br>
	<button id="mostrar" type="button" class="btn btn-lg btn-primary">Primary button</button>

	<br>
	<br>

	<div id="grafico">
		<br>
		<br>
		<h4>Tucuman</h4>
		<canvas id="pieChart" style="max-width: 500px;"></canvas>
		<br>
		<br>
		
	</div>

	</div>

<div class="col col-lg-1"></div>

</div>

</div>
</div>


{!! Form::open(['route' => ['encuesta.sector.show', ':ID'], 'method' => 'POST' , 'id' => 'form-sector' ]) !!}
{!! Form::close() !!}

{!! Form::open(['route' => ['encuesta.estadistica.show', ':ID'], 'method' => 'POST' , 'id' => 'form-estadisticas' ]) !!}
{!! Form::close() !!}

@endsection


@section('js')

<script src="{{asset('plugin/MDB-Free/js/popper.min.js')}}"></script>
<script src="{{asset('plugin/MDB-Free/js/mdb.min.js')}}"></script>

<script type="text/javascript">

//datos inicio

var descripcion = new Array();
var datos = new Array();

var sede = <?php echo $sedefavorbs ?>;

console.log(sede);

if(sede.length > 0){
	for (var i = 2; i >= 0; i--) {

			descripcion.push(sede[i]['favorabilidad']);

			datos.push(sede[i]['cantidad']);
	}
}

console.log(descripcion);
console.log(datos);

/*
*/
//datos fin
	//GRAFICO INICIO

var ctxP = document.getElementById("pieChart").getContext('2d');
var myPieChart = new Chart(ctxP, {
type: 'pie',
data: {
//labels: ["Red", "Green", "Yellow"],
labels: descripcion,
datasets: [{
data: datos,
backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C"],
hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870"]
}]
},
options: {
responsive: true
}
});

	//GRAFICO FIN



	  $('.select-category').prepend('<option value="" selected> </option>');
	  	  $('.select-category').attr('selected','0');

	$('#area').change(function(){

	  var form = $('#form-sector');
	  var id_area = $('#area').val();

	  var url = form.attr('action').replace(':ID', id_area);
//para imprimir form2 lista vieja, form3 lista nueva

//	  var token = form.serialize();
	  console.log(id_area);
//recupero lista vieja

		data = {};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

	});

	$('#mostrar').click(function(){
		
		var encuesta = $('#encuesta').val();
		
		var area = $('#area').val();
		
		var sector = $('#sector').val();
		
		var puesto = $('#puesto').val();
		
		var antiguedad = $('#antiguedad').val();
		
		var rangoedad = $('#rangoedad').val();
		
		var estudio = $('#estudio').val();
		
		var sede = $('#sede').val();
		
		var genero = $('#genero').val();
		
		var contrato = $('#contrato').val();


	  var form = $('#form-estadisticas');

	  var url = form.attr('action').replace(':ID', encuesta);
//para imprimir form2 lista vieja, form3 lista nueva

//	  var token = form.serialize();

//recupero lista vieja

		data = {area: area, sector: sector, puesto: puesto, antiguedad: antiguedad, rangoedad: rangoedad, estudio: estudio, sede:sede, genero: genero, contrato: contrato};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

	});

</script>


@endsection
