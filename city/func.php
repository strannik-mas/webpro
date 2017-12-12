<?php

    define ('DB_HOST', 'localhost');
    define ('DB_NAME', 'city');
    define ('DB_LOGIN', 'root');
    define ('DB_PASSWORD', '');
    $link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
    $link->set_charset("utf8");
    
    //run function from get query
	//var_dump($_GET);
    //$_GET["f"]($_GET["p"]);
	$_POST["f"]($_POST["p"]);
    
    function clearStr($data){
		global $link;
		$pattern = "/[^a-zA-Z0-9]/";
		
        return preg_replace($pattern, "", $data);
    }
    
    function result2Array($data, $f=true){
        $arr = array();
        while($f ? ($row = mysqli_fetch_assoc($data)) : ($row = mysqli_fetch_row($data)))
            $arr[] = $row;
        return $arr; 
    }
    
    function getTable($flag, $sqlQuery = ''){
        global $link;
        try{
            
            $sql = $sqlQuery ? $sqlQuery : "SELECT SQL_NO_CACHE * FROM users";
			
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
		$colNames = getTable(true);
		
		//field for filters the results
		//echo "<thead><tr><td colspan='".(count($colNames)+1)."'></td></tr></thead>";
		
        echo "<tr>";        
        for($i=0; $i<=count($colNames);$i++){
			if ($i != count($colNames)) {
				if(!empty($params) && $params[0] == $colNames[$i]->name){
					echo "<th class='headtable'>{$colNames[$i]->name}" . ($params[1] ? 
						"<span id='ar_up' style='color: grey'>&#9650;</span><br><span id='ar_down' style='color: black'>&#9660;</span>" 
					: "<span id='ar_up' style='color: black'>&#9650;</span><br><span id='ar_down' style='color: grey'>&#9660;</span>") . "</th>";
				}else {
					echo "<th class='headtable'>{$colNames[$i]->name}<span id='ar_up' style='color: black'>&#9650;</span><br><span id='ar_down' style='color: black'>&#9660;</span></th>";
				}
			} else echo "<th class='deleterows'><p>Delete rows</p><label for='select_all'  style='font-weight:normal; font-size:10px'>Select all</label><input id='select_all' type='checkbox'></th>";
		}
			
        echo "</tr>";
		
		if(empty($params)){
			//get table		
			$resTable = getTable(false);
		}else {
			//filtering
			if($params[2] == 'true'){
				if($params[1] == 'All'){
					$sqlString ="SELECT * FROM users WHERE";
					for($i=0; $i<count($colNames);$i++){
						$sqlString .= " {$colNames[$i]->name} LIKE '%{$params[0]}%'";
						if($i < (count($colNames)-1))
							$sqlString .= " OR";
					}						
				}else $sqlString ="SELECT * FROM users WHERE $params[1] LIKE '%$params[0]%'";
				$resTable = getTable(false, $sqlString);		
			}else{
				//sorting
				$resTable = getTable(false, "SELECT * FROM users ORDER BY $params[0] " . ($params[1] ? "ASC" : "DESC"));
			}			
		}
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
				
				if($colNames[$i]->name == 'id'){
					echo "<tr class='id_$item[$i]'>";
					echo "<td class='id'>$item[$i]</td>";
					$id = $item[$i];
				}					
				elseif($colNames[$i]->type == 252)
					echo "<td class='{$colNames[$i]->name}'><textarea class='editable {$colNames[$i]->name} $item[0] $type' type='text' disabled>$item[$i]</textarea></td>";
				else
					echo "<td class='{$colNames[$i]->name}'><input class='editable {$colNames[$i]->name} $item[0] $type' type='text' disabled value='$item[$i]'></td>";
			}
			echo "<td><input class='del $id' type='checkbox'/><a href='#' onclick='return false;' class='del_link $id'></a></td>";	
            echo "</tr>";
        }
		
    }
	
	
    function insertColumn($params){
//		$arr = explode(',', $params);
		global $link;
		if ($params[3])
			$sql = "ALTER TABLE users ADD COLUMN $params[0] $params[1]($params[2],$params[3]) NOT NULL";
		else
			$sql = "ALTER TABLE users ADD COLUMN $params[0] $params[1] ($params[2])";
        if(!$link->query($sql)){
            echo "SQL query: $sql", '<br>failed add column: (' . $link->errno . ")" . $link->error;
        }else getAllTable();
    }
    
    function deleteColumn($name){
	global $link;
        $sql = "ALTER TABLE users DROP COLUMN $name[0]";
        if(!$link->query($sql)){
            echo 'failed delete column: (' . $link->errno . ")" . $link->error;
        }else	getAllTable ();
    }
	
	function getSelectionColums($params){		
		$colNames = getTable(true);
//		echo "<pre>";
//    	var_dump($colNames);
//    	echo "</pre>";
		if(empty($params)){
			for($i=1; $i<count($colNames);$i++){
				echo "<option value='{$colNames[$i]->name}'>{$colNames[$i]->name}</option>";
			}
		}else{
			echo "<option selected>$params[0]</option>";
			for($i=1; $i<count($colNames);$i++){
				echo "<option value='{$colNames[$i]->name}'>{$colNames[$i]->name}</option>";
			}
		}            
	}
	
	function getUsers($params = array()){
		global $link;
		if (empty($params)) $sqlString ="SELECT username FROM users";
		else $sqlString = "SELECT $params[1] FROM $params[0]";
		if(!$res = $link->query($sqlString)){
            echo "SQL: $sqlString<br>" . 'failed getUsers: (' . $link->errno . ")" . $link->error;
        }else {
//		echo "<pre>";
//    	var_dump($res);
////    echo "</pre>";
//		$arr = result2Array($res);
		$arr= array();
//			for($i=1; $i<count($arr);$i++)
			while ($row = mysqli_fetch_row($res)[0]){
				if (empty($params)) echo "<option value='$row'>$row</option>";
				else {
					$arr[] = $row;
				}				
			}
			if(!empty($arr)) echo json_encode($arr);
		}		     
	}
	
	function updateTable($params){
//		$arr = explode(',', $params);
//		var_dump($params);
		global $link;
        $sql = "UPDATE users SET users." . $params[1] . "='" . $params[0] . "' WHERE users.id = $params[2]";
		//echo "$sql";
        if(!$link->query($sql)){
            echo "SQL: $sql<br>" . 'failed update table: (' . $link->errno . ")" . $link->error;
        }else {
			//echo "$sql";
			getAllTable();
		}
	}
	
	function insertRow(){
		global $link;
		$sql = "INSERT INTO users () VALUES ()";
		if(!$link->query($sql)){
            echo "SQL: $sql<br>" . 'failed insert row: (' . $link->errno . ")" . $link->error;
        }else {
			//echo "$sql";
			getAllTable();
		}
	}
	
	function deleteRow($id){
		global $link;
		$sql = "DELETE FROM users WHERE users.id = $id";
		if(!$link->query($sql)){
            echo "SQL: $sql<br>" . 'failed delete row: (' . $link->errno . ")" . $link->error;
        }else {
			//echo "$sql";
			getAllTable();
		}
	}
	

	
	//add map coords
	function addGoogleMapLabel($params){
		global $link;
		$sql = "INSERT INTO `googlemaplabels` (`user`, `lat`, `long`, `desc`) 
				VALUES ('$params[0]', '$params[1]', '$params[2]', '$params[3]')";
		$link->query($sql);
//		if($link->query($sql)) echo 'Данные внесены';
//		else echo "SQL: $sql<br>" . 'failed insert map data: (' . $link->errno . ")" . $link->error;
		getAllLabels();
	}
	
	//get all coords and description
	function getAllLabels(){
		global $link;
		$sql = "SELECT `lat`, `long`, `desc` FROM googlemaplabels";
		if(!$res = $link->query($sql)){
            echo "SQL: $sql<br>" . 'failed get labels: (' . $link->errno . ")" . $link->error;
        }else {
		$arr = result2Array($res, false);
			for($i=0; $i<count($arr);$i++){
				$j=1;
				foreach ($arr[$i] as $key=>$label){
					echo $label.($j < count($arr[$i]) ? "&&" : "");
					$j++;
				}
				echo ($i<count($arr)-1 ? "|" : "");
			}				
		}
	}
	
	/**
	 * Function for insert data for Push Notifications service
	 * in field `from` and `to` function select id from users table
	 * @var array $params			Array of parametest sending by user
	 * @var int $fromID				ID user which try send push notify
	 * @var int $toID				ID user-recipient to which a message is sent
	 * @var string $sql				simple MySQL query string to insert data to `notifications` table in database 
	 */
	function insertNotify($params){
		global $link;
		$fromID = mysqli_fetch_row($link->query("SELECT id FROM users 
				WHERE username='$params[2]'"))[0];
		$toID = mysqli_fetch_row($link->query("SELECT id FROM users 
				WHERE username='$params[3]'"))[0];
		$sql = "INSERT INTO `notifications` (`unit`, `type`, `from`, `to`, `message`, `status`, `url`) 
				VALUES ('$params[0]', '$params[1]', $fromID, $toID, '$params[4]', 0, '$params[5]')";
//	$link->query($sql);
		if($link->query($sql)) echo 'Данные внесены';
		else echo "SQL: $sql<br>" . 'failed insert notify data: (' . $link->errno . ")" . $link->error;
	}