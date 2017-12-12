<?php
//ini_set('display_errors',1);error_reporting(E_ALL);
   
	//var_dump($link);
    
    function getTable($flag, $sqlQuery = '', $tableName = ''){
        global $link;
        try{
        	
            $sql = $sqlQuery ? $sqlQuery : "SELECT * FROM $tableName";

            $result = $link->query($sql);
            

            if (!is_object($result)) 
                    throw new Exception($link->error);
            if($flag){
				while ($row = $result->fetch_field()) {
					$finfo[] = $row;
				}
//					echo "<pre>";
//					var_dump($finfo);
//					echo "</pre>";
				return $finfo;
			}                
            else return result2Array($result, false);
        }catch(Exception $e){
				echo $e->getMessage();
                return false;
        }	
    }
    
    function getAllTable($params = array()){
//		if(!empty($params)) {
//			$sqlString ="SELECT * FROM users WHERE $params[1] LIKE '%$params[0]%'";
//			var_dump($params[2]);
//			if($params[2]){
//				$sqlString ='SELECT * FROM users WHERE';
//				switch ($params[1]){
//					case 'All':
//						for($i=0; $i<count($colNames);$i++){
//							$sqlString .= " $colNames[$i]->name LIKE '%{$params[0]}%' OR";
//						}
//						$sqlString .= "DER BY id";
//						break;
//				}
//			var_dump($sqlString);
//			exit();
//			}
//		}
//			$str = "SELECT * FROM users ORDER BY $params[0]" . ($params[1] ? "DESC" : "ASC");
//			var_dump($str);
//			exit();}	
		
		//get column info
		$colNames = getTable(true, '', $params[1]);
		//var_dump($params);
		//field for filters the results
		//echo "<thead><tr><td colspan='".(count($colNames)+1)."'></td></tr></thead>";
		//head of table
        echo "<thead><tr>";        
        for($i=0; $i<=count($colNames);$i++){
			if ($i != count($colNames)) {
				if(!empty($params) && $params[4] == $colNames[$i]->name){
					echo "<th class='headtable'>{$colNames[$i]->name}" . ($params[5] ? 
						"<span class='ar_up' id='arup-{$colNames[$i]->name}' style='color: grey'>&#9650;</span><br><span class='ar_down' id='ardown-{$colNames[$i]->name}' style='color: black'>&#9660;</span>" 
					: "<span class='ar_up' id='arup-{$colNames[$i]->name}' style='color: black'>&#9650;</span><br><span class='ar_down' id='ardown-{$colNames[$i]->name}' style='color: grey'>&#9660;</span>") . "</th>";
				}else {
					echo "<th class='headtable'>{$colNames[$i]->name}<span class='ar_up' id='arup-{$colNames[$i]->name}' style='color: black'>&#9650;</span><br><span class='ar_down' id='ardown-{$colNames[$i]->name}' style='color: black'>&#9660;</span></th>";
				}
			} else echo "<th class='deleterows'><p>Delete rows</p><label for='select_all'  style='font-weight:normal; font-size:10px'>Select all</label><input id='select_all' type='checkbox'></th>";
		}
			
        echo "</tr></thead><tbody>";
		if($params[0] == 'gettable'){
			//get table		
			$resTable = getTable(false, '', $params[1]);
			//var_dump($params);
		}else {
			//filtering
				if($params[3] != 'null'){
					if($params[2] == 'All'){
						$sqlString ="SELECT * FROM `$params[1]` WHERE";
						for($i=0; $i<count($colNames);$i++){
							$sqlString .= " `{$colNames[$i]->name}` LIKE '%{$params[3]}%'";
							if($i < (count($colNames)-1))
								$sqlString .= " OR";
						}						
					}else {
						/*
						if(!isset($_SESSION['temptable'])){
							//$sqlString = "DROP VIEW IF EXISTS ".session_id()."; ";
							$sqlString = "CREATE VIEW `temp` AS SELECT * FROM `$params[1]` WHERE `$params[2]` LIKE '%$params[0]%'";
							$_SESSION['temptable'] = true;
						}else{
							
						}
						*/
						$sqlString = "SELECT * FROM `$params[1]` WHERE `$params[2]` LIKE '%$params[3]%'";
					}
					if($params[4])
						$sqlString .= " ORDER BY `$params[4]` " . ($params[5] ? "ASC" : "DESC");
				}
				
				//sorting
				
				if($params[4] && $params[3] == 'null')
					$sqlString = "SELECT * FROM `$params[1]` ORDER BY `$params[4]` " . ($params[5] ? "ASC" : "DESC");
				$resTable = getTable(false, $sqlString);	
				//var_dump($resTable);
				
		}
		//for editable cells
		$id = 0;
        foreach ($resTable as $item){
            for($i=0; $i<count($item);$i++){
				//switch field type from database
				switch ($colNames[$i]->type){
					case 3:
						$type = "INT";	break;
					case 246:
						$type = "DECIMAL"; break;
					case 252:
						$type = "TEXT"; break;
					case 253:
						$type = "VARCHAR"; break;
				}				
				
				//if($colNames[$i]->name == 'id'){
				if($i == 0){
					echo "<tr class='id_$item[$i]'>";
					echo "<td class='id'>$item[$i]</td>";
					$id = $item[$i];
				}					
				elseif($colNames[$i]->type == 252)
					echo "<td class='{$colNames[$i]->name}'><textarea class='editable {$colNames[$i]->name} $item[0] $type {$colNames[0]->name}' type='text' disabled>$item[$i]</textarea></td>";
				else
					echo "<td class='{$colNames[$i]->name}'><input class='editable {$colNames[$i]->name} $item[0] $type {$colNames[0]->name}' type='text' disabled value='$item[$i]'></td>";
			}
			//передаём имя ключевого столбца в класс для универсального удаления любой таблицы. Для этого ключевое поле должно быть первым
			echo "<td><input class='del $id {$colNames[0]->name}' type='checkbox'/><a href='#' onclick='return false;' class='del_link $id {$colNames[0]->name}'></a></td>";	
            echo "</tr>";
        }
        echo "</tbody>";
		
    }
	
	
    function insertColumn($params){
//		$arr = explode(',', $params);
		global $link;
		if ($params[4])
			$sql = "ALTER TABLE $params[1] ADD COLUMN $params[0] $params[2]($params[3],$params[4]) NOT NULL";
		else
			$sql = "ALTER TABLE $params[1] ADD COLUMN $params[0] $params[2] ($params[3])";
        if(!$link->query($sql)){
            echo "SQL query: $sql", '<br>failed add column: (' . $link->errno . ")" . $link->error;
        }else getAllTable(array('gettable', $params[1]));
    }
    
    function deleteColumn($params){
	global $link;
        $sql = "ALTER TABLE $params[1] DROP COLUMN $params[0]";
        if(!$link->query($sql)){
            echo 'failed delete column: (' . $link->errno . ")" . $link->error;
        }else	getAllTable (array('gettable', $params[1]));
    }
	
	function getSelectionColums($params){
		if($params[0] == "Select tables"){
			$colNames = getTable(false, "SHOW TABLES");
		}else if($params[0] == "Тип"){
			$colNames = getTable(false, "", $params[1]);
		}else if($params[0] == "names" || $params[0] == "All"){
			$colNames = getTable(true, "", $params[1]);
		}
			
		//$colNames = getTable(true, $sql);
		/*
		echo "<pre>";
    	var_dump($params);
    	echo "</pre>";
    	*/
		if(empty($params) || $params[0] == "names"){
			for($i=1; $i<count($colNames);$i++){
				echo "<option value='{$colNames[$i]->name}'>{$colNames[$i]->name}</option>";
			}
		}else{
			echo "<option selected>$params[0]</option>";
			if($params[0] == "Тип"){
				foreach ($colNames as $name) {
					//var_dump($name);
					echo "<option value='{$name[1]}'>{$name[1]}</option>";
				}
			}elseif($params[0] == "Select tables")	{
				foreach ($colNames as $name) {
					//var_dump($name);
					echo "<option value='{$name[0]}'>{$name[0]}</option>";
				}
			}			
			elseif($params[0] == "names" || $params[0] == "All"){
				for($i = ($params[0] == "All" ? 0 : 1); $i<count($colNames);$i++){
					echo "<option value='{$colNames[$i]->name}'>{$colNames[$i]->name}</option>";
				}
			}
			
		}            
	}
	
	
	function updateTable($params){
//		$arr = explode(',', $params);
		var_dump($params);
		global $link;
        $sql = "UPDATE $params[1] SET $params[1]." . $params[2] . "='" . $params[0] . "' WHERE $params[1].$params[4] = $params[3]";
		//echo "$sql";
        if(!$link->query($sql)){
            echo "SQL: $sql<br>" . 'failed update table: (' . $link->errno . ")" . $link->error;
        }else {
			//echo "$sql";
			if(!$params[7] || $params[5] == 'null')
				getAllTable(array('gettable', $params[1]));
			else getAllTable(array(null, $params[1], $params[5], $params[6], $params[7], $params[8]));
		}
	}
	
	function insertRow($params){
		global $link;
		$sql = "INSERT INTO $params[1] () VALUES ()";
		if(!$link->query($sql)){
            echo "SQL: $sql<br>" . 'failed insert row: (' . $link->errno . ")" . $link->error;
        }else {
			//echo "$sql";
			getAllTable(array($params[0], $params[1]));
		}
	}
	
	function deleteRow($params){
		global $link;
		$sql = "DELETE FROM $params[1] WHERE $params[1].{$params[2]} = '$params[0]'";
		if(!$link->query($sql)){
			echo "$params[2]<br>";
            echo "SQL: $sql<br>" . 'failed delete row: (' . $link->errno . ")" . $link->error;
        }else {
			echo "$sql";
			getAllTable(array('gettable', $params[1]));
		}
	}
/*
	function deleteView($params){
		global $link;
		$sql = "DROP VIEW IF EXISTS temp";
		unset($_SESSION);
		if($link->query($sql)) echo 'Представление temp удалено';
		else echo "SQL: $sql<br>" . 'failed delete VIEW from database: (' . $link->errno . ")" . $link->error;
	}*/