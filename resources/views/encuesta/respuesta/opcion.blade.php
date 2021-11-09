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

</div>


<script type="text/javascript">

function opcion1(opcion){
  console.log("llama a la funcion");
  console.log($(opcion).data('id'));

	  var form = $('#form-sector');
	  var id_area = $('#area').val();
	  var url = form.attr('action').replace(':ID', id_area);
//para imprimir form2 lista vieja, form3 lista nueva

//	  var token = form.serialize();
	  console.log(id_area);
//recupero lista vieja
	  data = {
	    token: token
	  };
		data = {};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector').show().fadeOut().html(listasector).fadeIn();
	   });

/*
*/
  };

</script>