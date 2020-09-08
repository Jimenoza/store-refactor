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
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_responsive.css')}}">
</head>
@if(Session::has('success'))
<body onload="closeWin()">
@else
<body>
@endif
<div class="super_container">
	
	<div class="container" >
		<div class="row">
			<div class="col-sm-4">
				@if(count($errors) > 0) <!--Si le llegan errores a la vista, los despliega-->
				<div class="alert alert-danger">
					<ul>
					@foreach($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
					</ul>
				</div>
				@endif
				<div class="signup-form"><!--sign up form-->
					<h2>Agregar una tarjeta de crédito/débito</h2>
					{!!Form::open(array('url' => '/cliente/nuevoMetodo', 'method' => 'POST','autocomplete' =>'off','files' => 'true', 'onsubmit' => 'return validar()'))!!}<!--Indica inicio de formulario y los parámetros de este-->
					<form name="formularioInicioSesion" id="formularioInicioSesion" action="{{url('/usuarios/inicioSesion')}}" method="POST">
					{{Form::token()}}
						<input name="numero" id="numero" type="text" placeholder="Número de la tarjeta"/>
						<input name="ccv" id="ccv" type="text" placeholder="CCV"/>
						<input name="titular" id="titular" type="text" placeholder="Ttular de la tarjeta"/>
						<input type="number" name="mes" id="mes" placeholder="Mes de vencimiento" min="1" max="12">
						<input type="number" name="year" id="year" placeholder="Año de vencimiento" min="2018">
						<div class="btn-toolbar">
							<button type="submit" class="btn btn-success" >Agregar</button>
							<button type="submit" class="btn btn-secondary" onclick="window.close()">Cancelar</button>
						</div>
					{!!Form::close()!!}
				</div><!--/sign up form-->
			</div>
		</div>
	</div>

	<!-- Copyright -->
</div>


<script src="{{asset('js/registro/jquery.js')}}"></script>
<script src="{{asset('js/registro/price-range.js')}}"></script>
<script src="{{asset('js/registro/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('js/registro/bootstrap.min.js')}}"></script>
<script src="{{asset('js/registro/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('js/registro/main.js')}}"></script>
<script src="{{asset('js/registro/jquery.validate.js')}}"></script>
<script src="{{asset('js/tarjeta.js')}}"></script>
<script>
	function validar() {
		continuar = true;
		tarjeta = document.getElementById('numero').value;
		if(tarjeta.length != 16 || !$.isNumeric(tarjeta)){
			alert("No insertó todos los números de la tarjeta o ingresó una letra en el número de tarjeta");
			continuar = false;
		}
		ccv = document.getElementById('ccv').value;
		if(ccv.length != 3 || !$.isNumeric(ccv)){
			alert("No insertó todos los números del ccv o ingresó una letra en el ccv");
			continuar = false;
		}
		titular = document.getElementById('titular').value;
		if(!titular){
			alert("No hay un titular para la tarjeta");
			continuar = false;
		}
		mes = document.getElementById('mes').value;
		year = document.getElementById('numero').value;
		if(!mes || !year){
			alert("La fecha de vencimiento está incompleta");
			continuar = false;	
		}
		if(continuar){
			return continuar;
			window.close();
		}
		return continuar;
	}

	function closeWin() {
    	window.close();   // Closes the new window
	} 
</script>



</body>

</html>