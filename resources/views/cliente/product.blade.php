@extends('layouts.cliente')
@section('contenidoCliente')
@inject('Comment', 'tiendaVirtual\Comment')
@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('css/product_styles.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/product_responsive.css')}}">
@endpush

<div class="single_product">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 order-lg-2 order-1">
				<div class="image_selected"><img src="{{asset('images/productos/'.$producto->image)}}" alt=""></div>
			</div>

			<div class="col-lg-5 order-3">
				<div class="product_description">
					<div class="product_category"></div>
					<div class="product_name">{{$producto->name}}</div>
					@for($i = 0; $i < intval($producto->average); $i++)
						<i class="fas fa-star"></i>
					@endfor
					@if($producto->average - intval($producto->average) > 0.5)
						<i class="fas fa-star-half"></i>
					@endif
					<div class="product_text"><p>{{$producto->description}}</p></div>
					<div class="product_price">${{$producto->price}}</div>
					<div class="button_container">
					@if($producto->stock > 0)
						<a href="{{url('/cart/add/'.$producto->id)}}">
						<button type="button" class="button cart_button">Agregar a carrito</button></a>
					@else
						<button type="button" class="button cart_button" data-toggle="modal" data-target="#exampleModalCenter">Agregar a carrito</button>
					@endif
					</div>
				</div>
				
				<div class = "col-lg-12 order-3 opcionales">
					@if(Auth::user())
					<form name="formularioCali" id="formularioCali" action="{{url('comment/'.$producto->id)}}" method="post" onsubmit="return validar()"> {{csrf_field()}}
						<!-- Product Quantity -->
						<div class="modal-group">
							@if($errors->any())
							<div class="alert alert-danger alert-block">
								@foreach ($errors->all() as $error)
								<button type="button" class="close" data-dismiss="alert">X</button>
								<strong>{{ $error }}</strong>
								@endforeach
							</div>
							@endif
							<label for="tarjetas" class="col-form-label">Califique este producto</label>
							<div class="clearfix" style="z-index: 5;">
								<div class="product_quantity clearfix">
									<span>Calificación: </span>
									<input id="rate" name="rate" type="text" pattern="[0-9]*" value="" readonly>
									<div class="quantity_buttons">
										<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
										<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
									</div>
								</div>
								<p id="rateError" class="demoFont"></p>
							</div>
							<label for=""></label>
							<textarea class="form-control" id="comment" name="comment" placeholder="¿Qué le pareció el producto?"></textarea>
							<p id="commentError" class="demoFont"></p>
			            </div>
			            <div class="modal-footer">
			            	<button type="submit" class="btn btn-primary">Comentar y calificar</button>
			            </div>
        			</form>
        			@else
        			<h4>Para dejar una calificación, por favor inicie sesión</h4>
        			@endif
				</div>
			</div>

		</div>
		<h3>Comentarios</h3>
		<div class="comentarios">
			<div class="divTable blueTable">
				
				<div class="divTableBody">
					@foreach($comentarios as $comentario)
					<div class="divTableRow usuario">
						<div class="divTableCell">{{$comentario->userName}}</div>
						@for($i = 0; $i < $comentario->calification; $i++)
						<i class="fas fa-star"></i>
						@endfor
					</div>
					<div class="divTableRow coment">
						<div class="divTableCell" id="responses" name="responses">
							{{$comentario->comment}}
							<div class="respuestas">Respuestas:</div>
							<div style="padding: 0px 30px;">
								<div class="divTable response">
									<div class="divTableBody">
										@foreach($comentario->replies as $reply)
										<div class="divTableRow">
											<div class="divTableCell">
												<div class="nombre">{{$reply->userName}}:</div>
												<div class="respuesta" align="justify">	
													{{$reply->reply}}
												</div>
											</div>
										</div>
										@endforeach
									</div>
								</div>
							</div>
							@if(Auth::user())
							<a href="" id="linkReply" name="linkReply" onclick="mostrar('{{$comentario->id}}')">
								<div id="{{$comentario->id}}" name="{{$comentario->id}}">Dejar una respuesta</div>
		            		</a>
		            		@else
		            		<a href="{{url('/login/page')}}">
								Inicie sesión para responder
		            		</a>
		            		@endif
							<form id="respuesta{{$comentario->id}}" class="answer" action="{{url('reply/'.$comentario->id)}}" style="display: none;">
								 <div class="form-group row">
    								<div class="col-sm-6">
      									<textarea type="text" class="form-control" id="replyText" name="replyText"></textarea> 
    								</div>
  								</div>
  								<button class="btn btn-primary">Responder</button>
							</form>
						</div>
					</div>
					@endforeach
				</div>
				
			</div>
	    </div>
	</div>
</div>
@include('cliente.popups.modal')
@endsection
