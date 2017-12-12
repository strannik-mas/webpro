var allDivArr = [];
$(function(){
	
	newrequest('getAllLabels', null, 'AllDiv');
	
	$("#check10, #check11, #check12, #check13").change(function(){
		var parameters = '';
		$('input[name=check]').each(function(index, element){
			if($(element).is(":checked")){
				parameters += (parameters ? "," : "") + $(element).val();
			}
		});
		
//		console.log(this.value);
		newrequest('getAllLabels', null, parameters 
				+ (parameters ? ',AllDiv' : 'AllDiv'));
	});
	
	$.datepicker.setDefaults(
		$.extend($.datepicker.regional["ru"])
	);
	$( "#datepicker_arch" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "yy-mm-dd"
	});
	
	$('#filter_archive').on('submit', function(){
		var parameters = $('#streetaddr_arch').val() + "|"
				+ $('#datepicker_arch').val() + "|"
				+ $('#name_arch').val() + "|"
				+ $('#username_arch').val() + "|AllDiv";

		if(parameters == "||||AllDiv")
			alert('Заполните хотя бы одно поле!');
		else 
			showAllDivs('', allDivArr, [$('#streetaddr_arch').val(), $('#datepicker_arch').val(), $('#name_arch').val(), $('#username_arch').val()])
//			console.log(allDivArr);
//			newrequest('filterLabels', null, parameters);
		return false;
	});
	
	
});

/*
function showAllDivs(arrString, arrD = null, arrP = null){
	Date.prototype.format = function (mask, utc) {
		return dateFormat(this, mask, utc);
	};
	
	if(arrD == null){
		arrD = arrString.split("|");
		arrD.pop();
		allDivArr = arrD;
	}
	
//console.dir(location);
	var divList = document.getElementById('labellist');
	while (divList.hasChildNodes()) divList.removeChild(divList.lastChild);
	console.dir(arrD);
	var j = 0;
	arrD.forEach(function (item){		
		labelParams = item.split("&&");
//		console.log(labelParams);
		var coords = {lat: parseFloat(labelParams[0]), lng: parseFloat(labelParams[1])}
		var image = "/" + labelParams[6] + "/" + labelParams[7];
		var imageAvatar = "/" + labelParams[11] + "/" + labelParams[12];
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
		divarchDesc.setAttribute('class', 'col-lg-5 col-md-5 col-sm-4 col-xs-6 accident-desc accident-desc-height');
		//filtering 
		var h4Title = createNewElement('h4', labelParams[3]);
		divarchDesc.appendChild(h4Title);
		
		var divarchType = document.createElement('div');
		divarchType.setAttribute('class', 'type');
		var spanType = createNewElement('span', 'Тип: ');
		var elementText = document.createTextNode(labelParams[5]);
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
		userImg.setAttribute('src', imageAvatar);
		userImg.setAttribute('alt', "user");
		userImg.setAttribute('class', 'img-circle img-responsive');
		aImgUser.appendChild(userImg);
		divUserInfo.appendChild(aImgUser);
		var divUserInfoName = document.createElement('div');
		divUserInfoName.setAttribute('class', 'user-info-text');
		var aUname = createNewElement('a', labelParams[4]);
		aUname.setAttribute('class', "user-name");
		divUserInfoName.appendChild(aUname);
		divUserInfo.appendChild(divUserInfoName);
		var divDate = createNewElement('div', 'Добавлена ' + labelParams[8]);
		divDate.setAttribute('class', 'data');
		
		var $divMore = $('<div class="more-inner"><a href="' + location.origin + location.pathname + "?ops=maps&type=archive" + '&item=' + labelParams[9] + '" class="more">Подробнее</a></div>');
		var spanCountComments = createNewElement('span', labelParams[10]);
		var spanCountPhoto = createNewElement('span', labelParams[13]);
		
		$.ajax({
			type : "GET",
			url : "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + coords.lat + "," + coords.lng + "&sensor=false&language=ru",
			success : function(addrStr) {
//				console.log(addrStr);
				if(addrStr.status == "OK"){
					var str = addrStr.results[0].address_components[1].long_name + ", " + addrStr.results[0].address_components[0].long_name;
					
					var elementText2 = document.createTextNode(str);
					divarchType2.appendChild(elementText2);
					divarchDesc.appendChild(divarchType2);
					divarchDesc.appendChild(divUserInfo);
					
					
					var divRight = document.createElement('div');
					divRight.setAttribute('class', 'col-lg-3 col-md-3 col-sm-4 col-xs-6 accident-info');
					
					var $paragraf = $('<p><img src="ops/maps/img/comm.png" alt="comm"/></p>');
					var $paragraf2 = $('<p><img src="ops/maps/img/camera.png" alt="camera"/></p>');
//		console.log($paragraf);
					
					var elementTextP = document.createTextNode(' комментариев');
					var elementTextP2 = document.createTextNode(' фото');

					$paragraf.append($(spanCountComments), $(elementTextP));
					$paragraf2.append($(spanCountPhoto), $(elementTextP2));
					$(divRight).append($(divDate), $paragraf, $paragraf2, $divMore);
					if(arrP != null){
						if(arrP[1]) console.log($('#datepicker_arch').val());
//console.log(arrP[0]);
					}
					$(divRecord).append($(divarchDesc), $(divRight));
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
*/