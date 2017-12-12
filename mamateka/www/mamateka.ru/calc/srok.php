<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pregnancy_calendar</title>
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
            $(function (){
                $("#datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true
                }).on('change', function(){
                    if($(this).val())
                        $('input[type=number').prop('disabled', 'disabled');
                    else $('input[type=number').prop('disabled', '');
                });
                $('#srok_f1').on('submit', function(){
                    newrequest($('input[name=func]').val(), '.result', $('#datepicker').val()+','+$('input[name=week]').val()+','+$('input[name=month]').val());
                });
                $('input[type=number').on('input',function(){
                    if($(this).val()>0){
                        $('#datepicker').val('');
                        $('#datepicker').prop('disabled', 'disabled');
                        $t = $(this).val();
                        $('input[type=number').val('');
                        $(this).val($t);
                    }
                    if(!parseInt($('input[name=week]').val()) && !parseInt($('input[name=month]').val())){
                        $('#datepicker').prop('disabled', '');
                    }
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
    </head>
    <body>
        <h1>Акушерский срок беременности</h1>
        <form id="srok_f1" onsubmit="return false">
            <input type="hidden" name="func" value="getSrok" />
            <fieldset>
                <legend>Расчет срока</legend>
                <label for="datepicker">Укажите первый день последней менструации</label>
                <input type="text" name="ovul" id="datepicker">
            </fieldset>
            <fieldset>
                <legend>Расчет недели и месяца</legend>
                <table>
                    <caption>Укажите количество недель или месяцев</caption>
                    <tr>
                        <td>
                            <input type="number" name="week" min="0" max="44" />
                        </td>
                        <td>&hArr;</td>
                        <td>
                            <input type="number" name="month" min="0" max="9" />
                        </td>
                    </tr>
                    <tr><td>Неделя</td><td></td><td>Месяц</td></tr>
                </table>
            </fieldset>
            <input type="submit" value="Рассчитать" />
        </form>
        <table class="result"></table>
    </body>
</html>
