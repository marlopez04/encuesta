<?php $funcion2 = array('favorabilidaddemografico','indicedimensionfactor', 'multiple','preguntas'); ?>

<?php $direccion = array(route('estadistica.sede'),route('estadistica.demografico'),route('estadistica.favorabilidaddemografico'),route('estadistica.indicedimensionfactor'),route('estadistica.multiple'), route('estadistica.preguntas')); ?>

@if ($funcion == "favorabilidaddemografico")

<!--Elijo si va a cargar la lista de la columna 1 (demografico3)-->
<!--o si va a cargar la lista columna 2 (demografico6)-->

	@if($parametro == 1)
		{!! Form::select('demografico3', $demog, 'Sede', ['id' => 'demografico3', 'class' => 'form-control select-category', 'required']) !!}
    	{!! Form::close() !!}
	@else
		{!! Form::select('demografico6', $demog2, 'Sede', ['id' => 'demografico6', 'class' => 'form-control select-category', 'required']) !!}
    	{!! Form::close() !!}
	@endif

		{!! Form::open(['route' => ['estadistica.injeccionfavorabilidaddemo'], 'method' => 'GET' , 'id' => 'form-demografico3' ]) !!}
		{!! Form::close() !!}

@elseif ($funcion == "indicedimensionfactor")

<!--Elijo si va a cargar la lista de la columna 1 (demografico3)-->
<!--o si va a cargar la lista columna 2 (demografico6)-->

	@if($parametro == 1)
		{!! Form::select('demografico3', $demog, 'Sede', ['id' => 'demografico3', 'class' => 'form-control select-category', 'required']) !!}
    	{!! Form::close() !!}
	@else
		{!! Form::select('demografico6', $demog2, 'Sede', ['id' => 'demografico6', 'class' => 'form-control select-category', 'required']) !!}
    	{!! Form::close() !!}
	@endif

		{!! Form::open(['route' => ['estadistica.injeccionindicedimensionfactor'], 'method' => 'GET' , 'id' => 'form-demografico3' ]) !!}
		{!! Form::close() !!}

@elseif ($funcion == "multiple")

<!--Elijo si va a cargar la lista de la columna 1 (demografico3)-->
<!--o si va a cargar la lista columna 2 (demografico6)-->

	@if($parametro == 1)
		{!! Form::select('demografico3', $demog, 'Sede', ['id' => 'demografico3', 'class' => 'form-control select-category', 'required']) !!}
    	{!! Form::close() !!}
	@else
		{!! Form::select('demografico6', $demog2, 'Sede', ['id' => 'demografico6', 'class' => 'form-control select-category', 'required']) !!}
    	{!! Form::close() !!}
	@endif

		{!! Form::open(['route' => ['estadistica.injeccionmultiple'], 'method' => 'GET' , 'id' => 'form-demografico3' ]) !!}
		{!! Form::close() !!}
        
@elseif ($funcion == "preguntas")

<!--Elijo si va a cargar la lista de la columna 1 (demografico3)-->
<!--o si va a cargar la lista columna 2 (demografico6)-->

	@if($parametro == 1)
		{!! Form::select('demografico3', $demog, 'Sede', ['id' => 'demografico3', 'class' => 'form-control select-category', 'required']) !!}
    	{!! Form::close() !!}
	@else
		{!! Form::select('demografico6', $demog2, 'Sede', ['id' => 'demografico6', 'class' => 'form-control select-category', 'required']) !!}
    	{!! Form::close() !!}
	@endif

		{!! Form::open(['route' => ['estadistica.injeccionpreguntas'], 'method' => 'GET' , 'id' => 'form-demografico3' ]) !!}
		{!! Form::close() !!}

@endif

<script type="text/javascript">

var parametro = <?php echo $parametro ?>;

//funcion para cargar el grafico

	$('#demografico3').change(function(){

	//Controlo si la lista 3 o 6 fueron cargadas sino
	//tomo los valores de las listas 2 o 5
	var dem3 =  document.getElementById('demografico3');
	var dem6 =  document.getElementById('demografico6');

	//controlo si estoy usando indicadores (indice,dimension,factor)
	var indicador =  document.getElementById('indicadores');

	//console.log(dem6);


	if (typeof(dem3) != 'undefined' && dem3 != null)
	{
  		var demografico3 = $('#demografico3').val();
	}else{
		var demografico3 = $('#demografico2').val();
	}

	if (typeof(dem6) != 'undefined' && dem6 != null)
	{
  		var demografico6 = $('#demografico6').val();
	}else{
		var demografico6 = $('#demografico5').val();
	}

	//si esta definido el elemento HTML le asigno el valor, sino 0
	if (typeof(indicador) != 'undefined' && indicador != null)
	{
  		 indicador = $('#indicadores').val();
	}else{
		 indicador = 0;
	}


		var demografico1 = $('#demografico1').val();
		var demografico4 = $('#demografico4').val();

	  var form = $('#form-demografico3');

	  var url = form.attr('action');

		data = {demografico1: demografico1, demografico3: demografico3, demografico4:demografico4, demografico6: demografico6, indicador: indicador};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

	});

	$('#demografico6').change(function(){

	//Controlo si la lista 3 o 6 fueron cargadas sino
	//tomo los valores de las listas 2 o 5
	var dem3 =  document.getElementById('demografico3');
	var dem6 =  document.getElementById('demografico6');

	//controlo si estoy usando indicadores (indice,dimension,factor)
	var indicador =  document.getElementById('indicadores');

	//console.log(dem6);


	if (typeof(dem3) != 'undefined' && dem3 != null)
	{
  		var demografico3 = $('#demografico3').val();
	}else{
		var demografico3 = $('#demografico2').val();
	}

	if (typeof(dem6) != 'undefined' && dem6 != null)
	{
  		var demografico6 = $('#demografico6').val();
	}else{
		var demografico6 = $('#demografico5').val();
	}

	//si esta definido el elemento HTML le asigno el valor, sino 0
	if (typeof(indicador) != 'undefined' && indicador != null)
	{
  		 indicador = $('#indicadores').val();
	}else{
		 indicador = 0;
	}


		var demografico1 = $('#demografico1').val();
		var demografico4 = $('#demografico4').val();

	  var form = $('#form-demografico3');

	  var url = form.attr('action');

		data = {demografico1: demografico1, demografico3: demografico3, demografico4:demografico4, demografico6: demografico6, indicador: indicador};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

	});






$(document).ready(function(){

var parametro = <?php echo $parametro ?>;

if (parametro == 1) {
	$('#demografico3').prepend('<option value="todos" selected>todos</option>');
	$('#demografico3').attr('selected','0');
}else{
	$('#demografico6').prepend('<option value="todos" selected>todos</option>');
	$('#demografico6').attr('selected','0');
}

if (parametro == 1) {


	//Controlo si la lista 3 o 6 fueron cargadas sino
	//tomo los valores de las listas 2 o 5
	var dem3 =  document.getElementById('demografico3');
	var dem6 =  document.getElementById('demografico6');

	//controlo si estoy usando indicadores (indice,dimension,factor)
	var indicador =  document.getElementById('indicadores');

	//console.log(dem6);

var funcion = "<?php echo $menuitem ?>";

//controlo que no este en la estadistica 2
if (funcion == 2){

//si esta en la estadistica 2, no debe mostrar demografico2 ni demografico3
	if (typeof(dem3) != 'undefined' && dem3 != null)
	{
  		$('#demografico3').hide();
	}else{
		$('#demografico2').hide();
	}

}



	if (typeof(dem3) != 'undefined' && dem3 != null)
	{
  		var demografico3 = $('#demografico3').val();
	}else{
		var demografico3 = $('#demografico2').val();
	}

	if (typeof(dem6) != 'undefined' && dem6 != null)
	{
  		var demografico6 = $('#demografico6').val();
	}else{
		var demografico6 = $('#demografico5').val();
	}

	//si esta definido el elemento HTML le asigno el valor, sino 0
	if (typeof(indicador) != 'undefined' && indicador != null)
	{
  		 indicador = $('#indicadores').val();
	}else{
		 indicador = 0;
	}


		var demografico1 = $('#demografico1').val();
		var demografico4 = $('#demografico4').val();
	
		
	  var form = $('#form-demografico3');

	  var url = form.attr('action');

		data = {demografico1: demografico1, demografico3: demografico3, demografico4:demografico4, demografico6: demografico6, indicador: indicador};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

}

});



</script>