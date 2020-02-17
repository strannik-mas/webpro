$(function(){
	/**
	 * Fill the form
	 * 
	 * @var array parameters	Array for send parameters from form
	 * @var int sortDest		Destination of sortig
	 */
    var parameters = [];
	var sortDest = 1;
    newrequest('getSelectionColums', $('#alltable_select'), "Select tables");
	
	//sortable table rows
	//$('#t1').sortable().disableSelection();
	
	//validation Column name
	$("#f1").validate(
		{
//				debug: true,
		rules: {
			col_name:{
				required: true,
				alphanumeric: true
			}
		},				
		messages: {
			col_name:{
				required: "Field required!",
				alphanumeric: "Format is not valid!"
			}				
		},
		invalidHandler: function(event, validator) {
			var errors = validator.numberOfInvalids();
			if(errors) {
				//ничего не даёт
//					event.preventDefault();
//					onsubmit: false;
				//console.dir(event.target);
				//event.target.onsubmit = false;
				alert('Form is not filled correctly!');
			}
		},
		submitHandler: function(){
			//console.log('tut');
			if ($($('#f1 div.nice-select span.current')[0]).text() != 'Select type of field'){
			//console.log($('#decimal').val());
			parameters = $('#col_name').val() + "," 
			+ $($('#tableSelect div.nice-select span.current')[0]).text() + "," 
			+ $($('#f1 div.nice-select span.current')[0]).text() + "," 
			+ $('#length').val() + "," + $('#decimal').val();

			//console.dir($(this));
			newrequest('insertColumn', $('#t1'), parameters);
			}else {
				$('#type').css('border', '4px double red');
				alert('Select type!');
			}
		}
	});
	
		$("#f3").validate({
			rules: {
				searchable:{
					required: true,
					alphanumeric: true
				}
			},				
			messages: {
				searchable:{
					required: "Field required!",
					alphanumeric: "Format is not valid! Only alphanumeric"
				}				
			},
			submitHandler: function(){
				//search field
//				console.log($('#search_col option:selected').text());
				//console.log($($('#f3 div.nice-select span.current')[0]).text());
				/*
				parameters = $('#searchable').val() + "," 
				+ $($('#tableSelect div.nice-select span.current')[0]).text() + "," 
				+ $($('#f3 div.nice-select span.current')[0]).text() +",true";
				*/
				var tableparams = null + "," + $($('#tableSelect div.nice-select span.current')[0]).text() + ",";
				parameters = $($('#f3 div.nice-select span.current')[0]).text() + ","  
				+ $('#searchable').val();
//				console.log(parameters);
				sessionStorage.setItem('search',parameters);
				sessionStorage.removeItem('currentPage');
				if(sessionStorage.getItem('sort'))
					parameters += "," + sessionStorage.getItem('sort');
				newrequest('getAllTable', $('#t1'), tableparams + parameters);
			}
		});
		
		$('#but3').on('click', function(event){
			event.preventDefault();					
			newrequest('insertRow', $('#t1'), 'gettable' + "," 
				+ $($('#tableSelect div.nice-select span.current')[0]).text());
		});
		
		$('#but4').on('click', function(){
			event.preventDefault();

			$('#t1 tr td input[type=checkbox]').each(function(index, element){
				if($(element).is(":checked")){
					//console.log($(this).attr('class').split(' ')[2]);
					newrequest('deleteRow', $('#t1'), $(this).attr('class').split(' ')[1]  + ","
						+ $($('#tableSelect div.nice-select span.current')[0]).text() + ","
						+ $(this).attr('class').split(' ')[2]);
				}
			});
			
//			alert('Select row to delete');
//			$('#t1 tr').hover(function (){
//				toggleCSS($(this), 'yellow', 'bold');
//				$(this).on('click', function (){
////					console.log($(this).attr('class').split('_')[1]);
//					newrequest('deleteRow', $('#t1'), $(this).attr('class').split('_')[1]);
//				});
//			}, function (){
//				toggleCSS($(this), '#fff', 'normal');
//			});
		});
		
		
		$("#t1").on('click', function(event){
			var element = $(event.target);
//			console.log(element);
			//delete row by link
			if(element.is('A') ){
//				console.dir(element.previousElementSibling);
				newrequest('deleteRow', $('#t1'), element.attr('class').split(' ')[1] + ","
							+ $($('#tableSelect div.nice-select span.current')[0]).text() + ","
							+ element.attr('class').split(' ')[2]);
				return false;
			}
			//for sorting
			if((element.is('SPAN') && (element.prop('class') == 'ar_up' || element.prop('class') == 'ar_down')))
				element = element.parent();
			//console.dir(element.parent());
//			event.preventDefault();
//			return false;
			if (element.is('INPUT') && element.prop('id') == 'select_all'){
				var checkBoxes = $("input.del");
//				console.log(checkBoxes);
				checkBoxes.prop("checked", !checkBoxes.prop("checked"));
			}else if((element.is('TH') && element.prop('class') == 'headtable')){
				//sorting on click on column name or arrow
//				console.log(element.parent('TH').text());
				$text = element.text().replace(element.children().text(), '');
//				$text = element.text().slice(0, element.text().length - 2);
				console.log($text);	
				//second parameter: true - ASC; false - DESC
				if(sessionStorage.getItem('search'))
					var tableparams = null + "," + $($('#tableSelect div.nice-select span.current')[0]).text() + "," + sessionStorage.getItem('search') + ",";
				else var tableparams = null + "," + $($('#tableSelect div.nice-select span.current')[0]).text() + "," + null  + "," + null + ",";
				parameters = $text + "," + (sortDest%2);
				sessionStorage.setItem('sort',parameters);
				sessionStorage.removeItem('currentPage');
				//console.log(parameters);
				newrequest('getAllTable', $('#t1'), tableparams + parameters);
				//if()
				++sortDest;
			}
		});
		
		$.validator.addMethod(
			"regex",
			function(value, element, regexp) {
				var re = new RegExp(regexp);
				return this.optional(element) || re.test(value);
			},
			"Please check your input."
		);

		//validate varchar input
		jQuery.validator.addClassRules("VARCHAR", {
//			required: true,
			minlength: 1,
			maxlength: 255,
			//alphanumeric: true
		});
		
		//validate textarea
		jQuery.validator.addClassRules("TEXT", {
			required: true,
			minlength: 10,
			maxlength: 5000
		});
		
		//validate int input
		jQuery.validator.addClassRules("INT", {
//			required: true,
			minlength: 1,
			maxlength: 11,
			digits: true
		});
		
		//validate decimal input
		jQuery.validator.addClassRules("DECIMAL", {
//			required: true,
			regex: /^[1-9]\d{1,10}(\.\d{1,4})?$/
		});

			
    $('#f1').on('submit', function(){
		return false;		
    });


    $('#f2').on('submit', function(){
        parameters = $($('#f2 div.nice-select span.current')[0]).text() + ","
        			+ $($('#tableSelect div.nice-select span.current')[0]).text();
        newrequest('deleteColumn', $('#t1'), parameters);
	    //console.log(parameters);
        return false;
    });
    
	$("#t1").on('dblclick', function(event){
		var target = $(event.target);
		
		if (target.is('INPUT') || target.is('TEXTAREA')){
			target.removeAttr('disabled');
			target.focus();
			
			
			
			console.dir(target.prop('className'));
			//name of current column
			var p = target.prop('className').split(" ");
			var field = p[1];
			
			//id of current string
			var id = p[2];
			//console.log(id);
			var fieldType = p[3];
			//имя ключевого столбца таблицы
			var keyFieldName = p[4];
		}
		var str = '';
		target.bind({keypress: function(eventObject){
//			console.log(target.attr("class").indexOf("error"));
			if (target.attr("class").indexOf("error") ==  -1){
				if(eventObject.which == 13){
					updateCell([target.val(), $($('#tableSelect div.nice-select span.current')[0]).text(), 
						field, id, keyFieldName]);
					
					//unset submit on enter 
					eventObject.preventDefault();
					return false;
				}
				else {				
					str = str + eventObject.key;
//					console.log(eventObject);
				}
			}
		},
		blur: function (){
			if (target.attr("class").indexOf("error") ==  -1)
				updateCell([target.val(), 
					$($('#tableSelect div.nice-select span.current')[0]).text(), 
					field, id, keyFieldName]);
		}
				//
			//console.dir(eventObject);
		});
	});	
	
	//add constraints
	//console.dir($('#length'));
	$('#type').on('change', function(){
		$('#type').css('border', '1px solid grey');
		//console.log($('#type option:selected').val());
		switch ($($('#f1 div.nice-select span.current')[0]).text()){
			case "VARCHAR":
				$('.fr').each(function(index, element){
					if ($(element).css('display') != 'none')
						toggleObject($(element), true);
				});
				$('#length').prop('min', 1);
				$('#length').prop('max', 255); break;
			case "INT":
				$('.fr').each(function(index, element){
					if ($(element).css('display') != 'none')
						toggleObject($(element), true);
				});
				$('#length').prop('min', 1);
				$('#length').prop('max', 11); break;
			case "DECIMAL":
				$('#length').prop('min', 1);
				$('#length').prop('max', 11); 
				$('.fr').each(function(index, element){
					toggleObject($(element), true);
				});
				$('#decimal').prop('min', 1);
				$('#decimal').prop('max', 4);
				
				$('#decimal').prop('required', true);
				break;	
			case "TEXT":
				$('.fr').each(function(index, element){
					if ($(element).css('display') != 'none')
						toggleObject($(element), true);
				});
				$('#length').prop('min', 10);
				$('#length').prop('max', 5000); break;
			default :
				$('.fr').each(function(index, element){
					if ($(element).css('display') != 'none')
						toggleObject($(element), true);
				});
		}
	});

	$('#alltable_select').on('change', function(){
		if ($($('#tableSelect div.nice-select span.current')[0]).text() != 'Select tables'){
			sessionStorage.removeItem('sort');
			sessionStorage.removeItem('search');
			sessionStorage.removeItem('currentPage');
			toggleCSS($('#tableSelect'), "#ccc", 'normal');
    		newrequest('getSelectionColums', $('#del_col'), "names," + $($('#tableSelect div.nice-select span.current')[0]).text());
			newrequest('getSelectionColums', $('#search_col'), 'All,' + $($('#tableSelect div.nice-select span.current')[0]).text());
			newrequest('getAllTable', $('#t1'), 'gettable,' + $($('#tableSelect div.nice-select span.current')[0]).text());
			//console.log($($('#tableSelect div.nice-select span.current')[0]).text());
		}else{
			alert('Select some table!')
			$('#t1').html('');
			toggleCSS($('#tableSelect'), "#fa33ab", 'bold');
		}		
	});

	$('#pagespaginationform').on('submit', function(){
		getPagination();
		return false;		
    });
});

function getPagination(){
	//for pagination
	if($('#pagination').css('display') == 'none')
		$('#pagination').css('display', 'block');
	//while ($('#numpages').has('li')) $('#numpages').remove('li');
	$('#numpages').html('');
	$('table.paginated').each(function() {
	    var currentPage = sessionStorage.getItem('currentPage') ? sessionStorage.getItem('currentPage') : 0;
	    //alert(currentPage);
	    var numPerPage = $('#nuberitemsforpages').val();
	    //alert(numPerPage);
	    var $table = $(this);
	    $table.bind('repaginate', function() {
	        $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
	    });
	    $table.trigger('repaginate');
	    //console.log($table.find('tbody tr').length);
	    if($table.find('tbody tr').length){
	    	var numRows = $table.find('tbody tr').length;
		    var numPages = Math.ceil(numRows / numPerPage);
		    //var $pager = $('<div class="pager"></div>');
		    var $pager = $('<li class="pager"></li>');

		    for (var page = 0; page < numPages; page++) {
	    		
	    		//first
	    		if(page == 0){
	    			$('<a class="prevnext"></a>').text('« Туда').bind('click', 
			        	{newPage: page}, 
			        	function(event) {
				            currentPage = event.data['newPage'];
				            sessionStorage.setItem('currentPage', currentPage);
				            $table.trigger('repaginate');
				            $(this).siblings().removeClass('active');
				            $('#numpages').find('a.page-number:first').addClass('active');
				            return false;
				    }).appendTo($pager).addClass('clickable');
				    $pager.appendTo($('#numpages')).find('a.page-number:first').addClass('active');
	    		}
				
		        $('<a class="prevnext page-number"></a>').text(page + 1).bind('click', 
		        	{newPage: page}, 
		        	function(event) {
			            currentPage = event.data['newPage'];
			            sessionStorage.setItem('currentPage', currentPage);
			            $table.trigger('repaginate');
			            $(this).addClass('active').siblings().removeClass('active');
			            //return false;
			    }).appendTo($pager).addClass('clickable');
	    		
		    }
		    $pager.appendTo($('#numpages'));
		    //$pager.appendTo($('#numpages')).find('a.page-number:first').addClass('active');
		    $($('a.page-number')[currentPage]).addClass('active');
			//last
		    $('<a class="prevnext"></a>').text('Сюда »').bind('click', 
	        	{newPage: numPages-1}, 
	        	function(event) {
		            currentPage = event.data['newPage'];
		            sessionStorage.setItem('currentPage', currentPage);
		            $table.trigger('repaginate');
		            $(this).siblings().removeClass('active');
		            $('#numpages').find('a.page-number:last').addClass('active');
		            return false;
		    }).appendTo($pager).addClass('clickable');
		    $pager.appendTo($('#numpages'));
		    
	    }
	    
	});
}    

function updateCell(arr){
	//console.log(arr.toString());
	if(sessionStorage.getItem('search'))
		var params = sessionStorage.getItem('search');
	else var params = null  + "," + null;
	if(sessionStorage.getItem('sort'))
		params += "," + sessionStorage.getItem('sort');
	sessionStorage.removeItem('currentPage');
	newrequest('updateTable', $('#t1'), arr.toString() + "," + params);
}
function toggleObject($obj, flag){
	if ($obj.css('display') == 'none' || flag)
		$obj.toggle();
}
function toggleCSS($obj, $col, $fw){
	$obj.css('background', $col);
	$obj.children('td').css('font-weight', $fw);
}
/*
window.onbeforeunload = function(){
	alert('bye');
	newrequest('deleteView', null, null);
};
*/