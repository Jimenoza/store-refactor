<script>
	function abrir(id) {
		window.open(`/order/${id}`) ;
	}
</script>
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_responsive.css')}}">
@endpush

<!-- Characteristics -->
@extends('layouts.cliente')
@section('contenidoCliente')
<!-- Cart -->

<div class="cart_section">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1">
          <div class="cart_container">
            <div class="cart_title">Productos en la orden</div>
            <div class="cart_items">
              	<ul class="cart_list">
					@foreach($productos as $producto)
					<li class="cart_item clearfix">
						<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
							<div class="cart_item_image cart_info_col">
								<img src="{{asset('images/productos/'.$producto->image)}}" alt="">
							</div>
							<div class="cart_item_name cart_info_col">
								<div class="cart_item_title">Nombre</div>
								<div class="cart_item_text">{{$producto->name}}</div>
							</div>
							<div class="cart_item_price cart_info_col">
								<div class="cart_item_title">Precio</div>
								<div class="cart_item_text">${{$producto->price}}</div>
							</div>
						</div>
					</li>
					@endforeach
            	</ul>
            </div>
            <div class="cart_buttons">
              <button type="button" class="button cart_button_checkout" onclick="self.close()">Aceptar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

	<!-- Footer -->

	<!-- Copyright -->
