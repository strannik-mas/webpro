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
use Tygh\Enum\ABSFConfigs;
use Tygh\Registry;
function fn_ab__sf_install (){
$objects = array(
array(
ab_____(base64_decode('dWJjbWY=')) => ab_____(base64_decode('QDtxc3BldmR1YGdmYnV2c2Zgd2JzamJvdWBlZnRkc2pxdWpwb3Q=')),
ab_____(base64_decode('Z2pmbWU=')) => ab_____(base64_decode('YmNgYHRnYHRmcGB3YnNqYm91')),
ab_____(base64_decode('dHJt')) => ab_____(base64_decode('Qk1VRlMhVUJDTUYhQDtxc3BldmR1YGdmYnV2c2Zgd2JzamJvdWBlZnRkc2pxdWpwb3QhQkVFIWJjYGB0Z2B0ZnBgd2JzamJvdSFXQlNESUJTKTM2NiohRElCU0JEVUZTIVRGVSF2dWc5IURQTU1CVUYhdnVnOWBoZm9mc2JtYGRqIU9QVSFPVk1NIUVGR0JWTVUhKCg=')),
),
array(
ab_____(base64_decode('dWJjbWY=')) => ab_____(base64_decode('QDtiY2BgdGdgc3ZtZnQ=')),
ab_____(base64_decode('Z2pmbWU=')) => ab_____(base64_decode('Z2p5ZmU=')),
ab_____(base64_decode('dHJt')) => ab_____(base64_decode('Qk1VRlMhVUJDTUYhQDtiY2BgdGdgc3ZtZnQhQkVFIWdqeWZlIURJQlMpMiohRElCU0JEVUZTIVRGVSF2dWc5IURQTU1CVUYhdnVnOWBoZm9mc2JtYGRqIU9QVSFPVk1NIUVGR0JWTVUhKFYo')),
),
);
if (!empty($objects) and is_array($objects)){
foreach ($objects as $object){
$fields = db_get_fields('DESCRIBE ' . $object['table']);
if (!empty($fields) and is_array($fields)){
$is_present_field = false;
foreach ($fields as $f){
if ($f == $object['field']){
$is_present_field = true;
break;
}
}
if (!$is_present_field){
db_query($object['sql']);
if (!empty($object['add_sql'])){
foreach ($object['add_sql'] as $sql) {
db_query($sql);
}
}
}
}
}
}
}
function fn_ab__seo_filters_url_post (&$_url, $area, $url, $protocol, $company_id_in_url, $lang_code) {
static $init_cache = false;
if ($area == 'C' and strpos($_url, "features_hash") !== false) {
$url = str_replace("?", "&", $url);
parse_str($url, $parsed_query);
if (isset($parsed_query['category_id']) and isset($parsed_query['features_hash'])) {
$category_id = $parsed_query['category_id'];
$features_hash = $parsed_query['features_hash'];
$seo_settings = Registry::get('addons.seo');
if ($seo_settings['single_url'] == "Y") {
$lang_code = Registry::get('settings.Appearance.frontend_default_language');
}
$cache_name = "ab__seo_filters__" . $category_id;
$key = $features_hash . "__" . $lang_code;
if (!$init_cache) {
Registry::registerCache($cache_name, array('ab__sf_name_descriptions', 'ab__sf_names'), Registry::cacheLevel('static'), true);
$init_cache = true;
}
$seo_name_cache = Registry::get($cache_name . '.' . $key);
if (!empty($seo_name_cache)){
$seo_name = $seo_name_cache;
}else{
$seo_name = ABSF::get_name($category_id, $features_hash, $lang_code, false, array(ABSFConfigs::PAGE_STATE_FIXED, ABSFConfigs::PAGE_STATE_UNFIXED,));
Registry::set($cache_name . '.' . $key, !empty($seo_name)?$seo_name:'NM');
}
if ($seo_name == 'NM' and !is_array($seo_name) or empty($seo_name)){ // no-match NM
return;
}
$parse_url = parse_url($_url, PHP_URL_QUERY);
if (strlen(trim($parse_url))){
$items = (array) explode('&', $parse_url);
$q = array();
foreach ($items as $i){
if (strpos($i, "features_hash") === false){
$q[] = $i;
}
}
$q = array_merge(array("features_hash=" . $features_hash), $q);
list($u) = explode("?", $_url);
$_url = $u . "?" . implode("&", $q);
}
if (strlen($seo_name['name'])) {
switch ($seo_settings['seo_category_type']) {
case "category":
case "file":
if (isset($parsed_query['page']) and intval($parsed_query['page']) > 1) {
$page = "-page-" . $parsed_query['page'];
$seo_name['name'] .= $page;
$_url = str_replace($page, "", $_url);
}
$_url = str_replace(".html?features_hash=" . $features_hash, "/{$seo_name['name']}.html", $_url);
break;
case "category_nohtml":
case "root_category":
if (isset($parsed_query['page']) and intval($parsed_query['page']) > 1) {
$page = "/page-" . $parsed_query['page'];
$seo_name['name'] .= $page;
$_url = str_replace($page, "", $_url);
}
$_url = str_replace("/?features_hash=" . $features_hash, "/{$seo_name['name']}/", $_url);
break;
}
if (($pos = strpos($_url, "?")) === false) {
if (($pos = strpos($_url, "&")) !== false) {
$_url = substr_replace($_url, "?", $pos, 1);
}
}
}
}
}
}
function fn_ab__seo_filters_get_route (&$req, $result, $area, &$is_allowed_url) {
if (isset($_SESSION['ab__seo_data'])) unset($_SESSION['ab__seo_data']);
if (!empty($req["dispatch"]) and $req["dispatch"] == "_no_page" && $area = 'C') {
$server_uri = str_replace("&", "?", $_SERVER['REQUEST_URI']);
$server_uri = $_SERVER['REQUEST_URI'];
$uri = fn_get_request_uri($server_uri);
$rewrite_rules = fn_get_rewrite_rules();
foreach ($rewrite_rules as $pattern => $query) {
if (preg_match($pattern, $uri, $matches) || preg_match($pattern, urldecode($query), $matches)) {
$_query = preg_replace("!^.+\?!", '', $query);
parse_str($_query, $objects);
$result_values = 'matches';
$url_query = '';
foreach ($objects as $key => $value) {
preg_match('!^.+\[([0-9])+\]$!', $value, $_id);
$objects[$key] = (substr($value, 0, 1) == '$') ? ${$result_values}[$_id[1]] : $value;
}
$main_category = ABSF::parse_native_seo_name($uri, $objects);
if (!is_array($main_category) or empty($main_category)) {
break;
}
$lang_code = $lang_code_hash = "";
$seo_settings = Registry::get('addons.seo');
if ($seo_settings['seo_language'] == 'N') {
if ($seo_settings['single_url'] == 'N') {
$lang_code = $lang_code_hash = $req['sl'] = $main_category['lang_code'];
}
if ($seo_settings['single_url'] == 'Y') {
$q = parse_url($server_uri);
if (isset($q['query'])) {
parse_str($q['query'], $query_lang);
}
$lang_code = $lang_code_hash = Registry::get('settings.Appearance.frontend_default_language');
$req['sl'] = '';
if (isset($query_lang['sl']) and strlen($query_lang['sl']) == 2) {
$req['sl'] = $lang_code = $query_lang['sl'];
}
}
}
if ($seo_settings['seo_language'] == 'Y') {
if ($seo_settings['single_url'] == 'N') {
$lang_code = $lang_code_hash = $req['sl'] = $objects['sl'];
}
if ($seo_settings['single_url'] == 'Y') {
$req['sl'] = $lang_code = $objects['sl'];
$lang_code_hash = Registry::get('settings.Appearance.frontend_default_language');
}
}
$ab__seo_filter = ABSF::get_features_hash($objects['object_name'], $main_category['category_id'], $lang_code_hash);
if (empty($ab__seo_filter['features_hash'])) {
fn_redirect(fn_url("categories.view&category_id=" . $main_category['category_id'], "C", fn_get_storefront_protocol(), $lang_code));
}
$category_id = $main_category['category_id'];
$is_allowed_url = true;
$req['dispatch'] = 'categories.view';
$req['category_id'] = $category_id;
$req['features_hash'] = $ab__seo_filter['features_hash'];
$req['page'] = !empty($objects['page'])?$objects['page']:"";
$_SESSION['ab__seo_data'] = array ('sf_id' => $ab__seo_filter['sf_id'],
'category_id' => $req['category_id'],
'page' => empty($req['page']) ? 1 : $req['page'],
'features_hash' => $req['features_hash'],
'lang_code' => $lang_code,);
if (is_array($_GET) and !empty($_GET)){
$req = array_merge($_GET, $req);
}
if (empty($req['sl'])) {
unset($req['sl']);
}
$query_string = http_build_query($req);
$_SERVER['REQUEST_URI'] = fn_url($req['dispatch'] . '?' . $query_string, 'C', 'rel', $lang_code);
$_SERVER['QUERY_STRING'] = $query_string;
$_SERVER['X-SEO-REWRITE'] = true;
break;
}
}
}
}
function fn_ab__seo_filters_prepare_filter_url ($features_hash) {
$url = "";
if (isset($_REQUEST['dispatch']) and $_REQUEST['dispatch'] == "categories.view" and isset($_REQUEST['category_id'])){
$url = "categories.view&category_id=" . $_REQUEST['category_id'] . "&features_hash=" . fn_ab__sf_prepare_hash($features_hash, (isset($_REQUEST['features_hash']))?$_REQUEST['features_hash']:"");
}
return !empty($url)?fn_url($url, "C", fn_get_storefront_protocol()):"";
}
function fn_ab__sf_prepare_hash($hash_add, $hash_main){
$hash = array();
$result = array();
if (strlen($hash_main)){
$filters = explode(ABSF::get_hash_separate(), $hash_add . ABSF::get_hash_separate() . $hash_main);
if (is_array($filters) and !empty($filters)){
foreach ($filters as $item){
list($f_id, $f_variants) = explode ('-', $item, 2);
if (isset($result[$f_id])){
$result[$f_id] = array_merge($result[$f_id], (array)explode ('-', $f_variants));
}else{
$result[$f_id] = (array)explode ('-', $f_variants);
}
}
}
}
if (!empty($result)){
$hash = array();
foreach ($result as $k=>$i){
$hash[] = $k . "-" . implode ("-", array_unique($i));
}
}
return (!empty($hash))?implode(ABSF::get_hash_separate(), $hash):$hash_add;
}
function fn_ab__seo_filters_delete_category_post ($category_id, $recurse, $category_ids){
if (!empty($category_ids) and is_array($category_ids)){
ABSF::delete_names(array('category_id' => $category_ids));
}
}
function fn_ab__seo_filters_ab__as_other_objects (&$objects){
$seo_pages_fixed = Registry::ifGet("addons.ab__seo_filters.add_to_sitemap", "none");
if ($seo_pages_fixed == 'none') return false;
switch ($seo_pages_fixed){
case "fixed": $cond = db_quote("AND n.fixed = ?s", ABSFConfigs::PAGE_STATE_FIXED); break;
case "unfixed": $cond = db_quote("AND n.fixed = ?s", ABSFConfigs::PAGE_STATE_UNFIXED); break;
default: $cond = "";
}
$seo_filters = db_get_array("SELECT DISTINCT n.category_id, n.features_hash, n.fixed
FROM ?:ab__sf_names n
INNER JOIN ?:ab__sf_name_descriptions nd ON (n.sf_id = nd.sf_id)
INNER JOIN ?:categories c ON (c.category_id = n.category_id)
WHERE 1 AND c.status = 'A' ?p
ORDER BY n.category_id asc", $cond);
if (!empty($seo_filters)) {
$objects['ab__seo_filter'] = $seo_filters;
}
}
function fn_ab__seo_filters_sitemap_link_object (&$link, $object, $value){
if ($object == 'ab__seo_filter' && is_array($value)) {
$link = "categories.view&category_id={$value['category_id']}&features_hash={$value['features_hash']}";
}
}
