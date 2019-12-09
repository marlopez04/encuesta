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

		<a class="btn" style="background-color:rgb(173,219,173);" href="{{ route('estadistica.sede')}}" role="button">Sede</a>
		<a class="btn btn-success" href="{{ route('estadistica.demografico')}}" role="button">Demografico</a>

		<br>
	</div>

</div>

<div class="col col-lg-1"></div>
	<div class="col col-lg-5">
		<h4>General Cofaral</h4>
		<canvas id="SedeTotal" style="max-width: 500px;"></canvas>
		<br>
		<br>
		<h4>Salta</h4>
		<canvas id="SedeSalta" style="max-width: 500px;"></canvas>		
		<br>
		<br>
	</div>
	<div class="col col-lg-5">
		<h4>Tucuman</h4>
		<canvas id="SedeTucuman" style="max-width: 500px;"></canvas>
		<br>
		<br>
		<h4>Chaco</h4>
		<canvas id="SedeChaco" style="max-width: 500px;"></canvas>
		
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

var porcenTotal = 0;
var desc = 0;
var dat = 0;

/*
*/
//datos fin

//datos total Tucuman

console.log("tucuman");

var descripciontuc = new Array();
var datostuc = new Array();

var tuc = <?php echo $sedetucuman ?>;

if(tuc.length > 0){

	porcenTotal = 0;

	for (var i = tuc.length - 1; i >= 0; i--) {

			if (i == tuc.length - 1 ){

				porcenTotal = parseInt(tuc[i]['cantidad']);

			}else{

				porcenTotal =  porcenTotal  + parseInt(tuc[i]['cantidad']);
			}
			
	}

	console.log(porcenTotal);

	for (var i = tuc.length - 1; i >= 0; i--) {

			dat = (parseInt(tuc[i]['cantidad']) * 100) / porcenTotal;

			desc = tuc[i]['favorabilidad'] + ' ' + dat.toFixed(2) + '%' ;
	
			descripciontuc.push(desc);

			datostuc.push(dat.toFixed(2));

	}
}


/*
*/
//datos total Tucuman


//datos total Salta

console.log("Salta");

var descripcionsalt = new Array();
var datossalt = new Array();

var salt = <?php echo $sedesalta ?>;

if(salt.length > 0){

	porcenTotal = 0;

	for (var i = salt.length - 1; i >= 0; i--) {

			if (i == salt.length - 1 ){

				porcenTotal = parseInt(salt[i]['cantidad']);

			}else{

				porcenTotal =  porcenTotal  + parseInt(salt[i]['cantidad']);
			}
			
	}

	console.log(porcenTotal);

	for (var i = salt.length - 1; i >= 0; i--) {

			dat = (parseInt(salt[i]['cantidad']) * 100) / porcenTotal;

			desc = salt[i]['favorabilidad'] + ' ' + dat.toFixed(2) + '%' ;
	
			descripcionsalt.push(desc);

			datossalt.push(dat.toFixed(2));

	}
}

/*
*/
//datos total Salta

//datos total chaco

console.log("Salta");

var descripcionchac = new Array();
var datoschac = new Array();

var chac = <?php echo $sedechaco ?>;

if(chac.length > 0){

	porcenTotal = 0;

	for (var i = chac.length - 1; i >= 0; i--) {

			if (i == chac.length - 1 ){

				porcenTotal = parseInt(chac[i]['cantidad']);

			}else{

				porcenTotal =  porcenTotal  + parseInt(chac[i]['cantidad']);
			}
			
	}

	console.log(porcenTotal);

	for (var i = chac.length - 1; i >= 0; i--) {

			dat = (parseInt(chac[i]['cantidad']) * 100) / porcenTotal;

			desc = chac[i]['favorabilidad'] + ' ' + dat.toFixed(2) + '%' ;
	
			descripcionchac.push(desc);

			datoschac.push(dat.toFixed(2));

	}
}


/*
*/
//datos total Chaco


//datos total inicio

console.log("total");

var descripciontot = new Array();
var datostot = new Array();

var total = <?php echo $sedetotal ?>;

console.log(total);
console.log(total.length);

if(total.length > 0){

/*
	porcenTotal = 0;

	for (var i = total.length - 1; i >= 0; i--) {

			if (i == total.length - 1 ){

				porcenTotal = parseInt(total[i]['cantidad']);

			}else{

				porcenTotal =  porcenTotal  + parseInt(total[i]['cantidad']);
			}
			
	}

	console.log(porcenTotal);
*/

	

	var j = 0;

	for (var i = total.length - 1; i >= 0; i--) {

		dat = (parseFloat(datostuc[j]) + parseFloat(datossalt[j]) + parseFloat(datoschac[j]) ) / 3;

		datostot.push(dat.toFixed(2));

			//dat = (parseInt(total[i]['cantidad']) * 100) / porcenTotal;

			desc = total[i]['favorabilidad'] + ' ' + dat.toFixed(2) + '%' ;
	
			descripciontot.push(desc);

		j = j + 1;

	}
}

console.log(descripciontot);
console.log(datostot);

/*
*/
//datos total final


	//GRAFICO INICIO

var ctxP = document.getElementById("SedeTotal").getContext('2d');
var myPieChart = new Chart(ctxP, {
type: 'pie',
data: {
//labels: ["Red", "Green", "Yellow"],
labels: descripciontot,
fills: descripciontot,
datasets: [{
data: datostot,
backgroundColor: ["#46BFBD","#FDB45C","#F7464A"],
hoverBackgroundColor: ["#5AD3D1","#FFC870","#FF5A5E"]
}]
},
options: {
responsive: true

}
});

var ctxP = document.getElementById("SedeTucuman").getContext('2d');
var myPieChart = new Chart(ctxP, {
type: 'pie',
data: {
//labels: ["Red", "Green", "Yellow"],
labels: descripciontuc,
datasets: [{
data: datostuc,
backgroundColor: ["#46BFBD","#FDB45C","#F7464A"],
hoverBackgroundColor: ["#5AD3D1","#FFC870","#FF5A5E"]
}]
},
options: {
responsive: true
}
});

var ctxP = document.getElementById("SedeSalta").getContext('2d');
var myPieChart = new Chart(ctxP, {
type: 'pie',
data: {
//labels: ["Red", "Green", "Yellow"],
labels: descripcionsalt,
datasets: [{
data: datossalt,
backgroundColor: ["#46BFBD","#FDB45C","#F7464A"],
hoverBackgroundColor: ["#5AD3D1","#FFC870","#FF5A5E"]
}]
},
options: {
responsive: true
}
});

var ctxP = document.getElementById("SedeChaco").getContext('2d');
var myPieChart = new Chart(ctxP, {
type: 'pie',
data: {
//labels: ["Red", "Green", "Yellow"],
labels: descripcionchac,
datasets: [{
data: datoschac,
backgroundColor: ["#46BFBD","#FDB45C","#F7464A"],
hoverBackgroundColor: ["#5AD3D1","#FFC870","#FF5A5E"]
}]
},
options: {
	responsive: true,
    legend:{
      display:true,
      labels:{
        fontColor:'#777'
      }
    }
},
fillText: descripcionchac
});

	//GRAFICO FIN


//prueba de etiqueta de porcentaje INICIO

var start_angle = 0;
 
for (categ in this.options.data){
 
    val = this.options.data[categ];
 
    slice_angle = 2 * Math.PI * val / total_value;
 
    var pieRadius = Math.min(this.canvas.width/2,this.canvas.height/2);
 
    var labelX = this.canvas.width/2 + (pieRadius / 2) * Math.cos(start_angle + slice_angle/2);
 
    var labelY = this.canvas.height/2 + (pieRadius / 2) * Math.sin(start_angle + slice_angle/2);
 
    if (this.options.doughnutHoleSize){
 
        var offset = (pieRadius * this.options.doughnutHoleSize ) / 2;
 
        labelX = this.canvas.width/2 + (offset + pieRadius / 2) * Math.cos(start_angle + slice_angle/2);
 
        labelY = this.canvas.height/2 + (offset + pieRadius / 2) * Math.sin(start_angle + slice_angle/2);               
 
    }
 
 
    var labelText = Math.round(100 * val / total_value);
 
    this.ctx.fillStyle = "white";
 
    this.ctx.font = "bold 20px Arial";
 
    this.ctx.fillText(labelText+"%", labelX,labelY);
 
    start_angle += slice_angle;
 
}

//prueba de etiqueta de porcentaje FIN



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
