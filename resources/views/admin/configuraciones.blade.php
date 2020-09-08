@extends('layouts.adminLayout.admin_design')
@section('contenido')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/inicio')}}" title="Inicio" class="tip-bottom"><i class="icon-home"></i> Inicio</a> <a href="{{url('/admin/configuraciones')}}" class="current">Configuraciones</a> </div>
    <h1>Configuraciones de Administrador</h1>
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
              <h5>Actualizar Contraseña</h5>
            </div>
            <div class="widget-content nopadding">
              <form class="form-horizontal" method="post" action="{{url('/admin/actualizarContrasena')}}" name="validarContrasena" id="validarContrasena" novalidate="novalidate">
                {{ csrf_field()}}
                <div class="control-group">
                  <label class="control-label">Contraseña Actual</label>
                  <div class="controls">
                    <input type="password" name="ctr_actual" id="ctr_actual" />
                    <span id="revisarContrasena"></span>
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Contraseña Nueva</label>
                  <div class="controls">
                    <input type="password" name="ctr_nueva" id="ctr_nueva" />
                  </div>
                </div>
                <div class="control-group">
                  <label class="control-label">Repetir Contraseña</label>
                  <div class="controls">
                    <input type="password" name="ctr_confirmar" id="ctr_confirmar" />
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Actualizar Contraseña" class="btn btn-success">
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
