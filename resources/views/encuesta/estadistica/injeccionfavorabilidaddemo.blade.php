<?php $item =0; ?>
<?php $total =0; ?>
<?php $encuest =0; ?>

<?php $max =sizeof($encuestados2); ?>


@foreach ($datosO2 as $dato)

	<?php $total += $dato->cantidad; ?>

@endforeach

<div class="col col-lg-1"></div>
<div class="col-md-5">
	<h4>{{$titulo2}}</h4>
	<div class="grafico">
	<canvas id="Grafico2" style="max-width: 500px;"></canvas>
	<canvas id="Grafico3" style="width: 500px; height: 600px"></canvas>
	</div>
	<div class="nografico" hidden="true">
		<h4>Encuestados insuficientes para graficar</h4>
	</div>
</div>

<div class="col-md-6">
	<div class="grafico">
	<br>
	<br>
	@foreach ($ArrayOrdenID2 as $dato)

			@for ($i = 0; $i < $max; $i++)
	    		@if ($encuestados2[$i]->id == $dato->id)
					<?php $encuest = $encuestados2[$i]->encuestados; ?>
				@endif
			@endfor

				@if ($dato->favorabilidad == "Favorable" && $dato->porcentage > 0 )

					@if ($encuest > 2)

						<span>
							<svg width="30" height="10">
						  <rect id="{{$item}}" width="30" height="10" style="fill:rgb(0,0,255);stroke-width:1;stroke:rgb(0,0,0)" />
							</svg> {{ $dato->porcentage }}%  {{ $dato->descripcion }}</span>
							<br>

							<?php $item++; ?>
					@else

						<span>
							<svg width="30" height="10">
						  <rect id="{{$item}}" width="30" height="10" style="fill:rgba(54, 162, 235, 1);stroke-width:1;stroke:rgb(0,0,0)" />
							</svg> {{ $dato->descripcion }} <b>(Encuestados insuficientes para graficar)</b> </span>
							<br>

							<?php $item++; ?>

					@endif

				@endif

		
	@endforeach
	</div>
</div>


<script type="text/javascript">

//datos inicio
var porcenTotal = 0;
var desc = 0;
var dat = 0;

var backgroundColor = ['rgba(54, 162, 235, 0.2)','rgba(255, 206, 86, 0.2)','rgba(75, 192, 192, 0.2)','rgba(153, 102, 255, 0.2)','rgba(255, 159, 64, 0.2)','rgba(255, 99, 132, 0.2)', 'rgba(36, 113, 163, 0.2)','rgba(243, 156, 18, 0.2)','rgba(23, 165, 137, 0.2)','rgba(36, 113, 163, 0.2)','rgba(106, 32, 23, 0.2)','rgba(21, 95, 27, 0.2)','rgba(132, 221, 223, 0.2)','rgba(71, 45, 97, 0.2)','rgba(218, 223, 50, 0.2)','rgba(18, 238, 188, 0.2)','rgba(9, 98, 244, 0.2)','rgba(244, 9, 151, 0.2)','rgba(30, 244, 9, 0.2)','rgba(244, 9, 9, 0.2)','rgba(9, 9, 244, 0.2)', 'rgba(9, 102, 244, 0.2)','rgba(47, 134, 26, 0.2)', 'rgba(245, 290, 90, 0.2)'];

var borderColor     = ['rgba(54, 162, 235, 1)'  ,'rgba(255, 206, 86, 1)'  ,'rgba(75, 192, 192, 1)'  ,'rgba(153, 102, 255, 1)'  ,'rgba(255, 159, 64, 1)'  ,'rgba(255,99,132,1)'     , 'rgba(36, 113, 163, 1)'  ,'rgba(243, 156, 18, 1)'  ,'rgba(23, 165, 137, 1)'  ,'rgba(36, 113, 163, 1)'  ,'rgba(106, 32, 23, 1)'  ,'rgba(21, 95, 27, 1)'  ,'rgba(132, 221, 223, 1)'  ,'rgba(71, 45, 97, 1)'  ,'rgba(218, 223, 50, 1)'  ,'rgba(18, 238, 188, 1)'  ,'rgba(9, 98, 244, 1)'  ,'rgba(244, 9, 151, 1)'  ,'rgba(30, 244, 9, 1)'  ,'rgba(244, 9, 9, 1)'  ,'rgba(9, 9, 244, 1)'  ,'rgba(9, 102, 244, 1)' ,'rgba(47, 134, 26, 1)' ,'rgba(245, 290, 90, 1)'];

console.log("cargar grafico");

var descripcion = new Array();
var datos = new Array();
var background = new Array();
var border = new Array();

var h = 0;

var porcentage = <?php echo $porcentages2 ?>;
var descripcion3 = <?php echo $descripcion2 ?>;

console.log(descripcion3);

if(porcentage.length > 0){

	var e = 0;

	j = 0;

	for (var i = 0; i < porcentage.length; i++) {


		if (parseInt(porcentage[i]) > 0) {

			dat = parseInt(porcentage[i]);

			console.log(dat);

			desc = parseInt(porcentage[i]) + '%';

			console.log(desc);

			e = j;
			
			if ( descripcion3[h] == "NO") {

				h = h + 1;

				console.log("entro al no: ");

				console.log(descripcion3[h]);

				document.getElementById(e).style.fill = 'rgba(151, 155, 150, 0.2)';
				document.getElementById(e).style.stroke = 'rgba(151, 155, 150, 1)';

			}else{ 

				h = h + 1;

				console.log("entro a descripcion: ");

				console.log(descripcion3[h]);

				document.getElementById(e).style.fill = backgroundColor[j];
				document.getElementById(e).style.stroke = borderColor[j];

				background.push(backgroundColor[j]);
				border.push(borderColor[j]);


				descripcion.push(desc);

				datos.push(dat);


			}

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


//console.log(background);
//console.log(border);

//console.log("cantidad de datos");
//console.log(grafico.length);
	//GRAFICO INICIO

var encuestados = <?php echo $encuestados ?>;

console.log("encuestados: " + encuestados);

if (encuestados > 2) {

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

}else{

	$('.grafico').hide();
	$('.nografico').show();

}

</script>