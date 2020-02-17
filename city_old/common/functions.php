<?php
	function clearStralphanumeric($data){
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

    function clearStr($data){
        return mysqli_real_escape_string($this->_link, trim(strip_tags($data)));
    }