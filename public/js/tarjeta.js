$().ready(function(){
  $("#formularioRegistro").validate({
    rules:{
      titular:{
        required: true,
        minlength: 4,
        lettersonly: true
      },
      numero:{
        required: true
        minlength: 16,
      },
      ccv:{
        required: true
      },
      mes:{
        required: true
      },
      year:{
        required: true
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
  })
});