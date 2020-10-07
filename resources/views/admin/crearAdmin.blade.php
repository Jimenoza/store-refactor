@extends('layouts.adminLayout.admin_design')
@section('contenido')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/index')}}" title="Inicio" class="tip-bottom"><i class="icon-home"></i> Inicio</a> <a href="{{url('/admin/password/change')}}" class="current">Configuraciones</a> </div>
    <h1>Crear Administrador</h1>
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
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Crear Nuevo Administrador</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{url('/admin/new/admin')}}" name="crearAdmin" id="crearAdmin" novalidate="novalidate">
                {{ csrf_field()}}
                <div class="control-group">
                  <label class="control-label">Nombre del Nuevo Administrador</label>
                  <div class="controls">
                    <input type="text" name="userName" id="userName" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Correo del Nuevo Administrador</label>
                  <div class="controls">
                    <input type="email" name="userEmail" id="userEmail" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Contraseña del Nuevo Administrador</label>
                  <div class="controls">
                    <input type="password" name="password" id="password" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Repetir Contraseña</label>
                  <div class="controls">
                    <input type="password" name="passRepeated" id="passRepeated" />
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Insertar Administrador" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
