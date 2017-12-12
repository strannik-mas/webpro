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
var checkInterval = 20000;
var checkInterval2 = 20000;
/**
 * @var for set timeout on getPuch functions
 * @type Number
 */
var checkIntervalPush = 20000;


// Дата и время последнего изменения гостевой книги,
// по умолчанию - дата в прошлом
var lastUpdate = new Date("01/01/1900");

// Билет пользователя
var ticket;
var name;
function validateUser(){
	var txtLog = document.getElementById("txtLogin");
	var txtPass = document.getElementById("txtPassword");
	//alert('1');
// Проверка заполнения элементов
	if (txtLog.value == "" || txtPass.value == "")
	{
		alert("Заполните все поля!");
		return;
	}


	var user = new UserInfo('', txtLog.value, txtPass.value);
	// Сериализация в JSON
	var jsonData = JSON.stringify(user);
	//console.log(jsonData);
	// Передача данных
	var req = getXmlHttpRequest();
	req.open("POST", "./../user_auth.php", true);
	req.onreadystatechange = function()
	{
		if (req.readyState != 4) return;
		//console.log(req.responseText);
		ticket = JSON.parse(req.responseText);
			//console.log(tiket);
		if (!ticket.valid){
			alert('Неверные логин/пароль!');
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

function getOnlineUser(){
	if(ticket){
		//alert(1);
		var jsonData2 = JSON.stringify(ticket);
	}		
	else if(sessionStorage.ticket) jsonData2 = sessionStorage.getItem('ticket');
	else return;
	console.log(jsonData2);
	var req = getXmlHttpRequest();
	req.onreadystatechange = function()
		{
			if (req.readyState != 4) return;
			console.log(req.responseText);
			getOnlineUser.users = JSON.parse(req.responseText);
			
			/*
			//add option for select user to send message
			sel = document.getElementById("recipients");
			// delete old records
			while (sel.hasChildNodes()) sel.removeChild(sel.lastChild);
			var opt = createNewElement("option", "All");
			opt.setAttribute("value", '0');
			
			sel.appendChild(opt);
			*/

			var divUs = document.getElementById("divUsers");
			
				// Удаление старых записей
			while (divUs.hasChildNodes()) divUs.removeChild(divUs.lastChild);
			for (var i = 0; i < getOnlineUser.users.length; i++)
			{

				var user = document.createElement('div');
				user.setAttribute('class', 'user');
				if(getOnlineUser.users[i].path && getOnlineUser.users[i].fName)
					user.innerHTML = "<div class='user-col-left'><a href='#'><span class='img-inner'><img src='"
						 + getOnlineUser.users[i].path + "/" 
						 + getOnlineUser.users[i].fName + "' alt='user' class='img-circle img-responsive'></span></a></div>";
				else 
					user.innerHTML = "<div class='user-col-left'><a href='#'><span class='img-inner'><img src='"
						 + "img/thumb_170_170_c_noimg.png"  + "' alt='user' class='img-circle img-responsive'></span></a></div>";

				var divUserName = document.createElement('div');
				divUserName.setAttribute('class', 'user-col-right');
				
				var aAuthor = createNewElement("a", getOnlineUser.users[i].login);
				aAuthor.setAttribute('class', 'user-name');
				aLichka = createNewElement("a", 'Написать в личку');
				aLichka.setAttribute('class', 'message-to-user');
				divUserName.appendChild(aAuthor);
				divUserName.appendChild(aLichka);
				//console.log(divUserName);
				user.appendChild(divUserName);
				
				divUs.appendChild(user);
			}
			checkUpdates();
			checkTimer2 = window.setTimeout("getOnlineUser()", checkInterval2);
		}
	req.open("POST", "./../get_online_users.php", true);
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

function addRecord()
{
	// Элементы управления
	var txtMessage = document.getElementById("txtMessage");
	//var selectedUser = document.getElementById("recipients");
	//select value of selected option
//	console.log(selectedUser.options[selectedUser.selectedIndex].value);

	
	// Проверка заполнения элементов
	if (txtMessage.value == "")
	{
		alert("You must write a message!");
		return;
	}
	ticket = JSON.parse(sessionStorage.getItem('ticket'));
	// Создание объъекта записи
	var record = new Record(ticket.id, txtMessage.value, 0 /*selectedUser.options[selectedUser.selectedIndex].value*/, 0);

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
	reqChat.open("POST", "./../addrecord.php", true);
	reqChat.setRequestHeader("Content-Type", "text/plain");
//	reqChat.setRequestHeader("Content-Length", jsonData.length);			
	reqChat.send(jsonData);				
}

function getLastModified()
{
	// Выполним запрос HEAD к скрипту ...
	var reqChat = getXmlHttpRequest();
	var date;
	reqChat.open("HEAD", "./../getlastmsgs.php", false);
	reqChat.onload = function(e) {
		if (this.readyState == 4) {
			date = new Date(reqChat.getResponseHeader("Last-Modified"));
			}		
		};
	reqChat.send(null);
	
	// Создадим объект Date на основе ответа Last-Modified
	return date;
}



function checkUpdates()
{
	var lastModified = getLastModified();
	//var selectedUser = document.getElementById("recipients");
//	console.log(selectedUser.options[selectedUser.selectedIndex]); 
//	console.log(lastModified);
//	console.log(lastUpdate);
	if (lastUpdate < lastModified)
	{
		// Запрос новых данных из чата
		var reqChat = getXmlHttpRequest();
		if(sessionStorage.getItem('ticket')){
			ticket = JSON.parse(sessionStorage.getItem('ticket'));
			/*
			if (selectedUser.options[selectedUser.selectedIndex]){
				var jsonDataRec = JSON.stringify({from:ticket.id, to:selectedUser.options[selectedUser.selectedIndex].getAttribute("value")});
			}else {
				
			}
			*/
			var jsonDataRec = JSON.stringify(ticket.id);

			//console.log(jsonDataRec);
			reqChat.open("POST", "./../getlastmsgs.php", true);
			reqChat.send(jsonDataRec);
		}
		

		
		reqChat.onreadystatechange = function()
		{
			if (reqChat.readyState != 4) return;
			if(reqChat.responseText)
				var records = JSON.parse(reqChat.responseText);
			//console.log(records);

			// Элемент для отображения
			var divResult = document.getElementById("divResult");
			// Удаление старых записей
			while (divResult.hasChildNodes()) divResult.removeChild(divResult.lastChild);
			// Отображение записей чата
			for (var i = 0; i < records.length; i++)
			{

				
				// Элемент для размещения записи
				var divRecord = document.createElement("div");
				divRecord.className = "chat-inner";
				var divRecordRow = document.createElement("div");
				divRecordRow.className = "chat-item row";
				var divUserPhoto = document.createElement("div");
				divUserPhoto.className = "chat-user";
				if (records[i].path && records[i].filename)
					divUserPhoto.innerHTML = "<a href='#'><span class='img-inner'><img src='"
									+ records[i].path + "/" 
									+ records[i].filename + "' alt='user' class='img-circle img-responsive'></span></a>";
				else
					divUserPhoto.innerHTML = "<a href='#'><span class='img-inner'><img src='"
									+ "img/thumb_170_170_c_noimg.png"  + "' alt='user' class='img-circle img-responsive'></span></a>";			
				divRecordRow.appendChild(divUserPhoto);
				
				divResult.appendChild(divRecord);

				//div-container for message
				var divMessage = document.createElement("div");
				divMessage.className = "chat-message";
				var divMessInfo = document.createElement("div");
				divMessInfo.className = "chat-message-info";
				// Ссылка на автора 
				var aAuthor = createNewElement("a", records[i].author);
				aAuthor.className = "user-name";
				divMessInfo.appendChild(aAuthor);

				//message date 
				var spanDateContainer = document.createElement("span");
				spanDateContainer.className = "pull-right";
				spanDateContainer.innerHTML = "<a href='#'><i class='fa fa-exclamation-circle' aria-hidden='true'></i></a>";
				var spanMessData = createNewElement("span", records[i].date);
				spanMessData.className = "data";

				spanDateContainer.insertBefore(spanMessData, spanDateContainer.firstChild);
				
				divMessInfo.appendChild(spanDateContainer);
				divMessage.appendChild(divMessInfo);
				// Текст сообщения
				var pMessage = createNewElement("p", records[i].message);
				divMessage.appendChild(pMessage);

				//comments
				var divCommentsContainer = document.createElement("div");
				divCommentsContainer.className = "chat-reply row";
				var divRightBlock = document.createElement("div");
				divRightBlock.className = "pull-right";
				divRightBlock.innerHTML = "<a href='#' class='reply'><span><i class='fa fa-reply' aria-hidden='true'></i></span></a><a href='#' class='commenting'><span><i class='fa fa-commenting' aria-hidden='true'></i></span></a>";


				divCommentsContainer.appendChild(divRightBlock);
				divMessage.appendChild(divCommentsContainer);
				divRecordRow.appendChild(divMessage);
				divRecord.appendChild(divRecordRow);
				//divRecord.insertBefore(divRecordRow, divRecord.firstChild);
				// Время  последнего отображения 
				lastUpdate = lastModified;
				
			}
		}
		
		
	}
	// Таймер на следующую проверку
	checkTimer = window.setTimeout("checkUpdates()", checkInterval);
}

window.onload = function()
{
	/*
	if(!sessionStorage.getItem('select')){
		document.getElementById("recipients").addEventListener('change', function (){
			var selectedUser = document.getElementById("recipients");
			sessionStorage.setItem('select', selectedUser.options[selectedUser.selectedIndex].value);
//			console.log(selectedUser.options[selectedUser.selectedIndex].value);
		});
	}
	*/
	getOnlineUser();
		
	//getPushMessage();
};

// Создание элемента с тектом
function createNewElement(tag, text)
{
	var element = document.createElement(tag);
	var elementText = document.createTextNode(text);
	element.appendChild(elementText);
	return element;
}


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