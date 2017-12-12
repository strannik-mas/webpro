<?php
	function clearStralphanumeric($data){
		global $link;
		$pattern = "/[^a-zA-Z0-9]/";
		
        return preg_replace($pattern, "", $data);
    }
    
    function result2Array($data, $f=true, $userID = null, $notNull = false){
		$strHTML = '';				//html-сниппет ответа
        $arr = array();
		$i = 0;
        while($f ? ($row = mysqli_fetch_assoc($data)) : ($row = mysqli_fetch_row($data))){
			if($notNull && $row[0] == NULL)
				continue;	
            $arr[$i] = $row;
			if($userID != null){
				if($row['from'] == $userID){
					$strHTML .= '<div class="chat-inner">
											<div class="chat-item row">
												<div class="chat-user-info">
													<div class="chat-user">
														<a href=""><span class="img-inner"><img src="/'.$row['path'].'/'.$row['filename'].'" alt="user" class="img-circle img-responsive mCS_img_loaded"></span></a>
													</div>
													<div class="chat-message-info">
														<a class="user-name">'.$row['username'].'</a><span><span class="data">'.$row['date'].'</span></span>
													</div>
												</div>
												<div class="chat-message">
													<p>
														'.$row['message'].'
													</p>
												</div>
											</div>
										</div>';
				}else {
					$strHTML .= '<div class="chat-inner answer">
											<div class="chat-item row">
												<div class="chat-user-info">
													
													<div class="chat-message-info">
														<a class="user-name">'.$row['username'].'</a><span><span class="data">'.$row['date'].'</span></span>
													</div>
													<div class="chat-user">
														<a href=""><span class="img-inner"><img src="/'.$row['path'].'/'.$row['filename'].'" alt="user" class="img-circle img-responsive mCS_img_loaded"></span></a>
													</div>
												</div>
												<div class="chat-message">
													<p>
														'.$row['message'].'
													</p>
												</div>
											</div>
										</div>';
					
				}
			}
			$i++;
		}
		if($strHTML == '')	
			return $arr; 
		else return $strHTML;
    }

    function clearStr($data){
        return mysqli_real_escape_string($this->_link, trim(strip_tags($data)));
    }