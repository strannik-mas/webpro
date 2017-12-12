/**ajax get function
 *вторым параметром при обращении к таблицам должно быть имя таблицы
 *в html приходит либо html-сниппет либо сообщение
 */
function newrequest(func, toupdate, params) {
	$.ajax({
		type : "GET",
		url : "common/ajax.php?func=" + func + "&params=" + params,
		success : function(html) {
			if (func == 'addOrUpdateUser' || func == 'deleteView') {
			} else if (func == 'getAllLabels' || func == 'addGoogleMapLabel') {
				if (params == 'All' || (params != 'AllDiv' && params.indexOf('AllDiv')) < 0)
					showAllMapLabels(html);
				else
					showAllDivs(html);
			} else if (func == 'getSelectionColums') {
				//$('#marker_types div.nice-select ul.list')[0].html('');
				$(toupdate).html('');
				$(toupdate).html(html);
				if (params.indexOf("names") >= 0) {
					spanElement = $('#f2 div.nice-select span.current')[0];
					ulElement = $('#f2 div.nice-select ul.list')[0];
				} else if (params.indexOf("All") >= 0) {
					spanElement = $('#f3 div.nice-select span.current')[0];
					ulElement = $('#f3 div.nice-select ul.list')[0];
				} else if (params == 'Тип,marker_types') {
					spanElement = $('#marker_types div.nice-select span.current')[0];
					ulElement = $('#marker_types div.nice-select ul.list')[0];
				} else if (params == "Select tables") {
					spanElement = $('#tableSelect div.nice-select span.current')[0];
					ulElement = $('#tableSelect div.nice-select ul.list')[0];
				}
				spanElement.innerText = "";
				ulElement.innerHTML = "";
				$(toupdate).children('option').each(function(index, element) {
					if ($(element).is(':selected')) {
						$(spanElement).text($(element).val());
						var liSelected = createNewElement('li', $(element).val());
						$(liSelected).prop('data-value', $(element).val());
						$(liSelected).addClass('option focus selected');
						ulElement.appendChild(liSelected);
					} else {
						var liSelected = createNewElement('li', $(element).val());
						$(liSelected).prop('data-value', $(element).val());
						$(liSelected).addClass('option');
						ulElement.appendChild(liSelected);
					}
				});

			} else if (func == 'getCurrentLabel') {
				showLabelInfo(html);

			}/* else if(func == 'getMiniChat'){
			 minichatInit(html);
			 }*/else if (func == 'showResords') {
				showMessages(html, true);
			} else {

				$(toupdate).html(html);
				if (func == "getAllTable")
					getPagination();

			}
		},
		error : function(html) {
			$(toupdate).html(html);
		}
	});
}

function form_submit(formname, toupdate) {
	$(formname).ajaxSubmit({
		type : "POST",
		url : "common/ajax.php",
		success : function(html) {
//console.log(html);
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