@extends('layouts.adminLayout.admin_design')
@section('contenido')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/index')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Inicio</a> <a href="#"> Categoría</a> <a href="{{url('/admin/category/new')}}" class="current">Agregar Categoría</a> </div>
    <h1>Agregar Categoría</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Formulario de Nueva Categoría</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{url('/admin/category/new')}}" name="agregarCategorias" id="agregarCategorias" novalidate="novalidate"> {{csrf_field()}}
              <div class="control-group">
                <label class="control-label">Nombre de la Categoría</label>
                <div class="controls">
                  <input type="text" name="nombre" id="nombre">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Descripción de la Categoría</label>
                <div class="controls">
                  <textarea name="descripcion" id="descripcion"></textarea>
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Agregar Categoría" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
