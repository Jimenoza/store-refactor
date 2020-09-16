
<!-- Header Main -->
<script>
	function nuevoMetodo() {
	open('/cliente/metodos','','top=100,left=300,width=500,height=400') ;
	}
</script>
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
						@if(!$usuario)
							<div class="user_icon"><img src="{{asset('images/user.svg')}}" alt=""></div>
							<div><a href="{{url('/usuarios/inicioSesionRegistro')}}" id="register">Registrarse</a></div>
							<div><a href="{{url('/usuarios/inicioSesionRegistro')}}" id="iniciarSesion">Iniciar Sesión</a></div>
						@else
							<div class="user_icon"><img src="{{asset('images/user.svg')}}" alt=""></div>
							<div class="top_bar_menu">
								<ul class="standard_dropdown top_bar_dropdown">
									<li>
										<a href="#" id="welcomeUser">Bienvenido {{$usuario->name}}<i class="fas fa-chevron-down"></i></a>
										<ul>
											<li><a href="{{url('/cliente/ordenes')}}">Mis órdenes</a></li>
											<!-- <li><a href="">Métodos de pago</a>
												<ul>
													<li><a href="/cliente/vermetodos">Ver métodos<i class="fas fa-chevron-right"></i></a></li>
													<li><a href="#" onclick="nuevoMetodo()">Agregar<i class="fas fa-chevron-right"></i></a></li>
												</ul>
											</li> -->
										</ul>
									</li>
								</ul>
							</div>
							<div><a href="{{URL::action('UsuarioController@cerrarSesion')}}" id="cerrarSesion">Cerrar Sesión</a></div>
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
						{!! Form::open(array('url' => 'cliente/results', 'method' =>'GET', 'autocomplete' => 'off','role' => 'search','class' => 'header_search_form clearfix'))!!}
								<input type="search" name="buscador" required="required" class="header_search_input" placeholder="Buscar...">
								<div class="custom_dropdown">
									<div class="custom_dropdown_list">
										<span class="custom_dropdown_placeholder clc">Todas las categorías</span>
										<i class="fas fa-chevron-down"></i>
										<select name="catFiltro" id="catFiltro" class="custom_list clc form-control">
											<option value="0" class="clc" label="Todas las categorías">Todas las categorías</option>
											@foreach($categorias as $cat)
											@if($cat->condicion != 0)
											<option value="{{$cat->idCategoria}}" class="clc" label="{{$cat->nombre}}">
												{{$cat->nombre}}
											</option>
											@endif
											@endforeach
										</select>
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
								<a href="{{url('/cliente/cart')}}">
									<img src="{{asset('images/cart.png')}}" alt="">
								</a>
								<div class="cart_count"><span>{{$carritoLen}}</span></div>
							</div>
							<div class="cart_content">
								<div class="cart_text"><a href="{{url('/cliente/cart')}}" id="carrito">Carrito</a></div>
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

						<ul class="cat_menu">
						@foreach($categorias as $cat)
							@if($cat->condicion != 0)
								<li><a href="{{URL::action('ProductoController@filtrar',$cat->idCategoria)}}" id="categoria_{{$cat->idCategoria}}">{{$cat->nombre}}<i class="fas fa-chevron-right ml-auto"></i></a></li>
							@endif
						@endforeach
						</ul>
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

<!-- Menu -->

<div class="page_menu">
	<div class="container">
		<div class="row">
			<div class="col">

				<div class="page_menu_content">

					<div class="page_menu_search">
						<form action="#">
							<input type="search" required="required" class="page_menu_search_input" placeholder="Search for products...">
						</form>
					</div>
					<ul class="page_menu_nav">
						<li class="page_menu_item has-children">
							<a href="#">Moneda<i class="fa fa-angle-down"></i></a>
							<ul class="page_menu_selection">
								<li><a href="#">US Dollar<i class="fa fa-angle-down"></i></a></li>
							</ul>
						</li>
						<li class="page_menu_item">
							<a href="{{URL::action('ClientController@index')}}">Inicio<i class="fa fa-angle-down"></i></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
