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
use Tygh\Enum\ABSFConfigs;
use Tygh\Registry;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
return true;
}
if ($mode == ab_____(base64_decode('bmJvYmhm'))) {
if (isset($_REQUEST[ab_____(base64_decode('aGZvZnNidWY='))]) and $_REQUEST[ab_____(base64_decode('aGZvZnNidWY='))] == 'Y'){
list($sitemap, $count, $time) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZm9mc2J1ZmB0anVmbmJx')),$_REQUEST);
Registry::get('view')->assign('sitemap', $sitemap);
Registry::get('view')->assign('count', $count);
Registry::get('view')->assign('time', $time);
$sitemap_url = call_user_func(ab_____(base64_decode('Z29gaGZ1YHR1cHNmZ3Nwb3VgdnNt')),call_user_func(ab_____(base64_decode('Z29gaGZ1YHR1cHNmZ3Nwb3VgcXNwdXBkcG0=')))) . ab_____(base64_decode('MGJjYGB0Z2B0anVmbmJxL3lubQ=='));
$p = array();
if (isset($_REQUEST['lang']) and $_REQUEST['lang'] != 'all' and strlen($_REQUEST['lang']) == 2){
$p['lang'] = $_REQUEST['lang'];
}
if (isset($_REQUEST['fixed']) and $_REQUEST['fixed'] != 'all' and in_array($_REQUEST['fixed'], ABSFConfigs::get_page_states())){
$p['fixed'] = $_REQUEST['fixed'];
}
if (!empty($p)){
$sitemap_url .= "?" . call_user_func(ab_____(base64_decode('aXV1cWBjdmptZWBydmZzeg==')),$p);
}
Registry::get('view')->assign('sitemap_url', $sitemap_url);
}
Registry::get('view')->assign('search', $_REQUEST);
Registry::get('view')->assign('avail_langs', call_user_func(ab_____(base64_decode('Z29gaGZ1YHRqbnFtZmBtYm9odmJoZnQ='))));
}
if ($mode == ab_____(base64_decode('d2pmeA=='))) {
list($sitemap) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZm9mc2J1ZmB0anVmbmJx')),$_REQUEST);
header(ab_____(base64_decode('RHBvdWZvdS5VenFmOyF1Znl1MHlubTxkaWJzdGZ1PnZ1Zy45')));
echo $sitemap;
exit;
}
