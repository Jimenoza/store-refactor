@extends('layouts.adminLayout.admin_design')
@section('contenido')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{url('/admin/index')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Inicio</a> <a href="#"> Producto</a> <a href="{{url('/admin/product/index')}}" class="current">Ver Productos</a> </div>
    <h1>Productos</h1>
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
            <h5>Ver Productos</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Id Producto</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Imagen</th>
                  <th>Precio</th>
                  <th>Stock</th>
									<th>Estado</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              	@foreach($productos as $prod)
                <tr class="gradeX">
                  <td>{{$prod->id}}</td>
                  <td>{{$prod->name}}</td>
                  <td>{{$prod->description}}</td>
                  <td> <img src="{{asset('/images/productos/'.$prod->image)}}"></td>
                  <td>{{$prod->price}}</td>
                  <td>{{$prod->stock}}</td>
									<td>{{$prod->available}}</td>
                  <td class="center"><a href="{{url('/admin/product/edit/'.$prod->id)}}" class="btn btn-primary btn-mini" method="get">Editar</a>
                  @if($prod->available == 1)
                    <a href="{{url('/admin/product/delete/'.$prod->id)}}" class="btn btn-danger btn-mini delProd">Inhabilitar</a></td>
                  @else
                    <a href="{{url('/admin/product/enable/'.$prod->id)}}" class="btn btn-danger btn-mini">habilitar</a></td>
                  @endif
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
