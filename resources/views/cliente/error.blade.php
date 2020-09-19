@extends('layouts.cliente')
@section('contenidoCliente')
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
              @if($usuario == 'NULL')
                <div class="user_icon"><img src="{{asset('images/user.svg')}}" alt=""></div>
                <div><a href="{{url('/login/page')}}" id="register">Registrarse</a></div>
                <div><a href="{{url('/login/page')}}" id="iniciarSesion">Iniciar Sesión</a></div>
              @else
                <div class="user_icon"><img src="{{asset('images/user.svg')}}" alt=""></div>
                <div class="top_bar_menu">
                  <ul class="standard_dropdown top_bar_dropdown">
                    <li>
                      <a href="#">Bienvenido {{$usuario->name}}<i class="fas fa-chevron-down"></i></a>
                      <ul>
                        <li><a href="{{url('/cliente/ordenes')}}">Mis órdenes</a></li>
                        <!-- <li><a href="">Métodos de pago</a>
                          <ul>
                            <li><a href="/cliente/vermetodos">Ver métodos<i class="fas fa-chevron-right"></i></a></li>
                            <li><a href="#">Agregar<i class="fas fa-chevron-right"></i></a></li>
                          </ul>
                        </li> -->
                      </ul>
                    </li>
                  </ul>
                </div>
                <div><a href="{{URL::action('UserController@logout')}}">Cerrar Sesión</a></div>
              @endif
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
            <div class="logo"><a href="{{URL::action('ClientController@index')}}">Tienda Virtual</a></div>
          </div>
        </div>

        <!-- Search -->
        <div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
          <div class="header_search">
            <div class="header_search_content">
              <div class="header_search_form_container">
              {!! Form::open(array('url' => 'results/0', 'method' =>'GET', 'autocomplete' => 'off','role' => 'search','class' => 'header_search_form clearfix'))!!}
                  <input type="search" name="buscador" required="required" class="header_search_input" placeholder="Buscar..." >
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
                  <div class="cart_count"><span>{{$carritoLen}}</span></div>
                </div>
                <div class="cart_content">
                  <div class="cart_text"><a href="{{url('/cart')}}">Carrito</a></div>
                  <div class="cart_price">${{$total}}</div>
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
              <li><a href="{{URL::action('ClientController@index')}}">Inicio<i class="fas fa-chevron-down"></i></a></li>
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
            <strong>Lo sentimos, algo salió mal en el servidor, inténtelo más tarde</strong>
          </div>
      </div>
    </div>
  </div>
@stop
