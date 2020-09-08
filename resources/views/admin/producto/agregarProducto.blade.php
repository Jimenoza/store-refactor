@extends('layouts.adminLayout.admin_design')
@section('contenido')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/inicio')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Inicio</a> <a href="#"> Producto</a> <a href="{{url('/admin/agregarProducto')}}" class="current">Agregar Producto</a> </div>
    <h1>Agregar Producto</h1>
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
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Formulario de Nuevo Producto</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/agregarProducto')}}" name="agregarProducto" id="agregarProducto" novalidate="novalidate" onsubmit="return validar()"> {{csrf_field()}}
              <div class="control-group">
                <label class="control-label">Nombre del Producto</label>
                <div class="controls">
                  <input type="text" name="nombre" id="nombre">
                  <p id="error1" class="demoFont"></p>
                </div>
              </div>
              <div class="control-group">
	            <label class="control-label">Seleccione una Categoría</label>
	              <div class="controls">
	              	<select name="categorias" id="categorias"style="width: 220px;">
	              		<?php echo $listadoCategorias; ?>
	            	</select>
                <p id="error2" class="demoFont"></p>
	          	</div>
	          </div>
              <div class="control-group">
                <label class="control-label">Descripción del Producto</label>
                <div class="controls">
                  <textarea name="descripcion" id="descripcion"></textarea>
                  <p id="error3" class="demoFont"></p>
                </div>
              </div>
              <div class="control-group">
              	<label class="control-label">Imagen del Producto</label>
              	<div class="controls">
                	<input type="file" name="imageInput" id="imageInput" accept="image/*"/>
                  <p id="error4" class="demoFont"></p>
              	</div>
              </div>
              <div class="control-group">
                <label class="control-label">Precio del Producto</label>
                <div class="controls">
                  <input type="text" name="precio" id="precio">
                  <p id="error5" class="demoFont"></p>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Stock del Prodcuto</label>
                <div class="controls">
                  <input type="number" name="disponibles" id="disponibles">
                  <p id="error6" class="demoFont"></p>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Agregar Producto" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
