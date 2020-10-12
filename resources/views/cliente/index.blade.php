@extends('layouts.cliente')
@section('contenidoCliente')
<!-- Banner -->

<div class="banner_2">
		<div class="banner_2_background" style="background-image:url({{asset('images/banner_2_background.jpg')}}"></div>
		<div class="banner_2_container">
			<div class="banner_2_dots"></div>
			<!-- Banner 2 Slider -->

			<div class="owl-carousel owl-theme banner_2_slider">

				<!-- Banner 2 Slider Item -->
				@foreach($productos as $prod)
				@if($loop->index < 5)
				<div class="owl-item">
					<div class="banner_2_item">
						<div class="container fill_height">
							<div class="row fill_height">
								<div class="col-lg-4 col-md-6 fill_height">
									<div class="banner_2_content">
										<div class="banner_2_category"></div>
										<div class="banner_2_title">{{$prod->name}}</div>
										<div class="banner_2_text">{{$prod->description}}</div>
										<div class="banner_2_rating">
											@for($i = 0; $i < intval($prod->average); $i++)
											<i class="fas fa-star"></i>
											@endfor
											@if($prod->average - intval($prod->average) > 0.5)
											<i class="fas fa-star-half"></i>
											@endif
										</div>
										<div class="button banner_2_button"><a class="productoSlider_{{$prod->id}}"  href="{{URL::action('Web\WebProductController@show',$prod->id)}}">Explorar</a></div>
									</div>

								</div>
								<div class="col-lg-8 col-md-6 fill_height">
									<div class="banner_2_image_container">
										<div class="banner_2_image"><img src="{{asset('images/productos/'.$prod->image)}}" alt=""></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
				@endforeach
			</div>
		</div>
</div>


<div class="deals_featured">
	<div class="container">
		<div class="row">
			<div class="col d-flex flex-lg-row flex-column align-items-center justify-content-start">

				<!-- Deals -->
				<div class="deals">
					<div class="deals_title">Productos Destacados</div>
					<div class="deals_slider_container">

						<!-- Deals Slider -->
						<div class="owl-carousel owl-theme deals_slider">
							<!-- Deals Item 1-->
							@foreach($productos as $prod)
							<div class="owl-item deals_item">
								<div class="deals_image"><img src="{{asset('images/productos/'.$prod->image)}}" alt="" width="150" height="350"></div>
								<div class="deals_content">
									<div class="deals_info_line d-flex flex-row justify-content-start">
										<div class="deals_item_name"><a class="productoSlider_{{$prod->id}}"  href="{{URL::action('Web\WebProductController@show',$prod->id)}}">{{$prod->name}}</a></div>
										<div class="deals_item_price ml-auto">${{$prod->price}}</div>
									</div>
									<div class="deals_info_line d-flex flex-row justify-content-start">
										<div class="deals_item_category ">{{$prod->description}}</div>
									</div>
									<div class="available">
										<div class="available_line d-flex flex-row justify-content-start">
											<div class="available_title">Disponbles:<span>{{$prod->stock}}</span></div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>

					</div>

					<div class="deals_slider_nav_container">
						<div class="deals_slider_prev deals_slider_nav"><i class="fas fa-chevron-left ml-auto"></i></div>
						<div class="deals_slider_next deals_slider_nav"><i class="fas fa-chevron-right ml-auto"></i></div>
					</div>
				</div>

				<!-- Featured -->
				<div class="featured">
					<div class="tabbed_container">
						<div class="tabs">
							<ul class="clearfix">
								<li class="active">Destacados</li>
							</ul>
							<div class="tabs_line"><span></span></div>
						</div>

						<!-- Product Panel -->
						<div class="product_panel panel active">
							<div class="featured_slider slider">

								<!-- Slider Item 1-->
								@foreach($productos as $prod)
								<div class="featured_slider_item">
									<div class="border_active"></div>
									<a href="{{URL::action('Web\WebProductController@show',$prod->id)}}">
										<div class="product_item discount d-flex flex-column align-items-center justify-content-center text-center">
											<div class="product_image d-flex flex-column align-items-center justify-content-center"><img src="{{asset('images/productos/'.$prod->image)}}" alt="" width="150" height="150"></div>
											<div class="product_content">
												<div class="product_price discount">${{$prod->price}}</div>
												<div class="product_name"><div>{{$prod->name}}</div></div>
												<div class="product_extras">
												@if($prod->stock > 0)
												<a href="{{url('/cart/add/'.$prod->id)}}" id="addCart_{{$prod->id}}" >
													<button class="product_cart_button" > Añadir al carrito</button>
												</a>
												@else
													<!-- Button trigger modal -->
													<button type="button" class="product_cart_button" data-toggle="modal" data-target="#exampleModalCenter">
													Añadir al carrito
													</button>
												@endif
												</div>
											</div>
											@if($prod->stock == 0)
											<ul class="product_marks">
												<li class="product_mark product_discount">Agotado</li>
											</ul>
											@endif
										</div>
									</a>
								</div>
								@endforeach
							</div>
							<div class="featured_slider_dots_cover"></div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@include('cliente.popups.modal')
@endsection
