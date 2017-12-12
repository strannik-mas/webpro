$(function(){
//	console.dir(location.search);
	var params = window
	.location
			.search
			.replace('?', '')
			.split('&')
			.reduce(
					function (p, e) {
						var a = e.split('=');
						p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
						return p;
					},
					{}
			);
	newrequest('getCurrentLabel', null, 'All,' + params['item']);
	
});

//показываем принятые данные от сервера
function showLabelInfo(strLabel){
	//временный массив комментов
	var arrComments = [];
	var arrLabel = jQuery.parseJSON(strLabel);
	var coords = {lat: parseFloat(arrLabel[0]['lat']), lng: parseFloat(arrLabel[0]['long'])}
	var str = '';
	var divResult = document.getElementById("divResultComments");
	
	$.ajax({
		type : "GET",
		url : "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + coords.lat + "," + coords.lng + "&sensor=false&language=ru",
		async: false,
		success : function(addrStr) {
//				console.log(addrStr);
			if(addrStr.status == "OK"){
				str = addrStr.results[0].address_components[1].long_name + ", " + addrStr.results[0].address_components[0].long_name;
			}
		},
		error : function(erraddrStr){
//                    $(toupdate).html(html);
			console.log(erraddrStr);
		}
	});
	var h1 = document.createElement('h1');
	var h1Text = document.createTextNode(arrLabel[0]['title']);
	var imgH1 = document.createElement('img');
	imgH1.setAttribute('src', "./img/map-sel.png");		
	
	h1.appendChild(imgH1);
	h1.appendChild(h1Text);
	$($('.notice')[0]).append($(h1));
	
	var divDate = createNewElement('div', 'Добавлена ' + arrLabel[0]['date'], {'class':'data'});
	var span1 = createNewElement('span', 'Тип: ');
	var span2 = createNewElement('span', 'Адрес: ');
	var p1 = createNewElement('p', arrLabel[0]['typename'], {'class':'type'}, span1);
	var p2 = createNewElement('p', str, {'class':'type'}, span2);
	var h4 = createNewElement('h4', 'Описание:');
	var pDesc = createNewElement('p', arrLabel[0]['desc']);
	var $divGalleryContainer = $('<div class="accident-view"></div>');
	if(arrLabel['photos'][0].path !== null){
		var $divImageGallery = $('<div class="fotorama" data-nav="thumbs"  data-arrows="false" data-vertical="true" data-fullscreenIcon="true" data-navPosition="right" data-width="100%" data-ratio="800/600"></div>');
		for (var i = 0; i < arrLabel['photos'].length; i++) {
			imgGal = createNewElement('img', '', {'src': "./" + arrLabel['photos'][i].path + "/" + arrLabel['photos'][i].filename});
			$divImageGallery.append(imgGal);
		}
		$divGalleryContainer.append($divImageGallery);
	}
	
//	console.log($('.col-lg-6.col-md-6.col-sm-6.col-xs-12.accident-desc')[0]);
	$($('.col-lg-6.col-md-6.col-sm-6.col-xs-12.accident-desc')[0]).append($(divDate), $(p1), $(p2), $(h4), $(pDesc), $divGalleryContainer);
	$('.fotorama').fotorama({});
	//выводим маркер на карте
	$('#mapLabel').css('height', 543);
	$('#mapLabel').css('width', 585);
	var map = new google.maps.Map(document.getElementById('mapLabel'), {
		zoom: 15,
		center: coords
	});
	var image = "/" + arrLabel[0]['marker_path'] + "/" + arrLabel[0]['marker_filename'];
	marker = new google.maps.Marker({
		position: coords,
		map: map,
		title: arrLabel[0]['title'],
		icon: image
	});
	var infowindow = new google.maps.InfoWindow({
		content: arrLabel[0]['title']
	});
	google.maps.event.addListener(marker, 'click', function (e) {
		infowindow.open(map, this);
	});
	
	//автор
	// console.dir(arrLabel);
	
}