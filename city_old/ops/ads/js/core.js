$(".list li").click(function() {
	var group = $(this).attr("data-value");
	$(".selection-group select option").attr('selected', false);
	$(".selection-group select option[value=" + group + "]").attr('selected', true);
	// $(".selection-group select").val(group);
});

function initMap() {
	var uluru = {
		lat : 49.979423,
		lng : 36.178386
	};
	var map = new google.maps.Map(document.getElementById('map'), {
		zoom : 15,
		center : uluru
	});
	google.maps.event.addListener(map, 'tilesloaded', function() {
		newrequest('getAllLabels', null, 'All');
	});
	google.maps.event.addListener(map, 'click', function(e) {
		var location = e.latLng;
		/*
		 document.getElementById('lat').value = location.lat();
		 document.getElementById('long').value = location.lng();
		 */
	});

	var input = document.getElementById('streetaddr');

	var options = {
		offset : 3,
		types : ['address']/*,
		 location: [uluru.lat+','+uluru.lng],
		 radius: ['300']*/
	};
	console.dir(options);
	var autocomplete = new google.maps.places.Autocomplete(input, options);

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

/**
 *Function get
 */
function whereami() {
	var d = document.getElementById("map");
	var options = {
		zoom : 13,
		timeout : 30000,
		enableHighAccuracy : true,
		maximumAge : 75000,
		mapTypeId : google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(d, options);

	var apiGeolocationSuccess = function(map, position) {
		alert("API geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude + "\nAccuracy: " + position.coords.accuracy);
		var uluru = {
			lat : position.coords.latitude,
			lng : position.coords.longitude
		};

		var loc = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		map.setCenter(loc);
		var label = new google.maps.InfoWindow();
		label.setContent("Вы здесь!");
		label.setPosition(loc);
		label.open(map);
	};

	var tryAPIGeolocation = function() {
		jQuery.post("https://www.googleapis.com/geolocation/v1/geolocate?key=AIzaSyDCa1LUe1vOczX1hO_iGYgyo8p_jYuGOPU", function(success) {
			apiGeolocationSuccess(new google.maps.Map(document.getElementById('map'), {
				zoom : 16,
				enableHighAccuracy : true,
				mapTypeId : google.maps.MapTypeId.ROADMAP
			}), {
				coords : {
					latitude : success.location.lat,
					longitude : success.location.lng
				}
			});
		}).fail(function(err) {
			alert("API Geolocation error! \n\n" + err);
		});
	};
	function success(position) {
		var loc = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		map.setCenter(loc);
		//alert("Browser geolocation success!\n\nlat = " + position.coords.latitude + "\nlng = " + position.coords.longitude);
		parameters = [$('#usersMap option:selected').val(), $('#lat').val(), $('#long').val(), $('#labelDesc').val()];
		newrequest('addGoogleMapLabel', $('#messageMap'), parameters);
		var label = new google.maps.InfoWindow();
		label.setContent("Вы здесь!");
		label.setPosition(loc);
		label.open(map);
		//					d.innerHTML = "Ваши координаты: широта: "+position.coords.latitude+" долгота: "+position.coords.longitude+" точность определения, м : "+ position.coords.accuracy;
	}

	function error(err) {
		var s = "";
		console.log(err);
		switch(err.code) {
		case 1:
			s = "Нет разрешения";
			tryAPIGeolocation();
			break;
		case 2:
			s = "Техническая ошибка";
			break;
		case 3:
			s = "Превышено время ожидания";
			break;
		default:
			s = err.message;
		}
		//					d.innerHTML = s;
	}

	params = {
		timeout : 10000
	};
	navigator.geolocation.getCurrentPosition(success, error, params);
	return false;
}