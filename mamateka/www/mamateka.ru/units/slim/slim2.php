<?php

function slim_srok() {
    ?>
    <script>
            /* Russian (UTF-8) initialisation for the jQuery UI date picker plugin. */
            /* Written by Andrew Stromnov (stromnov@gmail.com). */
            (function (factory) {
                if (typeof define === "function" && define.amd) {

                    // AMD. Register as an anonymous module.
                    define(["../widgets/datepicker"], factory);
                } else {

                    // Browser globals
                    factory(jQuery.datepicker);
                }
            }(function (datepicker) {

                datepicker.regional.ru = {
                    closeText: "Закрыть",
                    prevText: "&#x3C;Пред",
                    nextText: "След&#x3E;",
                    currentText: "Сегодня",
                    monthNames: ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"],
                    monthNamesShort: ["Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"],
                    dayNames: ["воскресенье", "понедельник", "вторник", "среда", "четверг", "пятница", "суббота"],
                    dayNamesShort: ["вск", "пнд", "втр", "срд", "чтв", "птн", "сбт"],
                    dayNamesMin: ["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
                    weekHeader: "Нед",
                    dateFormat: "dd.mm.yy",
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ""
                };
                datepicker.setDefaults(datepicker.regional.ru);

                return datepicker.regional.ru;

            }));
    </script>
    <script>
            $(function () {
                $("#datepicker").datepicker({
                    changeMonth: true,
                    changeYear: true
                }).on('change', function () {
                    if ($(this).val())
                        $('input[type=number').prop('disabled', 'disabled');
                    else
                        $('input[type=number').prop('disabled', '');
                });
                $('#srok_f1').on('submit', function () {
                    newrequest($('input[name=func]').val(), '.result', $('#datepicker').val() + ',' + $('input[name=week]').val() + ',' + $('input[name=month]').val());
                });
                $('input[type=number').on('input', function () {
                    if ($(this).val() > 0) {
                        $('#datepicker').val('');
                        $('#datepicker').prop('disabled', 'disabled');
                        $t = $(this).val();
                        $('input[type=number').val('');
                        $(this).val($t);
                    }
                    if (!parseInt($('input[name=week]').val()) && !parseInt($('input[name=month]').val())) {
                        $('#datepicker').prop('disabled', '');
                    }
                });
            });
            function newrequest(func, toupdate, params) {
                //                console.log(params);
                $.ajax({
                    type: "GET",
                    url: "func_analizator.php?func=" + func + "&params=" + params,

                    success: function (html) {
                        //                        console.log(html);
                        $(toupdate).html(html);
                    },
                    error: function (html) {
                        alert('error!');
                        //            $(toupdate).html(html);
                        console.log(html);
                    }
                });
            }
    </script>
    <h1>Акушерский срок беременности</h1>
    <form id="srok_f1" onsubmit="return false">
        <input type="hidden" name="func" value="getSrok" />
        <fieldset>
            <legend>
                Расчет срока
            </legend>
            <label for="datepicker">Укажите первый день последней менструации</label>
            <input type="text" name="ovul" id="datepicker">
        </fieldset>
        <fieldset>
            <legend>
                Расчет недели и месяца
            </legend>
            <table>
                <caption>
                    Укажите количество недель или месяцев
                </caption>
                <tr>
                    <td>
                        <input type="number" name="week" min="0" max="44" />
                    </td>
                    <td>&hArr;</td>
                    <td>
                        <input type="number" name="month" min="0" max="9" />
                    </td>
                </tr>
                <tr>
                    <td>Неделя</td><td></td><td>Месяц</td>
                </tr>
            </table>
        </fieldset>
        <input type="submit" value="Рассчитать" />
    </form>
    <table class="result"></table>
<?php

}
function slim_analizator(){
?>
    <style>
                #t1, #but1 {
                    margin-top: 5px;
                }
                td {
                    padding: 2px;
                }
                thead, tfoot{
                    background-color: #cffecb;
                    color: #1d8620;
                    font-weight: bold;
                    text-align: center;
                }
        </style>


        <script>  
            var totalIndex = 0;
            $(function(){                
                newrequest('addRow', $('#t1 tbody'), $('#t1 tbody tr').length);
                $('#ves').on('input',getCalories);  
                $('#t1').on('click',function(e){
                    var element = $(event.target);
                    if(element.is('SPAN') ){
    //                        console.log(element.attr('class').split(' ')[2]);
                        var clName = '.' + element.attr('class').split(' ')[2];
                        $('tr').remove(clName);
                        getCalories();
                    }
                });
            });
            function newrequest(func, toupdate, params) {
    //                console.log(params);
                var typeReq = (func === 'addRow' || func === 'getSelAct'  ? false : true);
                $.ajax({
                    type : "GET",
                    url : "func_analizator.php?func=" + func + "&params=" + params,
                    async: typeReq,
                    success : function(html) {
    //                        console.log(html);
                        if(func === 'addRow'){
                            $(toupdate).append(html);
                            totalIndex++;
                            addEvents();
                        }else $(toupdate).html(html);
                    },
                    error : function(html) {
                            alert('error!');
                            //            $(toupdate).html(html);
                            console.log(html);
                        }
                    });
                }
                function getCalories() {
                    var totalTime = 0;
                    var totalResult = 0;
                    for (var i = 0; i < $('#t1 tbody tr').length; i++) {
    //                    console.log($($('#t1 tbody tr')[i]).attr('class'));
                        var indexRow = $($('#t1 tbody tr')[i]).attr('class');
                        var time = $('#time_' + indexRow).val();
                        if (time.indexOf('*') != -1) {
                            var arr = time.split('*', 2);
                            time = arr[0] * arr[1];
    //                        console.log(time);
                        }

                        var activity = $('#type2_' + indexRow).val();
                        var weight = $('#ves').val();
                        if (weight && $('#type1_' + indexRow).val() !== 'def' && time) {
    //                    console.log($('#t1 tbody tr').length);


                            if (weight <= 70) {
                                res = ((activity * 1 - ((70 - weight) * activity * 1.4444) / 100) * time / 60).toFixed(1)
                            } else {
                                res = ((activity * 1 + ((weight - 70) * activity * 1.3333) / 100) * time / 60).toFixed(1)
                            }
                            $('#calories_' + indexRow).text(res);

                            totalTime += time * 1;
                            totalResult += res * 1;
                        }
                    }
                    if (totalResult > 0 && totalTime > 0) {
                        $footHtmlString = '<tr><td></td><td colspan="2">Итого:</td><td>' + totalTime + '</td><td>' + totalResult.toFixed(1) + '</td></tr>';
                        $('#t1 tfoot').html($footHtmlString);
                    } else
                        $('#t1 tfoot').html('');

                }

                function addEvents() {
                    var str = '';
                    $('#t1 tbody tr').each(function (index, element) {
                        var indexRow = $(element).attr('class');
                        $('#type1_' + indexRow).on('change', function () {
                            newrequest("getSelAct", $("#type2_" + indexRow), $("#type1_" + indexRow).val());
                            getCalories();
                        });
                        $('#type2_' + indexRow).on('change', getCalories);
                        $('#time_' + indexRow).on("keyup", function (eventObject) {
    //                        console.log(eventObject.key);
                            if (eventObject.key !== '*' && eventObject.key !== 'Backspace' && eventObject.key !== 'Delete' && (eventObject.key < '0' || eventObject.key > '9')) {
                                this.value = str;
                            } else {
                                if (eventObject.key !== 'Backspace' && eventObject.key !== 'Delete')
                                    str += eventObject.key;
                                else
                                    str = this.value;
                                getCalories();
                            }
                        });
                    });
                }

        </script>
            <h1>Анализатор расхода калорий</h1>
            <p>Анализатор поможет рассчитать примерный расход калорий при занятиях различными видами деятельности</p>
            <p>Введите ваш вес, выберете деятельность, время занятий и результат посчитается автоматически. Строки добавляются кнопкой «Добавить активность».</p>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method='post' id='' onsubmit="return false">
                <input type="hidden" name="func" value="calculateCalories" />
                <label for="ves">Ваш вес, кг</label>
                <input type="number" name="ves" value="" id="ves" min="30" max="200"/>
                <table border="1" cellspacing="1" cellpadding="2" id="t1">
                    <thead>
                        <tr>
                            <th></th>
                            <th colspan="2">Вид деятельности</th>
                            <th>Время, мин</th>
                            <th>Расход калорий,<br>
                                ккал</th>
                        </tr>
                    </thead>
                    <tfoot></tfoot>
                    <tbody></tbody>
                </table>
                <button type="button" class="btn btn-default" id="but1" onclick="newrequest('addRow', $('#t1 tbody'), totalIndex);">Добавить активность</button>
            </form>
            <p>Можно использовать символ «*» для умножения (например 5 уроков по 45 минут можно записать как 5*45).</p>

<?php } 
function slim_bazal(){
?>
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
        <script type="text/javascript">
            var db;
            const dbName = 'graph';
            var dbVersion = localStorage.getItem('version') ? parseInt(localStorage.getItem('version')) : 2;     
            var tableName = localStorage.getItem('database') ? localStorage.getItem('database') : "";
            const  cellWidth = 20;                 //размер ячейки
            //начало координат на холсте
            const x_begin = 200;
            const y_begin = 100;  
            if(navigator.userAgent.indexOf('.NET') > 0){
                //для IE
                var fontName = "Arial";
                var fontSize = "8pt";
            }else{
                var fontName = "Courier"; 
                var fontSize = "10pt";
            }
            var menstrDaysCount = 0 //количество дней месячных                
            var middle = 0;         //для среднего значения
            var middle2 = 0;         //для среднего значения
            var curDay = 0;                     //текущий день
            var x_ovul = 0;                     //координата овуляции
            const tableGraphParamsName = 'graph_params';    //имя таблицы существующих графиков и их параметров
            const middleLineColor = '#A4A4A4';
            const ovulLineColor = '#FF0000';
            const gridLineColor = '#000';
            const menstrDayColor = '#fadaee';
            var ovulPoint = 100;
            $(function(){
                getSelectItems();                
                $('#datepicker, #datepicker1').datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: "dd.mm.yy"
                }); 
                if(localStorage.getItem('database')){            
                    //выключаем див и включаем другой
                    $('#container1').css('display','none');
                    $('#container2').css('display','block');
                    
                    var kol_x = tableName.split('_')[2];
                    addCanvas(kol_x);
                    grid(parseInt(kol_x)+1);
                    getGraph(null);                   
                }
                $('#bazal_month').on('change',function(){
                    curDay = 0;
                    menstrDaysCount = 0;
                    x_ovul = 0;                    
                    ovulPoint = 100;
                    middle = 0;
                    middle2 = 0;
                    tableName = $('#bazal_month option:selected').val();
                    localStorage.setItem('database', tableName);
                    localStorage.setItem('graph', $('#bazal_month option:selected').text());
                    var kol_x = tableName.split('_')[2];
                    addCanvas(kol_x);
                    grid(parseInt(kol_x)+1);
                    getGraph(null); 
                });
//                console.log(document.getElementById("bazal_month").hasChildNodes());
//                if(document.getElementById("bazal_month").hasChildNodes()){
//                    $('.month').show();
                    //выключаем див и включаем другой
//                    $('#container1').css('display','none');
//                    $('#container2').css('display','block'); 

//                }
                $('#bazal_f1').on('submit', function(){
                    getSelectItems();
                    var kol_x = parseInt($('input[name=cycle]').val());
                    tableName = 'dataFromDays_' + $('#datepicker').val() + '_' + kol_x;
                    localStorage.setItem('graph', $('input[name=name]').val());
                    localStorage.setItem('database', tableName);                    
                    addCanvas(kol_x + 1);
                    
                    //выключаем див и включаем другой
                    $('#container1').css('display','none');
                    $('#container2').css('display','block'); 
                    $('#bazal_f2').show();
                    $('#info').hide();
                    setDefaultValues(kol_x);
                    
                    //функция отрисовки сетки и разметки координатных осей
                    grid(kol_x + 1);
                });
                //сохранение данных о дне (точки на графике) в indexedDB
                $('#bazal_f2').on('submit', function(){           
                    //объект записи в бд
                    var dayData = {
                        cycle_day : parseInt($('input[name=cycle_day]').val()),
                        cur_date : $('input[name=cur_date]').val(),
                        temp : $('input[name=temp]').val(),
                        cron : $('input[name=cron]').val(),
                        uchit : $('input[name=uchit]').is(':checked'),
                        ovul_date : $('input[name=ovul_date]').is(':checked'),
                        migren : $('select[name=migren]').val(),
                        givot : $('select[name=givot]').val(),
                        menstr_day : $('select[name=menstr_day]').val(),
                        sleep_length : $('input[name=sleep_length]').val(),
                        sleep_cond : $('input[name=sleep_cond]').val(),
                        illness : $('input[name=illness]').val(),
                        sex : $('input[name=sex]').is(':checked'),
                        alcohol : $('input[name=alcohol]').is(':checked'),
                        snotv : $('input[name=snotv]').is(':checked'),
                        pill_name : $('input[name=pill_name]').val(),
                        pill_rec : $('input[name=pill_rec]').val(),
                        pill_doza : $('input[name=pill_doza]').val(),
                        pill_desc : $('input[name=pill_desc]').val(),
                        pill_reason : $('input[name=pill_reason]').val(),
                        pill_eff : $('input[name=pill_eff]').val(),
                        comment : $('textarea[name=comment]').val()
                    };
                    //очистка div с canvas
                    console.log(dayData)
                    $('div.graph').html('');
                    var kol_x = tableName.split('_')[2];
                    //перерисовка графика с изменениями
                    addCanvas(parseInt(kol_x)+1);
                    grid(parseInt(kol_x)+1);
                    getGraph(dayData);
                                      
                });
                var icons = {
                    header: "ui-icon-circle-plus",
                    activeHeader: "ui-icon-circle-minus"
                };
                $( "#accordion" ).accordion({
                    collapsible: true,
                    icons: icons,
                    heightStyle: "content"
                });
                $('input[name=cron]').on('input',function(){
                    var tempArr = this.value.split(':');
                    if(tempArr[0]>24 || tempArr[1]>60)
                        this.value = this.value.substr(0,this.value.length-1);
                });
            });
            function getSelectItems(){
                $('#bazal_month').html('');
                var thisDB = null;
                var openRequest = indexedDB.open(dbName);
                openRequest.onsuccess = function(e){
                    console.log("Success for p!");
                    thisDB = e.target.result;
                    try{
                        var transactionParams = thisDB.transaction([tableGraphParamsName], "readonly");
                        var storeParams = transactionParams.objectStore(tableGraphParamsName);
                        var cursorParams = storeParams.openCursor();
                        
                        cursorParams.onsuccess = function(e){
                            var result = e.target.result;
                            if(result){
                                console.log("Key:", result.key);
                                console.dir(result.value);
                                $('#bazal_month').append('<option value="' + result.value.tablename + '">' + result.value.name + '</option>');
//                                tableName = result.value.tablename;
//                                localStorage.setItem('database', tableName);
                                result.continue();
                            }else{                                
                                console.log(result);
                                if(document.getElementById("bazal_month").hasChildNodes()){
                                    $('.month').show();
                                }
                            }
                        };
                        cursorParams.onerror = function(e){
                            var err = e.target.error;
                              console.log("Error par: ", err.name+": "+err.message);
                        }; 
                    }catch(e){
                        console.log('try error, DOMException : ' + e.message);
                    }
                };
                openRequest.onerror = function(e){
                    var err = e.target.error;
                    console.log("Error params: ", err.name+": "+err.message);
                };
            }
            //сетка
            function grid(kolichestvo_x){
                var cw = cellWidth*kolichestvo_x;
                var hObj = getHeight();
                var ch = hObj.height;
                var kolichestvo_y = hObj.kY;
                var canvas = document.getElementById("graph");
                var ctx = canvas.getContext("2d");
                var tempDateArr = tableName.split('_')[1].split('.');
                var beginDay = new Date(tempDateArr[2], tempDateArr[1]-1, tempDateArr[0]);
                var textOrd = '';
                var textOrdArr = ["гол. боль: слабая","гол. боль: сильная","гол. боль: мигрень","боль живота: тупая","боль живота: резкая","боль живота: ноющая","боль живота: другое","выд-я скудные","выд-я умеренные","выд-я обильные",'бесс. ночь', 'сон в необычн. усл.', 'болезнь', 'пол. акт', 'алкоголь', 'снотворное'];
                var now = new Date();
//                console.log(textOrdArr);
                
                ctx.font = fontSize + fontName;
                for (var i = 0; i <= kolichestvo_x; i++) {
                    //вертикальные линии
                    ctx.beginPath();
                    ctx.moveTo(i * cellWidth+x_begin, 0+y_begin);
                    ctx.lineTo(i * cellWidth+x_begin, ch+y_begin);
                    if(i == 0 || i == kolichestvo_x)
                        ctx.lineWidth = 1;
                    else {
                        ctx.lineWidth = 0.5;
                        //рисуем текст к сетке на оси абсцисс
                        ctx.fillText(i, i * cellWidth+x_begin-4, ch+y_begin+40);
                        ctx.fillText(beginDay.getDate(), i * cellWidth+x_begin-5, ch+y_begin+50);
                        
                        beginDay.setDate(beginDay.getDate()+1);
                    }
                    ctx.strokeStyle = gridLineColor;
                    ctx.stroke(); 
                    if(beginDay.getDate() == now.getDate() && beginDay.getMonth() == now.getMonth()){
                        ctx.beginPath();
                        ctx.globalAlpha = 0.5;
                        ctx.fillStyle = "#fff990";
                        ctx.fillRect(i * cellWidth+x_begin+7, ch+y_begin+20, cellWidth, cellWidth*2);
                        ctx.fillStyle = '#000000';
                        ctx.globalAlpha = 1;
                        ctx.closePath();
                    }
                }
                for (var i = 0; i <= kolichestvo_y; i++) {
                    //горизонтальные линии
                    ctx.beginPath();
                    ctx.moveTo(0+x_begin, i * cellWidth+y_begin);
                    ctx.lineTo(cw+x_begin, i * cellWidth+y_begin);
                    if(i == 0 || i == kolichestvo_y)
                        ctx.lineWidth = 1;
                    else {                        
                        textOrd = parseFloat($('input[name=temp]').attr('max'))-parseFloat($('input[name=temp]').attr('step'))*(i-1);
                        if(i < (kolichestvo_y-17)){
                            ctx.fillText(textOrd, x_begin-25, i * cellWidth+y_begin+4);
                            if(textOrd === 37){
                                ctx.lineWidth = 2;
                                ctx.strokeStyle = "#CC2EFA";
                            }else{
                                ctx.strokeStyle = gridLineColor;
                                ctx.lineWidth = 0.3;
                            }
                        }else if (i == (kolichestvo_y-17)) {
                            continue;
                        }else{
                            ctx.fillText(textOrdArr[i-28], x_begin-105, i * cellWidth+y_begin+3);
//                            console.log(kolichestvo_y-17);
                        }

                    }
                    ctx.stroke();
                    ctx.closePath();
                }
            }
            function drawGraph(flag){   
                
                var pCount = 0;         //счетчик точек до овуляции
                var sumTemp = 0;        //сумма значений температур до овуляции
                var pCount2 = 0;         //счетчик точек после овуляции
                var sumTemp2 = 0;        //сумма значений температур после овуляции
                var tempObj = getHeight();
                var height = tempObj.height;
                var canvas = document.getElementById("graph");
                var ctx = canvas.getContext('2d');                
                var transaction = db.transaction([tableName], "readonly");
                var store = transaction.objectStore(tableName);
                var cursor = store.openCursor();
                cursor.onsuccess = function(e){
                    var res = e.target.result;
                    if(res){
                        var obj = res.value;
                        var b_coords = getBeginCoords(res.key, obj.temp);
                        console.log("Key:", res.key);
                        //текущий день
                        curDay = res.key;
                        
                        console.dir(obj);
                        
                        //точки графика
                        addPoint(ctx, b_coords.x, b_coords.y, "#08088A");
                        //получаем данные предыдущей точки и рисуем отрезок от текущей к предыдущей
                        var request_prev = store.get(res.key-1);
                        request_prev.onsuccess = function(e){
                            
                            var res_prev = e.target.result;
                            if(res_prev){
                                ctx.beginPath();
                                coords_prev = getBeginCoords(res_prev.cycle_day, res_prev.temp);
                                ctx.moveTo(b_coords.x, b_coords.y);
                                ctx.lineTo(coords_prev.x, coords_prev.y);
                                ctx.strokeStyle = "#08088A";
                                ctx.lineWidth = 5;
                                ctx.stroke();
                                ctx.closePath();
                                
                                
                                //определение овуляции
                                if(obj.ovul_date || (res.key > 8 && res.key < 18 && obj.uchit && res_prev.uchit && ((parseFloat(res_prev.temp) === 36.3 || parseFloat(res_prev.temp) === 36.4) && parseFloat(obj.temp) > 36.5))){                                    
                                    ctx.beginPath();
                                    //рисуем линию овуляции
                                    //проверка для единственности линии
                                    if(x_ovul == 0)
                                        x_ovul = obj.ovul_date ? b_coords.x : coords_prev.x;
                                    if(ovulPoint == 100 || ovulPoint == res_prev.cycle_day){
                                        if(obj.ovul_date && ovulPoint == 100)
                                            ovulPoint = res.key;
                                        else ovulPoint = res_prev.cycle_day;
                                    
                                        ctx.moveTo(x_ovul, y_begin);
                                        ctx.lineTo(x_ovul, height+y_begin);
                                        ctx.strokeStyle = ovulLineColor;
                                        ctx.lineWidth = 2;
                                        ctx.stroke();
                                        ctx.font = fontSize + fontName;
                                        ctx.fillStyle = 'black';
                                        ctx.fillText('ДПО', ovulPoint * cellWidth+x_begin-10, height+y_begin+15);
                                        var lCycle = tableName.split('_')[2];
                                        for(var l=1; l<=(lCycle-ovulPoint); l++){
                                            ctx.fillStyle = "#FF0000";
                                            ctx.fillText(l, (ovulPoint + l) * cellWidth+x_begin-6, height+y_begin+15);
                                        }
                                    }
                                    ctx.closePath();
                                }
                            }
                            //для среднего значения данные
                            if(res.key <= ovulPoint){
                                sumTemp += parseFloat(obj.temp);
                                pCount++;
                                console.log(ovulPoint, sumTemp, pCount);
                            }else{
                                sumTemp2 += parseFloat(obj.temp);
                                pCount2++;
                                console.log(sumTemp2, pCount2);    
                            }
                        };
                        request_prev.onerror = function(e){
                            var err = e.target.error;
                            console.log("Error: ", err.name+": "+err.message);
                        };
                        
                        //отрисовка точек дополнительных полей
                        if(obj.migren !== '0'){
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*obj.migren, "#FE9A2E");
                        }
                        if(obj.givot !== '0'){
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*obj.givot, "#B43104");
                        }
                        if(obj.sleep_length === '0'){
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*38, "#2EFEF7");
                        }
                        if(obj.sleep_cond){
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*39, "#D7DF01");
                        }
                        if(obj.illness){
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*40, "#0B4C5F");
                        }
                        if(obj.sex){
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*41, "#DF0174");
                        }
                        if(obj.alcohol){
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*42, "#40FF00");
                        }
                        if(obj.snotv){
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*43, "#819FF7");
                        }
                        
                        //заливка при критических днях и их подсчет
                        if(obj.menstr_day !== '0'){
                            menstrDaysCount = res.key;
                            addPoint(ctx, res.key*cellWidth+x_begin, y_begin+cellWidth*obj.menstr_day, "#DF01A5");
                            ctx.beginPath();
                            ctx.globalAlpha = 0.5;
                            ctx.fillStyle = menstrDayColor;
                            ctx.fillRect(x_begin+(res.key-1)*cellWidth, y_begin, cellWidth, height);
                            ctx.fillStyle = '#000000';
                            ctx.globalAlpha = 1;
                        }                       
                        res.continue();
                    }else{
                        console.log(res, curDay); 
                        if(x_ovul || curDay == tableName.split('_')[2] || flag){
                            middle = Math.round(sumTemp*10/pCount)/10;
                            var yMid = y_begin + cellWidth*(1+(parseFloat($('input[name=temp]').attr('max'))-middle)/parseFloat($('input[name=temp]').attr('step')));
                            console.log(sumTemp,pCount, sumTemp2, pCount2,middle,yMid, ovulPoint);
                            if(x_ovul)
                                drawMiddleLine(ctx, x_ovul, yMid, middleLineColor,false);
                            else drawMiddleLine(ctx, x_begin + cellWidth*(curDay+1), yMid, middleLineColor,false);
                        }
                        if((curDay == tableName.split('_')[2] && pCount2) || flag){
                            //если достигли дня конца цикла, то гасим форму
                            middle2 = Math.round(sumTemp2*10/pCount2)/10;
                            var yMid2 = y_begin + cellWidth*(1+(parseFloat($('input[name=temp]').attr('max'))-middle2)/parseFloat($('input[name=temp]').attr('step')));
                            console.log(middle2);
                            drawMiddleLine(ctx, x_ovul, yMid2, middleLineColor, true);
                            endCycle();
                        }
                        if(localStorage.getItem('hide'))
                            endCycle();
                        else setDefaultValues(tableName.split('_')[2]);
                    }

                };
                cursor.onerror = function(e){
                    var err = e.target.error;
                    console.log("Error: ", err.name+": "+err.message);
                };
            }
            function addPoint(context, x, y, color){
                context.beginPath();
                context.moveTo(x, y);
                context.lineWidth = 3;
                context.fillStyle = color;
                context.arc(x, y,5,0,2*Math.PI, false);
                context.closePath(); 
                context.fill();
            }
            function getBeginCoords(key, t){
                var x0 = key*cellWidth+x_begin;
                var y0 = y_begin + cellWidth*(((parseFloat($('input[name=temp]').attr('max')) - parseFloat(t))/parseFloat($('input[name=temp]').attr('step')))+1);
                return {x:x0,y:y0};
            }
            function getHeight(){
                //19-из-за пустой строки и добавочных пунктов
                var kol_y = 19+(parseFloat($('input[name=temp]').attr('max'))-parseFloat($('input[name=temp]').attr('min')))/parseFloat($('input[name=temp]').attr('step'));
                var height = cellWidth*kol_y;
                return {kY:kol_y, height: height};
            }
            function drawMiddleLine(context, x, y, color, flag){
                console.log(context, x, y, color);
                context.beginPath();                
                context.strokeStyle = color;
                context.lineWidth = 2;
                if(flag){
                    context.moveTo(x, y);
                    context.lineTo(x_begin
                     + (curDay + 1)*cellWidth,y); 
                }else{
                    context.moveTo(x_begin, y);
                    context.lineTo(x,y); 
                }                      
                context.stroke();
                context.closePath(); 
            }
            function addCanvas(kolX){
                var h = getHeight();
                var gridHeight = h.height;
                var gridWidth = cellWidth*kolX;

                var canvasWidth = gridWidth+x_begin*2;             //ширина холста
                var canvasHeight = gridHeight+y_begin*2;             //высота холста
                $htmlCanvas = '<h3>' + localStorage.getItem("graph") + '</h3><p id="fin"></p><canvas id="graph" width="' + canvasWidth + '" height="' + canvasHeight + '"></canvas><span class="left red"></span><span class="left">Линия овуляции</span><span class="left grey"></span><span class="left">Средняя линия</span><span class="left" id="cycle_length"></span>';
                $('div.graph').html($htmlCanvas);
            }
            function getGraph(data){
                console.log(dbVersion, tableName);
                var openRequest = indexedDB.open(dbName, dbVersion);
                console.log(openRequest);
                openRequest.onupgradeneeded = function (e){
                    //тут только создаем таблицу данных для текущего дня, если её нет
                    var thisDB = e.target.result;
                    if(!thisDB.objectStoreNames.contains(tableName)){
                        thisDB.createObjectStore(tableName, {keyPath: "cycle_day"});
                    //записываем имя таблицы в хранилище
                        localStorage.setItem('database', tableName);
                    }
                    if(!thisDB.objectStoreNames.contains(tableGraphParamsName)){
                        thisDB.createObjectStore(tableGraphParamsName, {keyPath: "id"});
                    }
                    console.log("Upgrading");
                };
                openRequest.onsuccess = function(e){
                    db = e.target.result;
                    console.log("Success!!!", tableName);
                    if(data){
                        var transaction = db.transaction([tableName], "readwrite");
                        var store = transaction.objectStore(tableName);
                        var request = store.put(data);
                        request.onsuccess = function(e){          
                            console.log("Record added");          
                        };
                        request.onerror = function(e){
                            var err = e.target.error;
                            console.log("Error: ", err.name+": "+err.message);
                            console.dir(err);
                        };  
                    }
                    drawGraph(false);                    
                };
                openRequest.onerror = function(e){
                    var err = e.target.error;
                    console.log("Error: ", err.name+": "+err.message);
                    console.dir(err);
                    if(err.code === 0){
                        dbVersion++;
                        localStorage.setItem('version', dbVersion);
                    }
                    location.reload();
                };
            }
            function setDefaultValues(kX){
                if(curDay == kX){
                    $('#bazal_f2').hide();
                    endCycle();
                    return;
                }
                var now = new Date();
                //значения по умолчанию
                $('#cycle_length').text('Длина цикла: ' + kX + ' дней');
                $('#datepicker1').val((parseInt(now.getDate())<=9 ? '0' + now.getDate(): now.getDate()) +'.'+((parseInt(now.getMonth())+1)<=9 ? '0'+ (parseInt(now.getMonth())+1) : (parseInt(now.getMonth())+1)) +'.'+now.getFullYear());
                $('input[name=cycle_day]').val(curDay+1);
                $('select[name=menstr_day] option').eq(2).attr("selected", false);
                if(curDay <= 6){
                    $('input[name=temp]').val(36.4);
                    $('select[name=menstr_day] option').eq(2).attr("selected", "selected");
                }else if(curDay >6 && curDay < 11)
                    $('input[name=temp]').val(36.8);
                else if(curDay == 12 && curDay == 13)
                    $('input[name=temp]').val(36.3);
                else if(curDay >=14 && curDay < 27)
                    $('input[name=temp]').val(37.1);
                else $('input[name=temp]').val(36.8);
                $('input[name=cron]').val((parseInt(now.getHours())<=9 ? '0' + now.getHours() : now.getHours()) +":"+(parseInt(now.getMinutes())<=9 ? '0' + now.getMinutes() : now.getMinutes()));
                $('input[name=sleep_length]').val(8);    
                if(x_ovul){
                    $('.check').hide();
                    $('input[name=uchit').attr('checked', false);
                    $('input[name=ovul_date').attr('checked', false);
                }
            }
            function endCycle(){
                if(middle2 === 0 || middle === 0)
                        drawGraph(true);
                //скрываем форму
                $('#bazal_f2').hide();
                localStorage.setItem('hide', true);
                var canvas = document.getElementById("graph");
                var ctx = canvas.getContext("2d");
                if(!x_ovul){
                    $('#info').show();
                    var finalStr = 'ДЦ: ' + curDay + ' дн., М: ' + menstrDaysCount + ' дн., фаза &#8544;: ' + middle + '&deg;C';
                }else{
                    
                    
                    var finalStr = 'ДЦ: ' + curDay + ' дн., М: ' + menstrDaysCount + ' дн., фаза &#8544;: ' + middle + '&deg;C, фаза &#8545;: ' + middle2 + '&deg;C, разница &#8544; и &#8545; фаз: ' + Math.round((middle - middle2)*10)/10 + '&deg;C';
                }
                $('#fin').html(finalStr);

                //добавляем квадрат с пояснениями в левый верхний угол canvas
                ctx.fillStyle = "white";
                ctx.fillRect(x_begin+cellWidth/2,y_begin+cellWidth/2,cellWidth*7,cellWidth*4);
                ctx.fillStyle = menstrDayColor;
                ctx.fillRect(x_begin+cellWidth,y_begin+cellWidth,cellWidth,cellWidth);
                ctx.fillStyle = gridLineColor;
                ctx.fillText('месячные ' + menstrDaysCount + ' дн.', x_begin+cellWidth*2 + 3, y_begin+cellWidth*2);
                if(x_ovul){
                    ctx.fillStyle = ovulLineColor;
                    ctx.fillRect(x_begin+cellWidth,y_begin+2*cellWidth+5,cellWidth,cellWidth);
                    ctx.fillStyle = gridLineColor;
                    ctx.fillText('овуляция ' + ovulPoint + ' дц.', x_begin+cellWidth*2 + 3, y_begin+cellWidth*3+5);
                }
                ctx.fill();
                
                addParamsOfCurGraph();
            }            
            function deleteGraph(){
                $text = localStorage.getItem('graph');
                if($('option:contains("' + $text + '")')[0]){
                    $('option:contains("' + $text + '")')[0].remove();
                    var transactionParams = db.transaction([tableGraphParamsName], "readwrite");
                    var storeParams = transactionParams.objectStore(tableGraphParamsName);
                    var request = storeParams.delete(dbVersion);
                    request.onsuccess = function(e){console.log("Record deleted")};
                    request.onerror = function(e){
                        var err = e.target.error;
                          console.log("Error: ", err.name+": "+err.message);
                    };
                    curDay = 0;
                    menstrDaysCount = 0;
                    x_ovul = 0;                    
                    ovulPoint = 100;
                    middle = 0;
                    middle2 = 0;
                    tableName = $('#bazal_month option:selected').val();
                    localStorage.setItem('database', tableName);
                    localStorage.setItem('graph', $('#bazal_month option:selected').text());
                    var kol_x = tableName.split('_')[2];
                    addCanvas(kol_x);
                    grid(parseInt(kol_x)+1);
                    getGraph(null); 
                }
                else addNewGraph(false);
//                indexedDB.deleteDatabase('graph');            
            }
            function addNewGraph(f){
                if(f && db.objectStoreNames.contains(tableName))
                    addParamsOfCurGraph();
                localStorage.removeItem('graph');
                dbVersion++;
                localStorage.setItem('version', dbVersion);
                curDay = 0;
                menstrDaysCount = 0; 
                x_ovul = 0;            
                ovulPoint = 100;
                middle = 0;
                middle2 = 0;
                db = null;
                localStorage.removeItem('database');
                localStorage.removeItem('hide');
                //выключаем див и включаем другой
                $('#container2').hide();
                $('#container1').show();
            }
            function addParamsOfCurGraph(){
                
                $tempDateArr = tableName.split('_')[1].split('.');
                var monthGraph = new Date($tempDateArr[2], $tempDateArr[1]-1, $tempDateArr[0]);
                
                //добавляем общие данные графика в базу
                var objGraph = {
                    id: parseInt(dbVersion),
                    name: localStorage.getItem('graph') + '_' + monthGraph.toLocaleDateString("ru",{month:'long', year:'numeric'}),
                    tablename: tableName,
                    lastday: curDay
                };                
                console.log(objGraph);
//                $('.month').show();
//                $('#bazal_month').append('<option value="' + objGraph.tablename + '">' + objGraph.name + '</option>');
                var transaction = db.transaction([tableGraphParamsName], "readwrite");
                var store = transaction.objectStore(tableGraphParamsName);
                var request = store.add(objGraph);
                request.onsuccess = function(e){console.log("Record graph params added")};
                request.onerror = function(e){
                    var err = e.target.error;
                      console.log("Error: ", err.name+": "+err.message);
                };
            }
        </script>
        <style>
            h3 {
                text-align: center;
            }
            .month{
                display: none;
            }
            canvas {
                display: block;
                margin: 20px auto 0;
                border: 1px dotted #ccc;
            }
            .left{
                float: left;
                height: 30px;
                margin: 20px 10px;
                vertical-align: text-bottom
            }
            .red{
                background-color: red;
                width: 30px;
                border: 1px solid black;
                margin-top: 10px
            }
            .grey{
                background-color: #A4A4A4;
                width: 30px;
                border: 1px solid black;
                margin-top: 10px
            }
            .graph{
                overflow: hidden;
            }
            #accordion{
                float: right;
                width: 40%
            }
            #bazal_f2 fieldset{
                min-height: 300px
            }
            #container2, #info{
                display: none
            }
            .bottom{
                text-align: center
            }
        </style>
        <h1>Базальная температура</h1>
        <p>Известно, что в зависимости от фазы менструального цикла в организме колеблется уровень гормонов, а вместе с ним и базальная температура.</p>
        <p>Наш сервис поможет Вам построить Ваш личный график базальной температуры, отследить изменения самочувствия, прием таблеток и, при желании, посоветоваться с подругами!</p>
        <!--все значения аттрибутов полей нужны для скрипта (min, max, step итд), т.е. при их изменении будут разные результаты-->
        <div id="container1">
            <form id="bazal_f1" onsubmit="return false">
                <table cellspacing="1" cellpadding="2" id="bazal_t1">
                    <caption><h3><i>Создать график измерения базальной температуры</i></h3></caption>
                    <tbody>
                        <tr>
                            <td>Название графика</td>
                            <td colspan="3"><input type="text" name="name" pattern="^[0-9A-Za-zА-Яа-яЁё\-\s]+$" size="50" required placeholder="Только буквы, цифры и знак -" value="График1"></td>
                        </tr>
                        <tr>
                            <td>Выберите дату начала последней менструации:</td>
                            <td><input type="text" name="menstr_date" id="datepicker" required></td>
                            <td>Длительность цикла:</td>
                            <td><input type="number" name="cycle" min="21" max="35" required></td>
                        </tr>
                        <tr>
                            <!--<td colspan="2"><input name="auto_date" type="checkbox" checked>Определять дату овуляции автоматически</td>-->
                            <td><input type="checkbox" name="show_graph">Показывать график подругам</td>
                            <td><input type="submit" value="Рассчитать"></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <div id="container2">            
            <h3><i>Текущий график</i></h3>
            <div class="month">
                <label for="bazal_month">Показать другой ваш график</label>
                <select id="bazal_month"></select>
            </div>
            <div class="graph"></div>
            <div id="info"><h2 style="text-align: center"><a href="" onclick="return false" title="К сожалению, наша программа не может определить дату вашей овуляции. Возможно, разброс температур в первой фазе цикла очень высок. Вы можете не учитывать в расчете овуляции дни, температура которых отличается от предыдущего и последующего больше чем на 0,2 градуса. Для этого в характеристике дня отметьте — не учитывать день при расчете овуляции. Также вы можете выставить дату овуляции вручную."><span class="glyphicon glyphicon-info-sign"></span></a></h2></div>
            <form id="bazal_f2" onsubmit="return false">
                <fieldset>
                    <legend><i>Ввод ежедневных данных</i></legend>                    
                    <div style="float: left">
                        <label>Дата:<input type="text" name="cur_date" id="datepicker1" required size="10"></label>                    
                        <label>День цикла:<input name="cycle_day" type="number" min="1" max="35" required></label><br><br>
                        <label>Температура:<input name="temp" type="number" min="35.5" max="38" required step="0.1"></label><br><br>
                        <label>Время измерения: <input type="time" name="cron" pattern="[0-9]{2}[:0-9]{3}" placeholder="--:--"></label><br><br>
                        <div class="check">
                            <label><input type="checkbox" name="uchit" checked><b>Учитывать при расчёте овуляции</b></label><br><br>
                            <label><input type="checkbox" name="ovul_date"><b>Это дата овуляции</b></label><br>
                        </div>
                    </div>
                    <div id="accordion">
                        <h3>Самочувствие</h3>
                        <div id="samoch">
                            <label>Головная боль: 
                                <select name="migren">
                                    <option value="0" selected>нет</option>
                                    <option value="28">слабая</option>
                                    <option value="29">сильная</option>
                                    <option value="30">мигрень</option>
                                </select>
                            </label><br>
                            <label>Боль внизу живота: 
                                <select name="givot">
                                    <option value="0" selected>нет</option>
                                    <option value="31">тупая</option>
                                    <option value="32">резкая</option>
                                    <option value="33">ноющая</option>
                                    <option value="34">свой вариант</option>
                                </select>
                            </label><br>
                            <label>Критические дни: 
                                <select name="menstr_day">
                                    <option value="0" selected>нет</option>
                                    <option value="35">скудные</option>
                                    <option value="36">умеренные</option>
                                    <option value="37">обильные</option>
                                </select>
                            </label><br>
                            <label>Длительность сна: 
                                <input name="sleep_length" type="number" min="0" max="15"> часов
                            </label><br>
                            <label>Сон в необычных условиях: 
                                <input name="sleep_cond" type="text">
                            </label><br>
                            <label>Болезнь: 
                                <input name="illness" type="text">
                            </label><br>
                            <label><input type="checkbox" name="sex">Половой акт</label>
                            <label><input type="checkbox" name="alcohol">Алкоголь</label>
                            <label><input type="checkbox" name="snotv">Снотворное</label>
                        </div>
                        <h3>Приём лекарств</h3>
                        <div>
                            <label>Наименование: 
                                <input name="pill_name" type="text">
                            </label><br>
                            <label>Доза:  
                                <input name="pill_rec" type="text">
                                <input name="pill_doza" type="number" min="1" max="5"> раз в день
                            </label><br>
                            <label>Описание: 
                                <input name="pill_desc" type="text">
                            </label><br>
                            <label>Причина приёма: 
                                <input name="pill_reason" type="text">
                            </label><br>
                            <label>Побочные эффекты: 
                                <input name="pill_eff" type="text">
                            </label>
                        </div>
                        <h3>Комментарий</h3>
                        <div>
                            <textarea name="comment" rows="4" cols="20"></textarea>
                        </div>
                    </div>
                    <div style="clear: both; text-align: center; vertical-align: bottom">
                        <input type="submit" value="Сохранить">
                    </div>
                </fieldset>
            </form>
            <hr>
            <div class="bottom">
                <button class="btn-link" type="button" onclick="deleteGraph()">Удалить график</button>
                <button type="button" onclick="endCycle()">Мой цикл закончился</button>
                <button type="button" onclick="addNewGraph(true)">Добавить новый график</button>
            </div>
        </div>            
<?php } 
function slim_calcBody(){
    //значения по умолчанию
    static $rostVal = '';
    static $vesVal = '';
    static $zhelVesVal = '';
    static $raznCalVal = '0';
    static $vozrVal = '';
    static $polVal = '';
    static $levelActivity = '0';
    static $BZHU = '0';
    static $arrayBZHU = array();
    static $amount = '0';
    static $newTarget = '0';
    static $out = '';
    static $outCalories = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //echo '<pre>';
    //var_dump($_POST);
    //echo '</pre>';
        $rostVal = $_POST['rost'] ? $_POST['rost'] : '';
        $vesVal = $_POST['ves'] ? $_POST['ves'] : '';
        $zhelVesVal = $_POST['zhelves'] ? $_POST['zhelves'] : '';
        $vozrVal = $_POST['vozr'] ? $_POST['vozr'] : '';
        $polVal = $_POST['sex'] ? $_POST['sex'] : '';
        $levelActivity = isset($_POST['activity']) ? $_POST['activity'] : '0';
        $BZHU = $_POST['system'] ? $_POST['system'] : '0';
        $amount = $_POST['amount'] ? $_POST['amount'] : '0';
        $newTarget = $_POST['tar'] ? $_POST['tar'] : '0';
        $raznCalVal = $_POST['calories'] ? $_POST['calories'] : '0';
    //		$_POST['func']();
    }
?>
        <script>
               $(function () {
                $("#tabs").tabs({
                 active: localStorage.getItem('tabindex') ? localStorage.getItem('tabindex') : 0					
                }).on('click', function(event){
            //					alert($("#tabs").tabs("option", "active"));
            //console.dir(event);
                 localStorage.setItem('tabindex', $("#tabs").tabs("option", "active"));
                });
            //				console.log($("#tabs").tabs("option", "active"));
            //				$( "input" ).checkboxradio();
    				
                $('.range_rost').slider({
                 min: 100,
                 max: 250,
                 slide: function(event, ui){
                  $('.rost').val(ui.value);
                 }
                });
                $('.range_rost').slider( "value", $('.rost').val());
                $('.range_ves').slider({
                 min: 20,
                 max: 170,
                 slide: function(event, ui){
                  $('.ves').val(ui.value);
                 }
                });
                $('.range_ves').slider( "value", $('.ves').val());
                $('.range_zhel_ves').slider({
                 min: 20,
                 max: 170,
                 slide: function(event, ui){
                  $('.zhel_ves').val(ui.value);
                                    if($('.zhel_ves').val() > $('.ves').val()){
                                        changeOption(false);
                                    }else changeOption(true);
                 }
                });
                $('.range_zhel_ves').slider( "value", $('.zhel_ves').val());
                            if($('.zhel_ves').val() > $('.ves').val()){
                                changeOption(false);
                            }
                $('.range_vozr').slider({
                 min: 12,
                 max: 80,
                 slide: function(event, ui){
                  $('.vozr').val(ui.value);
                 }
                });
                $('.range_vozr').slider( "value", $('.vozr').val());
                            $('.range_calories').slider({
                 min: 0,
                 max: 1500,
                                step: 50,
                 slide: function(event, ui){
                  $('.calories').val(ui.value);
                 }
                });
                $('.range_calories').slider( "value", $('.calories').val());
               });
                        function changeOption(flag){
                            if(!flag){
                                $('select[name=tar]').children('option').eq(2).text('Медленного повышения веса');
                                $('select[name=tar]').children('option').eq(3).text('Умеренного повышения веса');
                                $('select[name=tar]').children('option').eq(4).text('Быстрого повышения веса');
                                $('select[name=tar]').children('option').eq(5).text('Экстремального повышения веса');
                            }else{
                                $('select[name=tar]').children('option').eq(2).text('Медленного снижения веса');
                                $('select[name=tar]').children('option').eq(3).text('Умеренного снижения веса');
                                $('select[name=tar]').children('option').eq(4).text('Быстрого снижения веса');
                                $('select[name=tar]').children('option').eq(5).text('Экстремального снижения веса');
                            }
                        }
            </script>
            <style>
             td{
              padding: 5px;
             }
            </style>
            <title>Анализатор параметров тела</title>
            <h1>Анализатор параметров тела</h1>

            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Идеальный вес</a></li>
                    <li><a href="#tabs-2">Суточная потребность</a></li>
                    <li><a href="#tabs-3">Прогноз веса</a></li>
                </ul>
                <div id="tabs-1">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method='post'>
                        <input type="hidden" name="func" value="idealWeight" />
                        <fieldset>
                            <legend>Пол</legend>
                            <? if($polVal==='male') { ?>
                            <label>М<input type="radio" name="sex" id="radio-1" value="male" required checked/></label>
                            <label>Ж<input type="radio" name="sex" id="radio-2" value="female" required/></label>
                            <? }elseif($polVal==='female') { ?>
                            <label>М<input type="radio" name="sex" id="radio-1" value="male" required /></label>
                            <label>Ж<input type="radio" name="sex" id="radio-2" value="female" required checked/></label>
                            <? }else { ?>
                            <label>М<input type="radio" name="sex" id="radio-1" value="male" required /></label>
                            <label>Ж<input type="radio" name="sex" id="radio-2" value="female" required/></label>
                            <? } ?>
                        </fieldset>
                        <fieldset>
                            <table>
                                <tr>
                                    <td>Рост, см</td>
                                    <td><div class="range_rost" style="width:100px;"></div></td>
                                    <td><input type="text" class="rost" value="<?= $rostVal ?>" name="rost"></td>
                                </tr>
                                <tr>
                                    <td>Текущий вес, кг</td>

                                    <td><div class="range_ves" style="width:100px;"></div></td>
                                    <td><input type="text" class="ves" value="<?= $vesVal ?>" name="ves"></td>

                                </tr>
                                <tr>
                                    <td>Возраст, лет</td>

                                    <td><div class="range_vozr" style="width:100px;"></div></td>
                                    <td><input type="text" class="vozr" value="<?= $vozrVal ?>" name="vozr"></td>

                                </tr>
                            </table>
                        </fieldset>
                        <input type="submit" value="Рассчитать" />
                    </form>
                    <?php
//	function idealWeight(){
                    if ($_POST['func'] === 'idealWeight') {
//		echo '<pre>';
//		var_dump($_POST);
//		echo '</pre>';
                        $out = '<table>';
                        //ИМТ: вес (в килограммах) разделить на возведенный в квадрат рост (в метрах), то есть ИМТ = вес (кг): (рост (м))2
                        $imt = round($_POST['ves'] / pow($_POST['rost'] / 100, 2), 1);
                        if ($imt >= 20 && $imt <= 25) {
                            $strImt = '<b style="color:green">нормальный вес</b>';
                        } elseif ($imt < 20) {
                            $strImt = '<b style="color:red">недостаток веса</b>';
                        } elseif ($imt > 25 && $imt <= 30) {
                            $strImt = '<b style="color:yellow">легкое превышение веса</b>';
                        } elseif ($imt > 30 && $imt <= 35) {
                            $strImt = '<b style="color:grey">превышение веса</b>';
                        } elseif ($imt > 35) {
                            $strImt = '<b style="color:red">ожирение</b>';
                        }
                        $out .= "<tr><td>Индекс массы тела: </td><td>$imt</td><td>$strImt</td></tr>";
//		echo $strImt;
                        //индекс Брока - взял формулу из трех источников: 
                        //https://planetcalc.ru/35/ 
                        //https://ru.wikipedia.org/wiki/%D0%98%D0%BD%D0%B4%D0%B5%D0%BA%D1%81_%D0%BC%D0%B0%D1%81%D1%81%D1%8B_%D1%82%D0%B5%D0%BB%D0%B0
                        //https://beregifiguru.ru/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B-%D0%B8%D0%B4%D0%B5%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D0%B3%D0%BE-%D0%B2%D0%B5%D1%81%D0%B0/%D0%98%D0%BD%D0%B4%D0%B5%D0%BA%D1%81-%D0%91%D1%80%D0%BE%D0%BA%D0%B0

                        if ($_POST['vozr'] <= 30)
                            $kVBr = 0.89;
                        elseif ($_POST['vozr'] > 50)
                            $kVBr = 1.06;
                        else
                            $kVBr = 1;
                        /*
                          if($_POST['rost']<=165)
                          $kRBr = 100;
                          elseif ($_POST['rost']>165 && $_POST['rost']<=175)
                          $kRBr = 105;
                          elseif($_POST['rost']>175)
                          $kRBr = 110;

                          var_dump($kRBr,$kVBr);
                         * 
                         */
                        $iBr = round(($_POST['rost'] - 100) * ($_POST['sex'] === 'male' ? 0.9 : 0.85) * $kVBr, 1);
                        if ($_POST['ves'] >= $iBr * 0.9 && $_POST['ves'] <= $iBr * 1.1)
                            $strBr = '<b style="color:green">нормальный вес</b>';
                        elseif ($_POST['ves'] < $iBr * 0.9)
                            $strBr = '<b style="color:red">недостаток веса</b>';
                        elseif ($_POST['ves'] > $iBr * 1.1)
                            $strBr = '<b style="color:red">превышение веса</b>';
//		var_dump($iBr);
//		echo $iBr*0.9.'-'.$iBr*1.1;
                        $strIBr = $iBr * 0.9 . '-' . $iBr * 1.1;
                        $out .= "<tr><td>Идеальный вес (по Брока), кг:  </td><td>$strIBr</td><td>$strBr</td></tr>";

                        //расчет по Девайну:
                        //http://www.klinrek.ru/calcs/ibma.htm
                        if ($_POST['sex'] === 'male')
                            $iDev = round(50 + 2.3 * (($_POST['rost'] / 2.54) - 60));
                        else
                            $iDev = round(45.5 + 2.3 * (($_POST['rost'] / 2.54) - 60));
                        if ($_POST['ves'] >= $iDev * 0.9 && $_POST['ves'] <= $iDev * 1.1)
                            $strDev = '<b style="color:green">нормальный вес</b>';
                        elseif ($_POST['ves'] < $iDev * 0.9)
                            $strDev = '<b style="color:red">недостаток веса</b>';
                        elseif ($_POST['ves'] > $iDev * 1.1)
                            $strDev = '<b style="color:red">превышение веса</b>';
//		var_dump($iDev);
//		echo $iDev*0.9.'-'.$iDev*1.1;
                        $strIDev = $iDev * 0.9 . '-' . $iDev * 1.1;
//		echo $strDev;
                        $out .= "<tr><td>Идеальный вес (по Девайну), кг: </td><td>$strIDev</td><td>$strDev</td></tr>";

                        //по Робинсону
                        //http://www.klinrek.ru/calcs/ibma.htm
                        //https://beregifiguru.ru/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B-%D0%B8%D0%B4%D0%B5%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D0%B3%D0%BE-%D0%B2%D0%B5%D1%81%D0%B0/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D0%B0-%D0%A0%D0%BE%D0%B1%D0%B8%D0%BD%D1%81%D0%BE%D0%BD%D0%B0
                        if ($_POST['sex'] === 'male')
                            $iRob = round(52 + 1.9 * (($_POST['rost'] / 2.54) - 60));
                        else
                            $iRob = round(49 + 1.7 * (($_POST['rost'] / 2.54) - 60));
                        if ($_POST['ves'] >= $iRob * 0.9 && $_POST['ves'] <= $iRob * 1.1)
                            $strRob = '<b style="color:green">нормальный вес</b>';
                        elseif ($_POST['ves'] < $iRob * 0.9)
                            $strRob = '<b style="color:red">недостаток веса</b>';
                        elseif ($_POST['ves'] > $iRob * 1.1)
                            $strRob = '<b style="color:red">превышение веса</b>';
//		var_dump($iRob);
//		echo $iRob*0.9.'-'.$iRob*1.1;
                        $strIRob = $iRob * 0.9 . '-' . $iRob * 1.1;
//		echo $strRob;
                        $out .= "<tr><td>Идеальный вес (по Робинсону), кг: </td><td>$strIRob</td><td>$strRob</td></tr>";

                        //по Миллеру
                        //https://medicinelab.ru/formula-idealnogo-vesa.html#Формула Миллера (1983)
                        if ($_POST['sex'] === 'male')
                            $iMill = round(56.2 + 1.41 * (($_POST['rost'] / 2.54) - 60));
                        else
                            $iMill = round(53.1 + 1.36 * (($_POST['rost'] / 2.54) - 60));
                        if ($_POST['ves'] >= $iMill * 0.9 && $_POST['ves'] <= $iMill * 1.1)
                            $strMill = '<b style="color:green">нормальный вес</b>';
                        elseif ($_POST['ves'] < $iMill * 0.9)
                            $strMill = '<b style="color:red">недостаток веса</b>';
                        elseif ($_POST['ves'] > $iMill * 1.1)
                            $strMill = '<b style="color:red">превышение веса</b>';
//		var_dump($iMill);
//		echo $iMill*0.9.'-'.$iMill*1.1;
                        $strIMill = $iMill * 0.9 . '-' . $iMill * 1.1;
//		echo $strMill;
                        $out .= "<tr><td>Идеальный вес (по Миллеру), кг: </td><td>$strIMill</td><td>$strMill</td></tr>";
                        $out .= '</table>';
                        echo $out;
                    }
                    ?>
                </div>
                <div id="tabs-2">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method='post'>
                        <input type="hidden" name="func" value="sutPotr" />
                        <fieldset>
                            <legend>Пол</legend>
                            <? if($polVal==='male') { ?>
                            <label>М<input type="radio" name="sex" id="radio-1" value="male" required checked/></label>
                            <label>Ж<input type="radio" name="sex" id="radio-2" value="female" required/></label>
                            <? }elseif($polVal==='female') { ?>
                            <label>М<input type="radio" name="sex" id="radio-1" value="male" required /></label>
                            <label>Ж<input type="radio" name="sex" id="radio-2" value="female" required checked/></label>
                            <? }else { ?>
                            <label>М<input type="radio" name="sex" id="radio-1" value="male" required /></label>
                            <label>Ж<input type="radio" name="sex" id="radio-2" value="female" required/></label>
                            <? } ?>
                        </fieldset>
                        <fieldset>
                            <table>
                                <tr>
                                    <td>Рост, см</td>
                                    <td><div class="range_rost" style="width:100px;"></div></td>
                                    <td><input type="text" class="rost" value="<?= $rostVal ?>" name="rost"></td>
                                </tr>
                                <tr>
                                    <td>Возраст, лет</td>
                                    <td><div class="range_vozr" style="width:100px;"></div></td>
                                    <td><input type="text" class="vozr" value="<?= $vozrVal ?>" name="vozr"></td>

                                </tr>
                                <tr>
                                    <td>Текущий вес, кг</td>
                                    <td><div class="range_ves" style="width:100px;"></div></td>
                                    <td><input type="text" class="ves" value="<?= $vesVal ?>" name="ves"></td>

                                </tr>
                                <tr>
                                    <td>Желаемый вес, кг</td>
                                    <td><div class="range_zhel_ves" style="width:100px;"></div></td>
                                    <td><input type="text" class="zhel_ves" value="<?= $zhelVesVal ?>" name="zhelves"></td>

                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <select name="activity">
                                            <?= $levelActivity === '0' ? '<option value="0"  selected >Уровень активности</option>' : '<option value="0">Уровень активности</option>' ?>
                                            <?= $levelActivity === '1' ? '<option value="1" selected>Базовая (полный покой)</option>' : '<option value="1">Базовая (полный покой)</option>' ?>
    <?= $levelActivity === '1.2' ? '<option value="1.2" selected>Низкая (сидячий образ жизни)</option>' : '<option value="1.2">Низкая (сидячий образ жизни)</option>' ?>
    <?= $levelActivity === '1.38' ? '<option value="1.38" selected>Малая (1-3 раза в неделю легкие тренировки)</option>' : '<option value="1.38">Малая (1-3 раза в неделю легкие тренировки)</option>' ?>
    <?= $levelActivity === '1.55' ? '<option value="1.55" selected>Средняя (3-5 раз в неделю умеренные тренировки)</option>' : '<option value="1.55">Средняя (3-5 раз в неделю умеренные тренировки)</option>' ?>
    <?= $levelActivity === '1.73' ? '<option value="1.73" selected>Высокая (5-7 раз в неделю интенсивные тренировки)</option>' : '<option value="1.73">Высокая (5-7 раз в неделю интенсивные тренировки)</option>' ?>				
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <select name="system">
                                            <?= $BZHU === '0' ? '<option value="0" selected>Система питания (баланс БЖУ)</option>' : '<option value="0">Система питания (баланс БЖУ)</option>' ?>
    <?= $BZHU === '1' ? '<option value="1" selected>Сбалансированная (30/20/50)</option>' : '<option value="1">Сбалансированная (30/20/50)</option>' ?>
    <?= $BZHU === '2' ? '<option value="2" selected>Низкобелковая (15/20/65)</option>' : '<option value="2">Низкобелковая (15/20/65)</option>' ?>
    <?= $BZHU === '3' ? '<option value="3" selected>Низкожировая (40/15/45)</option>' : '<option value="3">Низкожировая (40/15/45)</option>' ?>
    <?= $BZHU === '4' ? '<option value="4" selected>Низкоуглеводная (65/20/15)</option>' : '<option value="4">Низкоуглеводная (65/20/15)</option>' ?>									
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <select name="amount">
                                            <?= $amount === '0' ? '<option value="0" selected>Приёмов пищи в день</option>' : '<option value="0">Приёмов пищи в день</option>' ?>
    <?= $amount === '3' ? '<option value="3" selected>3</option>' : '<option value="3">3</option>' ?>
    <?= $amount === '4' ? '<option value="4" selected>4</option>' : '<option value="4">4</option>' ?>
    <?= $amount === '5' ? '<option value="5" selected>5</option>' : '<option value="5">5</option>' ?>
    <?= $amount === '6' ? '<option value="6" selected>6</option>' : '<option value="6">6</option>' ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <select name="tar">
                                            <?= $newTarget === '1' ? '<option value="1" selected>Цель</option>' : '<option value="1">Цель</option>' ?>
                                            <?= $newTarget === '0' ? '<option value="0" selected>Поддержания текущего веса</option>' : '<option value="0">Поддержания текущего веса</option>' ?>
    <?= $newTarget === '150' ? '<option value="150" selected>Медленного снижения веса</option>' : '<option value="150">Медленного снижения веса</option>' ?>
    <?= $newTarget === '300' ? '<option value="300" selected>Умеренного снижения веса</option>' : '<option value="300">Умеренного снижения веса</option>' ?>
    <?= $newTarget === '450' ? '<option value="450" selected>Быстрого снижения веса</option>' : '<option value="450">Быстрого снижения веса</option>' ?>
    <?= $newTarget === '600' ? '<option value="600" selected>Экстремального снижения веса</option>' : '<option value="600">Экстремального снижения веса</option>' ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <input type="submit" value="Рассчитать" />
                    </form>
                    <?php
//источник: http://cookvegan.ru/raschet-sutochnoj-potrebnosti-v-kaloriyax-kalkulyator/
                    if ($_POST['func'] === 'sutPotr') {
                        //Расчет базового метаболизма
                        $baseMet = 9.99 * $vesVal + 6.25 * $rostVal - 4.92 * $vozrVal + 1 * ($polVal === 'male' ? 5 : -161);

                        //Расчет калорийности рациона: коэффициент активности
                        $baseMet *= $levelActivity;
                        if ($zhelVesVal > $vesVal) {
                            $baseMet += $newTarget;
                            $kzavtr = 0.25;
                            $kobed = 0.3;
                            $kuzh = 0.45;
                        } else {
                            $baseMet -= $newTarget;
                            $kzavtr = 0.3;
                            $kobed = 0.45;
                            $kuzh = 0.25;
                        }
                        $strCallories = round($baseMet * 0.95, 1) . '-' . round($baseMet * 1.05, 1);
//		var_dump($strCallories);
                        $outCalories = '<table border="1" width="600px"><thead><tr><th></th><th>Белки, г</th><th>Жиры, г</th><th>Углеводы, г</th><th>Килокалории</th></tr></thead><tbody>';
                        switch ($BZHU) {
                            case '1':
                                $arrayBZHU = [
                                    'bel' => 0.3,
                                    'zhir' => 0.2,
                                    'ugl' => 0.5
                                ];
                                break;
                            case '2':
                                $arrayBZHU = [
                                    'bel' => 0.15,
                                    'zhir' => 0.2,
                                    'ugl' => 0.65
                                ];
                                break;
                            case '3':
                                $arrayBZHU = [
                                    'bel' => 0.4,
                                    'zhir' => 0.15,
                                    'ugl' => 0.45
                                ];
                                break;
                            case '4':
                                $arrayBZHU = [
                                    'bel' => 0.65,
                                    'zhir' => 0.2,
                                    'ugl' => 0.15
                                ];
                                break;
                        }

                        //1 г жиров выделяет 9,3 ккал, 1 г углеводов - 4,1 ккал, 1 г белков - 4,1 ккал.
                        switch ($amount) {
                            case '3':
                                //завтрак 30%
                                $strCalZavtr = round($baseMet * 0.95 * $kzavtr, 1) . '-' . round($baseMet * 1.05 * $kzavtr, 1);
                                $strBelki = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Завтрак</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCalZavtr . '</td></tr>';
                                //обед 45%
                                $strCal = round($baseMet * 0.95 * $kobed, 1) . '-' . round($baseMet * 1.05 * $kobed, 1);
                                $strBelki = round($baseMet * 0.95 * $kobed * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kobed * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kobed * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Обед</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //ужин 25%
                                $strCal = round($baseMet * 0.95 * $kuzh, 1) . '-' . round($baseMet * 1.05 * $kuzh, 1);
                                $strBelki = round($baseMet * 0.95 * $kuzh * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kuzh * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kuzh * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Ужин</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //итого
                                $strBelki = round($baseMet * 0.95 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Итого</b></td><td><b>' . $strBelki . '</b></td><td><b>' . $strZhiri . '</b></td><td><b>' . $strUgl . '</b></td><td><b>' . $strCallories . '</b></td></tr></tbody></table>';
                                break;
                            case '4':
                                //завтрак 30%
                                if ($zhelVesVal > $vesVal)
                                    $kzavtr -= 0.1;
                                else
                                    $kuzh -= 0.1;
                                /*
                                  echo '<pre>';
                                  var_dump($baseMet);
                                  var_dump($arrayBZHU);
                                  echo '<br>',$kzavtr;
                                  echo '</pre>';
                                 * 
                                 */
                                $strCalZavtr = round($baseMet * 0.95 * $kzavtr, 1) . '-' . round($baseMet * 1.05 * $kzavtr, 1);
                                $strBelki = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Завтрак</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCalZavtr . '</td></tr>';
                                //обед 45%
                                $strCal = round($baseMet * 0.95 * $kobed, 1) . '-' . round($baseMet * 1.05 * $kobed, 1);
                                $strBelki = round($baseMet * 0.95 * $kobed * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kobed * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kobed * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Обед</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //перекус 10%
                                $strCal = round($baseMet * 0.95 * 0.1, 1) . '-' . round($baseMet * 1.05 * 0.1, 1);
                                $strBelki = round($baseMet * 0.95 * 0.1 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Перекус</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //ужин 15%
                                $strCal = round($baseMet * 0.95 * $kuzh, 1) . '-' . round($baseMet * 1.05 * $kuzh, 1);
                                $strBelki = round($baseMet * 0.95 * $kuzh * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kuzh * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kuzh * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Ужин</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //итого
                                $strBelki = round($baseMet * 0.95 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Итого</b></td><td><b>' . $strBelki . '</b></td><td><b>' . $strZhiri . '</b></td><td><b>' . $strUgl . '</b></td><td><b>' . $strCallories . '</b></td></tr></tbody></table>';
                                break;
                            case '5':
                                if ($zhelVesVal > $vesVal)
                                    $kobed -= 0.1;
                                else
                                    $kzavtr -= 0.1;
                                //завтрак 20%
                                $strCalZavtr = round($baseMet * 0.95 * $kzavtr, 1) . '-' . round($baseMet * 1.05 * $kzavtr, 1);
                                $strBelki = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Завтрак</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCalZavtr . '</td></tr>';
                                //перекус 10%
                                $strCal = round($baseMet * 0.95 * 0.1, 1) . '-' . round($baseMet * 1.05 * 0.1, 1);
                                $strBelki = round($baseMet * 0.95 * 0.1 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Перекус</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //обед 45%
                                $strCal = round($baseMet * 0.95 * $kobed, 1) . '-' . round($baseMet * 1.05 * $kobed, 1);
                                $strBelki = round($baseMet * 0.95 * $kobed * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kobed * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kobed * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Обед</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //перекус 10%
                                $strCal = round($baseMet * 0.95 * 0.1, 1) . '-' . round($baseMet * 1.05 * 0.1, 1);
                                $strBelki = round($baseMet * 0.95 * 0.1 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Перекус</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //ужин 15%
                                $strCal = round($baseMet * 0.95 * $kuzh, 1) . '-' . round($baseMet * 1.05 * $kuzh, 1);
                                $strBelki = round($baseMet * 0.95 * $kuzh * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kuzh * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kuzh * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Ужин</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //итого
                                $strBelki = round($baseMet * 0.95 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Итого</b></td><td><b>' . $strBelki . '</b></td><td><b>' . $strZhiri . '</b></td><td><b>' . $strUgl . '</b></td><td><b>' . $strCallories . '</b></td></tr></tbody></table>';
                                break;
                            case '6':
                                if ($zhelVesVal > $vesVal)
                                    $kuzh -= 0.1;
                                else
                                    $kobed -= 0.1;
                                //завтрак 20%
                                $strCalZavtr = round($baseMet * 0.95 * $kzavtr, 1) . '-' . round($baseMet * 1.05 * $kzavtr, 1);
                                $strBelki = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kzavtr * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kzavtr * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Завтрак</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCalZavtr . '</td></tr>';
                                //перекус 10%
                                $strCal = round($baseMet * 0.95 * 0.1, 1) . '-' . round($baseMet * 1.05 * 0.1, 1);
                                $strBelki = round($baseMet * 0.95 * 0.1 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Перекус</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //обед 35%
                                $strCal = round($baseMet * 0.95 * $kobed, 1) . '-' . round($baseMet * 1.05 * $kobed, 1);
                                $strBelki = round($baseMet * 0.95 * $kobed * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kobed * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kobed * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kobed * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Обед</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //перекус 10%
                                $strCal = round($baseMet * 0.95 * 0.1, 1) . '-' . round($baseMet * 1.05 * 0.1, 1);
                                $strBelki = round($baseMet * 0.95 * 0.1 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Перекус</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //ужин 15%
                                $strCal = round($baseMet * 0.95 * $kuzh, 1) . '-' . round($baseMet * 1.05 * $kuzh, 1);
                                $strBelki = round($baseMet * 0.95 * $kuzh * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $kuzh * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $kuzh * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $kuzh * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Ужин</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //перекус 10%
                                $strCal = round($baseMet * 0.95 * 0.1, 1) . '-' . round($baseMet * 1.05 * 0.1, 1);
                                $strBelki = round($baseMet * 0.95 * 0.1 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * 0.1 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Перекус</b></td><td>' . $strBelki . '</td><td>' . $strZhiri . '</td><td>' . $strUgl . '</td><td>' . $strCal . '</td></tr>';
                                //итого
                                $strBelki = round($baseMet * 0.95 * $arrayBZHU['bel'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['bel'] / 4.1, 1);
                                $strZhiri = round($baseMet * 0.95 * $arrayBZHU['zhir'] / 9.3, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['zhir'] / 9.3, 1);
                                $strUgl = round($baseMet * 0.95 * $arrayBZHU['ugl'] / 4.1, 1) . '-' . round($baseMet * 1.05 * $arrayBZHU['ugl'] / 4.1, 1);
                                $outCalories .= '<tr><td><b>Итого</b></td><td><b>' . $strBelki . '</b></td><td><b>' . $strZhiri . '</b></td><td><b>' . $strUgl . '</b></td><td><b>' . $strCallories . '</b></td></tr></tbody></table>';
                                break;
                        }
                        echo $outCalories;
                    }
//	var_dump($levelActivity);
                    ?>
                </div>
                <div id="tabs-3">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method='post'>
                        <input type="hidden" name="func" value="progVesa" />
                        <fieldset>
                            <table>
                                <tr>
                                    <td>Текущий вес, кг</td>
                                    <td><div class="range_ves" style="width:100px;"></div></td>
                                    <td><input type="text" class="ves" value="<?= $vesVal ?>" name="ves"></td>

                                </tr>
                                <tr>
                                    <td>Желаемый вес, кг</td>
                                    <td><div class="range_zhel_ves" style="width:100px;"></div></td>
                                    <td><input type="text" class="zhel_ves" value="<?= $zhelVesVal ?>" name="zhelves"></td>

                                </tr>
                                <tr>
                                    <td>Разница калорий в день, ккал</td>
                                    <td><div class="range_calories" style="width:100px;"></div></td>
                                    <td><input type="text" class="calories" value="<?= $raznCalVal ?>" name="calories"></td>

                                </tr>
                            </table>
                        </fieldset>
                        <input type="submit" value="Рассчитать" />
                    </form>
                    <?php
                    //источник:
                    //http://zozhnik.ru/pravilo-3500-kkal/
                    if ($_POST['func'] === 'progVesa') {
                        //коэффициент разницы каллорий
                        $kcalories = 7.777;
                        //массив строк
                        if ($zhelVesVal > $vesVal)
                            $strProgArr = array('прибавить', 'повышать');
                        else
                            $strProgArr = array('скинуть', 'снижать');
                        //расчёт веса за неделю
                        $raznVesWeek = round($raznCalVal * 7 / $kcalories);
//    echo $newVes;
                        //расчёт даты к которой будет нужный вес
                        $raznVesa = abs($vesVal - $zhelVesVal);
                        $raznVesa_cal_by_day = $raznCalVal / ($kcalories * 1000);     //сколько в кг будет разница в день
                        $numDays = ceil($raznVesa / $raznVesa_cal_by_day);
                        $newDate = getdate(strtotime("+$numDays day"));
//    var_dump( $newDate['mon']);
                        switch ($newDate['mon']) {
                            case 1:
                                $strMonth = 'января';
                                break;
                            case 2:
                                $strMonth = 'февраля';
                                break;
                            case 3:
                                $strMonth = 'марта';
                                break;
                            case 4:
                                $strMonth = 'апреля';
                                break;
                            case 5:
                                $strMonth = 'мая';
                                break;
                            case 6:
                                $strMonth = 'июня';
                                break;
                            case 7:
                                $strMonth = 'июля';
                                break;
                            case 8:
                                $strMonth = 'августа';
                                break;
                            case 9:
                                $strMonth = 'сентября';
                                break;
                            case 10:
                                $strMonth = 'октября';
                                break;
                            case 11:
                                $strMonth = 'ноября';
                                break;
                            case 12:
                                $strMonth = 'декабря';
                                break;
                        }
                        echo '<div style="text-align:center;color:green"><span>Вы хотите <b>' . $strProgArr[0] . ' ' . $raznVesa . ' кг.</b></span><br><span>При данной разнице калорий вы можете</span><br><span>в среднем <b>' . $strProgArr[1] . '</b> свой вес на <b>' . $raznVesWeek . ' грамм</b> в неделю,</span><br><span>и достигнете желаемого результата к:</span><br><h3>' . $newDate['mday'] . ' ' . $strMonth . ' ' . $newDate['year'] . '</h3></div>';
                    }
                    ?>
                </div>
            </div>        
<?php } 
function slim_ovulation(){
?>
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
<?php } 
function slim_pol(){
?>
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
<?php } 
function slim_pol2(){
?>
            <script>
                            function getPol(){
                                var grKrArr = [['девочка', "мальчик", 'девочка', "мальчик"],["мальчик", 'девочка', "мальчик", 'девочка'],['девочка', "мальчик", "мальчик", 'девочка'],["мальчик", 'девочка', "мальчик", "мальчик"]];
                                var rezFaktArr = [['девочка', "мальчик"], ["мальчик", 'девочка']];
                //                console.log($('#m_gr').val());
                //                console.log($('#f_gr').val());
                //                console.log(grKrArr[0][3]);
                                if($('#m_gr').val() !='0' && $('#f_gr').val() !='0'){
                //                    console.log($('#m_gr option:selected').val());
                                    var text = 'У вас будет ' + grKrArr[$('#m_gr option:selected').val()-1][$('#f_gr option:selected').val()-1] + '!';
                                    $htmlStr = '<tr><td><img src="http://rs1037.pbsrc.com/albums/a454/redwine-n-strawberries/Greetings%20Funny%20or%20Flirty/Happy%20Birthday-Anniversary-Congratulaions/02f.gif?w=280&h=210&fit=crop" width="200" height="200"></td><td><h2>'+ text +'</h2><p>Результаты теста не являются медицинским заключением и для уверенности в поле будущего ребенка необходимо обратится к врачу.</p></td><td><button>Сохранить результат</button><br><br><button onclick="location.reload()">Назад</button></td></tr>';
                                    $('#pol2_t1').html($htmlStr);
                                    return;
                                }else if ($('#m_rez').val() !='0' && $('#f_rez').val() !='0')   {
                                    var text = 'У вас будет ' + rezFaktArr[$('#m_rez option:selected').val()-1][$('#f_rez option:selected').val()-1] + '!';
                                    $htmlStr = '<tr><td><img src="http://rs1037.pbsrc.com/albums/a454/redwine-n-strawberries/Greetings%20Funny%20or%20Flirty/Happy%20Birthday-Anniversary-Congratulaions/02f.gif?w=280&h=210&fit=crop" width="200" height="200"></td><td><h2>'+ text +'</h2><p>Результаты теста не являются медицинским заключением и для уверенности в поле будущего ребенка необходимо обратится к врачу.</p></td><td><button>Сохранить результат</button><br><br><button onclick="location.reload()">Назад</button></td></tr>';
                                    $('#pol2_t1').html($htmlStr);
                                }else alert('Введите оба поля группы крови или оба поля резус-фактора')

                            }
                </script>
            <h1>Определение пола ребенка по крови родителей</h1>
            <p>Всем будущим мамам известно, какую важную роль играют группа крови и резус фактор для здоровья ребенка, но не все знают, что они же могут помочь рассчитать пол будущего ребенка. Многие считают этот тест на определение пола ребенка неправдоподобным, поскольку он делает только один прогноз пола будущего ребенка, то есть по выданным результатам у вас могут рождаться только мальчики или только девочки. Но почему бы не попробовать высчитать пол ребенка с его помощью, а потом сравнить с данными других тестов и УЗИ.</p>
            <table id="pol2_t1">
                <form method="POST" onsubmit="return false">
                    <tr>
                        <td>Мама</td><td>Папа</td><td></td>
                    </tr>
                    <tr>
                        <td>
                            <select id="m_gr">
                                <option selected value="0">Группа крови</option>
                                <option value="1">Первая</option>
                                <option value="2">Вторая</option>
                                <option value="3">Третяя</option>
                                <option value="4">Четвертая</option>
                            </select>
                        </td>
                        <td>
                            <select id="f_gr">
                                <option selected value="0">Группа крови</option>
                                <option value="1">Первая</option>
                                <option value="2">Вторая</option>
                                <option value="3">Третяя</option>
                                <option value="4">Четвертая</option>
                            </select>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <select id="m_rez">
                                <option selected value="0">Резус-фактор</option>
                                <option value="1">Положительный</option>
                                <option value="2">Отрицательный</option>
                            </select>
                        </td>
                        <td>
                            <select id="f_rez">
                                <option selected value="0">Резус-фактор</option>
                                <option value="1">Положительный</option>
                                <option value="2">Отрицательный</option>
                            </select>
                        </td>
                        <td><button onclick="getPol()">Узнать, кто родится</button></td>
                    </tr>                
                </form>
            </table>
<?php } 
function slim_pol3(){
?>
            <script>
                            //данные взяты отсюда: http://baby-calendar.ru/plod/opredelenie-pola/tablicy-opredeleniya/
                            function getPolChinese(){
                                var chineseArr = [
                                    ["девочка", "мальчик", "девочка", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик"],
                                    ["мальчик", "девочка", "мальчик", "девочка", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик", "девочка", "мальчик", "девочка"],
                                    ["девочка", "мальчик", "девочка", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик", "девочка", "мальчик", "мальчик"],
                                    ["мальчик", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка"],
                                    ["девочка", "мальчик", "мальчик", "девочка", "мальчик", "девочка", "девочка", "мальчик", "девочка", "девочка", "девочка", "девочка"],
                                    ["мальчик", "мальчик", "девочка", "мальчик", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "мальчик", "мальчик", "девочка"],
                                    ["мальчик", "девочка", "мальчик", "мальчик", "девочка", "мальчик", "мальчик", "девочка", "девочка", "девочка", "девочка", "девочка"],
                                    ["девочка", "мальчик", "мальчик", "девочка", "девочка", "мальчик", "девочка", "мальчик", "мальчик", "мальчик", "мальчик", "мальчик"],
                                    ["мальчик", "девочка", "мальчик", "девочка", "девочка", "мальчик", "девочка", "мальчик", "девочка", "девочка", "девочка", "девочка"],
                                    ["девочка", "мальчик", "девочка", "мальчик", "девочка", "девочка", "мальчик", "мальчик", "мальчик", "мальчик", "девочка", "мальчик"],
                                    ["мальчик", "девочка", "мальчик", "девочка", "девочка", "девочка", "мальчик", "мальчик", "мальчик", "мальчик", "девочка", "девочка"],
                                    ["девочка", "мальчик", "девочка", "девочка", "мальчик", "мальчик", "девочка", "девочка", "девочка", "мальчик", "мальчик", "мальчик"],
                                    ["мальчик", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "мальчик", "мальчик"],
                                    ["мальчик", "девочка", "мальчик", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "мальчик"],
                                    ["мальчик", "девочка", "мальчик", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "мальчик"],
                                    ["девочка", "мальчик", "девочка", "мальчик", "девочка", "девочка", "девочка", "мальчик", "девочка", "девочка", "девочка", "мальчик"],
                                    ["девочка", "девочка", "мальчик", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "девочка", "мальчик", "мальчик"],
                                    ["мальчик", "мальчик", "девочка", "мальчик", "девочка", "девочка", "девочка", "мальчик", "девочка", "девочка", "мальчик", "мальчик"],
                                    ["девочка", "мальчик", "мальчик", "девочка", "мальчик", "девочка", "девочка", "девочка", "мальчик", "мальчик", "мальчик", "мальчик"],
                                    ["мальчик", "девочка", "мальчик", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик"],
                                    ["девочка", "мальчик", "девочка", "мальчик", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка"],
                                    ["мальчик", "девочка", "мальчик", "мальчик", "мальчик", "девочка", "девочка", "мальчик", "девочка", "девочка", "девочка", "девочка"],
                                    ["девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка"],
                                    ["мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "мальчик", "девочка", "мальчик", "девочка", "мальчик"],
                                    ["девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "мальчик", "девочка", "мальчик", "девочка"],
                                    ["мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "мальчик", "мальчик", "мальчик"],
                                    ["мальчик", "мальчик", "девочка", "мальчик", "мальчик", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "девочка", "девочка"],
                                    ["девочка", "мальчик", "мальчик", "девочка", "девочка", "девочка", "мальчик", "девочка", "мальчик", "девочка", "мальчик", "мальчик"]
                                ];
                                if($('#vozr3_m').val() >= 18 && $('#vozr3_m').val() <= 45){
                                    var text = 'У вас будет ' + chineseArr[$('#vozr3_m').val()-18][$('#month_chinese').val()] + '!';
                                    $htmlStr = '<tr><td><img src="http://rs1037.pbsrc.com/albums/a454/redwine-n-strawberries/Greetings%20Funny%20or%20Flirty/Happy%20Birthday-Anniversary-Congratulaions/02f.gif?w=280&h=210&fit=crop" width="200" height="200"></td><td><h2>'+ text +'</h2><p>Результаты теста не являются медицинским заключением и для уверенности в поле будущего ребенка необходимо обратится к врачу.</p></td><td><button>Сохранить результат</button><br><br><button onclick="location.reload()">Назад</button></td></tr>';
                                    $('#pol3_t1').html($htmlStr);
                                }
                            }
                </script>
            <h1>Определение пола ребенка по китайскому календарю</h1>
            <p>Всем будущим мамам известно, какую важную роль играют группа крови и резус фактор для здоровья ребенка, но не все знают, что они же могут помочь рассчитать пол будущего ребенка. Многие считают этот тест на определение пола ребенка неправдоподобным, поскольку он делает только один прогноз пола будущего ребенка, то есть по выданным результатам у вас могут рождаться только мальчики или только девочки. Но почему бы не попробовать высчитать пол ребенка с его помощью, а потом сравнить с данными других тестов и УЗИ.</p>
            <table id="pol3_t1">
                <form method="POST" onsubmit="return false">
                    <tr>
                        <td>Возраст мамы</td>
                        <td><input type="number" min="18" max="45" id="vozr3_m"></td>
                        <td>Предполагаемый месяц рождения</td>
                        <td>
                            <select id="month_chinese">
                                <option value="0">Январь</option>
                                <option value="1">Февраль</option>
                                <option value="2">Март</option>
                                <option value="3">Апрель</option>
                                <option value="4">Май</option>
                                <option value="5">Июнь</option>
                                <option value="6">Июль</option>
                                <option value="7">Август</option>
                                <option value="8">Сентябрь</option>
                                <option value="9">Октябрь</option>
                                <option value="10">Ноябрь</option>
                                <option value="11">Декабрь</option>
                            </select>
                        </td>
                    </tr>
                    <tr><td colspan="4" align="center"><button onclick="getPolChinese()">Узнать, кто родится</button></td></tr>
                </form>
            </table>
<?php } ?>
