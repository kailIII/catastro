@extends('layouts.default')

@section('content')

<h1></h1>

<div class="panel panel-primary">

	<div class="panel-heading">

		<h2 class="panel-title">FOLIOS URBANOS AUTORIZADOS PARA</h2>

	</div>

	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<label>COREVAT</label>
				<h5>{{$perito->corevat}}</h5>
			</div>
			<div class="col-md-3">
				<label>NOMBRE</label>
				<h5>{{$perito->nombre}}</h5>				
			</div>
		</div>
		{{Form::open()}}
		<table class="table datatable">
			<thead>
				<tr>
					<!--<th>{{Form::checkbox('', '', '', ['id'=>'todos'])}}</th>-->
					<th>Marcar Folio Presentado</th>
					<th>Folio Autorizados</th>
					<th>Folio usado en el Municipio de:</th>
					<th>Fecha de Recepción</th>
					<th>Estado del Folio</th>

				</tr>
			</thead>
			<tbody>
				@foreach($fu as $u)

					
				<tr>
					<td align="center"> 
						@if($u->entrega_municipal == 0)
							{{Form::checkbox('urbanos[]', $u->numero_folio, '', ['class'=>'checkbox'])}}
						@endif
					</td>
					<?php
						$input = $u->numero_folio;
						$input = str_pad($input, 4, "0", STR_PAD_LEFT);
					?>
					<td align="center"> {{$perito->corevat."-".$input.$u->tipo_folio."-15"}}</td>
					<td align="center"> 
					@if($u->entrega_municipal == 1)
						{{$u->municipio->municipio}}
					@endif
					</td>
					<td align="center">
					@if($u->entrega_municipal == 1)
						{{$u->fecha_entrega_m}}
					@endif
					</td>
					<td align="center"> 
						@if($u->entrega_municipal == 0)
							Vigente
						@else
							Usado
						@endif
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{Form::submit('Guardar', ['class'=>'btn btn-success'])}}
		{{Form::close()}}
	</div>

	@stop

	@section('scripts')

	<script type="text/javascript">

	$(document).ready(function(){

		$("#todos").change(function(){

			if($(this).is(':checked')){

				$(".checkbox").prop('checked', 'checked');

			} else {

				$(".checkbox").attr('checked', false);				

			}

		});

	});

	</script>

	@stop