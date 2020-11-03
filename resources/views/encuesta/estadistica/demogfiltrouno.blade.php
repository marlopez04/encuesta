
<?php $encu = 5; ?>

<?php $descripcion = array('sede', 'participacion x demog', 'favorabilidad demografico','indice dimension factor', 'respuesta multiple','preguntas'); ?>

<?php $funcion = array('sede', 'participacionxdemog', 'favorabilidaddemografico','indicedimensionfactor', 'multiple','preguntas'); ?>

<?php $direccion = array(route('estadistica.sede', $encu),route('estadistica.demografico', $encu),route('estadistica.favorabilidaddemografico', $encu),route('estadistica.indicedimensionfactor', $encu),route('estadistica.multiple', $encu), route('estadistica.preguntas', $encu)); ?>

<!--actualizacion->

@if ( $menuitem == 3)
<div class='row'>
    <div class="col col-lg-1"></div>
    <div class="col col-lg-5">
        <br>
            {!! Form::select('demografico', $indicadores, 'Indice', ['id' => 'indicadores', 'class' => 'form-control select-category', 'required']) !!}
    </div>
    <div class="col col-lg-6"></div>
</div>
@endif

<div class='row'>
    <div class="col col-lg-1"></div>
    <div class="col col-lg-5">
        <br>
        {!! Form::select('demografico', $demograficos, 'Sede', ['id' => 'demografico1', 'class' => 'form-control select-category', 'required']) !!}
        <div id="demog2">
            {!! Form::select('demografico', $demograficos2, 'Sede', ['id' => 'demografico2', 'class' => 'form-control select-category', 'required']) !!}
        </div>
        <div id="demog3"></div>
    </div>
    <div class="col col-lg-5">
        <br>
        {!! Form::select('demografico', $demograficos, 'Sede', ['id' => 'demografico4', 'class' => 'form-control select-category', 'required']) !!}
        <div id="demog5">
            {!! Form::select('demografico', $demograficos2, 'Sede', ['id' => 'demografico5', 'class' => 'form-control select-category', 'required']) !!}
        </div>
        <div id="demog6"></div>	
    </div>
</div>
<!-- FORMULARIO PARA LA RUTA QUE MUESTRA LA LISTA DEL CONTENIDO DE CADA DEMOGRAFICO-->
{!! Form::open(['route' => ['estadistica.demogshow'], 'method' => 'GET' , 'id' => 'form-demografico' ]) !!}
{!! Form::close() !!}

@if ($menuitem == 2)

		{!! Form::open(['route' => ['estadistica.injeccionfavorabilidaddemo'], 'method' => 'GET' , 'id' => 'form-demografico2' ]) !!}
		{!! Form::close() !!}

@elseif ($menuitem == 3)

		{!! Form::open(['route' => ['estadistica.injeccionindicedimensionfactor'], 'method' => 'GET' , 'id' => 'form-demografico2' ]) !!}
		{!! Form::close() !!}

@elseif ($menuitem == 4)

		{!! Form::open(['route' => ['estadistica.injeccionmultiple'], 'method' => 'GET' , 'id' => 'form-demografico2' ]) !!}
		{!! Form::close() !!}
        
@elseif ($menuitem == 5)

		{!! Form::open(['route' => ['estadistica.injeccionpreguntas'], 'method' => 'GET' , 'id' => 'form-demografico2' ]) !!}
		{!! Form::close() !!}

@endif


<script>

$('#demografico2').prepend('<option value="todos" selected>todos</option>');
$('#demografico2').attr('selected','0');
$('#demografico5').prepend('<option value="todos" selected>todos</option>');
$('#demografico5').attr('selected','0');

var funcion = "<?php echo $funcion[$menuitem] ?>";

//funcion para cargar el lisdato del demografico3

$(document).ready(function(){

    var control = <?php echo $menuitem ?>;

    console.log("ingresa por la funcion");

    if (control == 2){
        document.getElementById("demografico2").style.display = "none";
        document.getElementById("demografico2").hidden = true;
        $('#demografico2').hide();
    }
    
});

$('#demografico1').change(function(){

    var menuitem = <?php echo $menuitem ?>;
		
		var demografico = $('#demografico1').val();
		
      var form = $('#form-demografico');
      
      console.log(menuitem);

	  var url = form.attr('action');
      
      //variable que define si agrega lista (1)demografico3 o (2)demografico6
      var parametro = 1;

		data = {demografico: demografico, funcion: funcion, parametro: parametro, menuitem: menuitem};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#demog3').show().fadeOut().html(listasector).fadeIn();
		      $('#demog2').hide();
	   });

    });
    
//funcion para cargar el lisdato del demografico6
$('#demografico4').change(function(){

        var menuitem = <?php echo $menuitem ?>;
		
		var demografico = $('#demografico4').val();
		
	  var form = $('#form-demografico');

	  var url = form.attr('action');
      
      //variable que define si agrega lista (1)demografico3 o (2)demografico6
      var parametro = 2;

		data = {demografico: demografico, funcion: funcion, parametro: parametro, menuitem:menuitem};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#demog6').show().fadeOut().html(listasector).fadeIn();
		      $('#demog5').hide();
	   });

	});


$('#demografico2').change(function(){

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

  var form = $('#form-demografico2');

  var url = form.attr('action');

    data = {demografico1: demografico1, demografico3: demografico3, demografico4:demografico4, demografico6: demografico6, indicador: indicador};
  $.get(url, data, function(listasector){
            console.log("json ok");
          $('#sector2').show().fadeOut().html(listasector).fadeIn();
          $('#sector1').hide();
   });

});

$('#demografico5').change(function(){

console.log("ingresa en 5");
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

  var form = $('#form-demografico2');

  var url = form.attr('action');

    data = {demografico1: demografico1, demografico3: demografico3, demografico4:demografico4, demografico6: demografico6, indicador: indicador};
  $.get(url, data, function(listasector){
            console.log("json ok");
          $('#sector2').show().fadeOut().html(listasector).fadeIn();
          $('#sector1').hide();
   });

});

$('#indicadores').change(function(){

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

  var form = $('#form-demografico2');

  var url = form.attr('action');

    data = {demografico1: demografico1, demografico3: demografico3, demografico4:demografico4, demografico6: demografico6, indicador: indicador};
  $.get(url, data, function(listasector){
            console.log("json ok");
          $('#sector2').show().fadeOut().html(listasector).fadeIn();
          $('#sector1').hide();
   });

});




</script>


