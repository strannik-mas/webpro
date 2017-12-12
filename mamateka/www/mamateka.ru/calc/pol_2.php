<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Blood_group</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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
    </head>
    <body>
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
    </body>
</html>
