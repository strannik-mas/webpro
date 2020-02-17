
// Button to Top
$('.btn-scroll-top').hide();
$(window).scroll(function () {
	if ($(this).scrollTop() > 500) {
		$('.btn-scroll-top').fadeIn('slow');
	} else {
		$('.btn-scroll-top').fadeOut('slow');
	}
});
$('.btn-scroll-top').click(function () {
	$('html,body').animate({
		scrollTop: 0
	}, 500);
	$(this).fadeOut('slow');
});


//mobile, nice select, placeholder
$(document).ready(function () {
	$('input,textarea').focus(function () {
		$(this).data('placeholder', $(this).attr('placeholder'))
		$(this).attr('placeholder', '');
	});
	$('input,textarea').blur(function () {
		$(this).attr('placeholder', $(this).data('placeholder'));
	});

	$('select').niceSelect();

	if (window.innerWidth <= 500) {
		$(".notice-search").find('.map-form').appendTo($(".label-links"));
		$(".notice-search").find('.map-form').addClass("dropdown-menu");
	}

	//отмена скрытия формы входа по клику
	$('#mainLogin').click(function (e) {
		if (e.target.className.split(" ")[0] != "fa") {
			e.preventDefault();
			return false;
		}
	});

	//validation login/register form
	$("#mainLogOrReg").validate(
		{
			//        debug: true,
			rules: {
				email: {
					required: true,
					email: true
				},
				Password: {
					required: true,
					alphanumeric: true
				}
			},
			messages: {
				email: {
					required: "Введите email",
					email: "Похоже, что это не email"
				},
				Password: {
					required: "Введите пароль",
					alphanumeric: "Только цифры, буквы и знак _"
				}
			}, /*
			 invalidHandler: function(event, validator) {
			 var errors = validator.numberOfInvalids();
			 if(errors) {
			 //ничего не даёт
			 //          event.preventDefault();
			 //          onsubmit: false;
			 //console.dir(event.target);
			 //event.target.onsubmit = false;
			 alert('Form is not filled correctly!');
			 }
			 },*/
			submitHandler: function () {
				if ($('#mainSubmitButton').text() == "Регистрация") {
					//console.log($('#mainLogOrReg input[name=email]').val());
					var parameters = $('#mainLogOrReg input[name=email]').val() + "," + $('#mainLogOrReg input[name=Password]').val();
					//console.log(parameters);
					newrequest('addOrUpdateUser', $('#mainLogOrReg'), parameters);
				} else {
					alert(3);
					validateUser();
				}


				//$('#type').css('border', '4px double red');
			}
		});

	/*
	 $('#mainLogOrReg').on('submit', function(){
	 if($('#mainSubmitButton').text() == "Регистрация"){
	 
	 }else{
	 alert(3);
	 }
	 newrequest('insertNotify', $('#notifyarea'), parameters);
	 //      console.log(parameters);
	 });
	 */
});

function changeRegBut() {
	//alert(event.target);
	$('#mainSubmitButton').text('Регистрация');
	return false;
}

// Создание элемента с тектом
function createNewElement(tag, text)
{
	var element = document.createElement(tag);
	var elementText = document.createTextNode(text);
	element.appendChild(elementText);
	return element;
}
