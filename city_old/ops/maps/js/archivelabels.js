$(function(){
	newrequest('getAllLabels', null, 'AllDiv');
});

function initMap() {
	
	/*
	
	*/
}

function showAllDivs(arrString){
	var arr = arrString.split("|");
	console.log(arr);
	var j = 0;
	arr.forEach(function (item){
		
		var divList = document.getElementById('labellist');
		labelParams = item.split("&&");
//		console.log(labelParams);
		var coords = {lat: parseFloat(labelParams[0]), lng: parseFloat(labelParams[1])}
		switch(labelParams[3]){
			case '3':
				srcMarkerImage = 'img/map-marker-3.png';
				archlabesType = 'SOS';
				break;
			case '2':
				srcMarkerImage = 'img/map-marker-2.png';
				archlabesType = 'ДПС';
				break;
			case '1':
				srcMarkerImage = 'img/map-marker.png';
				archlabesType = 'ДТП';
				break;
			default:
				srcMarkerImage = 'img/map.png';
				archlabesType = 'Другое';
		}
		var image = srcMarkerImage;
		var divRecord = document.createElement('div');
		divRecord.setAttribute('class', 'archive-accident row');
		var divarchRecMap = document.createElement('div');
		divarchRecMap.setAttribute('class', 'col-lg-4 col-md-4 col-sm-4 accident-map');
		divarchRecMap.setAttribute('id', 'accident-map_'+j);
		divarchRecMap.style.height = '260px';
		divRecord.appendChild(divarchRecMap);
		divList.appendChild(divRecord);
		var mapRec = new google.maps.Map(document.getElementById('accident-map_'+j), {
			zoom: 15,
			center: coords
		});
		marker = new google.maps.Marker({
			position: coords,
			map: mapRec,
			title:labelParams[2],
			icon: image

		});
//			console.dir(marker);
		var infowindow = new google.maps.InfoWindow({
			content: labelParams[2]
		});
		google.maps.event.addListener(marker, 'click', function (e) {
//				console.dir(e);
			infowindow.open(mapRec, this);
			mapRec.setZoom(18);
			mapRec.setCenter(e.latLng);
		});
		var divarchDesc = document.createElement('div');
		divarchDesc.setAttribute('class', 'col-lg-5 col-md-5 col-sm-4 col-xs-6 accident-desc');
		var h4Title = createNewElement('h4', labelParams[4]);
		divarchDesc.appendChild(h4Title);
		
		var divarchType = document.createElement('div');
		divarchType.setAttribute('class', 'type');
		var spanType = createNewElement('span', 'Тип: ');
		var elementText = document.createTextNode(archlabesType);
		divarchType.appendChild(spanType);
		divarchType.appendChild(elementText);
		divarchDesc.appendChild(divarchType);
		
		var divarchType2 = document.createElement('div');
		divarchType2.setAttribute('class', 'type');
		var spanType2 = createNewElement('span', 'Адрес: ');
		divarchType2.appendChild(spanType2);
		
		var divUserInfo = document.createElement('div');
		divUserInfo.setAttribute('class', 'user-info');
		var aImgUser = document.createElement('a');
		aImgUser.setAttribute('class', 'user-face');
		var userImg = document.createElement('img');
		userImg.setAttribute('src', "img/user.png");
		userImg.setAttribute('alt', "user");
		userImg.setAttribute('class', 'img-circle img-responsive');
		aImgUser.appendChild(userImg);
		divUserInfo.appendChild(aImgUser);
		var divUserInfoName = document.createElement('div');
		divUserInfoName.setAttribute('class', 'user-info-text');
		var aUname = createNewElement('a', labelParams[5]);
		aUname.setAttribute('class', "user-name");
		divUserInfoName.appendChild(aUname);
		divUserInfo.appendChild(divUserInfoName);
		
		$.ajax({
			type : "GET",
			url : "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + coords.lat + "," + coords.lng + "&sensor=false&language=ru",
			success : function(addrStr) {
				if(addrStr.status == "OK"){
					var str = addrStr.results[0].address_components[1].long_name + ", " + addrStr.results[0].address_components[0].long_name;
					var elementText2 = document.createTextNode(str);
					divarchType2.appendChild(elementText2);
					divarchDesc.appendChild(divarchType2);
					divarchDesc.appendChild(divUserInfo);
					
					divRecord.appendChild(divarchDesc);
				}
				
			},
			error : function(addrStr){
	//                    $(toupdate).html(html);
	//					console.log(html);
			}
		});
		
		j++;
		
	});
}