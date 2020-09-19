<script>
	function abrir(id) {
	open('/cliente/orden/' + id,'','top=100,left=300,width=800,height=300') ;
	}
</script>
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_responsive.css')}}">
@endpush

<!-- Characteristics -->
@extends('layouts.cliente')
@section('contenidoCliente')
<header class="header">
@include('cliente.search')
</header>
<!-- Cart -->

<div class="cart_section">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="cart_container">
					<div class="cart_title">Mis órdenes</div>
					<div class="cart_items">
						<ul class="cart_list">
						@foreach($ordenes as $orden)
							<li class="cart_item clearfix">
								<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
									<div class="cart_item_name cart_info_col">
										<div class="cart_item_title">Factura número</div>
										<div class="cart_item_text">{{$orden->factura}}</div>
									</div>
									<div class="cart_item_name cart_info_col">
										<div class="cart_item_title">Fecha</div>
										<div class="cart_item_text">{{$orden->fecha}}</div>
									</div>
									<div class="cart_item_name cart_info_col">
										<div class="cart_item_title">Total</div>
										<div class="cart_item_text">${{$orden->total}}</div>
									</div>
									<div class="cart_item_name cart_info_col">
										<div class="cart_item_title">Enviar a</div>
										<div class="cart_item_text">{{$orden->direccion}}</div>
									</div>
									<div class="cart_item_name cart_info_col">
										<div class="cart_item_text">
											<button type="button" class="button cart_button_clear" onclick="abrir({{$orden->Carrito_idCarrito}})">Ver</button>
											
										</div>
									</div>
								</div>
							</li>
							@endforeach
						</ul>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

	<!-- Footer -->

	<!-- Copyright -->
