<?php
/*******************************************************************************************
*   ___  _          ______                     _ _                _                        *
*  / _ \| |         | ___ \                   | (_)              | |              © 2016   *
* / /_\ | | _____  _| |_/ /_ __ __ _ _ __   __| |_ _ __   __ _   | |_ ___  __ _ _ __ ___   *
* |  _  | |/ _ \ \/ / ___ \ '__/ _` | '_ \ / _` | | '_ \ / _` |  | __/ _ \/ _` | '_ ` _ \  *
* | | | | |  __/>  <| |_/ / | | (_| | | | | (_| | | | | | (_| |  | ||  __/ (_| | | | | | | *
* \_| |_/_|\___/_/\_\____/|_|  \__,_|_| |_|\__,_|_|_| |_|\__, |  \___\___|\__,_|_| |_| |_| *
*                                                         __/ |                            *
*                                                        |___/                             *
* ---------------------------------------------------------------------------------------- *
* This is commercial software, only users who have purchased a valid license and  accept   *
* to the terms of the License Agreement can install and use this program.                  *
* ---------------------------------------------------------------------------------------- *
* website: https://cs-cart.alexbranding.com                                                *
*   email: info@alexbranding.com                                                           *
*******************************************************************************************/
if (!defined('BOOTSTRAP')) {die('Access denied');}
use Tygh\ABSF;
use Tygh\Registry;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
call_user_func(ab_____(base64_decode('Z29gdXN2dHVmZWB3YnN0')),ab_____(base64_decode('YmNgYHRnYHN2bWZgZWJ1Yg==')));
$suffix = "";
if ($mode == ab_____(base64_decode('dnFlYnVm'))) {
if (call_user_func(ab_____(base64_decode('anRgYnNzYno=')),$_REQUEST[ab_____(base64_decode('YmNgYHRnYHN2bWZgZWJ1Yg=='))]) and !empty($_REQUEST[ab_____(base64_decode('YmNgYHRnYHN2bWZgZWJ1Yg=='))]) and call_user_func(ab_____(base64_decode('an'.'RgY'.'nNz'.'Yno=')),call_user_func(ab_____(base64_decode('V'.'Xpo'.'aV1CQ'.'0JOYm9'.'iaG'.'ZzOz'.'tkaWBi')),true)) ) {
$rule_id = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOzt2cWVidWZgc3ZtZg==')),$_REQUEST[ab_____(base64_decode('YmNgYHRnYHN2bWZgZWJ1Yg=='))], $_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))], DESCR_SL);
if ($rule_id === false) {
call_user_func(ab_____(base64_decode('Z29gdGJ3ZmBxcHR1YGVidWI=')),ab_____(base64_decode('YmNgYHRnYHN2bWZgZWJ1Yg==')));
return array (CONTROLLER_STATUS_REDIRECT,
!empty($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]) ? 'ab__sf_rules.update?rule_id=' . $_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))] : 'ab__sf_rules.add');
}
}
if (!empty($rule_id)) {
$suffix = "update?rule_id=" . $rule_id;
} else {
$suffix = 'manage';
}
}
if ($mode == ab_____(base64_decode('bmBlZm1mdWY=')) or $mode == ab_____(base64_decode('ZWZtZnVm'))){
if (isset($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]) and !empty($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))])){
call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztlZm1mdWZgc3ZtZnQ=')),$_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]);
return array (CONTROLLER_STATUS_OK, "ab__sf_rules.manage");
}
}
if ($mode == ab_____(base64_decode('aGZvZnNidWY='))){
if (isset($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]) and !empty($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))])){
/*f*/ABSF::generate_names(/*/t*/(array)$_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]);
return array (CONTROLLER_STATUS_OK, "ab__sf_rules.manage");
}
}
return array (CONTROLLER_STATUS_OK, 'ab__sf_rules.' . $suffix);
}
if ($mode == ab_____(base64_decode('bmJvYmhm'))) {
$params = $_REQUEST;
$params[ab_____(base64_decode('aGZ1YGdmYnV2c2Zgb2JuZg=='))] = true;
$params[ab_____(base64_decode('aGZ1YGRidWZocHNqZnRgZWZ0ZHNqcXVqcG8='))] = true;
if (isset($_SESSION['ab__sf_rules']['params'])) {
if (!isset($params['feature_id'])){
$params['feature_id'] = isset($_SESSION['ab__sf_rules']['params']['feature_id'])?$_SESSION['ab__sf_rules']['params']['feature_id']:0;
}
if (!isset($params['cid'])){
$params['cid'] = isset($_SESSION['ab__sf_rules']['params']['cid'])?$_SESSION['ab__sf_rules']['params']['cid']:0;
}
$params = array_merge($_SESSION['ab__sf_rules'], $params);
}
list($ab__sf_rules, $search) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgc3ZtZnQ=')),$params, Registry::get(ab_____(base64_decode('dGZ1dWpvaHQvQnFxZmJzYm9kZi9iZW5qb2Bxc3BldmR1dGBxZnNgcWJoZg=='))), DESCR_SL);
$_SESSION['ab__sf_rules']['params'] = $search;
Registry::get('view')->assign(ab_____(base64_decode('YmNgYHRnYHN2bWZ0')), $ab__sf_rules);
Registry::get('view')->assign('search', $search);
}
if ($mode == ab_____(base64_decode('YmVl')) or $mode == ab_____(base64_decode('dnFlYnVm')) or $mode == ab_____(base64_decode('bmJvYmhm'))){
$p = array (ab_____(base64_decode('d2JzamJvdXQ=')) => false,
ab_____(base64_decode('dHVidXZ0ZnQ=')) => array('A'),
ab_____(base64_decode('Z2ZidXZzZmB1enFmdA==')) => ABSF::$feature_rules,);
list($f) = call_user_func(ab_____(base64_decode('Z29gaGZ1YHFzcGV2ZHVgZ2ZidXZzZnQ=')),$p, 0, DESCR_SL);
Registry::get('view')->assign(ab_____(base64_decode('Z2ZidXZzZnQ=')), $f);
$f = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgYmR1andmYGdqbXVmc3Q=')));
Registry::get('view')->assign(ab_____(base64_decode('Z2ptdWZzdA==')), $f);
list($_) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgcWJ1dWZzb3Q=')),$p, Registry::get('settings.Appearance.admin_products_per_page'), DESCR_SL);
Registry::get('view')->assign(ab_____(base64_decode('cWJ1dWZzb3Q=')), $_);
}
if ($mode == ab_____(base64_decode('dnFlYnVm'))) {
if (isset($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]) and intval($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))])) {
$rule_id = intval($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]);
$p = array (ab_____(base64_decode('c3ZtZmBqZQ==')) => array ($rule_id), ab_____(base64_decode('aGZ1YGdmYnV2c2Zgb2JuZg==')) => true);
list($ab__sf_rules) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgc3ZtZnQ=')),$p, 0, DESCR_SL);
Registry::get('view')->assign('r', $ab__sf_rules[$rule_id]);
}
}
if ($mode == ab_____(base64_decode('aGZvZnNidWZgZHNwbw=='))){
$cron_key = call_user_func(ab_____(base64_decode('dHZjdHVz')),trim(call_user_func(ab_____(base64_decode('VXpoaV1TZmhqdHVzejs7aGZ1')),ab_____(base64_decode('YmVlcG90L2JjYGB0ZnBgZ2ptdWZzdC9kc3BvYGxmeg==')))), 0, 10);
if (isset($_REQUEST[ab_____(base64_decode('ZHNwb2BsZno='))])
and strlen($cron_key) >= 5 and strlen($cron_key) <= 10
and $_REQUEST[ab_____(base64_decode('ZHNwb2BsZno='))] == $cron_key
and isset($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]) and !empty($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))])){
call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZm9mc2J1ZmBvYm5mdA==')),array($_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))]));
call_user_func(ab_____(base64_decode('Z29gZmRpcA==')),__(ab_____(base64_decode('YmNgYHRnL29wdWpnamRidWpwb3QvaGZvZnNidWZgb2JuZnRgY3pgc3ZtZmBqdGBkcG5xbWZ1Zg==')),array('[id]'=>$_REQUEST[ab_____(base64_decode('c3ZtZmBqZQ=='))])));
}else{
call_user_func(ab_____(base64_decode('Z29gZmRpcA==')),__(ab_____(base64_decode('YmNgYHRnL2Zzc3BzdC9kc3BvYGxmeg=='))));
}
exit;
}
