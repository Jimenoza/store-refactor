@extends('layouts.adminLayout.admin_design')
@section('contenido')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/index')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Inicio</a> <a href="#"> Producto</a> <a href="{{url('/admin/product/edit/'.$productDetail->id)}}" class="current">Editar Producto</a> </div>
    <h1>Editar Producto</h1>
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
            <h5>Formulario para Editar Producto</h5>
          </div>
          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="{{url('/admin/product/edit/'.$productDetail->id)}}" name="editarProducto" id="editarProducto" novalidate="novalidate"> {{csrf_field()}}
              <div class="control-group">
                <label class="control-label">Nombre del Producto</label>
                <div class="controls">
                  <input type="text" name="nombre" id="nombre" value="{{$productDetail->name}}">
                </div>
              </div>
              <div class="control-group">
              <label class="control-label">Seleccione una Categoría</label>
                <div class="controls">
                  <select name="categorias" style="width: 220px;">
                    <?php echo $categoriesList; //es lo mismo que el foreach?>
                </select>
              </div>
            </div>
              <div class="control-group">
                <label class="control-label">Descripción del Producto</label>
                <div class="controls">
                  <textarea name="descripcion" id="descripcion">{{$productDetail->description}}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Imagen del Producto</label>
                <div class="controls">
                  <input type="file" name="imageInput" id="imageInput" accept="image/*"/>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Precio del Producto</label>
                <div class="controls">
                  <input type="number" name="precio" id="precio" value="{{$productDetail->price}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Stock del Producto</label>
                <div class="controls">
                  <input type="number" name="disponibles" id="disponibles" value="{{$productDetail->stock}}">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Editar Producto" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection