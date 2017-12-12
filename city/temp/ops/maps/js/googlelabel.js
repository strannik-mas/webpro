var coords = {};		//объект координат от функции whereami()
$(function(){
//	console.log($('#marker_types div.nice-select span.current')[0]);
	//newrequest('getUsers', $('#usersMap'), null);
//	newrequest('getSelectionColums', $('#marker_types select')[0], 'Тип,marker_types');
	$("#check10, #check11, #check12, #check13").change(function(){
		var parameters = '';
		$('input[name=check]').each(function(index, element){
			if($(element).is(":checked")){
				parameters += (parameters ? "," : "") + $(element).val();
			}
		});
		
//		console.log(this.value);
		if(parameters == '')
			newrequest('getAllLabels', null, 'All');
		else newrequest('getAllLabels', null, parameters);
	});
	//filtering
	$('#filter_labels').on('submit', function(){
//		alert('filter');
		centerMap(coords, $('#radius_label').val());
		return false;
	});	
	
	$('#anonim').on('change', function(){
		if ($(this).is(":checked")) {
			$('#label_username').val('anonim');
		}else $('#label_username').val('');
	});
	
	$('#add_label').on('submit', function(){
		console.log($('#lat').val(), sessionStorage.getItem('uName'));
		if($('#lat').val() == ''){			
			alert('Необходимо ввести адрес!')
			return false;
		}
//		alert(sessionStorage.getItem('uName'));
		if(sessionStorage.getItem('uName') == ''){
			alert('Необходимо войти на сайт!');
			return false;
		}else{
			$('#label_username').val(sessionStorage.getItem('uName'));
		}
		if($($('#marker_types div.nice-select span.current')[0]).text() == 'Тип'){
			alert('Необходимо выбрать тип происшествия!');
			return false;
		}else{
			$('#label_type').val($($('#marker_types div.nice-select span.current')[0]).text());
		}
		form_submit('#add_label',null);
    });
	
});


function initMap() {
	var uluru = {lat: 49.979423, lng: 36.178386};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		center: uluru
	});
	google.maps.event.addListener(map, 'tilesloaded', function () {
		newrequest('getAllLabels', null, 'All');
	});
	google.maps.event.addListener(map, 'click', function (e) {
		var location = e.latLng;
		
		document.getElementById('lat').value = location.lat();
		document.getElementById('long').value = location.lng();
		
	});

	var inputs = $('.searchTextField');
//	input.push(document.getElementById('streetaddr_arch'));
//	input.push(document.getElementById('address_label'));	
	var options = {
		offset: 3,
		types: ['address']
	};
	$(inputs).each(function(i,elem){
		if(elem != null){
			var autocomplete = new google.maps.places.Autocomplete(elem, options);
			
			//получаем координаты пользователя при загрузке карты
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function (position) {
					coords = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};
					var circle = new google.maps.Circle({
						center: coords,
						radius: $('#radius_arch').val() ? $('#radius_arch').val() : 3000
					});
					autocomplete.setBounds(circle.getBounds());
				});
			}
			google.maps.event.addListener(autocomplete, 'place_changed', function () {
				var place = autocomplete.getPlace(); //получаем место
				
				$('#lat').val(place.geometry.location.lat());
				$('#long').val(place.geometry.location.lng());
				coords.lat = place.geometry.location.lat();
				coords.lng = place.geometry.location.lng();
				console.log(place.geometry.location.lat());
				console.log(place.geometry.location.lng());
				console.log(place.name);  //название места
				console.log(place.id);  //уникальный идентификатор места
			});
		}
	});
	
}


function showAllMapLabels(arrString, coords = null, newZoom = null) {
	sessionStorage.setItem('markers', arrString);
	var uluru = {lat: 49.979423, lng: 36.178386};
	var srcMarkerImage = '';
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: newZoom ? newZoom : 15,
		center: coords ? coords : uluru
	});
	var arr = arrString.split("|");
//	console.log(arr);
	
	arr.forEach(function (item){
		labelParams = item.split("&&");
		// console.dir(labelParams);
		for(var i = 0; i<labelParams.length; i++){
			var coords = {lat: parseFloat(labelParams[0]), lng: parseFloat(labelParams[1])}
			var image = "/" + labelParams[6] + "/" + labelParams[7];
			marker = new google.maps.Marker({
				position: coords,
				map: map,
				title: labelParams[2],
				icon: image

			});
			console.dir(marker);
			var infowindow = new google.maps.InfoWindow({
				content: "<a href='index.php?ops=maps&type=archive&item="+labelParams[10]+"'>"+labelParams[2]+"</a>"
			});
			//центовка карты по маркеру
			google.maps.event.addListener(marker, 'click', function (e) {
//				console.dir(e);
				infowindow.open(map, this);
				map.setZoom(18);
				map.setCenter(e.latLng);
			});
			
		}
	});
	
	google.maps.event.addListener(map, 'click', function (e) {
		var location = e.latLng;
		document.getElementById('lat').value = location.lat();
		document.getElementById('long').value = location.lng();
	});
}

/**
*Function get 
*/
function whereami(){
	var d = document.getElementById("map");
	var options = {
	  zoom: 15,
	  timeout: 30000,
	  enableHighAccuracy: true, 
	  maximumAge: 75000,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(d, options);
	
	
	var apiGeolocationSuccess = function(map, position) {
		alert("API geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude + "\nAccuracy: " + position.coords.accuracy);
		coords = {lat: position.coords.latitude, lng: position.coords.longitude};
		
		var loc = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		map.setCenter(loc);
		var label = new google.maps.InfoWindow();
		label.setContent("Вы здесь!");
		label.setPosition(loc);
		label.open(map);
	};

	var tryAPIGeolocation = function() {
		jQuery.post( "https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyDCa1LUe1vOczX1hO_iGYgyo8p_jYuGOPU", function (success) {
		apiGeolocationSuccess(new google.maps.Map(document.getElementById('map'), {
			zoom: 16,
			enableHighAccuracy: true, 
			mapTypeId: google.maps.MapTypeId.ROADMAP
			}), {coords: {lat: success.location.lat, lng: success.location.lng}});
				})
					.fail(function (err) {
						alert("API Geolocation error! \n\n" + err);
					});
	};
	function success(position){
		coords = {lat: position.coords.latitude, lng: position.coords.longitude};
		var loc = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		map.setCenter(loc);
		alert("Browser geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
		/*
		parameters = [$('#usersMap option:selected').val(), $('#lat').val(), $('#long').val(), $('#labelDesc').val()];
        newrequest('addGoogleMapLabel', $('#messageMap'), parameters);
		*/
		var label = new google.maps.InfoWindow();
		label.setContent("Вы здесь!");
		label.setPosition(loc);
		label.open(map);
					alert("Ваши координаты: широта: "+position.coords.latitude+" долгота: "+position.coords.longitude+" точность определения, м : "+ position.coords.accuracy);
	}
   function error(err){
		var s = "";
		console.log(err);
		switch(err.code){            
			case 1: s= "Нет разрешения"; tryAPIGeolocation(); break;
			case 2: s= "Техническая ошибка"; break;
			case 3: s= "Превышено время ожидания"; break;
			default: s = err.message;
		}
//					d.innerHTML = s;
   }
   params={
	   timeout: 10000
   }; 
   navigator.geolocation.getCurrentPosition(success, error, params); 
	$('#lat').val(coords.lat);
	$('#long').val(coords.lng);
//   console.log($('#label_latitude').val(), $('#label_longtitude').val());
	return false;
}

function centerMap(coordinates, radius){
	var ourZoom = 21 - Math.ceil((radius/100)*20);
//	alert(ourZoom);
	var d = document.getElementById("map");
	var options = {
		zoom: ourZoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		center: coordinates
	};
	var map = new google.maps.Map(d, options);
	showAllMapLabels(sessionStorage.getItem('markers'), coordinates, ourZoom);
}