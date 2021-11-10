@extends('template.main')

@section('title', 'Agregar Un Insumo')

@section('content')
<div class="container">

	<div id='sector1'>

		<div class="carousel-inner " role="listbox" style="padding-bottom: 1.5rem;">
			<!-- ngRepeat: pregunta in listaDePreguntas -->
			<!-- ngIf: $index < 1 -->
			@if($item->id == 54)
			<div class="item pregunta2 active ng-scope col-md-12">
				@else
				<div>


					<div class="item pregunta active ng-scope col-md">
						@endif

						<div class="" style="padding-bottom: 1.5rem;">
							<div class="parrafo">
								<p class="ng-binding ">{{$item->numero}} - {{$item->contenido}}</p>
							</div>
						</div>

						@if($item->id == 54)
						<div class="row">


							<?php $tabla = 0  ?>


							@foreach ($opciones as $opcion)

							@if( $tabla ==0 )

							@endif


							<?php $pintado = 0  ?>

							@if($opcion->codigo == $item->tipo_id)

							@foreach($encuestado->respuestasmultiples as $respuesta)


							@if($respuesta->opcion_id == $opcion->id)

							<div class="col-md-6">
								<div class="well well-sm margin-bottom-none text-left">
									<div class="checkbox">
										<label>
											<span onclick='pregunta(this)' data-p="{{$item->id}}" data-e="{{$encuestado->id}}" data-s="4" data-o="{{$opcion->id}}" data-check="0" class="chekeado" style="color:rgb(255,189,117);">
												<input type="radio" value="0" checked="checked">
												<label class="ng-binding">{{$opcion->opcion}}</label>
											</span>
										</label>
									</div>
								</div>
							</div>



							<?php $pintado = 1  ?>

							<?php $tabla = $tabla + 1 ?>

							@endif

							@endforeach

							@if($pintado == 0)

							<div class="col-md-6">
								<div class="well well-sm margin-bottom-none text-left">
									<div class="checkbox">
										<label>
											<span onclick='pregunta(this)' data-p="{{$item->id}}" data-e="{{$encuestado->id}}" data-check="0" data-s="4" data-o="{{$opcion->id}}" class="ng-scope">
												<input type="radio" value="5">
												<label class="ng-binding">{{$opcion->opcion}}</label>
											</span>

										</label>
									</div>
								</div>
							</div>



							<?php $tabla = $tabla + 1 ?>
							@endif

							@endif


							@if( $tabla ==3 )


							<?php $tabla = 0  ?>
							@endif

							@endforeach




							@else

							@foreach ($opciones as $opcion)
							@if($opcion->codigo == $item->tipo_id)
							@if($PregOpc == $opcion->id)
							<div class="col-md-6">
								<div class="well well-sm margin-bottom-none text-left">
									<div class="checkbox">
										<label>
											<span onclick='pregunta(this)' data-p="{{$item->id}}" data-e="{{$encuestado->id}}" data-s="4" data-o="{{$opcion->id}}" data-check="0" class="chekeado">
												<input type="radio" value="0" checked="checked">
												<label class="ng-binding" style="color:rgb(255,189,117);">{{$opcion->opcion}}</label>
											</span>
										</label>
									</div>
								</div>
							</div>

							@else
							<div class="col-md-6">
								<div class="well well-sm margin-bottom-none text-left">
									<div class="checkbox">
										<label>
											<span onclick='pregunta(this)' data-p="{{$item->id}}" data-e="{{$encuestado->id}}" data-check="0" data-s="4" data-o="{{$opcion->id}}" class="ng-scope">
												<input type="radio" value="5">
												<label class="ng-binding">{{$opcion->opcion}}</label>
											</span>
										</label>
									</div>
								</div>
							</div>

							@endif

							@endif
							@endforeach

						</div>
						@endif

						<br>


					</div>


					<div class=" text-center col-md botonesEncuesta">
						<div class="d-flex justify-content-around row">
							<button type="button" class="btn btn-primary botonEncuesta" data-toggle="modal"  onclick="abrir()">VER RESPUESTAS</button>

							<button type="button" class="btn btn-success botonEncuesta" onclick='botonfinalizar()' data-target="#modalalert">ENVIAR ENCUESTA</button>
						</div>
						<!-- Alerta -->

						<div class="modal " id="modalalert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header alerta">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true" style="color: #fff !important;">&times;</span>
										</button>
										<h5 class="modal-title" id="exampleModalLabel">¡Encuesta no finalizada, por favor conteste todas las preguntas!</h5>
									</div>
								</div>
							</div>
						</div>

						<!-- Modal -->

						<div class="modal fade" id="modalresp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<h4 class="modal-title" id="exampleModalLabel">Sus Respuestas</h4>
									</div>
									<div class="modal-body">
										<div>
											<ol class="carousel-indicators carousel-indicators-numbers" style="padding-left: initial;margin-top: 10px;">
												<?php $cantidad = 0; ?>
												@foreach($items as $pregunta)


												<?php $pintado = 0  ?>

												@if($pregunta->id == $item->id && $pintado == 0)

												<li data-target="#myCarousel" onclick='pregunta(this); cerrarModal();' data-p="{{$pregunta->id}}" data-e="{{$encuestado->id}}" data-s="3" data-o="0" data-slide-to="0" class="active">{{$pregunta->numero}}</li>

												<?php $pintado = 1;  ?>

												@endif

												@foreach($encuestado->respuestas as $respuesta)

												@if($pregunta->id == $respuesta->item_id && $pintado == 0)

												<li data-target="#myCarousel" onclick='pregunta(this); cerrarModal();' data-p="{{$pregunta->id}}" data-e="{{$encuestado->id}}" style="background: rgb(255,189,117);" data-s="3" data-o="0" data-r="$respuesta->id" data-slide-to="0" class="active">{{$pregunta->numero}}</li>

												<?php $pintado = 1;  ?>

												@endif

												@endforeach

												@if($pintado == 0)

												<li class="sincontestar" data-target="#myCarousel" onclick='pregunta(this); cerrarModal();' data-p="{{$pregunta->id}}" data-e="{{$encuestado->id}}" data-s="3" data-o="0" data-r="0" data-slide-to="0">{{$pregunta->numero}}</li>

												@endif


												@endforeach

												

											</ol>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal" data-backdrop="false">Cerrar</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<!-- <a class="left carousel-control prev" href="" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control next" href="" role="button" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a> -->


		</div>

	</div>

	<div id="sector2">
	</div>
	

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

		var CantItems = '{{ $CantItems }}';
		var CantMulti = '{{ $CantMulti }}';

		var aItems = [];

		var aItems2 = <?php echo $encuestado->respuestasmultiples ?>;

		//control si tiene respuestas multiples o no
		if (CantMulti == 0) {
			//la encuesta no tiene pregunta con multiples respuestas
			var mult = 10;
			//se le asigna 10 respuestas multiples, por que RRHH asi lo predispuso    
		} else {
			var mult = aItems.length;
		}

		console.log(aItems2);

		if (mult > 0 && CantMulti > 0) {
			for (var i = mult - 1; i >= 0; i--) {
				var obj = {
					encuestado: aItems2[i]['encuestado_id'],
					pregunta: aItems2[i]['item_id'],
					status: 4,
					opcion: aItems2[i]['opcion_id']
				};
				aItems.push(obj);
			}
		}

		console.log(aItems);

		var preg = '{{ $item->id}}';

		//var respuestasmultiples  = '{{ $encuestado1}}';

		// console.log(respuestasmultiples);


		console.log(preg);



		function botonfinalizar() {

			console.log(contestadas);

			//control si tiene respuestas multiples o no
			if (CantMulti == 0) {
				//la encuesta no tiene pregunta con multiples respuestas
				var mult = 10;
				//se le asigna 10 respuestas multiples, por que RRHH asi lo predispuso    
			} else {
				var mult = aItems.length;
			}

			if (contestadas == CantItems && mult == 10) {
				alert("¡Encuesta finalizada con éxito!");
				window.location.replace('{{route("encuesta.encuestado.create")}}');
			} else {
				$("#modalalert").modal('show')
				// alert("¡Encuesta no finalizada, por favor conteste todas las preguntas!");
				$('.sincontestar').css('background', 'RED');
			}


		};

		function abrir() {
			$('#modalresp').modal('hide');
			$('#modalresp').modal('show');


		}


		function cerrarModal() {
			$('#modalresp').modal('hide');
			$('body').removeClass('modal-open');
			$('.fade').remove();
			// $('.modal-backdrop').remove();
		};


		function pregunta(objeto) {
			//controlo si es la pregunta 54 multiple
			
			if (preg == 54 && ($(objeto).attr('class') == 'ng-scope' || $(objeto).attr('class') == 'chekeado' || $(objeto).attr('class') == 'uncheked')) {
				console.log('entra por la 54');
				//controlo si ya estaba elegida la respuesta
				if ($(objeto).attr('class') == 'chekeado') {
					//desmarco la opcion
					console.log("desmarcar");
					$(objeto).attr('class', 'uncheked');
					$(objeto).css('color', '#204d74');
					$(objeto).children().removeAttr('checked');

					for (var i = aItems.length - 1; i >= 0; i--) {
						if (aItems[i]['opcion'] == $(objeto).data('o')) {
							console.log($(objeto).data('o'));
							console.log('esta duplicado');
							aItems.splice(i, 1);
							console.log(JSON.stringify(aItems));
						}
					}

					//aItems.push();

				} else {

					if (aItems.length >= 10) {
						alert("solo puede seleccionar 10");
						return false;
					}

					//marco como seleccionado

					$(objeto).css('color', 'rgb(255,189,117)');
					$(objeto).children().attr('checked', 'checked');

					var obj = {
						encuestado: $(objeto).data('e'),
						pregunta: $(objeto).data('p'),
						status: $(objeto).data('s'),
						opcion: $(objeto).data('o')
					};
					aItems.push(obj);


					$(objeto).attr('class', 'chekeado');

					console.log($(objeto).attr('class'));


					if (aItems.length == 10) {
						//console.log('5 selecciandas');
						var json_items = JSON.stringify(aItems);

						var form = $('#form-multiple');
						var url = form.attr('action');

						//data = JSON.stringify(aItems);
						$('#datos').val(json_items);

						data = form.serialize();

						console.log(data);

						data1 = {
							token: data
						};

						$.post(url, data, function(respondidas) {
							console.log("json ok");

							console.log(respondidas);

							contestadas = respondidas;

							console.log(contestadas);

						});

					}
				}

			} else {

				//control si tiene respuestas multiples o no
				if (CantMulti == 0) {
					//la encuesta no tiene pregunta con multiples respuestas
					var mult = 10;
					//se le asigna 10 respuestas multiples, por que RRHH asi lo predispuso    
				} else {
					var mult = aItems.length;
				}

				if (contestadas == CantItems && mult == 10) {
					alert("¡Encuesta finalizada con éxito!");
					window.location.replace('{{route("encuesta.item.index")}}');
				}

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
				var pregunta = $(objeto).data('p');
				var status = $(objeto).data('s');
				var opcion = $(objeto).data('o');

				var form = $('#form-item');
				var url = form.attr('action').replace(':ID', pregunta);

				data = {
					encuestado: encuestado,
					pregunta: pregunta,
					status: status,
					opcion: opcion
				};

				
				$.get(url, data, function(pregunta) {
					console.log("json ok");

					$('#sector1').html('');
					
					$('#sector2').show().fadeOut().html(pregunta).fadeIn();
				
				});
			}
		};
	</script>


	@endsection