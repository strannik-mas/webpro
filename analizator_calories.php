<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Анализатор расхода калорий</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"> 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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
                    error : function(html){
                        alert('error!');
            //            $(toupdate).html(html);
                        console.log(html);
                    }
                });
            }
            function getCalories(){
                var totalTime = 0;
                var totalResult = 0;                
                for(var i=0; i<$('#t1 tbody tr').length; i++){
//                    console.log($($('#t1 tbody tr')[i]).attr('class'));
                    var indexRow = $($('#t1 tbody tr')[i]).attr('class');
                    var time = $('#time_'+indexRow).val();
                    if(time.indexOf('*') != -1){
                        var arr = time.split('*',2);
                        time = arr[0]*arr[1];
//                        console.log(time);
                    }
                        
                    var activity = $('#type2_'+indexRow).val();
                    var weight = $('#ves').val();
                    if(weight && $('#type1_'+indexRow).val() !== 'def' && time){
//                    console.log($('#t1 tbody tr').length);
                    
                        
                        if(weight <= 70){
                            res = ((activity*1 - ((70 - weight) * activity * 1.4444) / 100) * time / 60).toFixed(1)
                        } else {
                            res = ((activity*1 + ((weight - 70) * activity * 1.3333) / 100) * time / 60).toFixed(1)
                        }
                        $('#calories_'+indexRow).text(res);
                    
                        totalTime += time*1;
                        totalResult += res*1;
                    }
                }
                if(totalResult > 0 && totalTime > 0){
                    $footHtmlString = '<tr><td></td><td colspan="2">Итого:</td><td>' + totalTime + '</td><td>' + totalResult.toFixed(1) + '</td></tr>';
                    $('#t1 tfoot').html($footHtmlString);  
                }else $('#t1 tfoot').html('');
                  
            }
            
            function addEvents(){
                var str = '';
                $('#t1 tbody tr').each(function(index, element){
                    var indexRow = $(element).attr('class');
                    $('#type1_'+indexRow).on('change', function(){
                        newrequest("getSelAct", $("#type2_"+indexRow), $("#type1_"+indexRow).val());
                        getCalories();
                    });
                    $('#type2_'+indexRow).on('change', getCalories);
                    $('#time_'+indexRow).on("keyup", function(eventObject){
//                        console.log(eventObject.key);
                        if(eventObject.key !=='*' && eventObject.key !=='Backspace' && eventObject.key !=='Delete' && (eventObject.key < '0' || eventObject.key > '9')){
                            this.value = str;
                        }                        
                        else {
                            if(eventObject.key !=='Backspace' && eventObject.key !=='Delete')
                                str += eventObject.key;
                            else str = this.value;
                            getCalories();
                        }
                    });
                });
            }
            
        </script>
    </head>
    <body>
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

    </body>
</html>