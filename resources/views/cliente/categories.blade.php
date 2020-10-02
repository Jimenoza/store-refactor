@extends('layouts.cliente')
@section('contenidoCliente')
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/shop_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/shop_responsive.css')}}">
@endpush
	<!-- Home -->
<!-- <header class="header">
	@include('cliente.search')
</header> -->

<div class="home">
	<div class="home_background parallax-window" data-parallax="scroll" data-image-src="{{asset('images/shop_background.jpg')}}"></div>
	<div class="home_overlay"></div>
	<div class="home_content d-flex flex-column align-items-center justify-content-center">
		<h2 class="home_title">{{$nombreCat}}</h2>
	</div>
</div>


<!-- Shop -->

<div class="shop">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">

					<!-- Shop Sidebar -->
					<div class="shop_sidebar">
						<div class="sidebar_section filter_by_section">
							<div class="sidebar_title">Filtrar por</div>
							<div class="sidebar_subtitle">Precio</div>
							<div class="filter_price">
								<div id="slider-range" class="slider_range"></div>
								<p>Rango: </p>
								<p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
							</div>
						</div>
					</div>
			</div>

			<div class="col-lg-9">
				
				<!-- Shop Content -->

				<div class="shop_content">
					<div class="shop_bar clearfix">
						<div class="shop_product_count"><span>{{sizeof($productos)}}</span> productos encontrados</div>
					</div>

					<div class="product_grid">
						<div class="product_grid_border"></div>

						<!-- Product Item -->
						@foreach($productos->items() as $prod)
							<div class="product_item discount">
								<a href="{{URL::action('ProductController@productDetail',$prod['idProducto'])}}" tabindex="0">
								<div class="product_border"></div>
								<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{asset('images/productos/'.$prod['imagen'])}}" alt="" width="170" height="170"></div>
								<div class="product_content">
									<div class="product_price">${{$prod['precio']}}</div>
									<div class="product_name"><div>{{$prod['nombre']}}</div></div>
								</div>
								<div class="product_fav"><i class="fas fa-heart"></i></div>
								</a>
								@if($prod['stock'] == 0)
								<ul class="product_marks">
									<li class="product_mark product_discount">Agotado</li>
								</ul>
								@endif
								
							</div>
						@endforeach						

					</div>

					<!-- Shop Page Navigation -->
					<div class="shop_page_nav d-flex flex-row">
						{{$productos->render()}}
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection