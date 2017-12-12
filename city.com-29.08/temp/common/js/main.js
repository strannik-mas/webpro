$(document).ready(function() {
//var $img = $('.fotorama__frame img');
//console.log($img);
//var $src= $($img).attr('src').split('&');
//console.log($src);
//$src[1] = '&w=800&';
//var $new = ($src.join(''));
//console.log($new);
//var $result = $(".fotorama__frame img").attr("src", $new);
//console.log($result);
});


$(function () {
//	$('#fotorama').trigger('rescale', [$(window).width(), $(window).height()]);
	$('.fotorama__fsi').on('click',function (){
		$('.fotorama__frame img').each(function(index,element){
			var src= $(element).attr('src').split('&');
			if(src[1] = 'w=263'){
				src[1] = '&w=800&';
				$(element).attr("src", src.join(''));
			}
		});
	});
    $('.chat-nav a').each(function () {            
        var location = window.location.href; 
        var link = this.href;                
        if(location == link) {               
            $(this).addClass('active-chat-nav');  
        }
    });
});

//mobile, nice select, placeholder
$(document).ready(function() {
	// Button to Top
	$('.btn-scroll-top').hide();
	$(window).scroll(function() {
		if ($(this).scrollTop() > 500) {
			$('.btn-scroll-top').fadeIn('slow');
		} else {
			$('.btn-scroll-top').fadeOut('slow');
		}
	});
	$('.btn-scroll-top').click(function() {
		$('html,body').animate({
			scrollTop : 0
		}, 500);
		$(this).fadeOut('slow');
	});

	$('select').niceSelect();

	if (window.innerWidth <= 500) {
		$(".notice-search").find('.map-form').appendTo($(".label-links"));
		$(".notice-search").find('.map-form').addClass("dropdown-menu");
	}
});

function changeRegBut() {
	//alert(event.target);
	$('#mainSubmitButton').text('Регистрация');
	return false;
}

// Создание элемента с тектом
function createNewElement(tag, text, newAttr = null, newElement = null) {
	var element = document.createElement(tag);
	var elementText = document.createTextNode(text);
	if (newElement != null)
		element.appendChild(newElement);
	element.appendChild(elementText);
	if (newAttr !== null) {
		for (key in newAttr) {
			element.setAttribute(key, newAttr[key]);
		}
	}
	return element;
}

function initMap() {
	var input = document.getElementById('streetaddr_arch');
	if (input != null) {
		var options = {
			offset : 3,
			types : ['address']
		};
		var autocomplete = new google.maps.places.Autocomplete(input, options);
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var geolocation = {
					lat : position.coords.latitude,
					lng : position.coords.longitude
				};
				var circle = new google.maps.Circle({
					center : geolocation,
					radius : $('#radius_arch').val() ? $('#radius_arch').val() : 3000
				});
				autocomplete.setBounds(circle.getBounds());
			});
		}
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			//получаем место
			console.log(place);
			console.log(place.name);
			//название места
			console.log(place.id);
			//уникальный идентификатор места
		});
	}

}

function initMap2() {
	var input = document.getElementById('cities');
	if (input != null) {
		var options = {
			offset : 3,
			types : ['(cities)']
		};
		var autocomplete = new google.maps.places.Autocomplete(input, options);
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				var geolocation = {
					lat : position.coords.latitude,
					lng : position.coords.longitude
				};
				var circle = new google.maps.Circle({
					center : geolocation,
					radius : $('#radius_arch').val() ? $('#radius_arch').val() : 3000
				});
				autocomplete.setBounds(circle.getBounds());
			});
		}
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			//получаем место
			console.log(place);
			console.log(place.name);
			//название места
			console.log(place.id);
			//уникальный идентификатор места
		});
	}

}

initMap2();

$(".add-tel").click(function() {
	$(".form-tel2").toggle();
});

//for mini-chat
function minichatInit(strHtml) {
	var divResult = document.getElementById("divResultMiniChat");
	while (divResult.hasChildNodes())
	divResult.removeChild(divResult.lastChild);
	var arrMess = jQuery.parseJSON(strHtml);
	console.log(arrMess);

	for (var j = 0; j < arrMess.length; j++) {
		$divRecord = $(arrMess[j]['div']);
		//		console.log($divRecord);
		var divRecordRow = document.createElement("div");
		divRecordRow.className = "chat-item row";
		var divUInfo = document.createElement("div");
		divUInfo.className = "chat-user-info";
		var divUserPhoto = document.createElement("div");
		divUserPhoto.className = "chat-user";
		if (arrMess[j]['path'] && arrMess[j]['filename'])
			divUserPhoto.innerHTML = "<a href=''><span class='img-inner'><img src='" + "/" + arrMess[j]['path'] + "/" + arrMess[j]['filename'] + "' alt='user' class='img-circle img-responsive'></span></a>";
		else
			divUserPhoto.innerHTML = "<a href=''><span class='img-inner'><img src='" + "ops/chat/img/thumb_170_170_c_noimg.png" + "' alt='user' class='img-circle img-responsive'></span></a>";

		var divMessInfo = document.createElement("div");
		divMessInfo.className = "chat-message-info";
		// Ссылка на автора
		var aAuthor = createNewElement("a", arrMess[j]['username'], {
			'class' : 'user-name'
		});
		divMessInfo.appendChild(aAuthor);

		//message date
		var spanDateContainer = document.createElement("span");

		var spanMessData = createNewElement("span", arrMess[j]['date'], {
			'class' : 'data'
		});
		spanDateContainer.insertBefore(spanMessData, spanDateContainer.firstChild);

		divMessInfo.appendChild(spanDateContainer);

		if ($divRecord.hasClass('chat-inner answer')) {
			divUInfo.appendChild(divMessInfo);
			divUInfo.appendChild(divUserPhoto);

		} else {
			divUInfo.appendChild(divUserPhoto);
			divUInfo.appendChild(divMessInfo);

			//			console.log(document.getElementById('yourchat').hasChildNodes());
			if (!document.getElementById('yourchat').hasChildNodes()) {
				//функциональная нижняя панель
				$divUInfo = $('<div class="chat-user-info"></div>');
				$divUPhoto = $('<div class="chat-user"><a href="#"><span class="img-inner"><img src="/' + arrMess[j]['path'] + "/" + arrMess[j]['filename'] + '" alt="user" class="img-circle img-responsive"></span></a></div>');
				$divMess = $('<div class="chat-message-info"></div');
				var aNewAuthor = createNewElement("a", arrMess[j]['username'], {
					'class' : 'user-name'
				});
				$divMess.append($(aNewAuthor));
				$divAction = $('<div class="your-chat-action"><a href="#"><img src="img/reply.png" alt="reply"></a><a href="#"><img src="img/arrows.png" alt="arrows"></a><a href="#"><img src="img/close.png" alt="close"></a></div>');
				$divUInfo.append($divUPhoto, $divMess, $divAction);
				$('#yourchat').append($divUInfo);
			}

		}

		divRecordRow.appendChild(divUInfo);

		//div-container for message
		var divMessage = document.createElement("div");
		divMessage.className = "chat-message";
		var pMessage = createNewElement("p", arrMess[j]['message']);
		divMessage.appendChild(pMessage);
		divRecordRow.appendChild(divMessage);
		$divRecord.append($(divRecordRow));

		//divResult.appendChild(divRecord);
		$(divResult).prepend($divRecord);
		cemoticons('#mess_private');

	}

}

function cemoticons(elememt, ename, button) {
	// toggles emoji picker
	// $(elememt).emoji('toggle');

	$(elememt).emoji({
		// show emoji groups
		showTab : false,
		button : button,
		animation : 'fade',
		icons : [{
			name : ename, // Emoji name
			path : "./img/tieba/", // path to the emoji icons
			maxNum : 50,
			file : ".jpg", // file extension name
			placeholder : ":{alias}:",
			excludeNums : [], // exclude emoji icons
			title : {}, // titles of emoji icons
			alias : {
				1 : "hehe",
				2 : "haha",
				3 : "tushe",
				4 : "a",
				5 : "ku",
				6 : "lu",
				7 : "kaixin",
				8 : "han",
				9 : "lei",
				10 : "heixian",
				11 : "bishi",
				12 : "bugaoxing",
				13 : "zhenbang",
				14 : "qian",
				15 : "yiwen",
				16 : "yinxian",
				17 : "tu",
				18 : "yi",
				19 : "weiqu",
				20 : "huaxin",
				21 : "hu",
				22 : "xiaonian",
				23 : "neng",
				24 : "taikaixin",
				25 : "huaji",
				26 : "mianqiang",
				27 : "kuanghan",
				28 : "guai",
				29 : "shuijiao",
				30 : "jinku",
				31 : "shengqi",
				32 : "jinya",
				33 : "pen",
				34 : "aixin",
				35 : "xinsui",
				36 : "meigui",
				37 : "liwu",
				38 : "caihong",
				39 : "xxyl",
				40 : "taiyang",
				41 : "qianbi",
				42 : "dnegpao",
				43 : "chabei",
				44 : "dangao",
				45 : "yinyue",
				46 : "haha2",
				47 : "shenli",
				48 : "damuzhi",
				49 : "ruo",
				50 : "OK"
			},
		}]
	});
}

function cemoticons2(element) {
	$(element).emojiParse({
		icons : [{
			path : "./img/tieba/",
			file : ".jpg",
			placeholder : ":{alias}:",
			alias : {
				1 : "hehe",
				2 : "haha",
				3 : "tushe",
				4 : "a",
				5 : "ku",
				6 : "lu",
				7 : "kaixin",
				8 : "han",
				9 : "lei",
				10 : "heixian",
				11 : "bishi",
				12 : "bugaoxing",
				13 : "zhenbang",
				14 : "qian",
				15 : "yiwen",
				16 : "yinxian",
				17 : "tu",
				18 : "yi",
				19 : "weiqu",
				20 : "huaxin",
				21 : "hu",
				22 : "xiaonian",
				23 : "neng",
				24 : "taikaixin",
				25 : "huaji",
				26 : "mianqiang",
				27 : "kuanghan",
				28 : "guai",
				29 : "shuijiao",
				30 : "jinku",
				31 : "shengqi",
				32 : "jinya",
				33 : "pen",
				34 : "aixin",
				35 : "xinsui",
				36 : "meigui",
				37 : "liwu",
				38 : "caihong",
				39 : "xxyl",
				40 : "taiyang",
				41 : "qianbi",
				42 : "dnegpao",
				43 : "chabei",
				44 : "dangao",
				45 : "yinyue",
				46 : "haha2",
				47 : "shenli",
				48 : "damuzhi",
				49 : "ruo",
				50 : "OK"
			}
		}]
	});
}


$(document).ready(function() {
	//ADD SMILE IN TEXTAREA
	cemoticons('.notice-add #txtMessage', 'emoji', '#emoji');
	cemoticons('#mess_private', 'emoji1', '#emoji2');
	//PARSER SMILES IN CHAT
	cemoticons2('.record');
	cemoticons2('.chat-message');
});

$(document).on("ajaxComplete", function() {
	//ADD SMILE IN TEXTAREA
	cemoticons('.notice-add #txtMessage', 'emoji');
	cemoticons('#mess_private', 'emoji1');
	//PARSER SMILES IN CHAT
	cemoticons2('.record');
	cemoticons2('.chat-message');
});
