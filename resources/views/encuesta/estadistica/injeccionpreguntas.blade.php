<?php $porcentaje =0; ?>

<div class="col col-lg-1"></div>
	<div class="col col-md-10">
@if ($total > 2)

<table>
@foreach ($imtesCPorcentages2 as $item)

	@if ($item->id != 54)

		<?php $porcentaje =0; ?>

	<tr>
		<td><h6> {{$item->id}}  {{$item->descripcion}}</h6></td>
				<td>
					<svg width="600" height="25">
					
					<!-- FAVORABLE  INICIO -->
					@if ( $item->favorable > 0 )
						<rect width="{{ $item->favorable }}%" height="20px" x="0" y="0" style="fill:rgb(0,255,0,0.2);stroke-width:1;stroke:rgb(0,255,0);opacity:0.5" />
							@if ( $item->favorable <= 6 )
								<text fill="#000000" font-size="10" font-family="Verdana" x="{{ ($item->favorable/2)-1 }}%" y="15">{{ $item->favorable }}</text>
								<?php $porcentaje = $item->favorable; ?>
							@else
								<text fill="#000000" font-size="10" font-family="Verdana" x="{{ ($item->favorable/2)-1}}%" y="15">{{ $item->favorable }}%</text>
								<?php $porcentaje = $item->favorable; ?>
							@endif

					@endif
					<!-- FAVORABLE  FIN -->


					@if ($item->neutro > 0)
						@if ( $item->neutro <= 2 )
							<rect width="{{ $item->neutro }}%" height="20px" x="{{ $porcentaje }}%" y="0" style="fill:rgb(255,255,0,0.2);stroke-width:1;stroke:rgb(255,255,0);opacity:0.8" />
							<text fill="#000000" font-size="10" font-family="Verdana" x="{{ ($porcentaje + $item->neutro/2) -1}}%" y="15">{{ $item->neutro }}</text>
							<?php $porcentaje = $porcentaje + $item->neutro; ?>
						@else
							<rect width="{{ $item->neutro }}%" height="20px" x="{{$porcentaje}}%" y="0" style="fill:rgb(255,255,0,0.2);stroke-width:1;stroke:rgb(255,255,0);opacity:0.8" />
							<text fill="#000000" font-size="10" font-family="Verdana" x="{{ ($porcentaje + $item->neutro/2 ) -1}}%" y="15">{{ $item->neutro }}%</text>
							<?php $porcentaje = $porcentaje + $item->neutro; ?>
						@endif
					@endif
					@if ($item->desfavorable > 0)
						@if ($item->desfavorable <= 2)
							<rect width="{{100 - $porcentaje }}%" height="20px" x="{{ $porcentaje }}%" y="0" style="fill:rgba(255,0,0, 0.2);stroke-width:1;stroke:rgba(255, 0,0,1);" />
							<text fill="#000000" font-size="10" font-family="Verdana" x="{{ $porcentaje }}%" y="15">{{ 100 - round($porcentaje,0) }}</text>
						@else
							<rect width="{{ 100 - $porcentaje }}%" height="20px" x="{{ $porcentaje }}%" y="0" style="fill:rgba(255,0,0, 0.2);stroke-width:1;stroke:rgba(255, 0,0,1);" />
							<text fill="#000000" font-size="10" font-family="Verdana" x="{{ $porcentaje + ((100 - $porcentaje)/2) -1 }}%" y="15">{{ 100 - round($porcentaje,0) }}%</text>
							
						@endif
					@endif
				
		
			</svg>
		</td>
	</tr>
	@endif
	@endforeach
</table>

@else
<h4>Cantidad de encuestados insuficientes para graficar</h4>
@endif		
		
			
			</div>

		
		
	</div>




<script type="text/javascript">


</script>