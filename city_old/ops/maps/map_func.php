<?php
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
	function getAllLabels($type){
//		var_dump($type); exit();
		global $link;
		if(!empty($type)){
			if($type[0] == 'All' || $type[0] == 'AllDiv')
				$sql = "SELECT `lat`, `long`, `desc`, `type`, `title`, `user` FROM googlemaplabels";
			else {
				$sql = "SELECT `lat`, `long`, `desc`, `type` FROM googlemaplabels WHERE `type`=$type[0]";
				for($i=1; $i<count($type);$i++){				
					$sql .= " OR `type`=$type[$i]";
				}
			}
		}
		
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
?>