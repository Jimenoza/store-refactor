<!--No hay una sesión activa-->
  <div class="modal fade" id="popupLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Iniciar Sesión</h5>
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

<!--No hay una sesión activa-->
<div class="modal fade" id="popupRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Registro</h5>
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
          <form name="formularioRegistro" id="formularioRegistro" action="{{url('/register')}}" method="POST"> {{csrf_field()}}
            <div class="form-group">
              <label for="nombreRegistrar" class="col-form-label">Nombre:</label>
              <input type="text" class="form-control" id="nombreRegistrar" name="nombreRegistrar">
              <label for="correo" class="col-form-label">Correo:</label>
              <input type="email" class="form-control" name="correoRegistrar" id="correoRegistrar">
              <label for="password" class="col-form-label">Contraseña:</label>
              <input type="password" class="form-control" id="contrasenaRegistrar" name="contrasenaRegistrar">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Registrarme</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

