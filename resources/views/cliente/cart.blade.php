@extends('layouts.cliente')
@section('contenidoCliente')
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_responsive.css')}}">
@endpush
	<!-- Header -->

	<!-- Banner -->



	<!-- Characteristics -->

	<!-- <header class="header">
	@include('cliente.search')
	</header> -->
	<!-- Cart -->

	<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="cart_container">
						<div class="cart_title">Carrito de compras</div>
						<div class="cart_items">
							<ul class="cart_list">
							@foreach($carrito as $producto)
								<li class="cart_item clearfix">
									<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
										<div class="cart_item_image cart_info_col">
											<img src="{{asset('images/productos/'.$producto->imagen)}}" alt="">
										</div>
										<div class="cart_item_name cart_info_col">
											<div class="cart_item_title">Nombre</div>
											<div class="cart_item_text">{{$producto->nombre}}</div>
										</div>
										<div class="cart_item_price cart_info_col">
											<div class="cart_item_title">Precio</div>
											<div class="cart_item_text">${{$producto->precio}}</div>
										</div>
										<!-- <div class="cart_item_total cart_info_col">
											<div class="cart_item_title">Total</div>
											<div class="cart_item_text">${{$producto->precio}}</div>
										</div> -->
										<div class="cart_item_name cart_info_col">
											<div class="cart_item_text center-button">
												<a href="{{url('/cart/remove/'.$producto->idProducto)}}" class="button cart_button_clear">
													Quitar
													<!-- <button type="button" class="button cart_button_clear"></button> -->
												</a>
											</div>
										</div>
									</div>
								</li>
							@endforeach
							</ul>
						</div>
						
						<!-- Order Total -->
						<div class="order_total">
							<div class="order_total_content text-md-right">
								<div class="order_total_title">Precio total:</div>
								<div class="order_total_amount">${{$total}}</div>
							</div>						
						</div>

						<div class="cart_buttons">
							<a href="{{url('/cart/delete')}}" >
								<button type="button" class="button cart_button_clear">Eliminar carrito</button>
							</a>
							<!--<a href="{{url('/carrito/verificar')}}">-->
							<button type="button" class="button cart_button_checkout" data-toggle="modal" data-target="#exampleModal">Proceder con pago</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('cliente.popups.modalCarrito')


	<!-- Footer -->



	<!-- Copyright -->



@if(Session::has('address_error'))
<script type="text/javascript">
	$(function() {
		$("#exampleModal").modal('show');
	});
</script>
@endif
@endsection
