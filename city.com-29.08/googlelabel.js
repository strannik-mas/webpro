
$(function(){
	newrequest('getUsers', $('#usersMap'), null);
	newrequest('getSelectionColums', $('#search_column'), null);
	$('#formGoogle').on('submit', function(){
        parameters = [$('#usersMap option:selected').val(), $('#lat').val(), $('#long').val(), $('#labelDesc').val()];
        newrequest('addGoogleMapLabel', $('#messageMap'), parameters);
		$('#lat').val('');
		$('#long').val('');
		$('#labelDesc').val('');
		
		return false;
    });
	
	//autocomplete users
	var str = '';
	$('#searchuser1').on('keypress', function (eventObject){
		if(eventObject.which == 13){
			//unset submit on enter 
			eventObject.preventDefault();
			return false;
		}
		str = str + eventObject.key;		
		if(str.length>2){
//			console.log(str);
//			console.log($('#search_column option:selected').val());
			parameters = [$('#search_table option:selected').val(), $('#search_column option:selected').val()];
			newrequest('getUsers', $('#searchuser1'), parameters);
		}
		
	});
	
});

function newrequest(func, toupdate, params) {
//        console.log(params);
	$.ajax({
		type: "POST",
		url: "func.php",
		data: {
			f: func,
			p: params
		},
		success: function (html) {
			if(func == 'getAllLabels' || func == 'addGoogleMapLabel'){
//				console.log(html);
				showAllMapLabels(html);
			}else if(func == 'getUsers' && params != null){		
				var availableTags = [];
				var obj = JSON.parse(html);
				obj.forEach(function(item){
					availableTags.push(item.toString());
				});
//				console.log(obj);	
//				console.log(availableTags);	
				toupdate.autocomplete({
					minLength: 3,
					source: availableTags
				});
			}else {
//				console.log(html);
				$(toupdate).html(html);
			}
		},
		error: function (html) {
			$(toupdate).html(html);
//			console.log(html);
//			console.log('error');
		}
	});
}

function initMap() {
	var uluru = {lat: 49.979423, lng: 36.178386};

	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		center: uluru
	});
	google.maps.event.addListener(map, 'tilesloaded', function () {
		newrequest('getAllLabels', map, null);
	});
	google.maps.event.addListener(map, 'click', function (e) {
		var location = e.latLng;
		document.getElementById('lat').value = location.lat();
		document.getElementById('long').value = location.lng();
	});

	var input = document.getElementById('cityfind');

	var options = {
		offset: 3,
		types: ['(cities)']
	};

	var autocomplete = new google.maps.places.Autocomplete(input, options);

	google.maps.event.addListener(autocomplete, 'place_changed', function () {
		var place = autocomplete.getPlace(); //получаем место
		console.log(place);
		console.log(place.name);  //название места
		console.log(place.id);  //уникальный идентификатор места
	});
}


function showAllMapLabels(arrString) {
	var uluru = {lat: 49.979423, lng: 36.178386};

	var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 15,
		center: uluru
	});
	var arr = arrString.split("|");
//	console.log(arr);
//	var markers = [];				//array markers
	
	arr.forEach(function (item){
		labelParams = item.split("&&");
//		console.log(labelParams);
		for(var i = 0; i<labelParams.length; i++){
			var coords = {lat: parseFloat(labelParams[0]), lng: parseFloat(labelParams[1])}
//			console.log(labelParams[2]);
			marker = new google.maps.Marker({
				position: coords,
				map: map,
				title:labelParams[2]
			});
//			console.dir(marker);
			var infowindow = new google.maps.InfoWindow({
				content: labelParams[2]
			});
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