@if(Auth::user())
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
            <form name="formularioOrden" id="formularioOrden" action="{{url('/purchase')}}" method="POST"> {{csrf_field()}}
              <div class="form-group">
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
         <form name="formularioInicioSesion" id="formularioInicioSesion" action="{{url('/login')}}" method="POST"> {{csrf_field()}}
            <div class="form-group">
              <label for="email" class="col-form-label">Correo:</label>
              <input type="email" class="form-control" id="email" name="email">
              <label for="password" class="col-form-label">Contraseña:</label>
              <input type="password" class="form-control" id="password" name="password">
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

