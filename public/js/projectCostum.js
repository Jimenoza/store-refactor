$(document).ready(function(){
    initQuantity();
    $('#register').on('click', function (ev){
        $("#popupRegister").modal('show');
    });
    $('#iniciarSesion').on('click', function (ev){
        $("#popupLogin").modal('show');
	});
	$("a div").click(function(e){
	e.preventDefault();
	//var padre = $("a div").parent();
    //$("a div").parent().append("<p>Esto es un parrafo.</p>");
	});

})

function callModal(modal) {
    $(modal).modal('show');
};

function mostrar(e){
	// var padre = $('#link'+e).parent();
	// padre.preventDefault();
	var formulario = `<form id="respuesta" class="answer" onsubmit="return respuesta()" action="http://localhost:8000/reply/${e}" method="POST">
		<div class="form-group row">
			<div class="col-sm-6">
				<textarea type="text" class="form-control" id="replyText" name="replyText"></textarea>
				<p id="alerta" class="demoFont"></p>
			</div>
		</div>
		<button class="btn btn-primary">Responder</button>
	</form>`;
	var x = document.getElementById("" + e);
	var y = document.getElementById("respuesta" + e);
	if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
        y.style.display = "block";
	}
    //alert(formulario);
    //padre.append(formulario);
}

function respuesta(){
	var text = document.getElementById("replyText").value;
	var retorno = true;
	var msj = "* No deje una respuesta en blanco";
	if(text){
		if(text.length > 300){
			alert("El texto es muy largo, por favor, redúscalo");
			retorno = false;
		}
	}else{
		document.getElementById("alerta").innerHTML = msj;
		retorno = false;
	}
	return retorno;
}

function validar(){
	console.log('validando');
	var cal = $('#rate').val();
	var text = document.getElementById("comment").value;
	var retorno = false;
	if(text || cal){
		if(text.length > 300){
			document.getElementById("commentError").innerHTML = "El texto es muy largo, por favor, redúscalo";
		}else if(!cal){
			document.getElementById("rateError").innerHTML = '* Por favor, ingrese la calificación';
		}else{
			retorno = true;
		}
	}
	return retorno;
}

function initQuantity()
	{
		// Handle product quantity input
		if($('.product_quantity').length)
		{
			var input = $('#rate');
			var incButton = $('#quantity_inc_button');
			var decButton = $('#quantity_dec_button');

			var originalVal;
			var endVal;

			incButton.on('click', function()
			{
				originalVal = input.val();
				if(!originalVal || originalVal == 'NaN'){
					originalVal = 0;
					endVal = parseFloat(originalVal);
					input.val(endVal);
				}
				if(originalVal < 5){
					endVal = parseFloat(originalVal) + 1;
					input.val(endVal);
				}
			});

			decButton.on('click', function()
			{
				originalVal = input.val();
				if(!originalVal || originalVal == 'NaN'){
					originalVal = 1;
					endVal = parseFloat(originalVal);
					input.val(endVal);
				}
				if(originalVal > 1)
				{
					endVal = parseFloat(originalVal) - 1;
					input.val(endVal);
				}
			});
		}
	}