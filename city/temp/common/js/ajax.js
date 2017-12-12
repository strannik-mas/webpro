/**ajax get function
*вторым параметром при обращении к таблицам должно быть имя таблицы
*в html приходит либо html-сниппет либо сообщение
*/
function newrequest(func, toupdate, params) {
//    console.log(params);
//    console.log(params.indexOf('AllDiv'));
    $.ajax({
        type : "GET",
        url : "common/ajax.php?func=" + func + "&params=" + params,
        success : function(html) {
				console.log(html);
            if(func == 'addOrUpdateUser' || func == 'deleteView'){
//				alert(html);
            }else if(func == 'getAllLabels' || func == 'addGoogleMapLabel'){
				if(params == 'All' || (params != 'AllDiv' && params.indexOf('AllDiv')) < 0)
					showAllMapLabels(html);
				else showAllDivs(html);
            }else if(func == 'getSelectionColums'){
                //$('#marker_types div.nice-select ul.list')[0].html('');
                $(toupdate).html('');
                $(toupdate).html(html);
                //console.log($('#marker_types div.nice-select')[0]);
                //console.dir($(toupdate).children('option'));
                if(params.indexOf("names") >= 0){
                    //alert("0");
                    spanElement = $('#f2 div.nice-select span.current')[0];
                    ulElement = $('#f2 div.nice-select ul.list')[0];
                }else if(params.indexOf("All") >= 0){
                    //alert("11");
                    spanElement = $('#f3 div.nice-select span.current')[0];
                    ulElement = $('#f3 div.nice-select ul.list')[0];
                }else if(params == 'Тип,marker_types'){
                    //alert("2");
                    spanElement = $('#marker_types div.nice-select span.current')[0];
                    ulElement = $('#marker_types div.nice-select ul.list')[0];
                }else if(params == "Select tables"){
                    //alert("1");
                    spanElement = $('#tableSelect div.nice-select span.current')[0];
                    ulElement = $('#tableSelect div.nice-select ul.list')[0];
                }
                spanElement.innerText = "";
                ulElement.innerHTML = "";
//				console.log(ulElement);
                $(toupdate).children('option').each(function(index, element){
                    //console.log($(element).val());
                    if($(element).is(':selected')){
                        //console.dir(spanElement);
                        $(spanElement).text($(element).val());
                        //var spanCur = createNewElement('span', $(element).val());
                        var liSelected = createNewElement('li', $(element).val());
                        $(liSelected).prop('data-value', $(element).val());
                        $(liSelected).addClass('option focus selected');
//                        alert("22");
                        //добавить класс и свойство
                        //$('#marker_types div.nice-select')[0].append(spanCur);
                        ulElement.appendChild(liSelected);
                    }else{
                        var liSelected = createNewElement('li', $(element).val());
                        $(liSelected).prop('data-value', $(element).val());
                        $(liSelected).addClass('option');
                        ulElement.appendChild(liSelected);
                    }
                });
                
            }else if(func == 'getCurrentLabel'){
				console.log(html);
				showLabelInfo(html);
				
			}/*else if(func == 'getMiniChat'){
				minichatInit(html);
			}*/else if(func == 'showResords'){
				showMessages(html, true);
			}else{

                 $(toupdate).html(html);
                 //alert (sessionStorage.getItem('currentPage'));
                 if(func == "getAllTable") getPagination();

            }			
        },
        error : function(html){
			alert('error!');
                    $(toupdate).html(html);
//					console.log(html);
        }
    });
}

function form_submit(formname, toupdate) {
    $(formname).ajaxSubmit({
        type : "POST",
        url : "common/ajax.php",
        success : function(html) {
		$(toupdate).html(html);
        }
    });
}
function form_submit_append(formname, toupdate) {
    $(formname).ajaxSubmit({
    type : "POST",
    url : "common/ajax.php",
    success : function(html) {
	$(toupdate).append(html);
    }
 });
}
function ajaxinclude(page, toupdate, params) {
    $.ajax({
    type : "GET",
    url : page + "?" + params,
    success : function(html) {
        $(toupdate).html(html);
    }
 });
}