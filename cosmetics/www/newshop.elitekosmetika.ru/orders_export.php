<?
ini_set('display_errors',1);error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
//echo '<pre>';
//var_dump(get_loaded_extensions());
//echo '</pre>';
	define ('DB_HOST', 'localhost');
    define ('DB_NAME', 'newshop1');
    define ('DB_LOGIN', 'usernewshop');
    define ('DB_PASSWORD', 'peSohr4y');
	$errMsg = ""; //сообщение об ошибке
	$resCurDate = "";	  //результат
	$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
	$link->set_charset("utf8");
//	var_dump($link);
	static $dateFrom = '';
	static $dateTo = '';
	static $status = '';
	$tableArr = array();
	if ($_SERVER['REQUEST_METHOD'] == "POST"){	
		$dateFrom = $_POST['datefrom'];
		$dateTo = $_POST['dateto'];
		$status = $_POST['ordersstatus'];
		if(!$_POST['save']){
//			echo "<pre>";
//			var_dump($_POST);
//			echo "</pre>";
			
			$sql = "SELECT DISTINCT order_id FROM cscart_orders WHERE timestamp >= ".strtotime($dateFrom)." AND timestamp <= ".strtotime($dateTo)." AND status='$status'";
			
			if (!$res = $link->query($sql)) {
				echo "SQL: $sql<br>" . 'failed getSelect: (' . $link->errno . ")" . $link->error;
			} else {
				$arrOrders = array();
				while ($row = mysqli_fetch_row($res)) {
					$arrOrders[] = $row[0];
				}
//				echo "<pre>";	
//				var_dump($arrOrders);
//				echo "</pre>";
			}			 
		}elseif ($_POST['save']) {
//			echo "<pre>";
//			var_dump($_POST);
//			echo "</pre>";
			//вывод в файл order_(data).xlsx
			require_once ('./addons/phpexcel/PHPExcel.php');
			// Подключаем класс для вывода данных в формате excel
			require_once('./addons/phpexcel/PHPExcel/Writer/Excel2007.php');
			$fileName = 'orders_from_' . $dateFrom . '_to_' . $dateTo . '_status_' . $_POST['ordersstatus'] . '.xlsx';
			
			$xls = new PHPExcel();
			$xls->setActiveSheetIndex(0);
			$sheet = $xls->getActiveSheet();
//			var_dump($fileName);
			// Подписываем лист
			$sheet->setTitle('export_products');
//			echo "<pre>";
//			var_dump(unserialize($_POST['arr']));
//			echo "</pre>";
			$tableArr = unserialize($_POST['arr']);
			$sheet->setCellValue("A1", 'Название товара');
			$sheet->setCellValue("B1", 'Опции/объём');
			$sheet->setCellValue("C1", 'Модель');
			$sheet->setCellValue("D1", 'Количество');
			$sheet->setCellValue("E1", 'Цена');
			$sheet->getStyle('A1:E1')->getFill()->setFillType(
					PHPExcel_Style_Fill::FILL_SOLID);
			$sheet->getStyle('A1:E1')->getFill()->getStartColor()->setRGB('A2C4C9'); 
			$sheet->getColumnDimension('A')->setWidth(50);
			$sheet->getColumnDimension('B')->setWidth(15);
			$sheet->getColumnDimension('C')->setWidth(15);
			$sheet->getColumnDimension('D')->setWidth(15);
			$sheet->getColumnDimension('E')->setWidth(20);
			$row = $sheet->getHighestRow()+1;			//counter of rows
			//вывод таблицы
			foreach ($tableArr as $arrOrd){
				foreach ($arrOrd as $arr3){
					$sheet->setCellValue("A" . $row, $arr3['product']);
					$sheet->setCellValue("B" . $row, $arr3['options']);
					$sheet->setCellValue("C" . $row, $arr3['product_code']);
					$sheet->setCellValue("D" . $row, $arr3['amount']);
					$sheet->setCellValue("E" . $row, $arr3['amount']*$arr3['price']);
					$row++;
				}
			}
//			 Выводим HTTP-заголовки
			header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
			header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
			header ( "Cache-Control: no-cache, must-revalidate" );
			header ( "Pragma: no-cache" );
			header ( "Content-type: application/vnd.ms-excel" );
			header ( "Content-Disposition: attachment; filename=".$fileName );
			
			$objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
			$objWriter->save('php://output');
		}
	}
	
	//добавляем статусы для фильтра
	$sql = "SELECT t1.description, t2.status
			FROM cscart_status_descriptions t1, cscart_statuses t2 
			WHERE t1.status_id = t2.status_id";
	if(!$res = $link->query($sql)){
		echo "SQL: $sql<br>" . 'failed getSelect: (' . $link->errno . ")" . $link->error;
	}else {	
		$arrSelect= array();
		while ($row = mysqli_fetch_assoc($res)){
			$arrSelect[] = $row;
		}
//		echo "<pre>";	
//		var_dump($arrSelect);
//		echo "</pre>";
	}
?>
<title>Отчет по товарам</title>
<form action="<?php $_SERVER['PHP_SELF'] ?>" method='post' id="f1">
	<label for="datepickerfrom">Дата начала:</label>
	<input type="text" name="datefrom" value="<?=$dateFrom?>" id="datepickerfrom" required />
	<label for="datepickerto">Дата окончания:</label>
	<input type="text" name="dateto" value="<?=$dateTo?>" id="datepickerto" required/>
	<select name="ordersstatus" id="ordersstatus">
<?php
		foreach ($arrSelect as $selectItem){
			if($status === $selectItem['status'])
				echo "<option value='".$selectItem['status']."' selected>".$selectItem['description']."</option>"; 
			else echo "<option value='".$selectItem['status']."'>".$selectItem['description']."</option>"; 
		}
?>
	</select>
	<input type="submit" value="Фильтр" />
</form>
<script src="/js/lib/jquery/jquery.min.js"></script>
<script src="/js/lib/jqueryui/jquery-ui.min.js"></script>
<script src="/js/lib/jqueryui/datepicker-ru.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script>
	$( function() {
		$.datepicker.setDefaults(
			$.extend($.datepicker.regional["ru"])
		);
		$( "#datepickerfrom" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd.mm.yy"
		});
		$( "#datepickerto" ).datepicker({
			changeMonth: true,
			changeYear: true,
			dateFormat: "dd.mm.yy"
		});
		
		
		
	} );
</script>
<?php
class MyIterator extends FilterIterator{

	public function __construct( Iterator $it ){
		parent::__construct( $it );
	}

	//Проверяем, ключи из таблицы
	function accept(){
		if($this->key() === "product" || $this->key() === "variant_name")
			return $this->current();
	}

}	
?>
<!--рисуем таблицу-->
<!--<table border='1' width='600px' id='t1'>
	<caption>Все товары</caption>
	<thead><tr>
		<th>Название товара</th>
		<th>Опции/объём</th>
		<th>Модель</th>
		<th>Количество</th>
		<th>Цена</th>
	</tr></thead><tbody>-->
<?php

	$arrParameters = array();
	foreach ($arrOrders as $order){
		//получаем данные по запросу по каждому товару из всех заказов за данный период времени
		$sqlString = "SELECT `extra` FROM `cscart_order_details` WHERE `order_id`=$order";
		if (!$res = $link->query($sqlString)) {
			echo "SQL: $sqlString<br>" . 'failed getUsers: (' . $link->errno . ")" . $link->error;
		} else {
			$arr = array();
			$products = array();
			$options = array();
			while ($row = mysqli_fetch_row($res)) {
				$arr[] = unserialize($row[0]);
			}
			$iterator = new RecursiveArrayIterator($arr);
			$flatIterator = new RecursiveIteratorIterator($iterator);
			$result = new MyIterator($flatIterator);

			foreach ($result as $key => $value) {
	//			echo $key . ' == ' . $value . '<br>';
				switch ($key) {
					case 'product': $products[] = $value;
						break;
					case 'variant_name':
						$options[] = $value;
						break;
				}
				if (count($options) < count($products) - 1)
					$options[] = '';
			}
			if (count($options) < count($products))
				$options[] = '';
	//		echo "<pre>";	
	//		var_dump($products);
	//		echo "</pre>";
		}

		$sqlString2 = "SELECT `product_code`, price, amount FROM `cscart_order_details` WHERE `order_id`=$order";
		if (!$res = $link->query($sqlString2)) {
			echo "SQL: $sqlString2<br>" . 'failed getUsers: (' . $link->errno . ")" . $link->error;
		} else {
			$arr2 = array();
			while ($row = mysqli_fetch_row($res)) {
				$arr2[] = $row;
			}
			
			$globalArr = array_map(null, $products, $options, $arr2);	
		}
		
		
		/*
		//вывод таблицы
		for($i=0; $i<count($globalArr); $i++){
			echo "<tr>";
			for($j=0; $j<count($globalArr[$i]); $j++){
				if($j == 2){
					echo "<td>".$globalArr[$i][$j][0]."</td>";
					echo "<td>".$globalArr[$i][$j][2]."</td>";
					echo "<td>".$globalArr[$i][$j][2]*$globalArr[$i][$j][1]."</td>";
	//				foreach ($globalArr[$i][$j] as $item){
	//					
	//				}
				}else{
					echo "<td>".$globalArr[$i][$j]."</td>";
				}

			}
			echo "</tr>";
		 * 
		 
		}*/
/*вторая таблица с отсортированными товарами*/		
		$sql = "SELECT `product_code`, price, amount, `extra` FROM `cscart_order_details` WHERE `order_id`=$order";
		if (!$res = $link->query($sql)) {
			echo "SQL: $sql<br>" . 'failed get orders data: (' . $link->errno . ")" . $link->error;
		} else {
			$arrAll = array();
			$j = 0;				//counter
			while ($row = mysqli_fetch_assoc($res)) {
				$arrAll[$j]["product_code"] = $row["product_code"];
				$arrAll[$j]["price"] = $row["price"];
				$arrAll[$j]["amount"] = $row["amount"];
				$unsArr = unserialize($row['extra']);
				$iterator = new RecursiveArrayIterator($unsArr);
				$flatIterator = new RecursiveIteratorIterator($iterator);
				$result = new MyIterator($flatIterator);
				foreach ($result as $key => $value) {
//			echo $key . ' == ' . $value . '<br>';
					switch ($key) {
						case 'product': $arrAll[$j]['product'] = $value;
							break;
						case 'variant_name':
							$arrAll[$j]['options'] = $value;
							break;
					}						
				}
				if(!isset($arrAll[$j]['options'])) $arrAll[$j]['options'] = '';
				$j++;
			}
			$allOrdersArr[] = $arrAll;
			
			
//			echo "Global: <pre>";	
//			var_dump($globalArr);
//			echo "</pre>";
		}
	}
	//форматирование массива
	$arraySpec = array();		//временный массив для хранения опций
	$counter = 0;				//счётчик заказов
	foreach ($allOrdersArr as $arr2){
		for($k=0; $k<count($arr2); $k++){
			if(!isset($arraySpec[$arr2[$k]['product_code']]))
				$arraySpec[$arr2[$k]['product_code']] = $arr2[$k]['options']."_".$k."_".$counter;
			else {
				//для одинаковых опций (НЕЛЬЗЯ В ОПЦИЯХ использовать знак _ !!! иначе надо тут поменять разделитель строк)				

				$arraySpec[$arr2[$k]['product_code']] .= ",".$arr2[$k]['options']."_".$k."_".$counter;

				$tempArr = explode(',', $arraySpec[$arr2[$k]['product_code']]);
//					var_dump($tempArr);
				//необходимо пропустить последний элемент, чтоб не было ложного срабатывания
				for($l=0; $l<count($tempArr)-1; $l++){
					$smOptArr = explode('_', $tempArr[$l]);
					if($arr2[$k]['options'] === $smOptArr[0]){
//							echo $smOptArr[1];
						$allOrdersArr[$counter][$k]['amount'] += $allOrdersArr[$smOptArr[2]][$smOptArr[1]]['amount'];								
						unset($allOrdersArr[$smOptArr[2]][$smOptArr[1]]);						
					}
				}	
			}
		}
		$counter++;
	}
?>
<!--</tbody></table><br><br>-->
<!--рисуем вторую таблицу-->
<table border='1' width='600px' id='t1'>
	<caption><b>Отсортированные товары</b></caption>
	<thead><tr>
		<th>Название товара</th>
		<th>Опции/объём</th>
		<th>Модель</th>
		<th>Количество</th>
		<th>Цена</th>
	</tr></thead><tbody>		
<?php
	//вывод таблицы
	foreach ($allOrdersArr as $arrOrd){
		foreach ($arrOrd as $arr3){
			echo "<tr>";
							
				echo "<td>".$arr3['product']."</td>";
				echo "<td>".$arr3['options']."</td>";
				echo "<td>".$arr3['product_code']."</td>";
				echo "<td>".$arr3['amount']."</td>";
				echo "<td>".$arr3['amount']*$arr3['price']."</td>";

			
			echo "</tr>";
			
		}
		
	}
//		echo "<pre>";	
//		var_dump($allOrdersArr);
//		echo "</pre>";
	$strArr = serialize($allOrdersArr);
	echo "<input type='hidden' name='arr' form='f1' value='".$strArr."' />";
?>
</tbody></table>
<input type="submit" name="save" form="f1" value="Сохранить">