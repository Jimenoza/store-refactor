@extends('layouts.adminLayout.admin_design')
@section('contenido')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/index')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Inicio</a> <a href="#"> Categoría</a> <a href="{{url('/admin/category/edit/'.$detallesCategoria->id)}}" class="current">Editar Categoría</a> </div>
    <h1>Editar Categoría</h1>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Formulario de Editar Categoría</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{url('/admin/category/edit/'.$detallesCategoria->id)}}" name="editarCategoria" id="editarCategoria" novalidate="novalidate"> {{csrf_field()}}
              <div class="control-group">
                <label class="control-label">Nombre de la Categoría</label>
                <div class="controls">
                  <input type="text" name="nombre" id="nombre" value="{{ $detallesCategoria->name}}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Descripción de la Categoría</label>
                <div class="controls">
                  <textarea name="descripcion" id="descripcion">{{ $detallesCategoria->description}}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Condición</label>
                <div class="controls">
                  <input type="number" name="condicion" id="condicion" value="{{ $detallesCategoria->enable}}">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Editar Categoría" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
