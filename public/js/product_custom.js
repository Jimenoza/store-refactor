/* JS Document */

/******************************
[Table of Contents]
1. Vars and Inits
2. Set Header
3. Init Custom Dropdown
4. Init Page Menu
5. Init Recently Viewed Slider
6. Init Brands Slider
7. Init Quantity
8. Init Color
9. Init Favorites
10. Init Image
******************************/

$(document).ready(function()
{
	"use strict";

	/* 
	1. Vars and Inits
	*/

	var menuActive = false;
	var header = $('.header');

	setHeader();

	initCustomDropdown();
	initPageMenu();
	initViewedSlider();
	initBrandsSlider();
	initQuantity();
	initColor();
	initFavs();
	initImage();
	validar();

	$(window).on('resize', function()
	{
		setHeader();
	});



	/* 
	2. Set Header
	*/

	function setHeader()
	{
		//To pin main nav to the top of the page when it's reached
		//uncomment the following

		// var controller = new ScrollMagic.Controller(
		// {
		// 	globalSceneOptions:
		// 	{
		// 		triggerHook: 'onLeave'
		// 	}
		// });

		// var pin = new ScrollMagic.Scene(
		// {
		// 	triggerElement: '.main_nav'
		// })
		// .setPin('.main_nav').addTo(controller);

		if(window.innerWidth > 991 && menuActive)
		{
			closeMenu();
		}
	}

	/* 
	3. Init Custom Dropdown
	*/

	function initCustomDropdown()
	{
		if($('.custom_dropdown_placeholder').length && $('.custom_list').length)
		{
			var placeholder = $('.custom_dropdown_placeholder');
			var list = $('.custom_list');
		}

		placeholder.on('click', function (ev)
		{
			if(list.hasClass('active'))
			{
				list.removeClass('active');
			}
			else
			{
				list.addClass('active');
			}

			$(document).one('click', function closeForm(e)
			{
				if($(e.target).hasClass('clc'))
				{
					$(document).one('click', closeForm);
				}
				else
				{
					list.removeClass('active');
				}
			});

		});

		$('.custom_list select').on('click', function (ev)
		{
			ev.preventDefault();
			var index = $(this).parent().index();

			placeholder.text( $(this).text() ).css('opacity', '1');

			if(list.hasClass('active'))
			{
				list.removeClass('active');
			}
			else
			{
				list.addClass('active');
			}
		});


		$('select').on('change', function (e)
		{
			//alert(this.options[this.selectedIndex].text);
			placeholder.text(this.options[this.selectedIndex].text);

			//$(this).animate({width: placeholder.width() + 'px' });
		});
	}

	/* 
	4. Init Page Menu
	*/

	function initPageMenu()
	{
		if($('.page_menu').length && $('.page_menu_content').length)
		{
			var menu = $('.page_menu');
			var menuContent = $('.page_menu_content');
			var menuTrigger = $('.menu_trigger');

			//Open / close page menu
			menuTrigger.on('click', function()
			{
				if(!menuActive)
				{
					openMenu();
				}
				else
				{
					closeMenu();
				}
			});

			//Handle page menu
			if($('.page_menu_item').length)
			{
				var items = $('.page_menu_item');
				items.each(function()
				{
					var item = $(this);
					if(item.hasClass("has-children"))
					{
						item.on('click', function(evt)
						{
							evt.preventDefault();
							evt.stopPropagation();
							var subItem = item.find('> ul');
						    if(subItem.hasClass('active'))
						    {
						    	subItem.toggleClass('active');
								TweenMax.to(subItem, 0.3, {height:0});
						    }
						    else
						    {
						    	subItem.toggleClass('active');
						    	TweenMax.set(subItem, {height:"auto"});
								TweenMax.from(subItem, 0.3, {height:0});
						    }
						});
					}
				});
			}
		}
	}

	function openMenu()
	{
		var menu = $('.page_menu');
		var menuContent = $('.page_menu_content');
		TweenMax.set(menuContent, {height:"auto"});
		TweenMax.from(menuContent, 0.3, {height:0});
		menuActive = true;
	}

	function closeMenu()
	{
		var menu = $('.page_menu');
		var menuContent = $('.page_menu_content');
		TweenMax.to(menuContent, 0.3, {height:0});
		menuActive = false;
	}

	/* 
	5. Init Recently Viewed Slider
	*/

	function initViewedSlider()
	{
		if($('.viewed_slider').length)
		{
			var viewedSlider = $('.viewed_slider');

			viewedSlider.owlCarousel(
			{
				loop:true,
				margin:30,
				autoplay:true,
				autoplayTimeout:6000,
				nav:false,
				dots:false,
				responsive:
				{
					0:{items:1},
					575:{items:2},
					768:{items:3},
					991:{items:4},
					1199:{items:6}
				}
			});

			if($('.viewed_prev').length)
			{
				var prev = $('.viewed_prev');
				prev.on('click', function()
				{
					viewedSlider.trigger('prev.owl.carousel');
				});
			}

			if($('.viewed_next').length)
			{
				var next = $('.viewed_next');
				next.on('click', function()
				{
					viewedSlider.trigger('next.owl.carousel');
				});
			}
		}
	}

	/* 
	6. Init Brands Slider
	*/

	function initBrandsSlider()
	{
		if($('.brands_slider').length)
		{
			var brandsSlider = $('.brands_slider');

			brandsSlider.owlCarousel(
			{
				loop:true,
				autoplay:true,
				autoplayTimeout:5000,
				nav:false,
				dots:false,
				autoWidth:true,
				items:8,
				margin:42
			});

			if($('.brands_prev').length)
			{
				var prev = $('.brands_prev');
				prev.on('click', function()
				{
					brandsSlider.trigger('prev.owl.carousel');
				});
			}

			if($('.brands_next').length)
			{
				var next = $('.brands_next');
				next.on('click', function()
				{
					brandsSlider.trigger('next.owl.carousel');
				});
			}
		}
	}

	/* 
	7. Init Quantity
	*/

	function initQuantity()
	{
		// Handle product quantity input
		if($('.product_quantity').length)
		{
			var input = $('#quantity_input');
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

	/* 
	8. Init Color
	*/

	function initColor()
	{
		if($('.product_color').length)
		{
			var selectedCol = $('#selected_color');
			var colorItems = $('.color_list li .color_mark');
			colorItems.each(function()
			{
				var colorItem = $(this);
				colorItem.on('click', function()
				{
					var color = colorItem.css('backgroundColor');
					selectedCol.css('backgroundColor', color);
				});
			});
		}
	}

	/* 
	9. Init Favorites
	*/

	function initFavs()
	{
		// Handle Favorites
		var fav = $('.product_fav');
		fav.on('click', function()
		{
			fav.toggleClass('active');
		});
	}

	/* 
	10. Init Image
	*/

	function initImage()
	{
		var images = $('.image_list li');
		var selected = $('.image_selected img');

		images.each(function()
		{
			var image = $(this);
			image.on('click', function()
			{
				var imagePath = new String(image.data('image'));
				selected.attr('src', imagePath);
			});
		});
	}


});

function validar(){
	var cal = $('#quantity_input').val();
	var text = document.getElementById("comentario").value;
	var retorno = false;
	var msj = "* Por favor, ingrese la calificación";
	if(text || cal){
		if(text.length > 300){
			alert("El texto es muy largo, por favor, redúscalo");
		}else if(!cal){
			document.getElementById("error").innerHTML = msj;
		}else{
			retorno = true;
		}
	}
	return retorno;
}

$("a div").click(function(e){
	e.preventDefault();
	//var padre = $("a div").parent();
    //$("a div").parent().append("<p>Esto es un parrafo.</p>");
});

function mostrar(e){
	var formulario = '<form id="respuesta" class="answer" onsubmit="return respuesta()" ' + 
	                    'action="http://localhost:8000/cliente/responder/' + e + '"' +' >'+
						'<div class="form-group row">'+
						'<div class="col-sm-6">'+
						'<textarea type="text" class="form-control" id="respuestaText">'+
						'</textarea>'+
						'<p id="alerta" class="demoFont"></p>'+
						'</div>'+
						'</div>'+
						'<button class="btn btn-primary">Responder</button>'+
						'</form>';
	var x = document.getElementById("" + e);
	var y = document.getElementById("respuesta" + e);
	var padre = $('#link'+e).parent();
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
	var text = document.getElementById("respuestaText").value;
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