<?php
$confData = parse_ini_file('common/conf.ini');
		if(isset($_GET['code'])){
			$result = false;
			if(substr($_GET['code'], 0, 2) == '4/'){
				//for Google
				if($_GET['ops']){
					$redURI = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']."?ops=".$_GET['ops'];
				}else $redURI = $confData['redirect_uri'];
				$params = array(			
			        'code'          => $_GET['code'],
					'client_id'     => $confData['client_id'],
			        'client_secret' => $confData['client_secret'],
			        'redirect_uri'  => $redURI,
			        'grant_type'    => 'authorization_code'
				);

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_URL, $confData['google_url_token']);
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				$result = curl_exec($curl);
				curl_close($curl);

				$tokenInfo = json_decode($result, true);

				if (isset($tokenInfo['access_token'])) {
				    $params['access_token'] = $tokenInfo['access_token'];

				    $userInfo = json_decode(file_get_contents($confData['google_user_info_url'] . '?' . urldecode(http_build_query($params))), true);
				    if (isset($userInfo['id'])) {
				        $userInfo = $userInfo;
				        $result = true;
				    }
					print_r($userInfo);
				}
			}else{
				//for VK
				$result = false;
				$params = array(
					'code' => $_GET['code'],
			        'client_id' => $confData['vk_client_id'],
			        'client_secret' => $confData['vk_secret_key'],        
			        'redirect_uri' => $confData['redirect_uri']
			    );
				$tokenVK = json_decode(file_get_contents($confData['vk_url_token'] . '?' . urldecode(http_build_query($params))), true);
				//var_dump($tokenVK);
				if (isset($token['access_token'])) {
			        $params = array(
			            'uids'         => $tokenVK['user_id'],
			            'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
			            'access_token' => $tokenVK['access_token']
			        );

			        $userInfo = json_decode(file_get_contents($confData['vk_user_info_url'] . '?' . urldecode(http_build_query($params))), true);
			    }
			    
			    if (isset($userInfo['response'][0]['uid'])) {
		            $userInfo = $userInfo['response'][0];
		            $result = true;
		        }
			}
		}
	if($_SERVER['QUERY_STRING'] && stristr($_SERVER['QUERY_STRING'], 'ops')){
			$googleQueryUrl = http_build_query(array('redirect_uri'  => 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'], 'response_type' => 'code', 'client_id' => $confData['client_id'], 'scope' => $confData['google_scope']));
			$vkQueryUrl = http_build_query(array('client_id' => $confData['vk_client_id'], 'redirect_uri'  => $confData['redirect_uri'], 'response_type' => 'code'));
			include('blocks/nav.php');
			include('blocks/main.php');
			include('blocks/minichat.php');
	}else {
		$googleQueryUrl = http_build_query(array('redirect_uri'  => $confData['redirect_uri'], 'response_type' => 'code', 'client_id' => $confData['client_id'], 'scope' => $confData['google_scope']));
		$vkQueryUrl = http_build_query(array('client_id' => $confData['vk_client_id'], 'redirect_uri'  => $confData['redirect_uri'], 'response_type' => 'code'));
	}
?>
<span>вход через соц.сети</span>
<ul>
	<?= '<li><a href="' . $confData['google_url'] . '?' . urldecode($googleQueryUrl) . '"><i class="fa fa-google-plus" aria-hidden="true"></i>google</a></li>' ?>
	<li>
		<a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a>
	</li>
	<?= '<li><a href="' . $confData['vk_url'] . '?' . urldecode($vkQueryUrl) . '"><i class="fa fa-vk" aria-hidden="true"></i>VK</a></li>' ?>
	<li>
		<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
	</li>
	<li>
		<a href="#"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a>
	</li>

</ul>