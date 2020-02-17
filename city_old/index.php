<?php
	session_start();
	require_once('common.inc.php');
	include('blocks/header.php');
	require_once($_SERVER['DOCUMENT_ROOT'] . '/temp/ops/users/user.class.php');
?>
<body>
<div id="tempdiv"></div>
<div class="main">
<?php
	$confData = parse_ini_file('common/conf.ini');
		/*
		if (function_exists('curl_init')) {
		 echo 'Работает';
		} else {
		 echo 'Не работает';
		}
*/		
		if(isset($_GET['code'])){
			//var_dump($_GET['code']);
			
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
				//var_dump($tokenInfo);

				if (isset($tokenInfo['access_token'])) {
				    $params['access_token'] = $tokenInfo['access_token'];

				    $userInfo = json_decode(file_get_contents($confData['google_user_info_url'] . '?' . urldecode(http_build_query($params))), true);
				    if (isset($userInfo['id'])) {
				        $userInfo = $userInfo;
				        $result = true;
				    }
				/*
					$paramsUser = array(
						'grant_type' 	=> 'password',
						'client_id' 	=> 'chat',
						'client_secret'	=> 'qwerty',
						'username'		=> $userInfo['email'],
						'password'		=> ''
						);
					echo $tokenOAuth = json_decode(file_get_contents('ops/users/OAuth2/tokenController.php' . '?' . urldecode(http_build_query($paramsUser))), true);*/

					//var_dump($userInfo);
					echo "1<br>";
					//var_dump($_SESSION['access_token']);
					$user = new User();
					$user->addOrUpdateUser(array($userInfo['email'], '', $userInfo['given_name'], $userInfo['family_name'], true));
					$_SESSION['access_token'] = $tokenInfo['access_token'];
					$user->addSessionData($tokenInfo['access_token'], 'chat', $userInfo['email']);
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
		        
			    //var_dump($userInfo);
						
			}
			
			
		}

	/*	
		
	echo "string";
	var_dump(stripos($_SERVER['QUERY_STRING'], 'ops'));
	*/
	if($_SERVER['QUERY_STRING'] && stristr($_SERVER['QUERY_STRING'], 'ops')){
			$googleQueryUrl = http_build_query(array('redirect_uri'  => 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'], 'response_type' => 'code', 'client_id' => $confData['client_id'], 'scope' => $confData['google_scope']));
			$vkQueryUrl = http_build_query(array('client_id' => $confData['vk_client_id'], 'redirect_uri'  => $confData['redirect_uri'], 'response_type' => 'code'));
			include('blocks/nav.php');
			include('blocks/main.php');
	}else {
		$googleQueryUrl = http_build_query(array('redirect_uri'  => $confData['redirect_uri'], 'response_type' => 'code', 'client_id' => $confData['client_id'], 'scope' => $confData['google_scope']));
		$vkQueryUrl = http_build_query(array('client_id' => $confData['vk_client_id'], 'redirect_uri'  => $confData['redirect_uri'], 'response_type' => 'code'));
?>
<div class="entrance">
	<div class="container-fluid">
		<div class="container">
			<div class="row">
				<div class="logo">
					<img src="img/logo.png" alt="logo" class="img-responsive" />
				</div>
			</div>
			<div class="row info">
				<div class="col-lg-4 col-md-4 info-inner">
					<a href="#">
						<span>
							<i>
								<img src="img/info-1.png" alt="logo"/>
							</i>
						</span>
						<strong>Нужна помощь на дороге?</strong>
					</a>
				</div>
				<div class="col-lg-4 col-md-4 info-inner">
					<a href="#">
						<span>
							<i>
								<img src="img/info-2.png" alt="logo"/>
							</i>
						</span>
						<strong>Где сейчас наряды ДПС?</strong>
					</a>
				</div>
				<div class="col-lg-4 col-md-4 info-inner">
					<a href="#">
						<span>
							<i>
								<img src="img/info-3.png" alt="logo"/>
							</i>
						</span>
						<strong>Где произошли аварии?</strong>
					</a>
				</div>
			</div>
			<div class="row your-city">
				<div>
					<span>Ваш город:</span><i class="fa fa-map-marker" aria-hidden="true"></i> <span>Москва</span> <a href="#">X</a>
				</div>
			</div>
			<div class="row login">
				<div class="dropdown dropup">
					<a href="" data-toggle="dropdown" class="dropdown-toggle login-button">Войти в чат города</a>
					<div class="dropdown-menu" id="mainLogin">
						<div class="drop-menu-inner">
							<button type="button" class="close">X</button>
							<div class="drop-name">
								<h4>Вход</h4>
								<a href="" class="reg" onclick='return changeRegBut();'>Регистрация</a>
							</div>
							<form id="mainLogOrReg" onsubmit="return false">
								<div class="form-group">
									<input type="email" placeholder="E-mail" name="email" class="form-control" id="maintxtLogin">
								</div>
								<div class="form-group">
									<input type="password" placeholder="Пароль" name="Password" class="form-control" id="maintxtPassword">
								</div>
							</form>
							<div class="choose-login">
								<div class="social-link">
									<span>вход через соц.сети</span>
									<ul>
									<?= '<li><a href="' . $confData['google_url'] . '?' . urldecode($googleQueryUrl) . '"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>' ?>
										<li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<?= '<li><a href="' . $confData['vk_url'] . '?' . urldecode($vkQueryUrl) . '"><i class="fa fa-vk" aria-hidden="true"></i></a></li>' ?> 
										<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-odnoklassniki" aria-hidden="true"></i></a></li>
										
									</ul>
								</div>
								<div class="button-login">
									<a href="" id="mainSubmitButton" onclick="$('#mainLogOrReg').submit()">Войти</a>
								</div>
							</div>
						</div>					
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
<?php 
	}
	include('blocks/footer.php');
?>