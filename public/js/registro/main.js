/*price range*/

 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};

/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

$().ready(function(){
  $("#formularioRegistro").validate({
    rules:{
      userName:{
        required: true,
        minLength: 3,
        lettersOnly: true,
      },
      userEmail: {
        required: true,
        email: true,
        remote: "/usuarios/checkEmail"
      },
      password: {
        required: true,
        minLength: 8,
        maxLength: 20,
      }
    }

        minlength: 4,
        lettersonly: true
      },
      correo:{
        required: true,
        email: true
      },
      contrasena:{
        required: true,
        rangelength: [8,20]
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

  $("#formularioInicioSesion").validate({
    rules:{
      email: {
        required: true,
        email: true
      },
      password: {
        required: true
      }
    }
  })
});
