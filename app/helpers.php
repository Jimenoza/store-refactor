<?php
use tiendaVirtual\User;
use tiendaVirtual\Cart;
function handleError($error){
      $user = User::getUsuario();//Busca si hay un usuario logeado en el sistema, sino, user tiene el valor 'NULL'
      $carritoLen = Cart::getCartSize();
      $total = Cart::totalPrice();
      error_log($error);
      return view('cliente.error',['usuario'=>$user,'carritoLen' => $carritoLen,'total' => $total]);
    }