/**
 * Function check message for logined users (timeout 60 sec.)
 * @returns {Object}		Array of messages to this user
 */
function getPushMessage(){
	//alert('2');
	window.setTimeout("getPushMessage()", 20000);
	if (ticket) {
		var jsonData2 = JSON.stringify(ticket);		
	} else if (sessionStorage.ticket)
		jsonData2 = sessionStorage.getItem('ticket');
	else return;
	//console.log(jsonData2);
	var req = getXmlHttpRequest();
	req.onreadystatechange = function(){
		if (req.readyState != 4) return;
//		console.log(req.responseText);
		var records = JSON.parse(req.responseText);
		
		for (var i = 0; i < records.length; i++) {
			notify(records[i].message, records[i].url, "ops/notifications/img/mess.jpg", 'message from chat');
		}
	}
	
	req.open("POST", "ops/notifications/getpushdata.php", true);
	req.setRequestHeader("Content-Type", "text/plain");
	
	req.send(jsonData2);
}



function notify(text, link, icon, title) {
	if (Notification.permission === "granted") {
		var options = {
			body: text,
			icon: icon
		}

		var notification = new Notification(title, options);
		notification.onclick = function () {
			notification.close();
			window.location.href = link;
		}
	} else if (Notification.permission !== "denied") {
		Notification.requestPermission(function (permission) {
			if (permission === "granted") {
				var notification = new Notification("Hi there!");
			}
		});
	}
}