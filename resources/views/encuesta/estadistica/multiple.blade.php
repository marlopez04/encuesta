@extends('template.main')

@section('title', 'Estadisticas')

@section('head')

<link href="{{asset('plugin/MDB-Free/css/mdb.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/MDB-Free/css/style.css')}}" rel="stylesheet">

@endsection

@section('content')

<div class="panel panel-widget">
	<div class="panel-title">

<div class="row">
	<div class="col col-lg-1"></div>
	<div class="col col-md-10">
		@include('encuesta.estadistica.menu')

		<br>
	</div>

</div>



<div class="row">
<div class="col col-lg-1"></div>
<div class="col col-lg-5">
	<br>
	{!! Form::select('demografico', $demograficos, 'Sede', ['id' => 'demografico', 'class' => 'form-control select-category', 'required']) !!}
	<div id="demog1">
		{!! Form::select('demografico', $demograficos2, 'Sede', ['id' => 'demografico2', 'class' => 'form-control select-category', 'required']) !!}
	</div>
	<div id="demog2"></div>
</div>
<div class="col col-lg-4"></div>
</div>

<?php $item =0; ?>


<div class="row" id="sector1">
<div class="col col-lg-1"></div>
	<div class="col col-md-5">

		<h4>{{$titulo}}</h4>
		<canvas id="Grafico" style="width: 500px; height: 600px"></canvas>
		<br>
		<br>
		
	</div>

	<div class="col-md-6">
	<br>
	<br>
	<br>
	<br>
	@foreach ($datosO1 as $dato)

<span>
	<svg width="30" height="10">
  <rect id="{{100 + $item}}" width="30" height="10" style="fill:rgb(0,0,255);stroke-width:1;stroke:rgb(0,0,0)" />
	</svg> {{ round(($dato->cantidad * 100) /$total,1) }}%  {{ $dato->descripcion }}</span>
	<br>

	<?php $item++; ?>

	@endforeach

	</div>

</div>

<div class="row" id="sector2" >

</div>

</div>

</div>
</div>

{!! Form::open(['route' => ['estadistica.demogshow'], 'method' => 'GET' , 'id' => 'form-demografico' ]) !!}
{!! Form::close() !!}


{!! Form::open(['route' => ['estadistica.injeccionmultiple'], 'method' => 'GET' , 'id' => 'form-demografico2' ]) !!}
{!! Form::close() !!}

@endsection


@section('js')

<script src="{{asset('plugin/MDB-Free/js/popper.min.js')}}"></script>
<script src="{{asset('plugin/MDB-Free/js/mdb.min.js')}}"></script>

<script type="text/javascript">

//datos inicio

var desc = 0;
var dat = 0;

var backgroundColor = ['rgba(54, 162, 235, 0.2)','rgba(255, 206, 86, 0.2)','rgba(75, 192, 192, 0.2)','rgba(153, 102, 255, 0.2)','rgba(255, 159, 64, 0.2)','rgba(255, 99, 132, 0.2)', 'rgba(36, 113, 163, 0.2)','rgba(243, 156, 18, 0.2)','rgba(23, 165, 137, 0.2)','rgba(36, 113, 163, 0.2)','rgba(106, 32, 23, 0.2)','rgba(21, 95, 27, 0.2)','rgba(132, 221, 223, 0.2)','rgba(71, 45, 97, 0.2)','rgba(218, 223, 50, 0.2)','rgba(18, 238, 188, 0.2)','rgba(9, 98, 244, 0.2)','rgba(244, 9, 151, 0.2)','rgba(30, 244, 9, 0.2)','rgba(244, 9, 9, 0.2)','rgba(9, 102, 244, 0.2)','rgba(47, 134, 26, 0.2)'];

var borderColor = ['rgba(54, 162, 235, 1)','rgba(255, 206, 86, 1)','rgba(75, 192, 192, 1)','rgba(153, 102, 255, 1)','rgba(255, 159, 64, 1)','rgba(255,99,132,1)', 'rgba(36, 113, 163, 1)','rgba(243, 156, 18, 1)','rgba(23, 165, 137, 1)','rgba(36, 113, 163, 1)','rgba(106, 32, 23, 1)','rgba(21, 95, 27, 1)','rgba(132, 221, 223, 1)','rgba(71, 45, 97, 1)','rgba(218, 223, 50, 1)','rgba(18, 238, 188, 1)','rgba(9, 98, 244, 1)','rgba(244, 9, 151, 1)','rgba(30, 244, 9, 1)','rgba(244, 9, 9, 1)','rgba(9, 102, 244, 1)','rgba(9, 9, 244, 1)','rgba(47, 134, 26, 1)',];

console.log("cargar grafico");

var descripcion = new Array();
var datos = new Array();
var background = new Array();
var border = new Array();

var grafico = <?php echo $datos ?>;
var porcenTotal = <?php echo $total ?>;

if(grafico.length > 0){

	var e = 0;

	for (var i = 0; i < grafico.length; i++) {

			dat = (parseInt(grafico[i]['cantidad']) * 100) / porcenTotal;

			//desc = grafico[i]['descripcion'] + ' ' + dat.toFixed(2) + '%' ;

			desc = dat.toFixed(1) + '%';

			e = 100 + i;

			document.getElementById(e).style.fill = backgroundColor[i];
			document.getElementById(e).style.stroke = borderColor[i];

			background.push(backgroundColor[i]);
			border.push(borderColor[i]);
	
			descripcion.push(desc);

			datos.push(dat.toFixed(1));

	}


		background.push("rgba(255, 99, 132, 0)");
		border.push("rgba(255, 99, 132, 0)");
	
		//descripcion.push(' ');

		datos.push(100);


}


console.log(background);
console.log(border);

//canvas.style.width = '500px';  // or canvas.width = 300;
//canvas.style.height = '1000px'; // or canvas.heigth = 200;


	//GRAFICO INICIO

var ctx = document.getElementById("Grafico").getContext('2d');
var myChart = new Chart(ctx, {
type: 'horizontalBar',
data: {
labels: descripcion,
datasets: [{
label: ' ',
data: datos,
fill: false,
backgroundColor: background,
borderColor: border,
borderWidth: 1
}]
},
options: {
responsive: false,
scales: {
xAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
}
);

//funcion para cargar el lisdato del demografico

	$('#demografico').change(function(){
		
		var demografico = $('#demografico').val();
		
	  var form = $('#form-demografico');

	  var url = form.attr('action');

		data = {demografico: demografico};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#demog2').show().fadeOut().html(listasector).fadeIn();
		      $('#demog1').hide();
	   });

	});

//funcion para cargar el grafico

	$('#demografico2').change(function(){
		
		var demografico = $('#demografico').val();
		var demografico2 = $('#demografico2').val();
		
	  var form = $('#form-demografico2');

	  var url = form.attr('action');

		data = {demografico: demografico, demografico2: demografico2};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

	});



</script>


@endsection
