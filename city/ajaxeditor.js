$(function(){
	/**
	 * Fill the form
	 * 
	 * @var array parameters	Array for send parameters from form
	 * @var int sortDest		Destination of sortig
	 */
    var parameters = [];
	var sortDest = 1;
    newrequest('getAllTable', $('#t1'), null);
    newrequest('getSelectionColums', $('#del_col'), null);
	newrequest('getSelectionColums', $('#search_col'), ['All']);
	newrequest('getUsers', $('#fromnotify'), null);
	newrequest('getUsers', $('#tonotify'), null);
	
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
			if ($('#type option:selected').val() != 0){
			//console.log($('#decimal').val());
			parameters = [$('#col_name').val(), $('#type option:selected').val(), $('#length').val(), $('#decimal').val()];

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
				parameters = [$('#searchable').val(), $('#search_col option:selected').text(), true];
//				console.log(parameters);
				newrequest('getAllTable', $('#t1'), parameters);
			}
		});
		
		$('#but3').on('click', function(event){
			event.preventDefault();					
			newrequest('insertRow', $('#t1'), null);
		});
		
		$('#but4').on('click', function(){
			event.preventDefault();
			$('#t1 tr td input[type=checkbox]').each(function(index, element){
				if($(element).is(":checked")){
					newrequest('deleteRow', $('#t1'), $(this).attr('class').split(' ')[1]);
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
		
		/*
		 * function on submit form notifyform
		 */
		$('#notifyform').on('submit', function(){
			parameters = [
						$('#unitselect option:selected').val(),
						$('#typeselect option:selected').val(),
						$('#fromnotify option:selected').val(),
						$('#tonotify option:selected').val(),
						$('#notifyarea').val(),
						$(location).href()
						];
			newrequest('insertNotify', $('#notifyarea'), parameters);
//			console.log(parameters);
		});
		
		$("#t1").on('click', function(event){
			var element = $(event.target);
//			console.log(element);
			//delete row by link
			if(element.is('A') ){
//				console.dir(element.previousElementSibling);
				newrequest('deleteRow', $('#t1'), element.attr('class').split(' ')[1]);
				return false;
			}
			
			if((element.is('SPAN') && (element.prop('id') == 'ar_up' || element.prop('id') == 'ar_down')))
				element = element.parent();
//			console.dir(element.parent());
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
//				console.log($text);	
				//second parameter: true - ASC; false - DESC
				parameters = [$text, (sortDest%2)];
				//console.log(parameters);
				newrequest('getAllTable', $('#t1'), parameters);
				
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
			alphanumeric: true
		});
		
		//validate textarea
		jQuery.validator.addClassRules("TEXT", {
			required: true,
			minlength: 1000,
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
        parameters = [$('#del_col option:selected').val()];
        newrequest('deleteColumn', $('#t1'), parameters);
	    //console.log(parameters);
        return false;
    });
    
	$("#t1").on('dblclick', function(event){
		var target = $(event.target);
		
		if (target.is('INPUT') || target.is('TEXTAREA')){
			target.removeAttr('disabled');
			target.focus();
			
			
			
			//console.dir(target);
			//name of current column
			var p = target.prop('className').split(" ");
			var field = p[1];
			
			//id of current string
			var id = p[2];
			//console.log(id);
			var fieldType = p[3];
		}
		var str = '';
		target.bind({keypress: function(eventObject){
//			console.log(target.attr("class").indexOf("error"));
			if (target.attr("class").indexOf("error") ==  -1){
				if(eventObject.which == 13){
					updateCell([target.val(), field, id]);
					
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
				updateCell([target.val(), field, id]);
		}
				//
			//console.dir(eventObject);
		});
	});
    
	/**
	 * Function async send POST to func.php, where data add/get/delete 
	 * from database
	 * @var string func					Show executable php file
	 * @var jQuery object toupdate		DOM element selected by jQuery
	 * @var array params				Array which send to executable php file
	 */
    function newrequest(func, toupdate, params) {
        console.log(params);
        $.ajax({
            type : "POST",
//            url : "func.php" + func + "&p=" + params, 
			url: "func.php",
			data: {
				f: func,
				p: params
			},
            success : function(html) {
                $(toupdate).html(html);
				console.log(html);
//				alert(html);
				if(func == 'insertColumn' || func == 'deleteColumn')
					newrequest('getSelectionColums', $('#del_col'), null);
            },
            error : function(html){
//                    $(toupdate).html(html);
//					console.log(html);
            }
        });
    }
	
	//add constraints
	//console.dir($('#length'));
	$('#type').on('change', function(){
		$('#type').css('border', '1px solid grey');
		//console.log($('#type option:selected').val());
		switch ($('#type option:selected').val()){
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
				$('#length').prop('min', 1000);
				$('#length').prop('max', 5000); break;
			default :
				$('.fr').each(function(index, element){
					if ($(element).css('display') != 'none')
						toggleObject($(element), true);
				});
		}
	});
	function updateCell(arr){
		newrequest('updateTable', $('#t1'), arr);
	}
	function toggleObject($obj, flag){
		if ($obj.css('display') == 'none' || flag)
			$obj.toggle();
	}
	function toggleCSS($obj, $col, $fw){
		$obj.css('background', $col);
		$obj.children('td').css('font-weight', $fw);
	}
	
});
	
    

