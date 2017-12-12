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
call_user_func(ab_____(base64_decode('Z29gdXN2dHVmZWB3YnN0')),ab_____(base64_decode('YmNgYHRnYG9ibmZgZWJ1Yg==')));
$suffix = "";
if ($mode == ab_____(base64_decode('dnFlYnVm'))) {
if (call_user_func(ab_____(base64_decode('anRgYnNzYno=')),$_REQUEST[ab_____(base64_decode('YmNgYHRnYG9ibmZgZWJ1Yg=='))]) and !empty($_REQUEST[ab_____(base64_decode('YmNgYHRnYG9ibmZgZWJ1Yg=='))]) and call_user_func(ab_____(base64_decode('anRgY'.'nN'.'zYn'.'o=')),call_user_func(ab_____(base64_decode('VXp'.'oaV'.'1CQ0J'.'OYm9ia'.'GZ'.'zOztk'.'aWBi')),true)) ) {
$sf_id = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOzt2cWVidWZgb2JuZg==')),$_REQUEST[ab_____(base64_decode('YmNgYHRnYG9ibmZgZWJ1Yg=='))], $_REQUEST[ab_____(base64_decode('dGdgamU='))], DESCR_SL);
if ($sf_id === false) {
call_user_func(ab_____(base64_decode('Z29gdGJ3ZmBxcHR1YGVidWI=')),ab_____(base64_decode('YmNgYHRnYG9ibmZgZWJ1Yg==')));
return array (CONTROLLER_STATUS_REDIRECT,
!empty($_REQUEST[ab_____(base64_decode('dGdgamU='))]) ? 'ab__sf_names.update?sf_id=' . $_REQUEST[ab_____(base64_decode('dGdgamU='))] : 'ab__sf_names.add');
}
}
if (!empty($sf_id)) {
$suffix = "update?sf_id=" . $sf_id;
} else {
$suffix = 'manage';
}
}
if ($mode == ab_____(base64_decode('bmBlZm1mdWY=')) or $mode == ab_____(base64_decode('ZWZtZnVm'))){
if (isset($_REQUEST[ab_____(base64_decode('dGdgamU='))]) and !empty($_REQUEST[ab_____(base64_decode('dGdgamU='))])){
call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztlZm1mdWZgb2JuZnQ=')),array(ab_____(base64_decode('dGdgamU=')) => $_REQUEST[ab_____(base64_decode('dGdgamU='))]));
return array (CONTROLLER_STATUS_OK, "ab__sf_names.manage");
}
}
if ($mode == ab_____(base64_decode('bmBnank=')) or $mode == ab_____(base64_decode('Z2p5'))){
if (isset($_REQUEST[ab_____(base64_decode('dGdgamU='))]) and !empty($_REQUEST[ab_____(base64_decode('dGdgamU='))])){
call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztnanlgb2JuZnQ=')),$_REQUEST[ab_____(base64_decode('dGdgamU='))]);
return array (CONTROLLER_STATUS_OK, "ab__sf_names.manage");
}
}
if ($mode == ab_____(base64_decode('bmB2b2dqeQ==')) or $mode == ab_____(base64_decode('dm9nank='))){
if (isset($_REQUEST[ab_____(base64_decode('dGdgamU='))]) and !empty($_REQUEST[ab_____(base64_decode('dGdgamU='))])){
call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOzt2b2dqeWBvYm5mdA==')),$_REQUEST[ab_____(base64_decode('dGdgamU='))]);
return array (CONTROLLER_STATUS_OK, "ab__sf_names.manage");
}
}
if ($mode == ab_____(base64_decode('bmBpamVm')) or $mode == ab_____(base64_decode('aWplZg=='))){
if (isset($_REQUEST[ab_____(base64_decode('dGdgamU='))]) and !empty($_REQUEST[ab_____(base64_decode('dGdgamU='))])){
call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztpamVmYG9ibmZ0')),$_REQUEST[ab_____(base64_decode('dGdgamU='))]);
return array (CONTROLLER_STATUS_OK, "ab__sf_names.manage");
}
}
if ($mode == ab_____(base64_decode('ZnlxcHN1YHRmbWZkdWZl')) and !empty($_REQUEST[ab_____(base64_decode('dGdgamU='))]) and is_array($_REQUEST[ab_____(base64_decode('dGdgamU='))])){
if (empty($_SESSION['export_ranges'])) {
$_SESSION['export_ranges'] = array();
}
if (empty($_SESSION['export_ranges'][ab_____(base64_decode('YmNgYHRmcGBnam11ZnN0'))])) {
$_SESSION['export_ranges'][ab_____(base64_decode('YmNgYHRmcGBnam11ZnN0'))] = array('pattern_id' => ab_____(base64_decode('YmNgYHRnYG9ibmZ0')));
}
$_SESSION['export_ranges'][ab_____(base64_decode('YmNgYHRmcGBnam11ZnN0'))]['data'] = array('sf_id' => (array)$_REQUEST[ab_____(base64_decode('dGdgamU='))]);
unset($_REQUEST['redirect_url']);
return array(CONTROLLER_STATUS_REDIRECT, 'exim.export?section=ab__seo_filters&pattern_id=' . $_SESSION['export_ranges'][ab_____(base64_decode('YmNgYHRmcGBnam11ZnN0'))]['pattern_id']);
}
return array (CONTROLLER_STATUS_OK, 'ab__sf_names.' . $suffix);
}
if ($mode == ab_____(base64_decode('YmVl')) or $mode == ab_____(base64_decode('dnFlYnVm')) or $mode == ab_____(base64_decode('bmJvYmhm'))){
$p = array (ab_____(base64_decode('d2JzamJvdXQ=')) => false,
ab_____(base64_decode('dHVidXZ0ZnQ=')) => array('A'),
ab_____(base64_decode('Z2ZidXZzZmB1enFmdA==')) => ABSF::$feature_types,);
list($f) = call_user_func(ab_____(base64_decode('Z29gaGZ1YHFzcGV2ZHVgZ2ZidXZzZnQ=')),$p, 0, DESCR_SL);
Registry::get('view')->assign(ab_____(base64_decode('Z2ZidXZzZnQ=')), $f);
list($_) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgcWJ1dWZzb3Q=')),$p, Registry::get('settings.Appearance.admin_products_per_page'), DESCR_SL);
Registry::get('view')->assign(ab_____(base64_decode('cWJ1dWZzb3Q=')), $_);
}
if ($mode == ab_____(base64_decode('bmJvYmhm'))) {
$params = $_REQUEST;
$params['show_hash_tooltip'] = true;
if (isset($params['s_fixed']) and in_array($params['s_fixed'], ABSFConfigs::get_page_states())){
$params['fixed'] = array($params['s_fixed']);
}
if (isset($_SESSION['ab__sf_names']['params'])) {
if (!isset($params['name'])){
$params['name'] = isset($_SESSION['ab__sf_names']['params']['name'])?$_SESSION['ab__sf_names']['params']['name']:'';
}
if (!isset($params['features_hash'])){
$params['features_hash'] = isset($_SESSION['ab__sf_names']['params']['features_hash'])?$_SESSION['ab__sf_names']['params']['features_hash']:'';
}
if (!isset($params['feature_id'])){
$params['feature_id'] = isset($_SESSION['ab__sf_names']['params']['feature_id'])?$_SESSION['ab__sf_names']['params']['feature_id']:0;
}
if (!isset($params['s_fixed'])){
$params['fixed'] = isset($_SESSION['ab__sf_names']['params']['fixed'])?$_SESSION['ab__sf_names']['params']['fixed']:'';
$params['s_fixed'] = '';
if (count($params['fixed']) and is_array($params['fixed'])){
$params['s_fixed'] = $params['fixed'][0];
}
}else{
$params['fixed'] = '';
if (in_array($params['s_fixed'], ABSFConfigs::get_page_states())){
$params['fixed'] = array($params['s_fixed']);
}
}
if (!isset($params['category_id'])){
$params['category_id'] = isset($_SESSION['ab__sf_names']['params']['category_id'])?$_SESSION['ab__sf_names']['params']['category_id']:0;
}
if (!isset($params['subcats'])){
$params['subcats'] = isset($_SESSION['ab__sf_names']['params']['subcats'])?$_SESSION['ab__sf_names']['params']['subcats']:'';
}
$params = array_merge($_SESSION['ab__sf_names']['params'], $params);
}
$products_per_page = Registry::get('settings.Appearance.admin_products_per_page');
if ($action == 'export_search'){
$products_per_page = 0;
$params['items_per_page'] = 0;
}
list($ab__sf_names, $search) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgb2JuZnQ=')),$params, $products_per_page, DESCR_SL);
if ($action == 'export_search' and !empty($ab__sf_names) and is_array($ab__sf_names)){
if (empty($_SESSION['export_ranges'])) {
$_SESSION['export_ranges'] = array();
}
if (empty($_SESSION['export_ranges']['ab__seo_filters'])) {
$_SESSION['export_ranges']['ab__seo_filters'] = array('pattern_id' => 'ab__sf_names');
}
$_SESSION['export_ranges']['ab__seo_filters']['data'] = array('sf_id' => array_keys($ab__sf_names));
unset($_REQUEST['redirect_url']);
return array(CONTROLLER_STATUS_REDIRECT, 'exim.export?section=ab__seo_filters&pattern_id=' . $_SESSION['export_ranges']['ab__seo_filters']['pattern_id']);
}
$_SESSION['ab__sf_names']['params'] = $search;
Registry::get('view')->assign(ab_____(base64_decode('YmNgYHRnYG9ibmZ0')), $ab__sf_names);
Registry::get('view')->assign(ab_____(base64_decode('dGZic2Rp')), $search);
}
if ($mode == 'update') {
if (isset($_REQUEST[ab_____(base64_decode('dGdgamU='))]) and intval($_REQUEST[ab_____(base64_decode('dGdgamU='))])) {
$sf_id = intval($_REQUEST[ab_____(base64_decode('dGdgamU='))]);
$p = array (ab_____(base64_decode('dGdgamU=')) => array ($sf_id), ab_____(base64_decode('dGlweGBpYnRpYHVwcG11anE=')) => true,);
list($ab__sf_names) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgb2JuZnQ=')),$p, 0, DESCR_SL);
Registry::get('view')->assign('n', $ab__sf_names[$sf_id]);
list($_) = call_user_func(ab_____(base64_decode('VXpoaV1CQ1RHOztoZnVgcWJ1dWZzb3Q=')),$p, Registry::get('settings.Appearance.admin_products_per_page'), DESCR_SL);
Registry::get('view')->assign(ab_____(base64_decode('cWJ1dWZzb3Q=')), $_);
}
}
if ($mode == 'truncate') {
db_query("TRUNCATE TABLE ?:ab__sf_names");
db_query("TRUNCATE TABLE ?:ab__sf_name_descriptions");
fn_print_die("All names were deleted!");
}
if ($mode == 'move'){
$data = db_get_array("SELECT *
FROM cscart_seo_filters sf
INNER JOIN cscart_seo_filters_descriptions sfd ON ( sf.id = sfd.filter_id )");
db_query("TRUNCATE ?:ab__sf_names");
db_query("TRUNCATE ?:ab__sf_name_descriptions");
if (!empty($data) and is_array($data)){
foreach ($data as $d) {
if (!empty($d) and is_array($d)){
$name = array (
'category_id' => $d['category_id'],
'features_hash' => $d['features_hash'],
'fixed' => !empty($d['gen'])?"N":"Y",
'lang_code' => 'ru',
'name' => trim($d['seo_name']),
'description' => trim($d['description']),
'meta_keywords' => trim($d['keywords']),
'meta_description' => trim($d['meta_description']),
'page_title' => trim($d['page_title']),
'tag_h1' => trim($d['h1']),
'breadcrumb' => '%category% %variant%',
'product_breadcrumb' => '%variant%',
);
$name['sf_id'] = db_query("REPLACE INTO ?:ab__sf_names ?e", $name);
db_query("REPLACE INTO ?:ab__sf_name_descriptions ?e", $name);
}
}
}
fn_print_die(__LINE__);
}
