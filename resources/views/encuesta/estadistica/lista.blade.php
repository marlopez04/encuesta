
{!! Form::select('demografico3', $demograficos2, 'Sede', ['id' => 'demografico3', 'class' => 'form-control select-category', 'required']) !!}


{!! Form::open(['route' => ['estadistica.injeccionmultiple'], 'method' => 'GET' , 'id' => 'form-demografico3' ]) !!}
{!! Form::close() !!}


<script type="text/javascript">

//funcion para cargar el grafico

	$('#demografico3').change(function(){
		
		var demografico = $('#demografico').val();
		var demografico2 = $('#demografico3').val();
		
	  var form = $('#form-demografico3');

	  var url = form.attr('action');

		data = {demografico: demografico, demografico2: demografico2};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

	});


$(document).ready(function(){

		var demografico = $('#demografico').val();
		var demografico2 = $('#demografico3').val();
		
	  var form = $('#form-demografico3');

	  var url = form.attr('action');

		data = {demografico: demografico, demografico2: demografico2};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

});



</script>