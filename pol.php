<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Blood_renew</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script>/* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
/* Written by Andrew Stromnov (stromnov@gmail.com). */
( function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define( [ "../widgets/datepicker" ], factory );
	} else {

		// Browser globals
		factory( jQuery.datepicker );
	}
}( function( datepicker ) {

datepicker.regional.ru = {
	closeText: "Закрыть",
	prevText: "&#x3C;Пред",
	nextText: "След&#x3E;",
	currentText: "Сегодня",
	monthNames: [ "Январь","Февраль","Март","Апрель","Май","Июнь",
	"Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь" ],
	monthNamesShort: [ "Янв","Фев","Мар","Апр","Май","Июн",
	"Июл","Авг","Сен","Окт","Ноя","Дек" ],
	dayNames: [ "воскресенье","понедельник","вторник","среда","четверг","пятница","суббота" ],
	dayNamesShort: [ "вск","пнд","втр","срд","чтв","птн","сбт" ],
	dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ],
	weekHeader: "Нед",
	dateFormat: "dd.mm.yy",
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: "" };
datepicker.setDefaults( datepicker.regional.ru );

return datepicker.regional.ru;

} ) );</script>
        <script>
            $(function(){
                $(".datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd.mm.yy",                    
                    yearRange: "-50:+0",
                    defaultDate: "-25y"
                });
                $("#tabs").tabs({
                    active: localStorage.getItem('tabindex') ? localStorage.getItem('tabindex') : 0
                }).on('click', function(event){
					localStorage.setItem('tabindex', $("#tabs").tabs("option", "active"));
				});
                $('#pol_f1').on('submit', function(){
                   newrequest($('input[name=func]').val(), '#tabs-1', $('input[name=m_b]').val() + ',' + $('input[name=f_b]').val() + ',' + $('input[name=zach]').val())
                });
                $('#pol_f2').on('submit', function(){
                   newrequest($('input[name=func2]').val(), '#tabs-2', $('input[name=m2_b]').val() + ',' + $('input[name=f2_b]').val() + ',' + $('input[name=zach2]').val());
                });
            });
            function newrequest(func, toupdate, params) {
//                console.log(params);               
                $.ajax({
                    type : "GET",
                    url : "func_analizator.php?func=" + func + "&params=" + params,
                    
                    success : function(html) {
//                        console.log(html);
                        $(toupdate).html(html);
                    },
                    error : function(html){
                        alert('error!');
            //            $(toupdate).html(html);
                        console.log(html);
                    }
                });
            }
        </script>
        <style>
            .left, .right, .center {
                height: 500px;
            } 
            .left {
                float: left;
                width: 60px;
            }
            .center {
                float: left;
                margin: 0 65px;
            }
            .right {
                float: right;
                width: 60px;
            }
        </style>
    </head>
    <body>
        <h1>Определение пола ребенка по обновлению крови</h1>
        <p>Считается, что пол ребенка зависит от того, у кого из родителей кровь более «свежая». У мужчин кровь обновляется раз в 4 года, у женщины — раз в 3 года. Так что, если у папы дата последнего обновления крови позже маминой даты, то будет мальчик =). Попробуйте определить пол вашего ребенка по этому методу!</p>
        <p><b>Внимание!</b> Большие кровопотери также приводят к обновлению крови, поэтому при заполнении формы теста, отметьте либо дату последней кровопотери (переливание, сдача крови, операции), либо свой день рождения.</p>
        <div id="tabs" style="min-width: 800px">
            <ul>
				<li><a href="#tabs-1">По дате рождения</a></li>
				<li><a href="#tabs-2">По дате последней кровопотери
</a></li>
			</ul>
            <div id="tabs-1">
                <form id="pol_f1" onsubmit="return false">
                    <input type="hidden" name="func" value="whichPol" />
                    <table cellspacing="1" cellpadding="2" >
                        <tr>
                            <td>Дата рождения мамы</td>
                            <td>Дата рождения папы</td>
                            <td>Дата зачатия</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="m_b" class="datepicker" required></td>
                            <td><input type="text" name="f_b" class="datepicker" required></td>
                            <td><input type="text" name="zach" class="datepicker" required></td>
                            <td><input type="submit" value="Узнать кто родится"></td>
                        </tr>
                    </table>                   
                </form>
            </div>
            <div id="tabs-2">
                <form id="pol_f2" onsubmit="return false">
                    <input type="hidden" name="func2" value="whichPol" />
                    <table cellspacing="1" cellpadding="2" >
                        <tr>
                            <td>Дата последней кровопотери мамы</td>
                            <td>Дата последней кровопотери папы</td>
                            <td>Дата зачатия</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="m2_b" class="datepicker" required></td>
                            <td><input type="text" name="f2_b" class="datepicker" required></td>
                            <td><input type="text" name="zach2" class="datepicker" required></td>
                            <td><input type="submit" value="Узнать кто родится"></td>
                        </tr>
                    </table>                   
                </form>
            </div>
        </div>
    </body>
</html>
