@extends('layouts.adminLayout.admin_design')
@section('contenido')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/index')}}" title="Inicio" class="tip-bottom"><i class="icon-home"></i> Inicio</a> <a href="#"> Categoría</a> <a href="{{url('/admin/category/index')}}" class="current">Ver Categorías</a> </div>
    <h1>Categorías</h1>
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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Ver Categorías</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Id Categoría</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Condición</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($categories as $cat)
                <tr class="gradeX">
                  <td class="idCategoria">{{$cat->id}}</td>
                  <td class="nombreCategoria">{{$cat->name}}</td>
                  <td class="descripcionCategoria">{{$cat->description}}</td>
                  <td class="condicionCategoria">{{$cat->enable}}</td>
                  <td class="center"><a href="{{url('/admin/category/edit/'.$cat->id)}}" class="btn btn-primary btn-mini" id="edit_{{$cat->name}}">Editar</a>
                    <a href="{{url('/admin/category/delete/'.$cat->id)}}" class="btn btn-danger btn-mini elimiarCategoria" id="eliminar_{{$cat->id}}">Eliminar</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
