// Класс UserInfo
function UserInfo(log, pass)
{
	this.login = log;
	this.password = pass;
}

// Класс Билет сессии
function Ticket(t)
{
	this.access_token = "";
	this.expires_in = 0;
	this.token_type = "";
	this.scope = null;
	this.refresh_token = "";
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
var intervalRefresh;
var checkInterval = 10000;
var checkInterval2 = 20000;



// Дата и время последнего изменения гостевой книги,
// по умолчанию - дата в прошлом
var lastUpdate = new Date("01/01/1900");
/*
// Токен пользователя
var ticket;
function validateUser(){
	var txtLog = document.getElementById("txtLogin");
	var txtPass = document.getElementById("txtPassword");
// Проверка заполнения элементов
	if (txtLog.value == "" || txtPass.value == "")
	{
		alert("Заполните все поля!");
		return;
	}
	var searchString = "grant_type=password&client_id=chat&client_secret=chupakabra&username=" + txtLog.value + "&" + "password=" + txtPass.value;
	sessionStorage.setItem('searchstr', searchString);
	var req = getXmlHttpRequest();
	
	req.onreadystatechange = function()
	{
		if (req.readyState != 4) return;
		console.log(req.responseText);

		ticket = JSON.parse(req.responseText);
			//console.log(tiket);
			
		if (ticket.error){
			alert('Неверные логин/пароль!');
		}else {
			window.setTimeout("refreshSession()", (ticket.expires_in - 10)*1000);
			txtLog.value = "";
			txtPass.value = "";
			$('#enterFormSpan').css('display', 'none');
			$('#divRightProfile').append("<a id='logoutLink' href='' onclick='function(e) {e.preventDefault(); logout(" 
				+ ticket.access_token + ", " + ticket.refresh_token +"); return false;}'>Выйти Х</a>");
			
			sessionStorage.setItem('ticket', req.responseText);
			getOnlineUser();

		}
		
	}

	req.open("POST", "ops/users/OAuth2/tokenController.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.send(searchString);
	
}

function refreshSession(){
	//alert(sessionStorage.login);
	
	var req = getXmlHttpRequest();
	
	req.onreadystatechange = function()
	{
		if (req.readyState != 4) return;
		//console.log(JSON.parse(req.responseText));
		sessionStorage.setItem('ticket', req.responseText);
		newToken = JSON.parse(req.responseText);
			//console.log(tiket);
			
		
		
	}

	req.open("POST", "ops/users/OAuth2/tokenController.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.send(sessionStorage.searchstr);
	
	intervalRefresh = window.setTimeout("refreshSession()", (newToken.expires_in - 10)*1000);
}

function getOnlineUser(){
	//console.log(sessionStorage.ticket);
	if(ticket){
		//alert(1);
		var jsonData2 = JSON.stringify(ticket);
	}		
	else if(sessionStorage.ticket) jsonData2 = sessionStorage.getItem('ticket');
	else return;
	//console.log(jsonData2);
	var req = getXmlHttpRequest();


	req.onreadystatechange = function()
		{
			if (req.readyState != 4) return;
			console.log(req.responseText);
			getOnlineUser.users = JSON.parse(req.responseText);
			
			
			var divUs = document.getElementById("divUsers");
			//console.dir(duvUs);
			if(divUs != null){
				// Удаление старых записей
				while (divUs.hasChildNodes()) divUs.removeChild(divUs.lastChild);
				for (var i = 0; i < getOnlineUser.users.length; i++)
				{

					var user = document.createElement('div');
					user.setAttribute('class', 'user');
					if(getOnlineUser.users[i].path && getOnlineUser.users[i].fName)
						user.innerHTML = "<div class='user-col-left'><a href='#'><span class='img-inner'><img src='"
							 + "ops/chat/" + getOnlineUser.users[i].path + "/" 
							 + getOnlineUser.users[i].fName + "' alt='user' class='img-circle img-responsive'></span></a></div>";
					else 
						user.innerHTML = "<div class='user-col-left'><a href='#'><span class='img-inner'><img src='"
							 + "ops/chat/img/thumb_170_170_c_noimg.png"  + "' alt='user' class='img-circle img-responsive'></span></a></div>";

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
			}
			
			checkUpdates();
			checkTimer2 = window.setTimeout("getOnlineUser()", checkInterval2);
		}
	req.open("POST", "ops/users/get_online_users.php", true);
	req.setRequestHeader("Content-Type", "text/plain");
	
	req.send(jsonData2);	
	
}
*/
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
	var record = new Record(ticket.access_token, txtMessage.value, 0 /*selectedUser.options[selectedUser.selectedIndex].value*/, 0);

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
			txtMessage.value = "";
			checkUpdates();
		}
	reqChat.open("POST", "ops/chat/addrecord.php", true);
	reqChat.setRequestHeader("Content-Type", "text/plain");
//	reqChat.setRequestHeader("Content-Length", jsonData.length);			
	reqChat.send(jsonData);				
}

function getLastModified()
{
	// Выполним запрос HEAD к скрипту ...
	var reqChat = getXmlHttpRequest();
	var date;
	reqChat.open("HEAD", "ops/chat/getlastmsgs.php", false);
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
	var dMess = 5;					//count of messages which appear when user click the link "showMore"
	var beginMess = 10;				//Initial quantity of messages in chat
	//var selectedUser = document.getElementById("recipients");
	//console.log(lastModified);
	//console.log(lastUpdate);
	if (lastUpdate < lastModified)
	{
		//console.log(sessionStorage.getItem('ticket')); 
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
			var jsonDataRec = JSON.stringify(ticket.access_token);

			console.log(jsonDataRec);
			reqChat.open("POST", "ops/chat/getlastmsgs.php", true);
			reqChat.send(jsonDataRec);
		}

		
		reqChat.onreadystatechange = function()
		{
			if (reqChat.readyState != 4) return;
			console.log(reqChat.responseText);
			if(reqChat.responseText)
				lastUpdate = showMessages(reqChat.responseText, beginMess, dMess, true);
		}		
	}
	// Таймер на следующую проверку
	checkTimer = window.setTimeout("checkUpdates()", checkInterval);
}

function showMessages(recJson, c, dm, flag){

	console.log(recJson);
	var records = jQuery.parseJSON(recJson);
	// Элемент для отображения
	var divResult = document.getElementById("divResult");
	if(divResult != null){
		//link for More...
		var aMore = createNewElement("a", 'Показать еще...');
		aMore.setAttribute("onclick", "showMessages(" + JSON.stringify(recJson) + ", " + (c+dm) + ", "	+ dm + ", "	+ false + ")");
		//console.log(records.length);
		// Удаление старых записей
		while (divResult.hasChildNodes()) divResult.removeChild(divResult.lastChild);
		// Отображение записей чата
		for (var i = 0; i < records.length; i++)			
		{

			if(i>=c) {
				$(divResult).prepend($(aMore));
				continue;
			}

			// Элемент для размещения записи
			var divRecord = document.createElement("div");
			divRecord.className = "chat-inner";
			var divRecordRow = document.createElement("div");
			divRecordRow.className = "chat-item row";
			var divUserPhoto = document.createElement("div");
			divUserPhoto.className = "chat-user";
			if (records[i].path && records[i].filename)
				divUserPhoto.innerHTML = "<a href='#'><span class='img-inner'><img src='"
								+ "ops/chat/" + records[i].path + "/" 
								+ records[i].filename + "' alt='user' class='img-circle img-responsive'></span></a>";
			else
				divUserPhoto.innerHTML = "<a href='#'><span class='img-inner'><img src='"
								+ "ops/chat/img/thumb_170_170_c_noimg.png"  + "' alt='user' class='img-circle img-responsive'></span></a>";			
			divRecordRow.appendChild(divUserPhoto);
			
			//divResult.appendChild(divRecord);
			$(divResult).prepend($(divRecord));

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
		}
	}
	
	if(flag){
		$('#scrollbar').mCustomScrollbar("scrollTo","bottom",{
		    scrollEasing:"easeOut"
		});
	}
	
	// Время  последнего отображения 
	return getLastModified();
}

function logout(accessToken, refreshToken){
	var jsonData = JSON.stringify(accessToken, refreshToken);
	alert(jsonData);
	/*
	// Передача данных
	var req = getXmlHttpRequest();
	req.open("POST", "ops/chat/logout.php", true);
	req.onreadystatechange = function()
	{
		if (req.readyState != 4) return;
		//console.log(req.responseText);
		$('#logoutLink').remove();
		$('#enterFormSpan').css('display', 'inline');
		
		var txtLog = document.getElementById("txtLogin");
		var txtPass = document.getElementById("txtPassword");
		txtLog.value = "";
		txtPass.value = "";
	}
	
	req.setRequestHeader("Content-Type", "text/plain");			
	req.send(jsonData);
	*/
}