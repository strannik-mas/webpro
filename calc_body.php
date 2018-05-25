<?php
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
	
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
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
<html>
    <head>
        <meta charset="UTF-8">
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
                        if(Number($('.zhel_ves').val()) > Number($('.ves').val())){
                            changeOption(false);
                        }else changeOption(true);
					}
				});
				$('.range_ves').slider( "value", $('.ves').val());
				$('.range_zhel_ves').slider({
					min: 20,
					max: 170,
					slide: function(event, ui){
						$('.zhel_ves').val(ui.value);
                        if(Number($('.zhel_ves').val()) > Number($('.ves').val())){
                            changeOption(false);
                        }else changeOption(true);
					}
				});
                
				$('.range_zhel_ves').slider( "value", $('.zhel_ves').val());
                if(Number($('.zhel_ves').val()) > Number($('.ves').val())){
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
            function changeOption(flag = true){
                console.dir(flag);
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
    </head>
    <body>
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
						<td><input type="text" class="rost" value="<?=$rostVal?>" name="rost"></td>
						</tr>
						<tr>
							<td>Текущий вес, кг</td>
							
							<td><div class="range_ves" style="width:100px;"></div></td>
							<td><input type="text" class="ves" value="<?=$vesVal?>" name="ves"></td>
						
						</tr>
						<tr>
							<td>Возраст, лет</td>
							
							<td><div class="range_vozr" style="width:100px;"></div></td>
							<td><input type="text" class="vozr" value="<?=$vozrVal?>" name="vozr"></td>
							
						</tr>
						</table>
					</fieldset>
					<input type="submit" value="Рассчитать" />
				</form>
<?php
//	function idealWeight(){
	if($_POST['func']==='idealWeight'){
//		echo '<pre>';
//		var_dump($_POST);
//		echo '</pre>';
		$out = '<table>';
		//ИМТ: вес (в килограммах) разделить на возведенный в квадрат рост (в метрах), то есть ИМТ = вес (кг): (рост (м))2
		$imt = round($_POST['ves']/pow($_POST['rost']/100, 2), 1);
		if($imt >= 20 && $imt <=25){
			$strImt = '<b style="color:green">нормальный вес</b>';
		}elseif ($imt <20) {
			$strImt = '<b style="color:red">недостаток веса</b>';
		}elseif ($imt > 25 && $imt <=30) {
			$strImt = '<b style="color:yellow">легкое превышение веса</b>';
		}elseif ($imt > 30 && $imt <=35) {
			$strImt = '<b style="color:grey">превышение веса</b>';
		}elseif ($imt > 35) {
			$strImt = '<b style="color:red">ожирение</b>';
		}
		$out .= "<tr><td>Индекс массы тела: </td><td>$imt</td><td>$strImt</td></tr>";
//		echo $strImt;
		//индекс Брока - взял формулу из трех источников: 
		//https://planetcalc.ru/35/ 
		//https://ru.wikipedia.org/wiki/%D0%98%D0%BD%D0%B4%D0%B5%D0%BA%D1%81_%D0%BC%D0%B0%D1%81%D1%81%D1%8B_%D1%82%D0%B5%D0%BB%D0%B0
		//https://beregifiguru.ru/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B-%D0%B8%D0%B4%D0%B5%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D0%B3%D0%BE-%D0%B2%D0%B5%D1%81%D0%B0/%D0%98%D0%BD%D0%B4%D0%B5%D0%BA%D1%81-%D0%91%D1%80%D0%BE%D0%BA%D0%B0
		
		if($_POST['vozr'] <= 30)
			$kVBr = 0.89;
		elseif($_POST['vozr'] > 50)
			$kVBr = 1.06;
		else $kVBr = 1;
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
		$iBr = round(($_POST['rost']-100)*($_POST['sex']==='male' ? 0.9 : 0.85)*$kVBr, 1);
		if($_POST['ves']>=$iBr*0.9 && $_POST['ves']<=$iBr*1.1)
			$strBr = '<b style="color:green">нормальный вес</b>';
		elseif($_POST['ves']<$iBr*0.9)
			$strBr = '<b style="color:red">недостаток веса</b>';
		elseif($_POST['ves']>$iBr*1.1)
			$strBr = '<b style="color:red">превышение веса</b>';
//		var_dump($iBr);
//		echo $iBr*0.9.'-'.$iBr*1.1;
		$strIBr = $iBr*0.9.'-'.$iBr*1.1;
		$out .= "<tr><td>Идеальный вес (по Брока), кг:  </td><td>$strIBr</td><td>$strBr</td></tr>";
		
		//расчет по Девайну:
		//http://www.klinrek.ru/calcs/ibma.htm
		if($_POST['sex']==='male')
			$iDev = round(50+2.3*(($_POST['rost']/2.54)-60));
		else $iDev = round(45.5+2.3*(($_POST['rost']/2.54)-60));
		if($_POST['ves']>=$iDev*0.9 && $_POST['ves']<=$iDev*1.1)
			$strDev = '<b style="color:green">нормальный вес</b>';
		elseif($_POST['ves']<$iDev*0.9)
			$strDev = '<b style="color:red">недостаток веса</b>';
		elseif($_POST['ves']>$iDev*1.1)
			$strDev = '<b style="color:red">превышение веса</b>';
//		var_dump($iDev);
//		echo $iDev*0.9.'-'.$iDev*1.1;
		$strIDev = $iDev*0.9.'-'.$iDev*1.1;
//		echo $strDev;
		$out .= "<tr><td>Идеальный вес (по Девайну), кг: </td><td>$strIDev</td><td>$strDev</td></tr>";
		
		//по Робинсону
		//http://www.klinrek.ru/calcs/ibma.htm
		//https://beregifiguru.ru/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D1%8B-%D0%B8%D0%B4%D0%B5%D0%B0%D0%BB%D1%8C%D0%BD%D0%BE%D0%B3%D0%BE-%D0%B2%D0%B5%D1%81%D0%B0/%D0%A4%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D0%B0-%D0%A0%D0%BE%D0%B1%D0%B8%D0%BD%D1%81%D0%BE%D0%BD%D0%B0
		if($_POST['sex']==='male')
			$iRob = round(52+1.9*(($_POST['rost']/2.54)-60));
		else $iRob = round(49+1.7*(($_POST['rost']/2.54)-60));
		if($_POST['ves']>=$iRob*0.9 && $_POST['ves']<=$iRob*1.1)
			$strRob = '<b style="color:green">нормальный вес</b>';
		elseif($_POST['ves']<$iRob*0.9)
			$strRob = '<b style="color:red">недостаток веса</b>';
		elseif($_POST['ves']>$iRob*1.1)
			$strRob = '<b style="color:red">превышение веса</b>';
//		var_dump($iRob);
//		echo $iRob*0.9.'-'.$iRob*1.1;
		$strIRob = $iRob*0.9.'-'.$iRob*1.1;
//		echo $strRob;
		$out .= "<tr><td>Идеальный вес (по Робинсону), кг: </td><td>$strIRob</td><td>$strRob</td></tr>";
		
		//по Миллеру
		//https://medicinelab.ru/formula-idealnogo-vesa.html#Формула Миллера (1983)
		if($_POST['sex']==='male')
			$iMill = round(56.2+1.41*(($_POST['rost']/2.54)-60));
		else $iMill = round(53.1+1.36*(($_POST['rost']/2.54)-60));
		if($_POST['ves']>=$iMill*0.9 && $_POST['ves']<=$iMill*1.1)
			$strMill = '<b style="color:green">нормальный вес</b>';
		elseif($_POST['ves']<$iMill*0.9)
			$strMill = '<b style="color:red">недостаток веса</b>';
		elseif($_POST['ves']>$iMill*1.1)
			$strMill = '<b style="color:red">превышение веса</b>';
//		var_dump($iMill);
//		echo $iMill*0.9.'-'.$iMill*1.1;
		$strIMill = $iMill*0.9.'-'.$iMill*1.1;
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
								<td><input type="text" class="rost" value="<?=$rostVal?>" name="rost"></td>
							</tr>
							<tr>
								<td>Возраст, лет</td>
								<td><div class="range_vozr" style="width:100px;"></div></td>
								<td><input type="text" class="vozr" value="<?=$vozrVal?>" name="vozr"></td>

							</tr>
							<tr>
								<td>Текущий вес, кг</td>
								<td><div class="range_ves" style="width:100px;"></div></td>
								<td><input type="text" class="ves" value="<?=$vesVal?>" name="ves"></td>

							</tr>
							<tr>
								<td>Желаемый вес, кг</td>
								<td><div class="range_zhel_ves" style="width:100px;"></div></td>
								<td><input type="text" class="zhel_ves" value="<?=$zhelVesVal?>" name="zhelves"></td>

							</tr>
							<tr>
								<td colspan="3">
									<select name="activity">
										<?= $levelActivity==='0' ? '<option value="0"  selected >Уровень активности</option>' : '<option value="0">Уровень активности</option>' ?>
										<?= $levelActivity==='1' ? '<option value="1" selected>Базовая (полный покой)</option>' : '<option value="1">Базовая (полный покой)</option>' ?>
										<?= $levelActivity==='1.2' ? '<option value="1.2" selected>Низкая (сидячий образ жизни)</option>' : '<option value="1.2">Низкая (сидячий образ жизни)</option>' ?>
										<?= $levelActivity==='1.38' ? '<option value="1.38" selected>Малая (1-3 раза в неделю легкие тренировки)</option>' : '<option value="1.38">Малая (1-3 раза в неделю легкие тренировки)</option>' ?>
										<?= $levelActivity==='1.55' ? '<option value="1.55" selected>Средняя (3-5 раз в неделю умеренные тренировки)</option>' : '<option value="1.55">Средняя (3-5 раз в неделю умеренные тренировки)</option>' ?>
										<?= $levelActivity==='1.73' ? '<option value="1.73" selected>Высокая (5-7 раз в неделю интенсивные тренировки)</option>' : '<option value="1.73">Высокая (5-7 раз в неделю интенсивные тренировки)</option>' ?>				
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<select name="system">
										<?= $BZHU==='0' ? '<option value="0" selected>Система питания (баланс БЖУ)</option>' : '<option value="0">Система питания (баланс БЖУ)</option>' ?>
										<?= $BZHU==='1' ? '<option value="1" selected>Сбалансированная (30/20/50)</option>' : '<option value="1">Сбалансированная (30/20/50)</option>' ?>
										<?= $BZHU==='2' ? '<option value="2" selected>Низкобелковая (15/20/65)</option>' : '<option value="2">Низкобелковая (15/20/65)</option>' ?>
										<?= $BZHU==='3' ? '<option value="3" selected>Низкожировая (40/15/45)</option>' : '<option value="3">Низкожировая (40/15/45)</option>' ?>
										<?= $BZHU==='4' ? '<option value="4" selected>Низкоуглеводная (65/20/15)</option>' : '<option value="4">Низкоуглеводная (65/20/15)</option>' ?>									
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<select name="amount">
										<?= $amount==='0' ? '<option value="0" selected>Приёмов пищи в день</option>' : '<option value="0">Приёмов пищи в день</option>' ?>
										<?= $amount==='3' ? '<option value="3" selected>3</option>' : '<option value="3">3</option>' ?>
										<?= $amount==='4' ? '<option value="4" selected>4</option>' : '<option value="4">4</option>' ?>
										<?= $amount==='5' ? '<option value="5" selected>5</option>' : '<option value="5">5</option>' ?>
										<?= $amount==='6' ? '<option value="6" selected>6</option>' : '<option value="6">6</option>' ?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<select name="tar">
										<?= $newTarget==='1' ? '<option value="1" selected>Цель</option>' : '<option value="1">Цель</option>' ?>
										<?= $newTarget==='0' ? '<option value="0" selected>Поддержания текущего веса</option>' : '<option value="0">Поддержания текущего веса</option>' ?>
										<?= $newTarget==='150' ? '<option value="150" selected>Медленного снижения веса</option>' : '<option value="150">Медленного снижения веса</option>' ?>
										<?= $newTarget==='300' ? '<option value="300" selected>Умеренного снижения веса</option>' : '<option value="300">Умеренного снижения веса</option>' ?>
										<?= $newTarget==='450' ? '<option value="450" selected>Быстрого снижения веса</option>' : '<option value="450">Быстрого снижения веса</option>' ?>
										<?= $newTarget==='600' ? '<option value="600" selected>Экстремального снижения веса</option>' : '<option value="600">Экстремального снижения веса</option>' ?>
									</select>
								</td>
							</tr>
						</table>
					</fieldset>
					<input type="submit" value="Рассчитать" />
				</form>
<?php
//источник: http://cookvegan.ru/raschet-sutochnoj-potrebnosti-v-kaloriyax-kalkulyator/
	if($_POST['func']==='sutPotr'){
		//Расчет базового метаболизма
		$baseMet = 9.99*$vesVal+6.25*$rostVal-4.92*$vozrVal+1*($polVal==='male' ? 5 : -161);

		//Расчет калорийности рациона: коэффициент активности
		$baseMet *= $levelActivity;
		if($zhelVesVal > $vesVal){
			$baseMet += $newTarget;
			$kzavtr = 0.25;
			$kobed = 0.3;
			$kuzh = 0.45;
		}else {
			$baseMet -= $newTarget;
			$kzavtr = 0.3;
			$kobed = 0.45;
			$kuzh = 0.25;
		}
		$strCallories = round($baseMet*0.95, 1).'-'.round($baseMet*1.05, 1);
//		var_dump($strCallories);
		$outCalories = '<table border="1" width="600px"><thead><tr><th></th><th>Белки, г</th><th>Жиры, г</th><th>Углеводы, г</th><th>Килокалории</th></tr></thead><tbody>';
		switch ($BZHU){
			case '1':
				$arrayBZHU = [ 
					'bel'	=> 0.3, 
					'zhir'	=> 0.2,
					'ugl'	=> 0.5
					];
				break;
			case '2':
				$arrayBZHU = [
					'bel'	=> 0.15, 
					'zhir'	=> 0.2,
					'ugl'	=> 0.65					
				];
				break;
			case '3':
				$arrayBZHU = [
					'bel'	=> 0.4, 
					'zhir'	=> 0.15,
					'ugl'	=> 0.45
				];
				break;
			case '4':
				$arrayBZHU = [
					'bel'	=> 0.65, 
					'zhir'	=> 0.2,
					'ugl'	=> 0.15
				];
				break;
		}

        //1 г жиров выделяет 9,3 ккал, 1 г углеводов - 4,1 ккал, 1 г белков - 4,1 ккал.
		switch ($amount){
			case '3':
				//завтрак 30%
				$strCalZavtr = round($baseMet*0.95*$kzavtr, 1).'-'.round($baseMet*1.05*$kzavtr, 1);
				$strBelki = round($baseMet*0.95*$kzavtr*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kzavtr*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kzavtr*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Завтрак</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCalZavtr.'</td></tr>';
				//обед 45%
				$strCal = round($baseMet*0.95*$kobed, 1).'-'.round($baseMet*1.05*$kobed, 1);
				$strBelki = round($baseMet*0.95*$kobed*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kobed*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kobed*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Обед</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//ужин 25%
				$strCal = round($baseMet*0.95*$kuzh, 1).'-'.round($baseMet*1.05*$kuzh, 1);
				$strBelki = round($baseMet*0.95*$kuzh*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kuzh*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kuzh*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Ужин</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//итого
				$strBelki = round($baseMet*0.95*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Итого</b></td><td><b>'.$strBelki.'</b></td><td><b>'.$strZhiri.'</b></td><td><b>'.$strUgl.'</b></td><td><b>'.$strCallories.'</b></td></tr></tbody></table>';
				break;
			case '4':
				//завтрак 30%
				if($zhelVesVal > $vesVal)
					$kzavtr -= 0.1;
				else $kuzh -= 0.1;
                /*
echo '<pre>';
var_dump($baseMet);
var_dump($arrayBZHU);
echo '<br>',$kzavtr;
echo '</pre>';
                 * 
                 */
				$strCalZavtr = round($baseMet*0.95*$kzavtr, 1).'-'.round($baseMet*1.05*$kzavtr, 1);
				$strBelki = round($baseMet*0.95*$kzavtr*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kzavtr*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kzavtr*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Завтрак</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCalZavtr.'</td></tr>';
				//обед 45%
				$strCal = round($baseMet*0.95*$kobed, 1).'-'.round($baseMet*1.05*$kobed, 1);
				$strBelki = round($baseMet*0.95*$kobed*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kobed*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kobed*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Обед</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//перекус 10%
				$strCal = round($baseMet*0.95*0.1, 1).'-'.round($baseMet*1.05*0.1, 1);
				$strBelki = round($baseMet*0.95*0.1*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*0.1*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*0.1*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Перекус</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//ужин 15%
				$strCal = round($baseMet*0.95*$kuzh, 1).'-'.round($baseMet*1.05*$kuzh, 1);
				$strBelki = round($baseMet*0.95*$kuzh*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kuzh*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kuzh*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Ужин</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//итого
				$strBelki = round($baseMet*0.95*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Итого</b></td><td><b>'.$strBelki.'</b></td><td><b>'.$strZhiri.'</b></td><td><b>'.$strUgl.'</b></td><td><b>'.$strCallories.'</b></td></tr></tbody></table>';
				break;
			case '5':
				if($zhelVesVal > $vesVal)
					$kobed -= 0.1;
				else $kzavtr -= 0.1;
				//завтрак 20%
				$strCalZavtr = round($baseMet*0.95*$kzavtr, 1).'-'.round($baseMet*1.05*$kzavtr, 1);
				$strBelki = round($baseMet*0.95*$kzavtr*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kzavtr*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kzavtr*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Завтрак</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCalZavtr.'</td></tr>';
				//перекус 10%
				$strCal = round($baseMet*0.95*0.1, 1).'-'.round($baseMet*1.05*0.1, 1);
				$strBelki = round($baseMet*0.95*0.1*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*0.1*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*0.1*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Перекус</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//обед 45%
				$strCal = round($baseMet*0.95*$kobed, 1).'-'.round($baseMet*1.05*$kobed, 1);
				$strBelki = round($baseMet*0.95*$kobed*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kobed*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kobed*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Обед</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//перекус 10%
				$strCal = round($baseMet*0.95*0.1, 1).'-'.round($baseMet*1.05*0.1, 1);
				$strBelki = round($baseMet*0.95*0.1*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*0.1*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*0.1*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Перекус</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//ужин 15%
				$strCal = round($baseMet*0.95*$kuzh, 1).'-'.round($baseMet*1.05*$kuzh, 1);
				$strBelki = round($baseMet*0.95*$kuzh*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kuzh*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kuzh*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Ужин</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//итого
				$strBelki = round($baseMet*0.95*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Итого</b></td><td><b>'.$strBelki.'</b></td><td><b>'.$strZhiri.'</b></td><td><b>'.$strUgl.'</b></td><td><b>'.$strCallories.'</b></td></tr></tbody></table>';
				break;
			case '6':
				if($zhelVesVal > $vesVal)
					$kuzh -= 0.1;
				else $kobed -= 0.1;
				//завтрак 20%
				$strCalZavtr = round($baseMet*0.95*$kzavtr, 1).'-'.round($baseMet*1.05*$kzavtr, 1);
				$strBelki = round($baseMet*0.95*$kzavtr*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kzavtr*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kzavtr*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kzavtr*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Завтрак</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCalZavtr.'</td></tr>';
				//перекус 10%
				$strCal = round($baseMet*0.95*0.1, 1).'-'.round($baseMet*1.05*0.1, 1);
				$strBelki = round($baseMet*0.95*0.1*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*0.1*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*0.1*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Перекус</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//обед 35%
				$strCal = round($baseMet*0.95*$kobed, 1).'-'.round($baseMet*1.05*$kobed, 1);
				$strBelki = round($baseMet*0.95*$kobed*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kobed*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kobed*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kobed*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Обед</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//перекус 10%
				$strCal = round($baseMet*0.95*0.1, 1).'-'.round($baseMet*1.05*0.1, 1);
				$strBelki = round($baseMet*0.95*0.1*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*0.1*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*0.1*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Перекус</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//ужин 15%
				$strCal = round($baseMet*0.95*$kuzh, 1).'-'.round($baseMet*1.05*$kuzh, 1);
				$strBelki = round($baseMet*0.95*$kuzh*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$kuzh*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$kuzh*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$kuzh*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Ужин</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//перекус 10%
				$strCal = round($baseMet*0.95*0.1, 1).'-'.round($baseMet*1.05*0.1, 1);
				$strBelki = round($baseMet*0.95*0.1*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*0.1*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*0.1*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*0.1*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Перекус</b></td><td>'.$strBelki.'</td><td>'.$strZhiri.'</td><td>'.$strUgl.'</td><td>'.$strCal.'</td></tr>';
				//итого
				$strBelki = round($baseMet*0.95*$arrayBZHU['bel']/4.1, 1).'-'.round($baseMet*1.05*$arrayBZHU['bel']/4.1, 1);
				$strZhiri = round($baseMet*0.95*$arrayBZHU['zhir']/9.3, 1).'-'.round($baseMet*1.05*$arrayBZHU['zhir']/9.3, 1);
				$strUgl = round($baseMet*0.95*$arrayBZHU['ugl']/4.1, 1).'-'.round($baseMet*1.05*$arrayBZHU['ugl']/4.1, 1);
				$outCalories .= '<tr><td><b>Итого</b></td><td><b>'.$strBelki.'</b></td><td><b>'.$strZhiri.'</b></td><td><b>'.$strUgl.'</b></td><td><b>'.$strCallories.'</b></td></tr></tbody></table>';
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
								<td><input type="text" class="ves" value="<?=$vesVal?>" name="ves"></td>

							</tr>
							<tr>
								<td>Желаемый вес, кг</td>
								<td><div class="range_zhel_ves" style="width:100px;"></div></td>
								<td><input type="text" class="zhel_ves" value="<?=$zhelVesVal?>" name="zhelves"></td>

							</tr>
							<tr>
								<td>Разница калорий в день, ккал</td>
								<td><div class="range_calories" style="width:100px;"></div></td>
								<td><input type="text" class="calories" value="<?=$raznCalVal?>" name="calories"></td>

							</tr>
						</table>
					</fieldset>
					<input type="submit" value="Рассчитать" />
				</form>
<?php
    //источник:
    //http://zozhnik.ru/pravilo-3500-kkal/
if($_POST['func']==='progVesa'){
    //коэффициент разницы каллорий
    $kcalories = 7.777;
    //массив строк
    if($zhelVesVal > $vesVal)
        $strProgArr = array ('прибавить', 'повышать');
    else $strProgArr = array ('скинуть', 'снижать');
    //расчёт веса за неделю
    $raznVesWeek = round($raznCalVal*7/$kcalories);
//    echo $newVes;
    //расчёт даты к которой будет нужный вес
    $raznVesa = abs($vesVal - $zhelVesVal);
    $raznVesa_cal_by_day = $raznCalVal/($kcalories*1000);     //сколько в кг будет разница в день
    $numDays = ceil($raznVesa/$raznVesa_cal_by_day);
    $newDate = getdate(strtotime("+$numDays day"));
//    var_dump( $newDate['mon']);
    switch ($newDate['mon']){
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
    echo '<div style="text-align:center;color:green"><span>Вы хотите <b>'.$strProgArr[0].' '.$raznVesa.' кг.</b></span><br><span>При данной разнице калорий вы можете</span><br><span>в среднем <b>'.$strProgArr[1].'</b> свой вес на <b>'.$raznVesWeek.' грамм</b> в неделю,</span><br><span>и достигнете желаемого результата к:</span><br><h3>'.$newDate['mday'].' '.$strMonth.' '.$newDate['year'].'</h3></div>';
}
?>
			</div>
		</div>
	</body>
</html>