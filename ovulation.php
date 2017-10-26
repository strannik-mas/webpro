<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ovulation</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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

} ) );
        </script>
        <script>
            $(function(){
                $('#datepicker').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd.mm.yy"
                }); 
                if(localStorage.getItem('dates'))
                    drawTable();
                $('#ov_f1').on('submit',function(){
                   var parameters = $('#datepicker').val() + ',' + $('input[name=cycle]').val() + ',' + $('input[name=menstr]').val();
                    var func = $('input[name=func]').val();
                    localStorage.setItem('params', parameters);
                    newrequest(func, null, parameters);
                });
            });
            function newrequest(func,toupdate,params){             
                $.ajax({
                    type : "GET",
                    url : "func_analizator.php?func=" + func + "&params=" + params,
                    success : function(html) {
                        localStorage.setItem('dates', html);
                        drawTable();
                    },
                    error : function(html){
                        alert('error!');
            //            $(toupdate).html(html);
                        console.log(html);
                    }
                });
            }
            function highlightOvulDays(date) {
                var objDates = JSON.parse(localStorage.getItem('dates'));
                var ovulArr = []; 
                var menstrArr = []; 
                var fertrArr = []; 
                for(var i=0; i<objDates.ovul.length; i++){
                    ovulArr.push(new Date(objDates.ovul[i]).toDateString());
                }
                for(var i=0; i<objDates.menstr.length; i++){
                    menstrArr.push(new Date(objDates.menstr[i]).toDateString());
                }
                for(var i=0; i<objDates.fert.length; i++){
                    fertrArr.push(new Date(objDates.fert[i]).toDateString());
                }
                if(ovulArr.indexOf(date.toDateString())>=0){
                    return [true, 'ov_d'];
                }else if (menstrArr.indexOf(date.toDateString())>=0) {
                    return [true, 'menstr_d'];
                }else if (fertrArr.indexOf(date.toDateString())>=0) {
                    return [true, 'fert_d'];
                }else
                {
                    return[true, ""];                                
                }
            }
            function drawTable(){
                var objDates = JSON.parse(localStorage.getItem('dates'));
                var defDay = new Date(objDates.def);
                $htmlStr = '<caption><h3>Мой календарь овуляции</h3></caption><tr><td rowspan="3"><a id="go_back"><span class="glyphicon glyphicon-chevron-left"></span></a></td><td>Выбрать месяц</td><td><input type="text" name="month" id="datepicker_month"></td><td rowspan="3"><a id="go_forward"><span class="glyphicon glyphicon-chevron-right"></span></a></td></tr><tr><td><div id="datepicker2"></div></td><td><div id="datepicker3"></div></td></tr><tr><td><div id="datepicker4"></div></td><td><div id="datepicker5"></div></td></tr>';
                $('#ovul_t1').html($htmlStr);
                $('#datepicker_month').datepicker({
                    inline:true,
                    defaultDate: new Date(objDates.def),
                    dateFormat: "mm-yy"
                }).on('change',function(){
                    newrequest("getDatesArray",null,localStorage.getItem("params")+","+"01-"+this.value);
                });
                $('#datepicker2').datepicker({
                    inline:true,
                    defaultDate: defDay,
                    beforeShowDay:highlightOvulDays
                });
                $('#datepicker_month').val(defDay.toLocaleDateString("ru",{month:'long', year:'numeric'}));
                $('#go_forward').on('click', function(){
                    var tempD = new Date(objDates.def);
                    tempD.setMonth(tempD.getMonth()+2);
                    newrequest("getDatesArray",null,localStorage.getItem("params")+","+"01-"+tempD.getMonth()+"-"+tempD.getFullYear());
                });
                $('#go_back').on('click', function(){
                    var tempD = new Date(objDates.def);
                    newrequest("getDatesArray",null,localStorage.getItem("params")+","+"01-"+tempD.getMonth()+"-"+tempD.getFullYear());
                });
                defDay.setMonth(defDay.getMonth()+1);
                $('#datepicker3').datepicker({
                    inline:true,
                    defaultDate: defDay,
                    beforeShowDay:highlightOvulDays
                });
                defDay.setMonth(defDay.getMonth()+1);
                $('#datepicker4').datepicker({
                    inline:true,
                    defaultDate: defDay,
                    beforeShowDay:highlightOvulDays
                });
                defDay.setMonth(defDay.getMonth()+1);
                $('#datepicker5').datepicker({
                    inline:true,
                    defaultDate: defDay,
                    beforeShowDay:highlightOvulDays
                });
                $htmlStr2 = '<table cellpadding="2"><tr><td class="ov_d" width=25 height=25></td><td>дни овуляции</td><td class="fert_d" width=25 height=25></td><td>фертильные дни</td><td class="menstr_d" width=25 height=25></td><td>дни менструации</td></tr></table><br><br><button onclick="">Сохранить</button><button onclick="localStorage.removeItem(\'dates\'); location.reload()">Рассчитать заново</button>';
                $('#container').html($htmlStr2);
            }
        </script>
        <style>
            .ov_d a.ui-state-default, .ov_d {
                color:#fff;
                background-color: green;
            }
            .menstr_d a.ui-state-default, .menstr_d {
                color:#fff;
                background-color: red;
            }
            .fert_d a.ui-state-default, .fert_d {
                color:#fff;
                background-color: grey;
            }
            a.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover {
                border: 1px solid #c5c5c5;
                background: #f6f6f6;
                font-weight: normal;
                color: #454545;
            }
        </style>
    </head>
    <body>
        <h1>Календарь овуляции</h1>
        <!--проверял тут:-->
        <!--http://ovulyaciyatut.ru/rasschitat/rasschitat-ovulyatsiyu-kalkulyator.html-->
        <p>Как выяснить благоприятный день для зачатия? Воспользуйтесь календарем овуляции. Укажите дату последней менструации, ее продолжительность и общую длительность цикла. В вашем персональном календаре овуляции будут отмечены фертильные дни, в которые вероятность зачатия достаточно высока, а также дни овуляции, когда вероятность зачатия максимальна.</p>
        <table cellspacing="1" cellpadding="2" id="ovul_t1">
            <form id="ov_f1" onsubmit="return false">
                    <caption><h3>Рассчитать овуляцию</h3></caption>
                    <input type="hidden" name="func" value="getDatesArray">
                    <tbody>
                        <tr>
                            <td colspan="2">Выберите дату начала последней менструации:</td>
                            <td colspan="2"><input type="text" name="men_d" id="datepicker" required></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Длительность цикла:</td>
                            <td><input type="number" name="cycle" min="21" max="35" required></td>
                            <td>Продолжительность менструации:</td>
                            <td><input type="number" name="menstr" min="3" max="7"></td>
                            <td><input type="submit" value="Рассчитать"></td>
                        </tr>
                    </tbody>
            </form>
        </table>
        <div id="container"></div>
    </body>
</html>