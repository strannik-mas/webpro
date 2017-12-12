/**
 * Function check message for logined users (timeout 60 sec.)
 * @returns {Object}		Array of messages to this user
 */
function getPushMessage(){
	if (ticket) {
		var jsonData2 = JSON.stringify(ticket);		
	} else if (sessionStorage.ticket)
		jsonData2 = sessionStorage.getItem('ticket');
	else return;
	
	var req = getXmlHttpRequest();
	req.onreadystatechange = function(){
		if (req.readyState != 4) return;

		var records = JSON.parse(req.responseText);
		for (var i = 0; i < records.length; i++) {
			notify(records[i].message, records[i].url, "mess.jpg", 'message from chat');
		}
	}
	
	req.open("POST", "./../getpushdata.php", true);
	req.setRequestHeader("Content-Type", "text/plain");
	window.setTimeout("getPushMessage()", checkInterval2);
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

window.onload = function()
{
	getPushMessage();
};