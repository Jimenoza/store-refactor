<?php
use tiendaVirtual\Cart;
function handleError($error,$message,$code){
  error_log($error);
  return Response::make(view('cliente.error',['message' => $message]), $code);
}