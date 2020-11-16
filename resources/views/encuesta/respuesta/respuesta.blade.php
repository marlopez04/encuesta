@extends('template.main')

@section('title', 'Agregar Un Insumo')

@section('content')
<div class="panel panel-widget">
	<div class="panel-title">
	</div>
<!--
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
				<th>PREGUNTA</th>

					<tr>
						<td>{{$item->id}}</td>
						<td>{{$item->contenido}}</td>
					</tr>

					<tr>
						<td colspan="2">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
							@foreach ($opciones as $opcion)
								@if($opcion->codigo == $item->tipo_id)				
  								<label class="btn btn-warning">
    							<a class="opcion" onclick='opcion1(this)' data-id="{{$opcion->id}}" type="radio" name="options" id="option1" autocomplete="off"> {{$opcion->opcion}}
  								</a>
  								</label>
								@endif
							@endforeach
							</div>
						</td>
					</tr>
			
			</table>			
		</div>
-->

<div id='sector1'>

        <div class="carousel-inner" role="listbox">
            <!-- ngRepeat: pregunta in listaDePreguntas --><!-- ngIf: $index < 1 -->
			@if($item->id == 54)
				<div class="item pregunta2 active ng-scope col-md-12">
			@else
				<div class="item pregunta active ng-scope col-md-12">
			@endif
            
                <p class="ng-binding">{{$item->numero}}- {{$item->contenido}}</p>
           @if($item->id == 54)

		   	<?php $tabla=0  ?>
			<table>
	
                @foreach ($opciones as $opcion)

					@if( $tabla ==0 )
						<tr>
					@endif
				

                	<?php $pintado=0  ?>

                	@if($opcion->codigo == $item->tipo_id)

                	@foreach($encuestado->respuestasmultiples as $respuesta) <!-- 2 -->

                  		@if($respuesta->opcion_id == $opcion->id)

						  	<td style="padding: 10px;">

                    		<span onclick='pregunta(this)' data-p="{{$item->id}}" data-e="{{$encuestado->id}}" data-s="4" data-o="{{$opcion->id}}"  data-check="0" class="chekeado" style="color:rgb(255,189,117);">
                    		<input type="radio" value="0" checked="checked">
                    		<label class="ng-binding" >{{$opcion->opcion}}</label>
                    		</span>
                    		
                    		<?php $pintado=1  ?>

							<?php $tabla = $tabla + 1 ?>
							</td>
                  		@endif

                  	@endforeach

                  		@if($pintado == 0)

						  	<td style="padding: 10px;">

                  			<span onclick='pregunta(this)' data-p="{{$item->id}}" data-e="{{$encuestado->id}}" data-check="0" data-s="4" data-o="{{$opcion->id}}" class="ng-scope">
                    		<input type="radio" value="5">
		                    <label class="ng-binding">{{$opcion->opcion}}</label>
                    		</span>

							</td>
							<?php $tabla=$tabla + 1 ?>
          				@endif

          			@endif

					  
					  @if( $tabla ==3 )
						<tr>
						<?php $tabla=0  ?>
					@endif

        		@endforeach
				
</table>

        	@else

        		@foreach ($opciones as $opcion)
                	@if($opcion->codigo == $item->tipo_id)
                  		@if($PregOpc == $opcion->id)
                    		<span onclick='pregunta(this)' data-p="{{$item->id}}" data-e="{{$encuestado->id}}" data-s="4" data-o="{{$opcion->id}}"  data-check="0" class="chekeado">
                    		<input type="radio" value="0" checked="checked">
                    		<label class="ng-binding" style="color:rgb(255,189,117);">{{$opcion->opcion}}</label>
                    		</span>
                  		@else
                    		<span onclick='pregunta(this)' data-p="{{$item->id}}" data-e="{{$encuestado->id}}" data-check="0" data-s="4" data-o="{{$opcion->id}}" class="ng-scope">
                    		<input type="radio" value="5">
		                    <label class="ng-binding">{{$opcion->opcion}}</label>
                    		</span>
                  		@endif

          			@endif
        		@endforeach


           @endif

        	<br>
        	<br>
        	<br>

        </div>


<ol class="carousel-indicators carousel-indicators-numbers">

<?php $cantidad =0; ?>

	@foreach($items as $pregunta)

		<?php $pintado=0  ?>

			@if($pregunta->id == $item->id && $pintado == 0)

<!-- modificacion 2020 por numeracion de preguntas 16.11.2020-->

 				<li data-target="#myCarousel"onclick='pregunta(this)' data-p="{{$pregunta->id}}" data-e="{{$encuestado->id}}" data-s="3" data-o="0" data-slide-to="0" class="active">{{$pregunta->numero}}</li>
<!-- modificacion 2020 por numeracion de preguntas 16.11.2020-->

 				<?php $pintado=1;  ?>
		
			@endif

		@foreach($encuestado->respuestas as $respuesta)

 			@if($pregunta->id == $respuesta->item_id && $pintado == 0)

<!-- modificacion 2020 por numeracion de preguntas 16.11.2020-->
 				<li data-target="#myCarousel"onclick='pregunta(this)' data-p="{{$pregunta->id}}" data-e="{{$encuestado->id}}" style="background: rgb(255,189,117);" data-s="3" data-o="0" data-slide-to="0" class="active">{{$pregunta->numero}}</li>
<!-- modificacion 2020 por numeracion de preguntas 16.11.2020-->
 				<?php $pintado=1;  ?>
		
			@endif
	
		@endforeach

			@if($pintado == 0)

				<li class="sincontestar" data-target="#myCarousel"onclick='pregunta(this)' data-p="{{$pregunta->id}}" data-e="{{$encuestado->id}}"  data-s="3" data-o="0" data-slide-to="0">{{$pregunta->numero}}</li>

			@endif
	

	@endforeach
	<br>
	<br>
		<li><button class="btn btn-success" onclick='botonfinalizar()' style="width: 100px; margin-left: -35px; cursor: pointer;">FINALIZAR</button></li>

</ol>

	</div>
<!--
        <a class="left carousel-control prev" href="" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control next" href="" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
-->

</div>

</div>

<div id="sector2"></div>

{!! Form::open(['route' => ['encuesta.item.show', ':ID'], 'method' => 'POST' , 'id' => 'form-item' ]) !!}
{!! Form::close() !!}


{!! Form::open(['route' =>'respuestamultiple', 'method' => 'POST', 'id' => 'form-multiple' ]) !!}

<input type="hidden" name="datos" id="datos">

{!! Form::close() !!}

@endsection


@section('js')


<script type="text/javascript">

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var contestadas = '{{ $contestadas }}';

var aItems = [];

var aItems2 = <?php echo $encuestado->respuestasmultiples ?>;

console.log(aItems2);

if(aItems2.length > 0){
	for (var i = aItems2.length - 1; i >= 0; i--) {
		var obj = {
  				encuestado : aItems2[i]['encuestado_id'],
  				pregunta   : aItems2[i]['item_id'],
		  		 status    : 4,
		  		 opcion    : aItems2[i]['opcion_id']
		  		};
		  	aItems.push(obj);
	}
}

console.log(aItems);

var preg  = '{{ $item->id}}';

//var respuestasmultiples  = '{{ $encuestado1}}';

// console.log(respuestasmultiples);


console.log(preg);


function botonfinalizar(){

	console.log(contestadas);

	if (contestadas == 54 && aItems.length == 10) {
		alert("¡Encuesta finalizada con éxito!");
		window.location.replace('{{route("encuesta.encuestado.create")}}');
	}else{
		alert("debe contestar todas las preguntas");
		$('.sincontestar').css('background','RED');
	}
  

  };

function pregunta(objeto){
	//controlo si es la pregunta 54
	
	if (preg == 54 && ($(objeto).attr('class') == 'ng-scope' || $(objeto).attr('class') =='chekeado' || $(objeto).attr('class') == 'uncheked' )) {
		console.log('entra por la 54');
		//controlo si ya estaba elegida la respuesta
		if ($(objeto).attr('class') == 'chekeado') {
			//desmarco la opcion
			console.log("desmarcar");
			$(objeto).attr('class','uncheked');
		  	$(objeto).css('color','#204d74');
		  	$(objeto).children().removeAttr('checked');

		  	for (var i = aItems.length - 1; i >= 0; i--) {
		  		if (aItems[i]['opcion'] == $(objeto).data('o')) {
		  			console.log($(objeto).data('o'));
		  			console.log('esta duplicado');
		  			aItems.splice(i,1);
		  			console.log(JSON.stringify(aItems));
		  		}
		  	}

		  	//aItems.push();

		}else {

			if (aItems.length >= 10) {
				alert("solo puede seleccionar 10");
				return false;
			}

			//marco como seleccionado

			$(objeto).css('color','rgb(255,189,117)');
			$(objeto).children().attr('checked','checked');

		var obj = {
  				encuestado : $(objeto).data('e'),
  				pregunta   : $(objeto).data('p'),
		  		 status    : $(objeto).data('s'),
		  		 opcion    : $(objeto).data('o')
		  		};
		  	aItems.push(obj);


		  	$(objeto).attr('class','chekeado');

		  	console.log($(objeto).attr('class'));
		  	

		  	if(aItems.length == 10)
		  	{
		  		//console.log('5 selecciandas');
		  		var  json_items = JSON.stringify(aItems);

		  		var form = $('#form-multiple');
		  		var url = form.attr('action');
		  		
			  	//data = JSON.stringify(aItems);
			  	$('#datos').val(json_items);

			  	data = form.serialize();

			  	console.log(data);

			  	data1 = {token: data};

			  		$.post(url, data, function(respondidas){
			  			  console.log("json ok");

							console.log(respondidas);

							contestadas = respondidas;

							console.log(contestadas);
			  		  
			   		});

		  	}
		}

	}else{

		if (preg == 54 && aItems.length < 10) {
			alert("debe seleccionar 10 opciones antes de continuar");
			return false;
		}

	  console.log("llama a la funcion");
  		console.log($(objeto).data('e'));
  		console.log($(objeto).data('p'));
  		console.log($(objeto).data('s'));
  		console.log($(objeto).data('o'));

  		var encuestado = $(objeto).data('e');
  		var pregunta   = $(objeto).data('p');
		  var status   = $(objeto).data('s');
		  var opcion   = $(objeto).data('o');

		  var form = $('#form-item');
		  var url = form.attr('action').replace(':ID', pregunta);

			  data = {
			    encuestado: encuestado,
			    pregunta: pregunta,
			    status: status,
			    opcion:opcion
			  };

			  $.get(url, data, function(pregunta){
			  		  console.log("json ok");
			  		  
				      $('#sector1').hide();
				      $('#sector2').show().fadeOut().html(pregunta).fadeIn();
			   });

			}
  };


</script>


@endsection