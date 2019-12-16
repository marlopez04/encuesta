@extends('template.main')

@section('title', 'Estadisticas')

@section('head')

<link href="{{asset('plugin/MDB-Free/css/mdb.min.css')}}" rel="stylesheet">
<link href="{{asset('plugin/MDB-Free/css/style.css')}}" rel="stylesheet">

<style>



.progress-bar-succes {
  background-color: rgba(244, 9, 9, 0.2) !important;
  border-color: rgba(244, 9, 9, 1) !important;
}	
.progress-bar-warning {
  background-color: rgba(9, 98, 244, 0.2) !important;
  border-color: rgba(9, 98, 244,1) !important;
}
.progress-bar-danger {
  background-color: rgba(9, 102, 244, 0.2) !important;
  border-color: rgba(9, 102, 244, 1) !important;
}

</style>


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



<div class="row">
<div class="col col-lg-1"></div>
<div class="col col-lg-5">
	<br>
	{!! Form::select('demografico', $demograficos, 'Sede', ['id' => 'demografico', 'class' => 'form-control select-category', 'required']) !!}
	<div id="demog1">
		{!! Form::select('demografico', $demograficos2, 'Sede', ['id' => 'demografico2', 'class' => 'form-control select-category', 'required']) !!}
	</div>
	<div id="demog2"></div>
	<br>

</div>
<div class="col col-lg-4"></div>
</div>



<div class="row" id="sector1">
<div class="col col-lg-1"></div>
	<div class="col col-md-10">
<table>
	@foreach ($items as $item)

	@if ($item->id != 54)

		<?php $porcentaje =0; ?>

	<tr>
		<td><h6>{{$item->contenido}}</h6></td>
				<td>
					<svg width="500" height="25">
					@foreach ($datosO1 as $dato)
					

				@if ($item->id == $dato->id and $item->id != 54)

					@if ($dato->favorabilidad == "Favorable")
						<rect width="{{ round(($dato->cantidad * 100) /$total,1) }}%" height="20px" x="0" y="0" style="fill:rgb(0,255,0,0.2);stroke-width:1;stroke:rgb(0,255,0);opacity:0.5" />
							@if (round(($dato->cantidad * 100) /$total,1) < 10)
								<text fill="#000000" font-size="12" font-family="Verdana" x="{{ (round(($dato->cantidad * 100) /$total,1)/2)-1}}%" y="15">{{ round(($dato->cantidad * 100) /$total,0) }}</text>
								<?php $porcentaje = round(($dato->cantidad * 100) /$total,1); ?>
							@else
								<text fill="#000000" font-size="12" font-family="Verdana" x="{{ (round(($dato->cantidad * 100) /$total,1)/2)-1}}%" y="15">{{ round(($dato->cantidad * 100) /$total,0) }}%</text>
								<?php $porcentaje = round(($dato->cantidad * 100) /$total,1); ?>
							@endif
					@endif
					@if ($dato->favorabilidad == "Neutro")
						@if (round(($dato->cantidad * 100) /$total,1) < 10)
							<rect width="{{ round(($dato->cantidad * 100) /$total,1) }}%" height="20px" x="{{$porcentaje}}%" y="0" style="fill:rgb(255,255,0,0.2);stroke-width:1;stroke:rgb(255,255,0);opacity:0.5" />
							<text fill="#000000" font-size="12" font-family="Verdana" x="{{$porcentaje + ( round(($dato->cantidad * 100) /$total,1)/2 ) -1}}%" y="15">{{ round(($dato->cantidad * 100) /$total,0) }}</text>
							<?php $porcentaje = $porcentaje + round(($dato->cantidad * 100) /$total,1); ?>
						@else
							<rect width="{{ round(($dato->cantidad * 100) /$total,1) }}%" height="20px" x="{{$porcentaje}}%" y="0" style="fill:rgb(255,255,0,0.2);stroke-width:1;stroke:rgb(255,255,0);opacity:0.5" />
							<text fill="#000000" font-size="12" font-family="Verdana" x="{{$porcentaje + ( round(($dato->cantidad * 100) /$total,1)/2 ) -1}}%" y="15">{{ round(($dato->cantidad * 100) /$total,0) }}%</text>
							<?php $porcentaje = $porcentaje + round(($dato->cantidad * 100) /$total,1); ?>
						@endif
					@endif
					@if ($dato->favorabilidad == "Desfavorable")
						@if (round(($dato->cantidad * 100) /$total,1) < 10)
							<rect width="{{ round(($dato->cantidad * 100) /$total,1)}}%" height="20px" x="{{$porcentaje}}%" y="0" style="fill:rgba(255,0,0, 0.2);stroke-width:1;stroke:rgba(255, 0,0,1);" />
							<text fill="#000000" font-size="12" font-family="Verdana" x="{{$porcentaje + ( round(($dato->cantidad * 100) /$total,1)/2 ) -1}}%" y="15">{{ round(($dato->cantidad * 100) /$total,0) }}</text>
							<?php $porcentaje = $porcentaje + round(($dato->cantidad * 100) /$total,1); ?>
						@else
							<rect width="{{ round(($dato->cantidad * 100) /$total,1)}}%" height="20px" x="{{$porcentaje}}%" y="0" style="fill:rgba(255,0,0, 0.2);stroke-width:1;stroke:rgba(255, 0,0,1);" />
							<text fill="#000000" font-size="12" font-family="Verdana" x="{{$porcentaje + ( round(($dato->cantidad * 100) /$total,1)/2 ) -1}}%" y="15">{{ round(($dato->cantidad * 100) /$total,0) }}%</text>
							<?php $porcentaje = $porcentaje + round(($dato->cantidad * 100) /$total,1); ?>
						@endif
					@endif

				@endif
		
		@endforeach
			</svg>
		</td>
	</tr>
	@endif
	@endforeach
</table>
		
			


			
			</div>

		
		
	</div>

</div>

<div class="row" id="sector2" >

</div>

</div>

</div>
</div>

{!! Form::open(['route' => ['estadistica.demogshow'], 'method' => 'GET' , 'id' => 'form-demografico' ]) !!}
{!! Form::close() !!}


{!! Form::open(['route' => ['estadistica.injeccionmultiple'], 'method' => 'GET' , 'id' => 'form-demografico2' ]) !!}
{!! Form::close() !!}

@endsection


@section('js')


<script type="text/javascript">

//funcion para cargar el lisdato del demografico

	$('#demografico').change(function(){
		
		var demografico = $('#demografico').val();
		
	  var form = $('#form-demografico');

	  var url = form.attr('action');

	  var funcion = "preguntas";

		data = {demografico: demografico, funcion: funcion};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#demog2').show().fadeOut().html(listasector).fadeIn();
		      $('#demog1').hide();
	   });

	});

//funcion para cargar el grafico

	$('#demografico2').change(function(){
		
		var demografico = $('#demografico').val();
		var demografico2 = $('#demografico2').val();
		
	  var form = $('#form-demografico2');

	  var url = form.attr('action');

		data = {demografico: demografico, demografico2: demografico2};
	  $.get(url, data, function(listasector){
	  		  console.log("json ok");
		      $('#sector2').show().fadeOut().html(listasector).fadeIn();
		      $('#sector1').hide();
	   });

	});



</script>


@endsection
