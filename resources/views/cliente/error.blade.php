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
</head>

<body>

<div class="super_container">

	<!-- Header -->

	<!-- Banner -->



	<!-- Characteristics -->

	<header class="header">
  <div class="top_bar">
    <div class="container">
      <div class="row">
        <div class="col d-flex flex-row">

          <div class="top_bar_content ml-auto">
            <div class="top_bar_menu">
              <ul class="standard_dropdown top_bar_dropdown">
                <li>
                  <a href="#">$ Dólares<i class="fas fa-chevron-down"></i></a>
                </li>
              </ul>
            </div>
            <div class="top_bar_user">
                <div class="user_icon"><img src="{{asset('images/user.svg')}}" alt=""></div>
                <div><a href="{{url('/login/page')}}" id="register">Registrarse</a></div>
                <div><a href="{{url('/login/page')}}" id="iniciarSesion">Iniciar Sesión</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="header_main">
    <div class="container">
      <div class="row">

        <!-- Logo -->
        <div class="col-lg-2 col-sm-3 col-3 order-1">
          <div class="logo_container">
            <div class="logo"><a href="/">Tienda Virtual</a></div>
          </div>
        </div>

        <!-- Search -->
        <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
          <div class="header_search">
            <div class="header_search_content">
              <div class="header_search_form_container">
              {!! Form::open(array('url' => 'results/0', 'method' =>'GET', 'autocomplete' => 'off','role' => 'search','class' => 'header_search_form clearfix'))!!}
                  <input type="search" name="searcher" required="required" class="header_search_input" placeholder="Buscar..." >
                  <div class="custom_dropdown" hidden="false">
                    <div class="custom_dropdown_list">
                      <span class="custom_dropdown_placeholder clc">Todas las categorías</span>
                      <i class="fas fa-chevron-down"></i>
                      <ul class="custom_list clc"></ul>
                    </div>
                  </div>
                  <button type="submit" class="header_search_button trans_300" value="Submit"><img src="{{asset('images/search.png')}}" alt=""></button>
              {{Form::close()}}
              </div>
            </div>
          </div>
        </div>

        <!-- Wishlist -->
        <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
          <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
            <!-- Cart -->
            <div class="cart">
              <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                <div class="cart_icon">
                  <a href="{{url('/cart')}}">
                    <img src="{{asset('images/cart.png')}}" alt="">
                  </a>
                  @if(Session::get('cart'))
                  <div class="cart_count"><span>{{count(Session::get('cart'))}}</span></div>
                  @else
                  <div class="cart_count"><span>0</span></div>
                  @endif
                </div>
                <div class="cart_content">
                  <div class="cart_text"><a href="{{url('/cart')}}">Carrito</a></div>
                  <div class="cart_price">${{Session::get('total')}}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Main Navigation -->
  <nav class="main_nav">
  <div class="container">
    <div class="row">
      <div class="col">

        <div class="main_nav_content d-flex flex-row">

          <!-- Categories Menu -->

          <div class="cat_menu_container">
            <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
              <div class="cat_burger"><span></span><span></span><span></span></div>
              <div class="cat_menu_text">Categorías</div>
            </div>
          </div>

          <!-- Main Nav Menu -->

          <div class="main_nav_menu ml-auto">
            <ul class="standard_dropdown main_nav_dropdown">
              <li><a href="/">Inicio<i class="fas fa-chevron-down"></i></a></li>
            </ul>
          </div>

          <!-- Menu Trigger -->

          <div class="menu_trigger_container ml-auto">
            <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
              <div class="menu_burger">
                <div class="menu_trigger_text">menú</div>
                <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</nav>
</header>
  <div class="modal-dialog modal-dialog-centered" role="">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Oooops</h5>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger alert-block">
            <strong>{{$message}}</strong>
          </div>
      </div>
    </div>
  </div>


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
<script src="{{asset('plugins/slick-1.8.0/slick.js')}}"></script>
<script src="{{asset('plugins/easing/easing.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('plugins/Isotope/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.js')}}"></script>
<script src="{{asset('plugins/parallax-js-master/parallax.min.js')}}"></script>
<script src="{{asset('js/shop_custom.js')}}"></script>
@stack('scripts')
@if(Session::has('success_msg'))
<script type="text/javascript">
	$(function() {
		$("#popupThanks").modal('show');
	});
</script>
@endif

</body>

</html>
