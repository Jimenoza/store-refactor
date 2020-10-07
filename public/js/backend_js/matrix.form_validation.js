
$(document).ready(function(){

	// Revision de contraseña
	$('ctr_nueva').keyup(function(){
		var ctr_actual = $('ctr_actual').val();
		$.ajax({
			type: 'get',
			url:'admin/password/check',
			data:{ctr_actual:ctr_actual},
			success:function(resp){
				if(resp=="false"){
					$("#revisarContrasena").html("<font color='red'> Contraseña Actual Incorrecta.</font>");
				} else if(resp=="true"){
					$("#revisarContrasena").html("<font color='green'> Contraseña Actual Correcta.</font>");
				}
			}, error:function(){
				alert("Error");
			}
		});
	});

	$('input[type=checkbox],input[type=radio],input[type=file]').uniform();

	$('select').select2();

	// Validacion de agregar Categoría
	$("#agregarCategorias").validate({
		rules:{
			nombre:{
				required: true,
				rangelength: [3,45]
			},
			descripcion:{
				required: true,
				maxlength:200
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
		}
	});

	// Validacion de editar Categoría
	$("#editarCategoria").validate({
		rules:{
			nombre:{
				required: true,
				rangelength: [3,45]
			},
			descripcion:{
				required: true,
				maxlength: 200
			},
			condicion:{
				required: true,
				digits: true,
				max: 1
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
		}
	});

	// Validacion de agregar Producto
	$("#agregarProducto").validate({
		rules:{
			nombre:{
				required: true,
				rangelength: [3,45]
			},
			categorias:{
				required: true
			},
			descripcion:{
				required: true,
				maxlength: 200
			},
			imageInput:{
				required: true,
				accept: "image/*"
			},
			precio:{
				required: true,
				number: true,
				min: 1,
				maxlength: 45,
			},
			disponibles:{
				required: true,
				digits: true,
				min: 0,
				max: 100
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
		}
	});

	// Validacion de editar Producto
	$("#editarProducto").validate({
		rules:{
			nombre:{
				required: true,
				rangelength: [3,45]
			},
			categorias:{
				required: true
			},
			descripcion:{
				required: true,
				maxlength: 200
			},
			imageInput:{
				required: true,
				accept: "image/*"
			},
			precio:{
				required: true,
				number: true,
				min: 1,
				maxlength: 45,
			},
			disponibles:{
				required: true,
				digits: true,
				min: 0,
				max: 100
			},
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
		}
	});

	// Confirmar Validacion de contraseña
	$("#crearAdmin").validate({
		rules:{
			userName:{
				required: true,
				minlength: 3
			},
			userEmail:{
				required: true,
				email: true
			},
			password:{
				required: true,
				rangelength: [8,20]
			},
			passRepeated:{
				required:true,
				rangelength: [8,20],
				equalTo:"#password"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Confirmar Validacion de contraseña
	$("#validarContrasena").validate({
		rules:{
			currentPassword:{
				required: true,
				minlength:6,
				maxlength:20
			},
			newPassword:{
				required: true,
				rangelength: [8,20]
			},
			confirmPassoword:{
				required:true,
				rangelength: [8,20],
				equalTo:"#newPassword"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	// Ventana emergente de eliminación de Categoría
	$(".elimiarCategoria").click(function(){
		if(confirm('¿Está seguro que desea eliminar esta categoría?')){
			return true;
		}
		return false;
	});

	// Ventana emergente de eliminación de Producto
	$(".delProd").click(function(){
		if(confirm('¿Está seguro que desea inhabilitar este producto?')){
			return true;
		}
		return false;
	});
});


function validar(){
	var bandera = true;
	var nombre = $('#nombre').val();
	var categorias = $('#categorias').val();
	var descripcion = $('#descripcion').val();
	var imagen = $('#imageInput').val();
	var precio = $('#precio').val();
	var disponibles = $('#disponibles').val();
	if(!nombre || nombre.length < 3 || nombre.length > 45){
		bandera = false;
		document.getElementById("error1").innerHTML = "*No hay nombre de producto o se sale del rango";
	}
	if(!categorias){
		bandera = false;
		document.getElementById("error2").innerHTML = "*No se ha elegido una categoría";
	}
	if(!descripcion || descripcion.length > 300){
		bandera = false;
		document.getElementById("error3").innerHTML = "*No se ha ingresado una descripcion o es muy larga";
	}
	if(!imagen){
		bandera = false;
		document.getElementById("error4").innerHTML = "*No se ha ingresado una imagen para el producto";
	}
	if(!precio || isNaN(precio) || precio.length < 1 || precio.length > 45){
		bandera = false;
		document.getElementById("error5").innerHTML = "*No es un precio válido";
	}
	if(!disponibles || isNaN(disponibles) || Number(disponibles) < 0 || Number(disponibles) > 100){
		bandera = false;
		document.getElementById("error6").innerHTML = "*No ingresó un valor válido";
	}


	return bandera;
}
