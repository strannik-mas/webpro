
$(document).ready(function(){
	//autocomplete goods
	var str = '';
	$('#search_input').on('keypress', function (eventObject) {
		if (eventObject.which == 13) {
			//unset submit on enter 
			eventObject.preventDefault();
			return false;
		}
		str = str + eventObject.key;
		if (str.length > 2) {
//			console.log(str);
			parameters = ['cscart_product_descriptions', 'product',$('#search_input').val()];
			newrequest('getProducts', $('#search_input'), parameters);
		}

	});	
	
	
	
	
	//check screen size
	var scrSize = sessionStorage.getItem('clickcount');
//	console.log(scrSize);
	if(scrSize%2){
		$('meta[name=viewport]').prop("content", "width=1440");
		
		$('#desktop').prop('class', 'mobile-button');
	}
	
	
    $(".ty-discussion-post__content").wrap("<div class='ty-discussion-post__inner'></div>");
    $("#category_products_11 .ty-subcategories__item").find(".ty-subcategories-img").wrap("<i class='img-inner'></i>");

    $("<div class='show-more-inner'><button class='show-more'>Смотреть все линии бренда</button></div>").insertAfter('#category_products_11 .subcategories');
    $(".subcategories-lines").append("<div class='show-more-inner'><button class='show-more-categories'>Все подкатегории &rarr;</button></div>");
    $(function(){
        var $i = 0;
        $( ".show-more" ).click(function() {
            if ($i==0) {
                $("#category_products_11").find('.ty-subcategories__item').addClass('block');
                $i = 1;
            }
            else {
                $("#category_products_11").find('.ty-subcategories__item').removeClass('block');
                $i = 0;
            }
        });
    });

     $(function(){
        var $i = 0;
        $( ".show-more-categories" ).click(function() {
            if ($i==0) {
                $(".subcategories-lines").find('.ty-menu__item.cm-menu-item-responsive').addClass('block');
                $i = 1;
            }
            else {
                $(".subcategories-lines").find('.ty-menu__item.cm-menu-item-responsive').removeClass('block');
                $i = 0;
            }
        });
    });
       $(function(){
        var $i = 0;
        $( ".instructions h2").click(function() {
            if ($i==0) {
                $(".instructions-details").addClass('block');
                $i = 1;
            }
            else {
                $(".instructions-details").removeClass('block');
                $i = 0;
            }
        });
        $( ".instruction-button" ).click(function(event) {
        	event.preventDefault();
            if ($i==0) {
            	var id  = $(this).attr('href'),
            	 top = $(id).offset().top;
				$('body,html').animate({scrollTop: top}, 1500);
                $(".instructions-details").addClass('block');
                $i = 1;
            }
            else {
                $(".instructions-details").removeClass('block');
               $i = 0;
            }
        });
    });
      
});

/*$(function(){
	var divs = $('.ty-subheader');
	console.log(divs);
    var arr = divs.each(function (){
    	$(this).html();
       console.log($(this).html());
       
    });
    console.log(arr.html());
    $( ".btn" ).click(function(event) {
     	var x = ($(".btn").val());
     });
 });*/
 
$(document).ready(function(){ 
	$( "h3:contains('A')" ).attr("id","A");
	$( "h3:contains('B')" ).attr("id","B");
	$( "h3:contains('C')" ).attr("id","C");
	$( "h3:contains('D')" ).attr("id","D");
	$( "h3:contains('E')" ).attr("id","E");
	$( "h3:contains('F')" ).attr("id","F");
	$( "h3:contains('G')" ).attr("id","G");
	$( "h3:contains('H')" ).attr("id","H");
	$( "h3:contains('I')" ).attr("id","I");
	$( "h3:contains('J')" ).attr("id","J");
	$( "h3:contains('K')" ).attr("id","K");
	$( "h3:contains('L')" ).attr("id","L");
	$( "h3:contains('M')" ).attr("id","M");
	$( "h3:contains('N')" ).attr("id","N");
	$( "h3:contains('O')" ).attr("id","O");
	$( "h3:contains('P')" ).attr("id","P");
	$( "h3:contains('R')" ).attr("id","R");
	$( "h3:contains('S')" ).attr("id","S");
	$( "h3:contains('U')" ).attr("id","U");
	$( "h3:contains('V')" ).attr("id","V");
	$( "h3:contains('W')" ).attr("id","W");
	$( "h3:contains('X')" ).attr("id","X");
	$( "h3:contains('Y')" ).attr("id","Y");
	$( "h3:contains('Z')" ).attr("id","Z");
	
   $( ".alphabet a" ).click(function(event) {	
        event.preventDefault();
         var id  = $(this).attr('href'),
         top = $(id).offset().top-100;
		$('body,html').animate({scrollTop: top}, 1500);
    });
	
	
	//resize by click
//	var screenFullSizeCount = 0;
	$(".ty-wysiwyg-content p").on('click', function(event){
		target = $(event.target);
		if (target.is('A') && (target.prop('class') == 'desktop' || target.prop('class') == 'mobile-button')){
			
			if(sessionStorage.getItem('clickcount')){
				sessionStorage.clickcount = Number(sessionStorage.clickcount) + 1;
			}else {
				sessionStorage.clickcount = 1;
			}
//			console.log(sessionStorage.clickcount);
//			console.dir(navigator.userAgent);
			$('meta[name=viewport]').prop("content", (sessionStorage.getItem('clickcount') % 2 ? "width=1440" : "width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"));
			target.prop('class', (sessionStorage.getItem('clickcount') % 2 ? 'mobile-button' : 'desktop'));
//			console.log(target.prop('class'));
		
			
//			$('head').children('META').each(function(index, element){
//				if($(element).prop("name") == "viewport"){
//					$(element).prop("content", "width=1440");
//				}
//					
//			});
			
		}
	});
    
});

function newrequest(func, toupdate, params) {
//        console.log(params);
	$.ajax({
		type: "POST",
		url: "getgoods.php",
		data: {
			f: func,
			p: params
		},
		success: function (html) {
			if(func == 'getProducts' && params != null){	
//				alert(1);
//				console.log(html);
				/**/
				try{
					var availableTags = [];
					var obj = JSON.parse(html);
					obj.forEach(function (item) {
						availableTags.push(item.toString());
					});
//				console.log(obj);	
//					console.log(availableTags);
					toupdate.autocomplete({
						minLength: 3,
						source: availableTags
					});
				}catch(e){
					
				}
				
				
			}else {
//				console.log(html);
				$(toupdate).html(html);
			}
		},
		error: function (html) {
//			$(toupdate).html(html);
			console.log(html);
//			console.log('error');
		}
	});
}