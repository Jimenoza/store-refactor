<!DOCTYPE html>
<html lang="en">
<head>
<title>OneTech</title>
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

<link rel="stylesheet" type="text/css" href="{{asset('plugins/jquery-ui-1.12.1.custom/jquery-ui.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/cart_styles.css')}}">

</head>

<body>

<div class="super_container">

  <!-- Header -->

  <!-- Banner -->



  <!-- Characteristics -->
  <!-- Cart -->

  <div class="cart_section">
    <div class="container">
      <div class="row">
        <div class="col-lg-5">
          <div class="cart_container">
            <div class="cart_title">Productos en la orden</div>
            <div class="cart_items">
              <ul class="cart_list">
              @foreach($productos as $producto)
                <li class="cart_item clearfix">
                  <div class="cart_item_image">
                    <img src="{{asset('images/productos/'.$producto->imagen)}}" width="150" height="150">
                  </div>
                  <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                    <div class="cart_item_name cart_info_col">
                      <div class="cart_item_title">Nombre</div>
                      <div class="cart_item_text">{{$producto->nombre}}</div>
                    </div>
                    <div class="cart_item_price cart_info_col">
                      <div class="cart_item_title">Precio</div>
                      <div class="cart_item_text">${{$producto->precio}}</div>
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

  <!-- Copyright -->
</div>


</body>

</html>