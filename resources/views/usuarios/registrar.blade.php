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
<link rel="stylesheet" type="text/css" href="{{asset('plugins/slick-1.8.0/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/main_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/responsive.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
<link href="{{asset('css/registro/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/registro/font-awesome.min.css')}}" rel="stylesheet">
<link href="{{asset('css/registro/prettyPhoto.css')}}" rel="stylesheet">
<link href="{{asset('css/registro/price-range.css')}}" rel="stylesheet">
<link href="{{asset('css/registro/animate.css')}}" rel="stylesheet">
<link href="{{asset('css/registro/main.css')}}" rel="stylesheet">
<link href="{{asset('css/registro/responsive.css')}}" rel="stylesheet">
</head>

<body>

<div class="super_container">

	<!-- Header -->
	<header class="header">

	<div class="col-lg-2 col-sm-3 col-3 order-1 ">
		<div class="logo_container">
			<div class="logo"><a href="{{URL::action('ClienteController@index')}}">Tienda Virtual</a></div>
		</div>
	</div>
	<div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right 	">
		<div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
			<ul class="standard_dropdown main_nav_dropdown">
				<li><a href="{{URL::action('ClienteController@index')}}">Inicio<i class="fas fa-chevron-down"></i></a></li>
				<li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>
			</ul>
		</div>
	</div>

	<!-- Top Bar -->

</header>
	<!-- Banner -->



	<!-- Characteristics -->
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						@if(Session::has('flash_message_error'))
					        <div class="alert alert-danger alert-block">
					            <button type="button" class="close" data-dismiss="alert">X</button>
					            <strong>{!! session('flash_message_error') !!}</strong>
					        </div>
					    @endif
					    @if(Session::has('flash_message_success'))
					        <div class="alert alert-success alert-block">
					            <button type="button" class="close" data-dismiss="alert">X</button>
					            <strong>{!! session('flash_message_success') !!}</strong>
					        </div>
					    @endif
						<h2>Iniciar Sesión</h2>
						<form name="formularioInicioSesion" id="formularioInicioSesion" action="{{url('/usuarios/inicioSesion')}}" method="POST"> {{csrf_field()}}
							<input name="correo" id="correo" type="email" placeholder="Correo" />
							<input name="contrasena" id="contrasena" type="password" placeholder="Contraseña" />
							<button type="submit" class="btn btn-default">Iniciar Sesión</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-2">
				</div>
				<div class="col-sm-4">
					<div class="login-form"><!--sign up form-->
						<h2>¡Registrarte!</h2>
						<form name="formularioRegistro" id="formularioRegistro" action="{{url('/usuarios/registrar')}}" method="POST"> {{csrf_field()}}
							<input name="nombreRegistrar" id="nombreRegistrar" type="text" placeholder="Nombre"/>
							<input name="correoRegistrar" id="correoRegistrar" type="email" placeholder="Correo"/>
							<input name="contrasenaRegistrar" id="contrasenaRegistrar" type="password" placeholder="Contraseña"/>
							<button type="submit" class="btn btn-default">Registrarse</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->


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


<script src="{{asset('js/registro/jquery.js')}}"></script>
<script src="{{asset('js/registro/price-range.js')}}"></script>
<script src="{{asset('js/registro/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('js/registro/bootstrap.min.js')}}"></script>
<script src="{{asset('js/registro/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('js/registro/main.js')}}"></script>
<script src="{{asset('js/registro/jquery.validate.js')}}"></script>



</body>

</html>




<!-- Header Main -->
