<?php $item =0; ?>
<?php $total =0; ?>

@foreach ($datosO2 as $dato)

	<?php $total += $dato->cantidad; ?>

@endforeach

<div class="col col-lg-1"></div>
<div class="col-md-5">
	<h4>{{$titulo2}}</h4>
	<canvas id="Grafico2" style="max-width: 500px;"></canvas>
	<canvas id="Grafico3" style="width: 500px; height: 600px"></canvas>
</div>

<div class="col-md-6">
	<br>
	<br>
	@foreach ($datosO2 as $dato)

<span>
	<svg width="30" height="10">
  <rect id={{$item}} width="30" height="10" style="fill:rgb(0,0,255);stroke-width:1;stroke:rgb(0,0,0)" />
	</svg> {{ round(($dato->cantidad * 100) /$total,1) }}%  {{ $dato->descripcion }}</span>
	<br>

	<?php $item++; ?>

	@endforeach

</div>





<script type="text/javascript">

//datos inicio
var porcenTotal = 0;
var desc = 0;
var dat = 0;

var backgroundColor = ['rgba(54, 162, 235, 0.2)','rgba(255, 206, 86, 0.2)','rgba(75, 192, 192, 0.2)','rgba(153, 102, 255, 0.2)','rgba(255, 159, 64, 0.2)','rgba(255, 99, 132, 0.2)', 'rgba(36, 113, 163, 0.2)','rgba(243, 156, 18, 0.2)','rgba(23, 165, 137, 0.2)','rgba(36, 113, 163, 0.2)','rgba(106, 32, 23, 0.2)','rgba(21, 95, 27, 0.2)','rgba(132, 221, 223, 0.2)','rgba(71, 45, 97, 0.2)','rgba(218, 223, 50, 0.2)','rgba(18, 238, 188, 0.2)','rgba(9, 98, 244, 0.2)','rgba(244, 9, 151, 0.2)','rgba(30, 244, 9, 0.2)','rgba(244, 9, 9, 0.2)','rgba(9, 102, 244, 0.2)','rgba(47, 134, 26, 0.2)'];

var borderColor = ['rgba(54, 162, 235, 1)','rgba(255, 206, 86, 1)','rgba(75, 192, 192, 1)','rgba(153, 102, 255, 1)','rgba(255, 159, 64, 1)','rgba(255,99,132,1)', 'rgba(36, 113, 163, 1)','rgba(243, 156, 18, 1)','rgba(23, 165, 137, 1)','rgba(36, 113, 163, 1)','rgba(106, 32, 23, 1)','rgba(21, 95, 27, 1)','rgba(132, 221, 223, 1)','rgba(71, 45, 97, 1)','rgba(218, 223, 50, 1)','rgba(18, 238, 188, 1)','rgba(9, 98, 244, 1)','rgba(244, 9, 151, 1)','rgba(30, 244, 9, 1)','rgba(244, 9, 9, 1)','rgba(9, 102, 244, 1)','rgba(9, 9, 244, 1)','rgba(47, 134, 26, 1)',];

console.log("cargar grafico");

var descripcion = new Array();
var datos = new Array();
var background = new Array();
var border = new Array();

var grafico = <?php echo $datos2 ?>;

if(grafico.length > 0){

	porcenTotal = 0;

	//for (var i = grafico.length - 1; i >= 0; i--) {
	for (var i = 0; i < grafico.length; i++) {

			//if (i == grafico.length - 1 ){
			if (i == 0 ){

				porcenTotal = parseInt(grafico[i]['cantidad']);

			}else{

				porcenTotal =  porcenTotal  + parseInt(grafico[i]['cantidad']);
			}
			
	}

	console.log(porcenTotal);

	//for (var i = grafico.length - 1; i >= 0; i--) {
	for (var i = 0; i < grafico.length; i++) {

			dat = (parseInt(grafico[i]['cantidad']) * 100) / porcenTotal;

			//opcion 1 con descripcion
			//desc = grafico[i]['descripcion'] + ' ' + dat.toFixed(2) + '%' ;

			//opcion 2 descripcion vacia
			//desc = '';

			//opcion 3 descripcion con valor
			desc = dat.toFixed(1) + '%';
			document.getElementById(i).style.fill = backgroundColor[i];
			document.getElementById(i).style.stroke = borderColor[i];

			//style="fill:rgb(0,0,255);stroke-width:1;stroke:rgb(0,0,0)"

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


	//GRAFICO INICIO

if(datos.length > 7){

	console.log("horizontal");
	var ctx3 = document.getElementById("Grafico3").getContext('2d');
	var myChart = new Chart(ctx3, {
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

	$('#Grafico2').hide();

}else{

	var ctx2 = document.getElementById("Grafico2").getContext('2d');
	var myChart = new Chart(ctx2, {
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

}

</script>