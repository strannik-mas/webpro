// Класс UserInfo
function UserInfo(id, log, pass)
{
	this.id = id;
	this.login = log;
	this.password = pass;
}

// Класс Билет сессии
function Ticket(t)
{
	this.id = "";
	this.valid = false;
	this.name = "";
}
//класс записи чата
function Record(author, message, rec, s)
{
	this.author = author;
	this.message = message;
	this.recipient = rec;
	this.status = s;
}

var checkTimer;
var checkTimer2;
var checkInterval = 10000;
var checkInterval2 = 20000;
/**
 * @var for set timeout on getPuch functions
 * @type Number
 */
var checkIntervalPush = 20000;


/**
 * @var isPushEnabled			
 * @type Boolean
 */
//var isPushEnabled = false;

/**
 * @var worker			add new Worker to push the message
 * @type Worker
 */
var worker = new Worker("notify_worker.js");

// Дата и время последнего изменения гостевой книги,
// по умолчанию - дата в прошлом
var lastUpdate = new Date("01/01/1900");

function showLoginForm(but){
	//console.log(but);
	but.style.visibility = 'hidden';
	var f = document.getElementById("frmLogin");
	f.style.display = "block";
}

// Билет пользователя
var ticket;
var name;
function validateUser(){
	var txtLog = document.getElementById("txtLogin");
	var txtPass = document.getElementById("txtPassword");

// Проверка заполнения элементов
	if (txtLog.value == "" || txtPass.value == "")
	{
		alert("Enter all fields...");
		return;
	}


	var user = new UserInfo('', txtLog.value, txtPass.value);
	// Сериализация в JSON
	var jsonData = JSON.stringify(user);
//	console.log(jsonData);
	// Передача данных
	var req = getXmlHttpRequest();
	req.open("POST", "user_auth.php", true);
	req.onreadystatechange = function()
	{
		if (req.readyState != 4) return;
		ticket = JSON.parse(req.responseText);
//			console.log(tiket);
		if (!ticket.valid){
			var dm = document.getElementById("divMessage");
			dm.style.display = "block";
		}else {
			name = ticket.name;
			sessionStorage.setItem('ticket', req.responseText);
			getOnlineUser();

		}
		
	}
	
	req.setRequestHeader("Content-Type", "text/plain");
//	req.setRequestHeader("Content-Length", jsonData.length);			
	req.send(jsonData);
}
function hideErrorMessage(){
	var dm = document.getElementById("divMessage");
	dm.style.display = "";
}
function getOnlineUser(){
	if(ticket){
//		console.log(1);
		var jsonData2 = JSON.stringify(ticket);
		document.getElementById("frmLogin").style.display = "none";
	}		
	else if(sessionStorage.ticket) jsonData2 = sessionStorage.getItem('ticket');
	else return;
//	console.log(jsonData2);
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
		{
			if (req.readyState != 4) return;
//			console.log(req.responseText);
			getOnlineUser.users = JSON.parse(req.responseText);
			
			//add option for select user to send message
			sel = document.getElementById("recipients");
			// delete old records
			while (sel.hasChildNodes()) sel.removeChild(sel.lastChild);
			var opt = createElement("option", "All");
			opt.setAttribute("value", '0');
			
			sel.appendChild(opt);

			var divUs = document.getElementById("divUsers");
			var ul = divUs.getElementsByTagName('UL')[0];
				// Удаление старых записей
			while (ul.hasChildNodes()) ul.removeChild(ul.lastChild);
			for (var i = 0; i < getOnlineUser.users.length; i++)
			{

				var aAuthor = createElement("li", getOnlineUser.users[i].login);
				aAuthor.setAttribute("list-style-type", "square");
				ul.appendChild(aAuthor);
				
				opt = createElement("option", getOnlineUser.users[i].login);		
				opt.setAttribute("value", getOnlineUser.users[i].id);
				if(getOnlineUser.users[i].id == sessionStorage.getItem('select'))
					opt.setAttribute("selected", true);
				
				
				sel.appendChild(opt);
			}
			checkUpdates();
			getPushMessage();
			checkTimer2 = window.setTimeout("getOnlineUser()", checkInterval2);
		}
	req.open("POST", "get_online_users.php", true);
	req.setRequestHeader("Content-Type", "text/plain");
	
	req.send(jsonData2);	
	
}

/**
 * Function check message for logined users (timeout 60 sec.)
 * @returns {Object}		Array of messages to this user
 */
function getPushMessage(){
	if (ticket) {
		var jsonData2 = JSON.stringify(ticket);		
		document.getElementById("frmLogin").style.display = "none";
	} else if (sessionStorage.ticket)
		jsonData2 = sessionStorage.getItem('ticket');
	else return;
	
	var req = getXmlHttpRequest();
	req.onreadystatechange = function(){
		if (req.readyState != 4) return;
		console.log(JSON.parse(req.responseText));
//		var worker = new Worker("notify_worker.js");
//		worker.postMessage(JSON.parse(req.responseText));

		var records = JSON.parse(req.responseText);
		for (var i = 0; i < records.length; i++) {
			notify(records[i].message, records[i].url, "mess.jpg", 'message from chat');
		}
	}
	
	req.open("POST", "getpushdata.php", true);
	req.setRequestHeader("Content-Type", "text/plain");
	window.setTimeout("getPushMessage()", checkInterval2);
//	console.log(jsonData2);
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

function addRecord()
{
	// Элементы управления
	var txtMessage = document.getElementById("txtMessage");
	var selectedUser = document.getElementById("recipients");
	//select value of selected option
//	console.log(selectedUser.options[selectedUser.selectedIndex].value);

	
	// Проверка заполнения элементов
	if (txtMessage.value == "")
	{
		alert("You must write a message!");
		return;
	}
	ticket = JSON.parse(sessionStorage.ticket);
	// Создание объъекта записи
	var record = new Record(ticket.id, txtMessage.value, selectedUser.options[selectedUser.selectedIndex].value, 0);

	// Сериализация в JSON
	var jsonData = JSON.stringify(record);
//	console.log(jsonData);
	// Передача данных
	var reqChat = getXmlHttpRequest();
	reqChat.onreadystatechange = function()
		{
			if (reqChat.readyState != 4) return;
			// Завершение передачи... Сброс таймера и показ сообщения
			window.clearTimeout(checkTimer);
			checkUpdates();
		}
	reqChat.open("POST", "addrecord.php", true);
	reqChat.setRequestHeader("Content-Type", "text/plain");
//	reqChat.setRequestHeader("Content-Length", jsonData.length);			
	reqChat.send(jsonData);				
}
function getLastModified()
{
	// Выполним запрос HEAD к скрипту гостевой книги...
	var reqChat = getXmlHttpRequest();
	var date;
	reqChat.open("HEAD", "getlastmsgs.php", false);
	reqChat.onload = function(e) {
		if (this.readyState == 4) {
//			console.log(new Date(Date.parse(reqChat.getResponseHeader("Last-Modified"))));
			date = new Date(reqChat.getResponseHeader("Last-Modified"));
			}		
		};
	reqChat.send(null);
	
	// Создадим объект Date на основе ответа Last-Modified
	return date;
}

// Создание элемента с тектом
function createElement(tag, text)
{
	var element = document.createElement(tag);
	var elementText = document.createTextNode(text);
	element.appendChild(elementText);
	return element;
}

function checkUpdates()
{
	var lastModified = getLastModified();
	var selectedUser = document.getElementById("recipients");
//	console.log(selectedUser.options[selectedUser.selectedIndex]); 
//	console.log(lastModified);
//	console.log(lastUpdate);
	if (lastUpdate < lastModified)
	{
		// Запрос новых данных из чата
		var reqChat = getXmlHttpRequest();
		if(sessionStorage.getItem('ticket')){
			ticket = JSON.parse(sessionStorage.ticket);
			if (selectedUser.options[selectedUser.selectedIndex]){
				var jsonDataRec = JSON.stringify({from:ticket.id, to:selectedUser.options[selectedUser.selectedIndex].getAttribute("value")});
			}else {
				var jsonDataRec = JSON.stringify(ticket.id);
			}
//			console.log(jsonDataRec);
			reqChat.open("POST", "getlastmsgs.php", true);
			reqChat.send(jsonDataRec);
		}
		

		
		reqChat.onreadystatechange = function()
		{
			if (reqChat.readyState != 4) return;
			if(reqChat.responseText)
				var records = JSON.parse(reqChat.responseText);
//			console.log(reqChat.responseText);
			// Элемент для отображения
			var divResult = document.getElementById("divResult");
			// Удаление старых записей
			while (divResult.hasChildNodes()) divResult.removeChild(divResult.lastChild);
			// Отображение записей чата
			for (var i = 0; i < records.length; i++)
			{
				// Элемент для размещения записи
				var divRecord = document.createElement("div");
				divRecord.className = "divRecord";
				// Ссылка на автора
				var aAuthor = createElement("p", records[i].author);
				// Текст сообщения
				var pMessage = createElement("p", records[i].message);
				divRecord.appendChild(aAuthor);
				divRecord.appendChild(pMessage);
				divResult.appendChild(divRecord);
				// Время  последнего отображения 
				lastUpdate = lastModified;
			}
		}
		
		
	}
	// Таймер на следующую проверку
	checkTimer = window.setTimeout("checkUpdates()", checkInterval);
}
function hideForm(){
	document.getElementById("frmLogin").style.display = "none";
	document.getElementById("but_users").style.visibility = ''; 
}

window.onload = function()
{
	document.getElementById("frmLogin").style.display = "none";	
	if(sessionStorage.getItem('ticket')){
		document.getElementById("but_users").style.visibility = 'hidden';
		
	}
	if(!sessionStorage.getItem('select')){
		document.getElementById("recipients").addEventListener('change', function (){
			var selectedUser = document.getElementById("recipients");
			sessionStorage.setItem('select', selectedUser.options[selectedUser.selectedIndex].value);
//			console.log(selectedUser.options[selectedUser.selectedIndex].value);
		});
	}
	getOnlineUser();
		
	getPushMessage();
//	worker.postMessage([]);
};

//window.onbeforeunload = function(){
//	var req = getXmlHttpRequest();
//	
//	req.open("POST", "delete_session.php", false);
//	req.setRequestHeader("Content-Type", "text/plain");
//	
//	req.send(sessionStorage.getItem('ticket'));
//	console.log(sessionStorage.getItem('ticket'));
//	return false;
//}


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
			else new Notification(title);
		});
	}
}