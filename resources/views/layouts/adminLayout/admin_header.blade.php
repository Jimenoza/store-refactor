<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Matrix Admin</a></h1>
</div>
<!--close-Header-part-->


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">¡Bienvenido Administrador!</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> Mi Perfil</a></li>
        <!-- <li class="divider"></li>
        <li><a href="{{url('/logout')}}"><i class="icon-key"></i> Cerrar Sesión</a></li> -->
      </ul>
    </li>
    <li class="dropdown" id="configuracionesAdmins" ><a title="" href="#" data-toggle="dropdown" data-target="#configuracionesAdmins" class="dropdown-toggle"><i class="icon icon-cog"></i> <span class="text">Configuraciones</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li> <a href="{{url('/admin/configs')}}"><i class="icon-lock"></i> Actualizar Contraseña</a></li>
        <li> <a href="{{url('/admin/new/admin')}}"><i class="icon-user"></i> Crear Administrador</a></li>
      </ul>
    </li>
    <li class=""><a title="" href="{{url('/logout')}}" id="logOut"><i class="icon icon-share-alt"></i> <span class="text">Cerrar Sesión</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->
