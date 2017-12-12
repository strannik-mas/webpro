<?php
    define ('DB_HOST', 'localhost');
    define ('DB_NAME', 'newshop1');
    define ('DB_LOGIN', 'usernewshop');
    define ('DB_PASSWORD', 'peSohr4y');
	
	$link = mysqli_connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
	$link->set_charset("utf8");
//	var_dump($link);

$_POST["f"]($_POST["p"]);
//	var_dump($_POST);
	function getProducts($params){
		
		global $link;
		$sqlString = "SELECT $params[1] FROM $params[0] WHERE $params[1] LIKE '%$params[2]%' LIMIT 10";
		
		if(!$res = $link->query($sqlString)){
            echo "SQL: $sqlString<br>" . 'failed getUsers: (' . $link->errno . ")" . $link->error;
        }else {		
			$arr= array();
				while ($row = mysqli_fetch_row($res)){

					$arr[] = $row;
				}
	//		echo "<pre>";
	//    	var_dump($arr);
	//		echo "</pre>";
				if(!empty($arr)) echo json_encode($arr);
		}
		 	 
	}
 