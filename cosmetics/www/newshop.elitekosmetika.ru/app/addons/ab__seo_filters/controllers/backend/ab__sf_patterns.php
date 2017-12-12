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
if (!defined('BOOTSTRAP')) {
die('Access denied');
}
use Tygh\ABSF;
use Tygh\Registry;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
call_user_func(ab_____(base64_decode('Z29gdXN2dHVmZWB3YnN0')),ab_____(base64_decode('YmNgYHRnYHN2bWZgZWJ1Yg==')));
$suffix = "";
if ($mode == ab_____(base64_decode('dnFlYnVm'))) {
if (!empty($_REQUEST[ab_____(base64_decode('YmNgYHRnYHFidXVmc29gZWJ1Yg=='))]) and is_array($_REQUEST[ab_____(base64_decode('YmNgYHRnYHFidXVmc29gZWJ1Yg=='))])) {
$pattern = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOzt2cWVidWZgcWJ1dWZzbw==')),$_REQUEST[ab_____(base64_decode('YmNgYHRnYHFidXVmc29gZWJ1Yg=='))], $_REQUEST[ab_____(base64_decode('cWJ1dWZzbw=='))], DESCR_SL);
if (!empty($pattern)) {
$suffix = "update?pattern=" . $_REQUEST['pattern'];
} else {
$suffix = 'manage';
}
}
}
return array (CONTROLLER_STATUS_OK, 'ab__sf_patterns.' . $suffix);
}
if ($mode == ab_____(base64_decode('bmJvYmhm'))) {
$params = array();
list($_, $search) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgcWJ1dWZzb3Q=')),$params, Registry::get(ab_____(base64_decode('dGZ1dWpvaHQvQnFxZmJzYm9kZi9iZW5qb2Bxc3BldmR1dGBxZnNgcWJoZg=='))), DESCR_SL);
Registry::get('view')->assign(ab_____(base64_decode('YmNgYHRnYHFidXVmc290')), $_);
Registry::get('view')->assign('search', $search);
}
if ($mode == ab_____(base64_decode('dnFlYnVm'))) {
if (!empty($_REQUEST[ab_____(base64_decode('cWJ1dWZzbw=='))])) {
$p = array (ab_____(base64_decode('cWJ1dWZzbw==')) => array ($_REQUEST[ab_____(base64_decode('cWJ1dWZzbw=='))]));
list($_) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgcWJ1dWZzb3Q=')),$p, 0, DESCR_SL);
Registry::get('view')->assign(ab_____(base64_decode('cWJ1dWZzb3Q=')), $_);
Registry::get('view')->assign(ab_____(base64_decode('cWJ1dWZzbw==')), $_REQUEST[ab_____(base64_decode('cWJ1dWZzbw=='))]);
}
}