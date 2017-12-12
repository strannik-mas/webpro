<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Basal_temperature</title>
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
    </head>
    <body>
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
    </body>
</html>
