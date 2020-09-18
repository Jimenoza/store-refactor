<!DOCTYPE html>
<html lang="en">
<head>
<title>Tienda Virtual</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="OneTech shop project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap4/bootstrap.min.css')}}">
<link href="{{asset('plugins/fontawesome-free-5.0.1/css/fontawesome-all.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/OwlCarousel2-2.2.1/animate.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/product_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/product_responsive.css')}}">

</head>

<body>

<div class="super_container">

	<!-- Header -->

	<!-- Banner -->



	<!-- Characteristics -->
	<!-- Home -->

<header class="header">
	@include('cliente.search')
</header>

<div class="single_product">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 order-lg-2 order-1">
				<div class="image_selected"><img src="{{asset('images/productos/'.$producto->getImagen())}}" alt=""></div>
			</div>

			<div class="col-lg-5 order-3">
				<div class="product_description">
					<div class="product_category"></div>
					<div class="product_name">{{$producto->getNombre()}}</div>
					@for($i = 0; $i < intval($producto->getPromedio()); $i++)
						<i class="fas fa-star"></i>
					@endfor
					@if($producto->getPromedio() - intval($producto->getPromedio()) > 0.5)
						<i class="fas fa-star-half"></i>
					@endif
					<div class="product_text"><p>{{$producto->getDescripcion()}}</p></div>
					<div class="product_price">${{$producto->getPrecio()}}</div>
					<div class="button_container">
					@if($producto->getStock() > 0)
						<a href="{{url('/carrito/agregar/'.$producto->getID())}}">
						<button type="button" class="button cart_button">Agregar a carrito</button></a>
					@else
						<button type="button" class="button cart_button" data-toggle="modal" data-target="#exampleModalCenter">Agregar a carrito</button>
					@endif
					</div>
				</div>
				
				<div class = "col-lg-12 order-3 opcionales">
					@if($usuario)
					<form name="formularioCali" id="formularioCali" action="{{url('cliente/comentar/'.$producto->getID())}}" method="post" onsubmit="return validar()"> {{csrf_field()}}
						<!-- Product Quantity -->
						<div class="modal-group">
							<label for="tarjetas" class="col-form-label">Califique este producto</label>
							<div class="clearfix" style="z-index: 5;">
								<div class="product_quantity clearfix">
									<span>Calificación: </span>
									<input id="quantity_input" name="quantity_input" type="text" pattern="[0-9]*" value="" readonly>
									<div class="quantity_buttons">
										<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
										<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
									</div>
								</div>
								<p id="error" class="demoFont"></p>
							</div>
							<label for=""></label>
							<textarea class="form-control" id="comentario" name="comentario" placeholder="¿Qué le pareció el producto?"></textarea>
			            </div>
			            <div class="modal-footer">
			            	<button type="submit" class="btn btn-primary">Comentar y calificar</button>
			            </div>
        			</form>
        			@else
        			<h4>Para dejar una calificación, por favor inicie sesión</h4>
        			@endif
				</div>
			</div>

		</div>
		<h3>Comentarios</h3>
		<div class="comentarios">
			<div class="divTable blueTable">
				
				<div class="divTableBody">
					@foreach($comentarios as $comentario)
					<div class="divTableRow usuario">
						<div class="divTableCell">{{$comentario->getUser()}}</div>
						@for($i = 0; $i < $comentario->getCalification(); $i++)
						<i class="fas fa-star"></i>
						@endfor
					</div>
					<div class="divTableRow coment">
						<div class="divTableCell" id="responses" name="responses">
							{{$comentario->getText()}}
							<div class="respuestas">Respuestas:</div>
							<div style="padding: 0px 30px;">
								<div class="divTable response">
									<div class="divTableBody">
										@foreach($comentario->getReplies() as $respuesta)
										<div class="divTableRow">
											<div class="divTableCell">
												<div class="nombre">{{$respuesta->name}}:</div>
												<div class="respuesta" align="justify">	
													{{$respuesta->respuesta}}
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div>
							@if($usuario)
							<a href="#" id="link{{$comentario->getID()}}" name="link{{$comentario->getID()}}"onclick="mostrar('{{$comentario->getID()}}')">
								<div id="{{$comentario->getID()}}" name="{{$comentario->getID()}}">Dejar una respuesta</div>
		            		</a>
		            		@else
		            		<a href="{{url('/usuarios/inicioSesionRegistro')}}">
								Inicie sesión para responder
		            		</a>
		            		@endif
							<form id="respuesta{{$comentario->getID()}}" class="answer" action="{{url('cliente/responder/'.$comentario->getID())}}" style="display: none;">
								 <div class="form-group row">
    								<div class="col-sm-6">
      									<textarea type="text" class="form-control" id="respuestaText" name="respuestaText"></textarea> 
    								</div>
  								</div>
  								<button class="btn btn-primary">Responder</button>
							</form>
						</div>
					</div>
					@endforeach
				</div>
				
			</div>
	    </div>
	</div>
</div>
@include('cliente.popups.modal')


	<!-- Footer -->

	<footer class="footer">
		<div class="container">
			<div class="row">

				<div class="col-lg-3 footer_col">
					<div class="footer_column footer_contact">
						<div class="logo_container">
							<div class="logo"><a href="#">Tienda Virtual</a></div>
						</div>
					</div>
				</div>

				<div class="col-lg-2">
					<div class="footer_column">
						<div class="footer_title">Servicio al cliente</div>
						<ul class="footer_list">
							<li><a href="#">Mi cuenta</a></li>
							<li><a href="#">Mis órdenes</a></li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</footer>

	<!-- Copyright -->

	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col">

					<div class="copyright_container d-flex flex-sm-row flex-column align-items-center justify-content-start">
						<div class="copyright_content"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('css/bootstrap4/popper.js')}}"></script>
<script src="{{asset('css/bootstrap4/bootstrap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/TweenMax.min.js')}}"></script>
<script src="{{asset('plugins/greensock/TimelineMax.min.js')}}"></script>
<script src="{{asset('plugins/scrollmagic/ScrollMagic.min.js')}}"></script>
<script src="{{asset('plugins/greensock/animation.gsap.min.js')}}"></script>
<script src="{{asset('plugins/greensock/ScrollToPlugin.min.js')}}"></script>
<script src="{{asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
<script src="{{asset('plugins/easing/easing.js')}}"></script>
<script src="{{asset('js/product_custom.js')}}"></script>

</body>

</html>