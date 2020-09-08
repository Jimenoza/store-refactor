@extends('layouts.cliente')
@section('contenidoCliente')
<header class="header">
	@include('cliente.search')
</header>

<section id="form"><!--form-->
		<div class="container">
			<div class="row">
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
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Iniciar Sesión</h2>
						<!-- <form name="formularioInicioSesion" id="formularioInicioSesion" action="{{url('/usuarios/registrar')}}" method="POST"> {{csrf_field()}}
							<input name="correo" id="correo" type="email" placeholder="Correo" />
							<input name="contrasena" id="contrasena" type="password" placeholder="Contraseña" />
							<button type="submit" class="btn btn-default">Login</button>
						</form> -->
					</div><!--/login form-->
				</div>
				<div class="col-sm-2">
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>¡Registrarte!</h2>
						<!-- <form name="formularioRegistro" id="formularioRegistro" action="{{url('/usuarios/registrar')}}" method="POST"> {{csrf_field()}}
							<input name="nombre" id="nombre" type="text" placeholder="Nombre"/>
							<input name="correo" id="correo" type="email" placeholder="Correo"/>
							<input name="contrasena" id="contrasena" type="password" placeholder="Contraseña"/>
							<button type="submit" class="btn btn-default">Registrarse</button>
						</form> -->
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
</section><!--/form-->
@stop


