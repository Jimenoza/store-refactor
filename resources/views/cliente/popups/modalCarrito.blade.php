@if(Session::has('frontSession'))
  @if($total > 0)<!--Verifica que haya productos en el carrito-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rellene el formulario para generar la orden</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          @if(Session::has('address_error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">X</button>
                <strong>{!! session('address_error') !!}</strong>
            </div>
            @endif
            <form name="formularioOrden" id="formularioOrden" action="{{url('/carrito/pagar')}}" method="POST"> {{csrf_field()}}
              <div class="form-group">
                <label for="tarjetas" class="col-form-label">Pagar con:</label>
                <!-- <select class="form-control" name="tarjetas" id="tarjetas">
                  @if(count($tarjetas) > 0)
                    @foreach($tarjetas as $tar)
                    <option value="{{$tar->idTarjeta}}">Tarjeta a nombre de {{$tar->nombre_tarjeta}} que expira en {{$tar->fecha_expiracion}}</option>
                    @endforeach
                  @else
                    <option value="">No hay tarjetas registradas</option>
                  @endif
                </select> -->
                <label for="direccion" class="col-form-label">Enviar a:</label>
                <textarea class="form-control" id="direccion" name="direccion"></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Pagar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  @else<!--No hay productos en el carrito-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Carrito vacío</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Por favor, antes de continuar agregue productos al carrito
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  @endif
@else<!--No hay una sesión activa-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Por favor, inicie sesión para continuar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        @if(Session::has('flash_message_error'))
          <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">X</button>
              <strong>{!! session('flash_message_error') !!}</strong>
          </div>
          @endif
         <form name="formularioInicioSesion" id="formularioInicioSesion" action="{{url('/cliente/inicioSesion')}}" method="POST"> {{csrf_field()}}
            <div class="form-group">
              <label for="correo" class="col-form-label">Correo:</label>
              <input type="email" class="form-control" id="correo" name="correo">
              <label for="password" class="col-form-label">Contraseña:</label>
              <input type="password" class="form-control" id="contrasena" name="contrasena">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif

