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

@include('encuesta.estadistica.demogfiltrouno')

<?php $item =0; ?>
<?php $total =0; ?>

<div class="row" id="sector1">
<div class="col col-lg-1"></div>
	<div class="col col-md-5">

		<h4>{{$titulo}}</h4>
		<canvas id="Grafico" style="max-width: 700px;"></canvas>
		<br>
		<br>
		
	</div>

	<div class="col-md-6">
	<br>
	<br>
	@foreach ($ArrayOrdenID as $dato)

				@if ($dato->favorabilidad == "Favorable" && $dato->porcentage > 0)

					<span>
						<svg width="30" height="10">
					  <rect id="{{100 + $item}}" width="30" height="10" style="fill:rgb(0,0,255);stroke-width:1;stroke:rgb(0,0,0)" />
						</svg> {{ $dato->porcentage }}%  {{ $dato->descripcion }}</span>
						<br>

						<?php $item++; ?>

				@endif

	@endforeach

	</div>

</div>

<div class="row" id="sector2" >

</div>

</div>

</div>
</div>

{!! Form::open(['route' => ['estadistica.injeccionfavorabilidaddemo'], 'method' => 'GET' , 'id' => 'form-demografico' ]) !!}
{!! Form::close() !!}

@endsection


@section('js')

<script src="{{asset('plugin/MDB-Free/js/popper.min.js')}}"></script>
<script src="{{asset('plugin/MDB-Free/js/mdb.min.js')}}"></script>

<script type="text/javascript">

document.getElementById("demografico2").hidden = true;
document.getElementById("demografico2").style.display = "none";

$('#demografico2').hide();

//datos inicio

var desc = 0;
var dat = 0;

var backgroundColor = ['rgba(54, 162, 235, 0.2)','rgba(255, 206, 86, 0.2)','rgba(75, 192, 192, 0.2)','rgba(153, 102, 255, 0.2)','rgba(255, 159, 64, 0.2)','rgba(255, 99, 132, 0.2)', 'rgba(36, 113, 163, 0.2)','rgba(243, 156, 18, 0.2)','rgba(23, 165, 137, 0.2)','rgba(36, 113, 163, 0.2)','rgba(106, 32, 23, 0.2)','rgba(21, 95, 27, 0.2)','rgba(132, 221, 223, 0.2)','rgba(71, 45, 97, 0.2)','rgba(218, 223, 50, 0.2)','rgba(18, 238, 188, 0.2)','rgba(9, 98, 244, 0.2)','rgba(244, 9, 151, 0.2)','rgba(30, 244, 9, 0.2)','rgba(244, 9, 9, 0.2)','rgba(9, 102, 244, 0.2)','rgba(47, 134, 26, 0.2)'];

var borderColor = ['rgba(54, 162, 235, 1)','rgba(255, 206, 86, 1)','rgba(75, 192, 192, 1)','rgba(153, 102, 255, 1)','rgba(255, 159, 64, 1)','rgba(255,99,132,1)', 'rgba(36, 113, 163, 1)','rgba(243, 156, 18, 1)','rgba(23, 165, 137, 1)','rgba(36, 113, 163, 1)','rgba(106, 32, 23, 1)','rgba(21, 95, 27, 1)','rgba(132, 221, 223, 1)','rgba(71, 45, 97, 1)','rgba(218, 223, 50, 1)','rgba(18, 238, 188, 1)','rgba(9, 98, 244, 1)','rgba(244, 9, 151, 1)','rgba(30, 244, 9, 1)','rgba(244, 9, 9, 1)','rgba(9, 102, 244, 1)','rgba(9, 9, 244, 1)','rgba(47, 134, 26, 1)',];

//console.log("cargar grafico");

var descripcion = new Array();
var datos = new Array();
var background = new Array();
var border = new Array();

var porcentage = <?php echo $porcentages ?>;

if(porcentage.length > 0){

	var e = 0;

	j = 0;

	for (var i = 0; i < porcentage.length; i++) {
		
		if (parseInt(porcentage[i]) > 0) {
			dat = parseInt(porcentage[i]);

			console.log(dat);

			desc = parseInt(porcentage[i]) + '%';

			console.log(desc);

			e = 100 + j;

			document.getElementById(e).style.fill = backgroundColor[j];
			document.getElementById(e).style.stroke = borderColor[j];

			background.push(backgroundColor[j]);
			border.push(borderColor[j]);
	
			descripcion.push(desc);

			datos.push(dat);

			j = j + 1;

			//console.log(j);
			//console.log(e);
			//console.log(i);
			//console.log(grafico[i]['favorabilidad']);
		}

	}


		background.push("rgba(255, 99, 132, 0)");
		border.push("rgba(255, 99, 132, 0)");
	
		//descripcion.push(' ');

		datos.push(100);

}


//prueba de ordenamiento

/*

var ordenado = datos.sort(function(a, b) {
  return a - b;
});
console.log(ordenado);
*/


//prueba de ordenamiento

//console.log(background);
//console.log(border);


	//GRAFICO INICIO

var ctx = document.getElementById("Grafico").getContext('2d');
var myChart = new Chart(ctx, {
type: 'bar',
data: {
labels: descripcion,
datasets: [{
label: ' ',
data: datos,
backgroundColor: background,
borderColor: border,
borderWidth: 1
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
});


</script>

@endsection
