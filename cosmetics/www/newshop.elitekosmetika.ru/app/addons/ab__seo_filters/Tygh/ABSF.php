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
namespace Tygh;
if (!defined('BOOTSTRAP')) {
die('Access denied');
}
use DateTime;
use Tygh\Enum\ABSFConfigs;
use Tygh\Enum\ProductFeatures;
use Tygh\Languages\Languages;
use Tygh\Registry;
class ABSF {
public static $feature_types = array (ProductFeatures::SINGLE_CHECKBOX,
ProductFeatures::MULTIPLE_CHECKBOX,
ProductFeatures::TEXT_SELECTBOX,
ProductFeatures::NUMBER_SELECTBOX,
ProductFeatures::EXTENDED,
ProductFeatures::NUMBER_FIELD,
ProductFeatures::DATE);
public static $feature_rules = array (ProductFeatures::SINGLE_CHECKBOX,
ProductFeatures::MULTIPLE_CHECKBOX,
ProductFeatures::EXTENDED,
ProductFeatures::TEXT_SELECTBOX,);
public static function get_hash_separate () {
static $hash_separate = "";
if (empty($hash_separate)){
$hash_separate = ".";
if (version_compare(PRODUCT_VERSION, "4.3.5") >= 0){
$hash_separate = "_";
}
}
return $hash_separate;
}
private static function get_max_filters (){
return Registry::ifGet("addons.ab__seo_filters.max_filters", 4);
}
private static function get_max_variants (){
return Registry::ifGet("addons.ab__seo_filters.max_variants", 3);
}
public static function str_replace ($str = '', $category = '', $filter = '', $variant = '', $ab__custom_category_h1 = ''){
$str = trim($str);
$category = trim($category);
$variant = trim($variant);
$filter = trim($filter);
$placeholders = array (
'%category%' => $category,
'%category_lower%' => mb_convert_case($category, MB_CASE_LOWER),
'%Category%' => mb_convert_case(fn_substr($category, 0, 1), MB_CASE_UPPER) . mb_convert_case(fn_substr($category, 1), MB_CASE_LOWER),
'%CATEGORY%' => mb_convert_case($category, MB_CASE_UPPER),
'%filter%' => $filter,
'%filter_lower%' => mb_convert_case($filter, MB_CASE_LOWER),
'%Filter%' => mb_convert_case(fn_substr($filter, 0, 1), MB_CASE_UPPER) . mb_convert_case(fn_substr($filter, 1), MB_CASE_LOWER),
'%FILTER%' => mb_convert_case($filter, MB_CASE_UPPER),
'%variant%' => $variant,
'%variant_lower%' => mb_convert_case($variant, MB_CASE_LOWER),
'%Variant%' => mb_convert_case(fn_substr($variant, 0, 1), MB_CASE_UPPER) . mb_convert_case(fn_substr($variant, 1), MB_CASE_LOWER),
'%VARIANT%' => mb_convert_case($variant, MB_CASE_UPPER),
);
$placeholders['%custom_category_h1%'] = $placeholders['%category%'];
$placeholders['%custom_category_h1_lower%'] = $placeholders['%category_lower%'];
$placeholders['%Custom_category_h1%'] = $placeholders['%Category%'];
$placeholders['%CUSTOM_CATEGORY_H1%'] = $placeholders['%CATEGORY%'];
if (!empty($ab__custom_category_h1)){
$placeholders['%custom_category_h1%'] = $ab__custom_category_h1;
$placeholders['%custom_category_h1_lower%'] = mb_convert_case($ab__custom_category_h1, MB_CASE_LOWER);
$placeholders['%Custom_category_h1%'] = mb_convert_case(fn_substr($ab__custom_category_h1, 0, 1), MB_CASE_UPPER) . mb_convert_case(fn_substr($ab__custom_category_h1, 1), MB_CASE_LOWER);
$placeholders['%CUSTOM_CATEGORY_H1%'] = mb_convert_case($ab__custom_category_h1, MB_CASE_UPPER);
}
return str_replace(array_keys($placeholders), array_values($placeholders), $str);
}
public static function get_rules ($params, $items_per_page = 0, $lang_code = CART_LANGUAGE) {
$default_params = array ('rule_id' => array (),
'feature_id' => array (),
'category_id' => 0,
'page' => 1,
'items_per_page' => $items_per_page,
'limit' => 0,
'status' => array ('A', 'D'),);
$params = array_merge($default_params, $params);
$fields = array ('r.rule_id',
'r.feature_id',
'r.categories',
'r.subcats',
'r.position',
'r.status',
'r.generated_categories',
'r.fixed',
'rd.lang_code',
'rd.meta_keywords',
'rd.meta_description',
'rd.page_title',
'rd.tag_h1',
'rd.breadcrumb',
'rd.product_breadcrumb',);
$sortings = array ('status_position_rule' => array ('r.status',
'r.position',
'r.rule_id',));
$join = $cond = $limit = '';
$cond .= db_quote(" AND r.status in (?a) ", $params['status']);
if (!empty($params['rule_id']) and is_array($params['rule_id'])) {
$cond .= db_quote(" AND r.rule_id in (?n) ", $params['rule_id']);
}
if (!empty($params['feature_id']) and is_array($params['feature_id'])) {
$find_in_set = array();
foreach ($params['feature_id'] as $f){
$find_in_set[] = db_quote(" FIND_IN_SET(?i, feature_id) > 0 ", $f);
}
$cond .= db_quote(" AND (?p) ", implode(" AND ", $find_in_set));
}
if (!empty($params['cid']) and intval($params['cid'])) {
$cond .= db_quote("AND FIND_IN_SET(?i, r.categories)", intval($params['cid']));
}
$join .= db_quote("LEFT JOIN ?:ab__sf_rule_descriptions AS rd ON (rd.rule_id = r.rule_id AND rd.lang_code = ?s)", $lang_code);
$sorting = db_sort($params, $sortings, 'status_position_rule', 'asc');
$limit = '';
if (!empty($params['items_per_page'])) {
$params['total_items'] = db_get_field("SELECT COUNT(DISTINCT(r.rule_id)) FROM ?:ab__sf_rules AS r {$join} WHERE 1 ?p ", $cond);
$limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
}
$data = db_get_hash_array("SELECT " . implode(',', $fields) . " FROM ?:ab__sf_rules AS r {$join} WHERE 1 ?p ?p ?p", "rule_id", $cond, $sorting, $limit);
if (empty($data) or !is_array($data)) {
return array (false, $params);
}
foreach ($data as $k => $v) {
$data[$k]['feature_id'] = explode(",", $v['feature_id']);
}
if (!empty($params['get_categories_description'])) {
foreach ($data as $k => $v) {
$d = array ();
$data[$k]['categories_description'] = fn_array_merge($d, fn_get_categories_list($v['categories'], $lang_code), false);
}
}
if (!empty($params['get_feature_name'])) {
foreach ($data as $k => $v) {
foreach ($v['feature_id'] as $f){
$data[$k]['feature_name'][$f] = fn_get_feature_name($f, $lang_code);
}
}
}
if (!empty($params['get_desc_by_langs'])) {
foreach ($data as $k => $v) {
$data[$k]['desc_by_langs'] = db_get_hash_array("SELECT lang_code, meta_keywords, meta_description, page_title, tag_h1, breadcrumb, product_breadcrumb FROM ?:ab__sf_rule_descriptions WHERE rule_id = ?i ORDER BY lang_code", "lang_code", $k);
}
}
return array ($data, $params);
}
public static function update_rule ($data, $id = 0, $lang_code = CART_LANGUAGE) {
if (is_array($data) and !empty($data)) {
if (empty($data['sequence_features'])) {
fn_set_notification('E', __('error'), __('ab__sf.errors.feature_is_empty'));
return false;
}
if (!isset($data['categories']) or !strlen($data['categories'])) {
fn_set_notification('E', __('error'), __('ab__sf.errors.categories_is_empty'));
return false;
}
$d = array ('feature_id' => implode(",", array_slice((array)explode(',', $data['sequence_features']), 0, static::get_max_filters())),
'categories' => $data['categories'],
'subcats' => $data['subcats'],
'fixed' => in_array($data['fixed'], ABSFConfigs::get_page_states()) ? $data['fixed'] : ABSFConfigs::PAGE_STATE_UNFIXED,
'meta_keywords' => trim($data['meta_keywords']),
'meta_description' => trim($data['meta_description']),
'page_title' => trim($data['page_title']),
'tag_h1' => trim($data['tag_h1']),
'breadcrumb' => trim($data['breadcrumb']),
'product_breadcrumb' => trim($data['product_breadcrumb']),
'position' => intval(trim($data['position'])),
'generated_categories' => $data['generated_categories'],
'status' => $data['status'],);
if (intval($id)) {
db_query("UPDATE ?:ab__sf_rules SET ?u WHERE rule_id = ?i", $d, $id);
db_query("UPDATE ?:ab__sf_rule_descriptions SET ?u WHERE rule_id = ?i AND lang_code = ?s", $d, $id, $lang_code);
} else {
$id = $d['rule_id'] = db_query("REPLACE INTO ?:ab__sf_rules ?e", $d);
foreach (Languages::getAll() as $d['lang_code'] => $v) {
db_query("REPLACE INTO ?:ab__sf_rule_descriptions ?e", $d);
}
}
return $id;
}
return false;
}
public static function delete_rules ($id) {
$id = (array) $id;
if (is_array($id) and !empty($id)) {
db_query("DELETE FROM ?:ab__sf_rules WHERE rule_id in (?n)", $id);
db_query("DELETE FROM ?:ab__sf_rule_descriptions WHERE rule_id in (?n)", $id);
}
}
public static function get_name ($category_id, $features_hash, $lang_code, $full = true, $fixed = array(ABSFConfigs::PAGE_STATE_FIXED, ABSFConfigs::PAGE_STATE_UNFIXED, ABSFConfigs::PAGE_STATE_HIDDEN)) {
if (intval($category_id) > 0 and strlen(trim($features_hash)) and strlen(trim($lang_code))) {
$fields = array('nd.sf_id', 'nd.name');
if ($full){
$fields[] = 'nd.description';
$fields[] = 'nd.meta_keywords';
$fields[] = 'nd.meta_description';
$fields[] = 'nd.page_title';
$fields[] = 'nd.tag_h1';
$fields[] = 'nd.breadcrumb';
$fields[] = 'nd.product_breadcrumb';
}
$fs = (array) explode(static::get_hash_separate(), $features_hash);
$fs = array_slice($fs, 0, static::get_max_filters());
$hash_cond = array();
$length = 0;
foreach ($fs as $f){
$hash_cond[] = static::_get_hash_combos($f);
$length += strlen($f);
}
array_unshift($hash_cond, db_quote("LENGTH(n.features_hash)=?i", $length + (count($hash_cond) - 1)));
if (!empty($fixed)){
$hash_cond[] = db_quote(" n.fixed in (?a) ", $fixed);
}
$data = false;
$sf_ids = db_get_row("SELECT sf_id
FROM ?:ab__sf_names n
WHERE n.category_id = ?i AND ?p", $category_id, "(" . implode(" AND ", $hash_cond) . ")");
if (!empty($sf_ids) and is_array($sf_ids)){
$data = db_get_row("SELECT " . implode(', ', $fields) . "
FROM ?:ab__sf_name_descriptions nd
WHERE lang_code = ?s AND sf_id in (?n)", $lang_code, $sf_ids);
}
return $data;
}
return false;
}
private static function _get_hash_combos ($hash) {
if (strlen($hash)){
if (strpos($hash, '-', strpos($hash, '-')+1) === false){
return "LOCATE('$hash', n.features_hash)>0";
}else{
list($id, $h) = explode("-", $hash, 2);
$combo_hash = array();
if (db_get_field('SELECT IFNULL(field_type,0) FROM ?:product_filters WHERE filter_id = ?i', $id)){
$combo_hash[] = "LOCATE('" . $hash . "', n.features_hash)>0";
}else{
foreach (static::_get_array_combos (explode('-', $h)) as $combo){
$combo_hash[] = "LOCATE('" . $id . "-" . $combo . "', n.features_hash)>0";
}
}
return "(" . implode(" OR ", $combo_hash) . ")";
}
}
return false;
}
private static function _get_array_combos ($arr, $glue="-", $slice = true) {
if ($slice) {
$arr = array_slice((array)$arr, 0, static::get_max_variants());
}
$combinations = array();
$words = sizeof($arr);
$combos = 1;
if (count(array_unique($arr)) != 1){
for($i = $words; $i > 0; $i--) {
$combos *= $i;
}
}
while(sizeof($combinations) < $combos) {
shuffle($arr);
$combo = implode($glue, $arr);
if(!in_array($combo, $combinations)) {
$combinations[] = $combo;
}
}
return $combinations;
}
public static function get_features_hash ($name, $category_id, $lang_code) {
if (strlen(trim($name)) and intval($category_id) and strlen(trim($lang_code))) {
return db_get_row("SELECT n.sf_id, n.features_hash
FROM ?:ab__sf_names n
INNER JOIN ?:ab__sf_name_descriptions nd ON (n.sf_id = nd.sf_id)
WHERE nd.name = ?s AND n.category_id = ?i AND nd.lang_code = ?s", $name, $category_id, $lang_code);
}
return false;
}
public static function get_names ($params, $items_per_page = 0, $lang_code = CART_LANGUAGE) {
$default_params = array ('name_id' => array (),
'category_id' => 0,
'feature_id' => 0,
'name' => '',
'features_hash' => '',
'fixed' => ABSFConfigs::get_page_states(),
'page' => 1,
'items_per_page' => $items_per_page,
'limit' => 0,);
$params = array_merge($default_params, $params);
$fields = array ('n.sf_id',
'n.category_id ',
'n.features_hash',
'n.fixed',
'nd.lang_code',
'nd.name',
'nd.description',
'nd.meta_keywords',
'nd.meta_description',
'nd.page_title',
'nd.tag_h1',
'nd.breadcrumb',
'nd.product_breadcrumb',);
$sortings = array ('name' => 'nd.name', 'category' => 'cd.category', 'features_hash' => 'n.features_hash', 'fixed' => 'n.fixed');
$join = $cond = $limit = '';
if (!empty($params['sf_id']) and is_array($params['sf_id'])) {
$cond .= db_quote(" AND n.sf_id in (?n) ", $params['sf_id']);
}
if (!empty($params['category_id']) and intval($params['category_id'])) {
if (!empty($params['subcats']) and $params['subcats'] == 'Y'){
$categories = static::_get_categories_and_subcategories($params['category_id']);
if ($categories){
$cond .= db_quote(" AND n.category_id in (?n) ", $categories);
}
}else{
$cond .= db_quote(" AND n.category_id = ?i ", $params['category_id']);
}
}
if (!empty($params['name']) and strlen(trim($params['name']))) {
$cond .= db_quote(" AND nd.name like ?l ", trim($params['name']));
}
if (!empty($params['features_hash']) and strlen(trim($params['features_hash']))) {
$cond .= db_quote(" AND n.features_hash like ?l ", trim($params['features_hash']));
}
if (!empty($params['fixed']) and is_array($params['fixed'])) {
$cond .= db_quote(" AND n.fixed in (?a) ", $params['fixed']);
}
if (!empty($params['feature_id']) and is_array($params['feature_id'])) {
$spliter = '-';
$filter_ids = array_keys(fn_array_value_to_key(static::_get_filter_by_feature($params['feature_id']), 'filter_id'));
$filters_combos = static::_get_array_combos($filter_ids, $spliter, false);
$cond_combos = array();
foreach ($filters_combos as $combo) {
$elements = (array) explode($spliter, $combo);
$pattern = implode('-[Y0-9]+' . static::get_hash_separate(), $elements) . '-[Y0-9]+';
$cond_combos[] = db_quote("features_hash REGEXP (?s)", "^" . $pattern . "$");
}
$cond .= db_quote("AND (?p) ", implode(" OR ", $cond_combos));
}
$join .= db_quote("LEFT JOIN ?:ab__sf_name_descriptions AS nd ON (nd.sf_id = n.sf_id AND nd.lang_code = ?s)", $lang_code);
$join .= db_quote("LEFT JOIN ?:category_descriptions AS cd ON (cd.category_id = n.category_id AND cd.lang_code = ?s)", $lang_code);
$sorting = db_sort($params, $sortings, 'name', 'asc');
$limit = '';
if (!empty($params['items_per_page'])) {
$params['total_items'] = db_get_field("SELECT COUNT(DISTINCT(n.sf_id)) FROM ?:ab__sf_names AS n {$join} WHERE 1 ?p ", $cond);
$limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
}
$data = db_get_hash_array("SELECT " . implode(',', $fields) . " FROM ?:ab__sf_names AS n {$join} WHERE 1 ?p ?p ?p", "sf_id", $cond, $sorting, $limit);
if (!is_array($data) or empty($data)) {
return array (false, $params);
}
if (!empty($params['show_hash_tooltip'])){
foreach ($data as $k => $d) {
$data[$k]['tooltip'] = static::get_variant_list($d['features_hash'], $lang_code, " ", true);
}
}
return array ($data, $params);
}
public static function update_name ($data, $id = 0, $lang_code = CART_LANGUAGE) {
if (is_array($data) and !empty($data)) {
if (!isset($data['category_id']) or !intval($data['category_id'])) {
fn_set_notification('E', __('error'), __('ab__sf.errors.category_id_is_empty'));
return false;
}
if (!isset($data['features_hash']) or !strlen(trim($data['features_hash']))) {
fn_set_notification('E', __('error'), __('ab__sf.errors.features_hash_is_empty'));
return false;
}
if (!isset($data['name']) or !strlen(trim($data['name']))) {
fn_set_notification('E', __('error'), __('ab__sf.errors.name_is_empty'));
return false;
}
$d = array ('category_id' => intval($data['category_id']),
'features_hash' => trim($data['features_hash']),
'fixed' => (in_array($data['fixed'], ABSFConfigs::get_page_states())) ? $data['fixed'] : ABSFConfigs::PAGE_STATE_UNFIXED,
'name' => trim(fn_generate_name($data['name'])),
'description' => trim($data['description']),
'meta_keywords' => trim($data['meta_keywords']),
'meta_description' => trim($data['meta_description']),
'page_title' => trim($data['page_title']),
'tag_h1' => trim($data['tag_h1']),
'breadcrumb' => trim($data['breadcrumb']),
'product_breadcrumb' => trim($data['product_breadcrumb']),);
if (intval($id)) {
db_query("UPDATE ?:ab__sf_names SET ?u WHERE sf_id = ?i", $d, $id);
db_query("UPDATE ?:ab__sf_name_descriptions SET ?u WHERE sf_id = ?i AND lang_code = ?s", $d, $id, $lang_code);
} else {
$id = $d['sf_id'] = db_query("REPLACE INTO ?:ab__sf_names ?e", $d);
foreach (Languages::getAll() as $d['lang_code'] => $v) {
db_query("REPLACE INTO ?:ab__sf_name_descriptions ?e", $d);
}
}
return $id;
}
return false;
}
public static function delete_names ($params, $fixed = '') {
$cond = array ();
if (!empty($params) and is_array($params)) {
if (isset($params['sf_id']) and !empty($params['sf_id'])) {
$cond[] = db_quote("?:ab__sf_names.sf_id IN (?n)", (array) $params['sf_id']);
}
if (isset($params['category_id']) and !empty($params['category_id'])) {
$cond[] = db_quote("?:ab__sf_names.category_id IN (?n)", (array) $params['category_id']);
}
if (!empty($params['filter_id'])) {
$spliter = '-';
$filter_ids = array_keys(fn_array_value_to_key($params['filter_id'], 'filter_id'));
$filters_combos = static::_get_array_combos($filter_ids, $spliter, false);
$cond_combos = array();
foreach ($filters_combos as $combo) {
$elements = (array) explode($spliter, $combo);
$pattern = implode('-[Y0-9]+' . static::get_hash_separate(), $elements) . '-[Y0-9]+';
$cond_combos[] = db_quote("?:ab__sf_names.features_hash REGEXP (?s)", "^" . $pattern . "$");
}
$cond[] = db_quote(" (?p) ", implode(" OR ", $cond_combos));
}
if (!empty($fixed) and in_array($fixed, ABSFConfigs::get_page_states())) {
$cond[] = db_quote("?:ab__sf_names.fixed = ?s", $fixed);
}
}
if (!empty($cond)) {
db_query("DELETE ?:ab__sf_name_descriptions FROM ?:ab__sf_name_descriptions
INNER JOIN ?:ab__sf_names ON (?:ab__sf_names.sf_id = ?:ab__sf_name_descriptions.sf_id)
WHERE ?p", implode(" AND ", $cond));
db_query("DELETE ?:ab__sf_names FROM ?:ab__sf_names
WHERE ?p", implode(" AND ", $cond));
}
}
public static function fix_names ($id) {
$id = (array) $id;
if (is_array($id) and !empty($id)) {
db_query("UPDATE ?:ab__sf_names SET fixed = ?s WHERE sf_id in (?n)", ABSFConfigs::PAGE_STATE_FIXED, $id);
}
}
public static function unfix_names ($id) {
$id = (array) $id;
if (is_array($id) and !empty($id)) {
db_query("UPDATE ?:ab__sf_names SET fixed = ?s WHERE sf_id in (?n)", ABSFConfigs::PAGE_STATE_UNFIXED, $id);
}
}
public static function hide_names ($id) {
$id = (array) $id;
if (is_array($id) and !empty($id)) {
db_query("UPDATE ?:ab__sf_names SET fixed = ?s WHERE sf_id in (?n)", ABSFConfigs::PAGE_STATE_HIDDEN, $id);
}
}
public static function generate_names ($rules) {
$result = array();
$p = array ("get_desc_by_langs" => true,);
if (!empty($rules) and is_array($rules)) {
$p["rule_id"] = $rules;
}
list($rules) = static::get_rules($p);
foreach ($rules as $rule) {
$result[$rule['rule_id']]['status'] = true;
$features = static::_get_active_features($rule['feature_id']);
if (count($features) != count($rule['feature_id'])){
$result[$rule['rule_id']]['status'] = false;
$result[$rule['rule_id']]['text'] = __("ab__sf.errors.not_all_features_are_active");
continue;
}
$filters = static::_get_filter_by_feature($rule['feature_id']);
if (empty($filters)){
$result[$rule['rule_id']]['status'] = false;
$result[$rule['rule_id']]['text'] = __("ab__sf.errors.no_active_filters_by_selected_features");
continue;
}elseif (count($filters) != count($rule['feature_id'])){
$result[$rule['rule_id']]['status'] = false;
$result[$rule['rule_id']]['text'] = __("ab__sf.errors.not_all_features_exist_active_filters");
continue;
}
$categories = static::_get_categories_by_rule($rule, $filters);
if (empty($categories)){
$result[$rule['rule_id']]['status'] = false;
$result[$rule['rule_id']]['text'] = __("ab__sf.errors.there_are_no_active_categories");
continue;
}
if ($rule['generated_categories'] == 'by_non_empty_filter_categories'){
$categories = static::_check_empty_categories($categories, $filters);
}
if (empty($categories)){
$result[$rule['rule_id']]['status'] = false;
$result[$rule['rule_id']]['text'] = __("ab__sf.errors.no_active_products_for_categories");
continue;
};
static::delete_names(array ('category_id' => $categories, 'filter_id' => $filters), ABSFConfigs::PAGE_STATE_UNFIXED);
$langs = array_keys(fn_get_translation_languages());
foreach ($categories as $category) {
static::_generate_seo_by_category($category, $langs, $filters, $rule);
}
}
fn_clear_cache('all');
if (!empty($result)){
foreach ($result as $k => $r){
if ($r['status']){
fn_set_notification(/*/f*/'N', __(ab_____(base64_decode('b3B1amRm'))), __(ab_____(base64_decode('YmNgYHRnL29wdWpnamRidWpwb3QvaGZvZnNidWZgb2JuZnRgY3pgc3ZtZmBqdGBkcG5xbWZ1Zg==')),array('[id]'=>$k)));
}else{
fn_set_notification(/*/f*/'E', __(ab_____(base64_decode('ZnNzcHM='))), __(ab_____(base64_decode('YmNgYHRnL29wdWpnamRidWpwb3QvaGZvZnNidWZgb2JuZnRgY3pgc3ZtZmBqdGBvcHVgZHBucW1mdWZl')),array('[id]'=>$k, '[text]' => $r['text'])));
}
}
}
return $result;
}
private static function _generate_seo_by_category ($category_id, $langs, $filters, $rule) {
$all_hashs = $variants_info = array();
foreach ($filters as $feature_id => $filter) {
$feature_type = db_get_field("SELECT IFNULL(feature_type, 0) FROM ?:product_features WHERE feature_id = ?i", $feature_id);
switch ($feature_type){
case ProductFeatures::SINGLE_CHECKBOX:
foreach ($langs as $l){
$feature_name = db_get_field("SELECT description FROM ?:product_features_descriptions WHERE feature_id = ?i and lang_code = ?s", $feature_id, $l);
$variants_info['Y'][$l] = array('variant' => $feature_name . " " . __('ab__sf.checkbox_set', array(), $l));
}
$all_hashs[$feature_id][] = $filter['filter_id'] . "-Y";
break;
case ProductFeatures::MULTIPLE_CHECKBOX:
case ProductFeatures::EXTENDED:
case ProductFeatures::TEXT_SELECTBOX:
$variants = db_get_fields(
"SELECT DISTINCT pf.variant_id
FROM ?:product_features_values pf
INNER JOIN ?:products_categories pc ON (pc.product_id = pf.product_id)
WHERE pf.feature_id = ?i AND pc.category_id in (?n)", $feature_id, (Registry::get('settings.General.show_products_from_subcategories') == 'Y')?static::_get_categories_and_subcategories($category_id):(array)$category_id);
if (!empty($variants) and is_array($variants)){
foreach ($variants as $v) {
$all_hashs[$feature_id][] = $filter['filter_id'] . "-" . $v;
}
}
break;
}
}
if (empty($all_hashs) or count($all_hashs) != count($filters)){
return;
}
$group_combo_all_hashs = static::_generate_variant_combinations(array_values($all_hashs));
if (count($all_hashs) == 1){
$group_combo_all_hashs = array_shift($all_hashs);
}
if (!empty($group_combo_all_hashs) and is_array($group_combo_all_hashs)) {
foreach ($group_combo_all_hashs as $group){
if (db_get_field("SELECT IFNULL(count(*),0) FROM ?:ab__sf_names
WHERE category_id = ?i AND features_hash IN (?a)", $category_id, static::_get_array_combos((array)$group, static::get_hash_separate()))){
continue;
}
$cond = array();
foreach ((array)$group as $h){
list($f, $v) = explode("-", $h);
$cond[] = db_quote("(pf.filter_id = ?s AND pfv.?p = ?s)", $f, (intval($v)?"variant_id":"value"), $v);
}
$amount = db_get_field("SELECT COUNT(products.product_id)
FROM (
SELECT pfv.product_id
FROM ?:product_features_values AS pfv
INNER JOIN ?:product_filters AS pf ON (pfv.feature_id = pf.feature_id)
INNER JOIN ?:products_categories AS pc ON (pc.product_id = pfv.product_id)
INNER JOIN ?:products AS p ON (p.product_id = pfv.product_id)
WHERE pc.category_id in (?n) AND (?p) AND p.status = 'A'
GROUP BY pfv.product_id
HAVING count(*) = ?i*?i
) as products", (Registry::get('settings.General.show_products_from_subcategories') == 'Y')?static::_get_categories_and_subcategories($category_id):(array)$category_id, implode(" OR ", $cond), count($cond), count($langs)
);
if (empty($amount)){
continue;
}else {
$hash = array();
foreach ($filters as $filter) {
foreach ((array)$group as $h){
if (substr($h, 0, strlen($filter['filter_id'] . "-")) == $filter['filter_id'] . "-"){
$hash[]= $h;
}
}
}
$hash_string = implode(static::get_hash_separate(), $hash);
$nd = array ();
$sf_id = db_query("REPLACE INTO ?:ab__sf_names ?e", array ('category_id' => $category_id,
'features_hash' => $hash_string,
'fixed' => in_array($rule['fixed'], array(ABSFConfigs::PAGE_STATE_UNFIXED, ABSFConfigs::PAGE_STATE_HIDDEN)) ? $rule['fixed'] : ABSFConfigs::PAGE_STATE_UNFIXED,));
foreach ($langs as $lang) {
$nd[] = array ('sf_id' => $sf_id,
'lang_code' => $lang,
'name' => static::_generate_seo_variant_name($category_id, $hash_string, $lang),
'meta_keywords' => trim($rule['desc_by_langs'][$lang]['meta_keywords']),
'meta_description' => trim($rule['desc_by_langs'][$lang]['meta_description']),
'page_title' => trim($rule['desc_by_langs'][$lang]['page_title']),
'tag_h1' => trim($rule['desc_by_langs'][$lang]['tag_h1']),
'breadcrumb' => trim($rule['desc_by_langs'][$lang]['breadcrumb']),
'product_breadcrumb' => trim($rule['desc_by_langs'][$lang]['product_breadcrumb']),
);
}
db_query("REPLACE INTO ?:ab__sf_name_descriptions ?m", $nd);
if ($rule['generated_categories'] == 'by_all_filter_categories' and Registry::get('settings.General.show_products_from_subcategories')){
$category_path = db_get_field("SELECT id_path FROM ?:categories WHERE category_id = ?i", $category_id);
if (!empty($category_path)){
$categories = db_get_fields("SELECT category_id FROM ?:categories WHERE status = 'A' AND category_id != ?i AND category_id in (?n)", $category_id, (array)explode('/', $category_path));
if (!empty($categories) and is_array($categories)){
foreach ($categories as $c){
$show_filters_into_category = true;
foreach ($filters as $filter){
if (!empty($filter['categories_path']) and !in_array($c, (array) explode(',', $filter['categories_path']))){
$show_filters_into_category = false;
break;
}
}
if ($show_filters_into_category){
$isset_sf_id = db_get_field("SELECT sf_id FROM ?:ab__sf_names WHERE category_id = ?i AND features_hash = ?s", $c, $hash_string);
if (empty($isset_sf_id)){
$nd = array ();
$sf_id = db_query("INSERT INTO ?:ab__sf_names ?e", array ('category_id' => $c, 'features_hash' => $hash_string, 'fixed' => in_array($rule['fixed'], array(ABSFConfigs::PAGE_STATE_UNFIXED, ABSFConfigs::PAGE_STATE_HIDDEN)) ? $rule['fixed'] : ABSFConfigs::PAGE_STATE_UNFIXED,));
foreach ($langs as $lang) {
$nd[] = array ('sf_id' => $sf_id,
'lang_code' => $lang,
'name' => static::_generate_seo_variant_name($c, $hash_string, $lang),
'meta_keywords' => trim($rule['desc_by_langs'][$lang]['meta_keywords']),
'meta_description' => trim($rule['desc_by_langs'][$lang]['meta_description']),
'page_title' => trim($rule['desc_by_langs'][$lang]['page_title']),
'tag_h1' => trim($rule['desc_by_langs'][$lang]['tag_h1']),
'breadcrumb' => trim($rule['desc_by_langs'][$lang]['breadcrumb']),
'product_breadcrumb' => trim($rule['desc_by_langs'][$lang]['product_breadcrumb']),
);
}
db_query("INSERT INTO ?:ab__sf_name_descriptions ?m", $nd);
}
}
}
}
}
}
}
}
}
return true;
}
private static function _generate_seo_variant_name ($category_id, $hash_string, $lang_code){
$name = fn_generate_name(static::get_variant_list($hash_string, $lang_code, "-"));
$sf_id = db_get_fields("SELECT n.sf_id
FROM ?:ab__sf_names as n
INNER JOIN ?:ab__sf_name_descriptions as nd ON (n.sf_id = nd.sf_id)
WHERE nd.lang_code = ?s AND n.category_id = ?i AND nd.name = ?s AND n.fixed != ?s", $lang_code, $category_id, $name, ABSFConfigs::PAGE_STATE_HIDDEN);
if (!empty($sf_id)){
$name .= '-absf-dublicate-' . $lang_code . "-" . $hash_string;
}
return $name;
}
private static function _generate_variant_combinations ($arrays, $i = 0){
if (!isset($arrays[$i])) {
return array();
}
if ($i == count($arrays) - 1) {
return $arrays[$i];
}
$tmp = static::_generate_variant_combinations($arrays, $i + 1);
$result = array();
foreach ($arrays[$i] as $v) {
foreach ($tmp as $t) {
$result[] = is_array($t) ?
array_merge(array($v), $t) :
array($v, $t);
}
}
return $result;
}
private static function _check_empty_categories ($categories, $filters = array()) {
$result = false;
if (!empty($categories) and is_array($categories)) {
$no_empty_categories = db_get_fields("SELECT pc.category_id
FROM ?:products_categories AS pc
INNER JOIN ?:products AS p ON (p.product_id = pc.product_id)
WHERE pc.category_id IN (?n) AND p.status = 'A'
GROUP BY pc.category_id HAVING count(pc.product_id) > 0", $categories);
if (is_array($no_empty_categories) and !empty($no_empty_categories)) {
$result = $no_empty_categories;
$empty_categories = array_diff($categories, $no_empty_categories);
if (!empty($empty_categories) and is_array($empty_categories)) {
static::delete_names(array ('category_id' => $empty_categories, 'filter_id' => $filters,), ABSFConfigs::PAGE_STATE_UNFIXED);
}
}
}
return $result;
}
private static function _get_filter_by_feature ($feature = 0) {
if (!empty($feature)) {
$data = db_get_hash_array("SELECT filter_id, categories_path, feature_id FROM ?:product_filters WHERE status = 'A' AND feature_id in (?n)", 'feature_id', $feature);
if (!empty($data) and is_array($data)){
$result = array();
foreach ($feature as $f){
if (!empty($data[$f])){
$result[$f] = $data[$f];
}
}
return $result;
}
}
return false;
}
private static function _get_active_features ($feature = 0) {
if (!empty($feature)) {
return db_get_fields("SELECT feature_id FROM ?:product_features WHERE status = 'A' AND feature_type in (?a) AND feature_id in (?n)", static::$feature_rules, (array) $feature);
}
return false;
}
private static function _get_categories_by_rule ($r, $filters) {
if (!isset($r['categories']) or !strlen(trim($r['categories']))) {
return false;
}
$rule_categories = array ();
foreach ((array) explode(",", $r['categories']) as $category_id) {
if ($r['subcats'] == 'Y') {
$cats = static::_get_categories_and_subcategories($category_id);
} else {
$cats = array ($category_id);
}
if (is_array($cats) and !empty($cats)) {
$rule_categories = array_merge($rule_categories, $cats);
}
}
$rule_categories = array_unique($rule_categories);
$filters_categories = array ();
foreach ($filters as $f){
if (strlen($f['categories_path'])) {
$filters_categories = array_merge($filters_categories, (array) explode(",", $f['categories_path']));
}
}
$filters_categories = array_unique($filters_categories);
if (is_array($filters_categories) and !empty($filters_categories)) {
return array_intersect($filters_categories, $rule_categories);
}
return $rule_categories;
}
private static function _consider_parent_categories ($rule){
$result = false;
if (!empty($rule['generated_categories'])
and $rule['generated_categories'] == 'by_all_filter_categories'
and Registry::get('settings.General.show_products_from_subcategories') == 'Y'){
$result = true;
}
return $result;
}
private static function _get_categories_and_subcategories ($category_id){
if (intval($category_id)){
return db_get_fields("SELECT a.category_id
FROM ?:categories AS a
LEFT JOIN ?:categories AS b ON (b.category_id = ?i and b.status = 'A')
WHERE a.id_path LIKE CONCAT( b.id_path, '/%' )
UNION
SELECT c.category_id
FROM ?:categories AS c
WHERE c.category_id = ?i AND c.status = 'A'", $category_id, $category_id);
}
return false;
}
public static function parse_native_seo_name ($uri, $o){
$req['sl'] = '';
if (strlen($o['object_name'])){
$search = "/" . $o['object_name'];
$pos = strrpos($uri, $search);
if ($pos !== false) {
$uri = substr_replace($uri, "", $pos, strlen($search));
}
}
if (!empty($uri)) {
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
if (!empty($objects) && !empty($objects['object_name'])) {
if (Registry::get('addons.seo.single_url') == 'Y') {
$objects['sl'] = (Registry::get('addons.seo.seo_language') == 'Y') ? $objects['sl'] : '';
$objects['sl'] = !empty($req['sl']) ? $req['sl'] : $objects['sl'];
}
$lang_cond = db_quote("AND lang_code = ?s", !empty($objects['sl']) ? $objects['sl'] : Registry::get('settings.Appearance.frontend_default_language'));
$object_type = db_get_field("SELECT type FROM ?:seo_names WHERE name = ?s ?p", $objects['object_name'], fn_get_seo_company_condition('?:seo_names.company_id'));
$_seo = db_get_array("SELECT * FROM ?:seo_names WHERE name = ?s ?p ?p", $objects['object_name'], fn_get_seo_company_condition('?:seo_names.company_id', $object_type), $lang_cond);
if (empty($_seo)) {
$_seo = db_get_array("SELECT * FROM ?:seo_names WHERE name = ?s ?p", $objects['object_name'], fn_get_seo_company_condition('?:seo_names.company_id'));
}
if (empty($_seo) && !empty($objects['extension'])) {
$_seo = db_get_array("SELECT * FROM ?:seo_names WHERE name = ?s ?p ?p", $objects['object_name'] . '.' . $objects['extension'], fn_get_seo_company_condition('?:seo_names.company_id'), $lang_cond);
if (empty($_seo)) {
$_seo = db_get_array("SELECT * FROM ?:seo_names WHERE name = ?s ?p", $objects['object_name'] . '.' . $objects['extension'], fn_get_seo_company_condition('?:seo_names.company_id', $object_type));
}
}
if (!empty($_seo)) {
$_seo_valid = false;
foreach ($_seo as $__seo) {
$_objects = $objects;
if (Registry::get('addons.seo.single_url') != 'Y' && empty($_objects['sl'])) {
$_objects['sl'] = $__seo['lang_code'];
}
if (fn_seo_validate_object($__seo, $uri, $_objects) == true) {
$_seo_valid = true;
$_seo = $__seo;
$objects = $_objects;
break;
}
}
if ($_seo_valid == true) {
$req['sl'] = $objects['sl'];
$_seo_vars = fn_get_seo_vars($_seo['type']);
if ($_seo['type'] == 's') {
$url_query = $_seo['dispatch'];
$req['dispatch'] = $_seo['dispatch'];
} else {
$page_suffix = (!empty($objects['page'])) ? ('&page=' . $objects['page']) : '';
$url_query = $_seo_vars['dispatch'] . '?' . $_seo_vars['item'] . '=' . $_seo['object_id'] . $page_suffix;
$req['dispatch'] = $_seo_vars['dispatch'];
}
if (!empty($_seo['object_id'])) {
$req[$_seo_vars['item']] = $_seo['object_id'];
}
if (!empty($objects['page'])) {
$req['page'] = $objects['page'];
}
$is_allowed_url = true;
}
}else{
$query_string = array();
if (!empty($_SERVER['QUERY_STRING'])) {
parse_str($_SERVER['QUERY_STRING'], $query_string);
}
if (preg_match('/\/page-(\d+)\/?$/', $uri, $m)) {
$query_string['page'] = $m[1];
$uri = preg_replace('/\/page-\d+\/?$/', '', $uri);
}
$condition = fn_get_seo_company_condition("?:seo_redirects.company_id");
$redirect_data = db_get_row("SELECT type, object_id, dest, lang_code FROM ?:seo_redirects WHERE src = ?s ?p", $uri, $condition);
if (!empty($redirect_data) and $redirect_data['type'] == 'c'){
$redirect_uri = fn_url("categories.view&category_id=" . $redirect_data['object_id'], "C", fn_get_storefront_protocol(), $redirect_data['lang_code']);
if (!empty($redirect_uri)){
if (substr($redirect_uri, -5) == '.html'){
$redirect_uri = substr($redirect_uri, 0, -5);
$redirect_uri .= "/" . $o['object_name'] . ".html";
}elseif (substr($redirect_uri, -1) == '/'){
$redirect_uri .= $o['object_name'] . "/";
}
}
fn_redirect($redirect_uri);
}
}
if (!empty($is_allowed_url)) {
$req['lang_code'] = empty($objects['sl']) ? Registry::get('settings.Appearance.frontend_default_language') : $objects['sl'];
if (empty($req['sl'])) {
unset($req['sl']);
}
return $req;
}
}
}
}
}
}
public static function get_variant_list ($features_hash, $lang_code, $glue = " ", $group_by_filter = false){
$res = array();
if (strlen($features_hash)){
$hashs = (array) explode(static::get_hash_separate(), $features_hash);
$variants = array();
foreach ($hashs as $h){
list($filter_id) = explode("-", $h);
$variants[$filter_id] = (array) explode("-", substr($h, strpos($h, '-') + 1));
}
if (is_array($variants) and !empty($variants)){
foreach ($variants as $filter_id => $v){
$feature = static::_get_feature_by_filter($filter_id, $lang_code);
if (!empty($feature) and is_array($feature)){
switch ($feature['feature_type']){
case ProductFeatures::SINGLE_CHECKBOX:
if ($v[0] == "Y"){
$res[$filter_id][] = (trim($feature['description']))
.__("absf.variant_glue", array(), $lang_code)
.__("absf.checkbox_set", array(), $lang_code);
}
break;
case ProductFeatures::MULTIPLE_CHECKBOX:
case ProductFeatures::TEXT_SELECTBOX:
case ProductFeatures::EXTENDED:
$variant_name = db_get_hash_array("SELECT variant_id, variant, ab__sf_seo_variant FROM ?:product_feature_variant_descriptions WHERE variant_id in (?n) AND lang_code = ?s", "variant_id", $v, $lang_code);
if (is_array($variant_name) and !empty($variant_name)){
foreach ($v as $i){
$res[$filter_id][] = (!empty($feature['prefix'])?$feature['prefix']:"") . (!empty($variant_name[$i]['ab__sf_seo_variant'])?$variant_name[$i]['ab__sf_seo_variant']:$variant_name[$i]['variant']) . (!empty($feature['suffix'])?$feature['suffix']:"");
}
}
break;
case ProductFeatures::NUMBER_SELECTBOX:
case ProductFeatures::NUMBER_FIELD:
case ProductFeatures::DATE:
$res[$filter_id][] = (!empty($feature['prefix']) ? $feature['prefix'] : "")
. (!empty($v[0]) ? (__('ab__sf.from', array(), $lang_code) . " " . $v[0] . " ") : "")
. __('ab__sf.to', array(), $lang_code) . " " . $v[1] . " "
. (!empty($feature['suffix'])?$feature['suffix']:"");
break;
}
}else{
if (isset($v[0]) and isset($v[1])){
$res[$filter_id][] = (!empty($v[0]) ? (__('ab__sf.from', array(), $lang_code) . " " . $v[0] . " ") : "")
. __('ab__sf.to', array(), $lang_code) . " " . $v[1] . " ";
}
}
}
$variant_list = array();
if (!empty($res)){
if (!$group_by_filter){
foreach ($res as $filter_id => $v){
$variant_list = array_merge($variant_list, $v);
}
$res = implode($glue, $variant_list);
}else{
$filter_info = db_get_hash_array("SELECT filter_id, filter FROM ?:product_filter_descriptions WHERE filter_id in (?n) AND lang_code = ?s", "filter_id", array_keys($res), $lang_code);
foreach ($res as $filter_id => $v){
if (!empty($filter_info[$filter_id]['filter'])){
$variant_list[$filter_info[$filter_id]['filter']] = $v;
}
}
$res = $variant_list;
}
}
}
}
return $res;
}
public static function get_filter_list ($features_hash, $lang_code, $glue = " ", $only_first = false){
$res = "";
if (strlen($features_hash)){
$hashs = (array) explode(static::get_hash_separate(), $features_hash);
$filters = array();
foreach ($hashs as $h){
list($filter) = explode("-", $h);
$filters[$filter] = db_get_field("SELECT filter FROM ?:product_filter_descriptions WHERE filter_id = ?i and lang_code = ?s", $filter, $lang_code);
if ($only_first) break;
}
$res = implode($glue, $filters);
}
return $res;
}
private static function _get_feature_by_filter ($filter_id = 0, $lang_code){
$res = false;
if (!empty($filter_id) and intval($filter_id)){
$res = db_get_row("SELECT
f.field_type as filter_type
, pf.feature_id
, pf.feature_type
, pfd.description
, pfd.prefix
, pfd.suffix
FROM ?:product_features as pf
LEFT JOIN ?:product_filters as f ON (f.feature_id = pf.feature_id)
LEFT JOIN ?:product_features_descriptions as pfd ON (pf.feature_id = pfd.feature_id)
WHERE f.filter_id = ?i AND pfd.lang_code = ?s
", $filter_id, $lang_code, $lang_code);
}
return $res;
}
public static function generate_sitemap ($params) {
$time = microtime(true);
$location = fn_get_storefront_url(fn_get_storefront_protocol());
$objDateTime = new DateTime('NOW');
$lmod = $objDateTime->format(DateTime::W3C);
$head = <<<HEAD
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
HEAD;
$foot = <<<FOOT
</urlset>
FOOT;
$body = <<<HEAD
<url>
<loc>$location/</loc>
<lastmod>$lmod</lastmod>
<changefreq>daily</changefreq>
<priority>0.5</priority>
</url>
HEAD;
$names = ABSF::_get_names_for_sitemap($params);
if (is_array($names) and !empty($names)){
foreach ($names as $name){
$url = fn_url("categories.view&category_id={$name['category_id']}&features_hash={$name['features_hash']}", "C", fn_get_storefront_protocol(), $name['lang_code']);
$body .= <<<HEAD
<url>
<loc>$url</loc>
<lastmod>$lmod</lastmod>
<changefreq>daily</changefreq>
<priority>0.5</priority>
</url>
HEAD;
}
}
return array($head . $body . $foot, count($names), microtime(true) - $time);
}
private static function _get_names_for_sitemap ($params){
$cond = "";
if (!empty($params['fixed']) and in_array($params['fixed'], ABSFConfigs::get_page_states())){
$cond .= db_quote("AND n.fixed = ?s", $params['fixed']);
}else{
$cond .= db_quote("AND n.fixed in (?a)", array(ABSFConfigs::PAGE_STATE_FIXED, ABSFConfigs::PAGE_STATE_UNFIXED));
}
if (!empty($params['lang'])) {
if ($params['lang'] == 'all') {
if (Registry::get('addons.seo.single_url') == "Y") {
$cond .= db_quote("AND nd.lang_code = ?s", Registry::get('settings.Appearance.frontend_default_language'));
}
} elseif (strlen($params['lang']) == 2) {
$cond .= db_quote("AND nd.lang_code = ?s", $params['lang']);
}
}
$names = db_get_array("SELECT n.category_id, n.features_hash, n.fixed, nd.lang_code
FROM ?:ab__sf_names n
INNER JOIN ?:ab__sf_name_descriptions nd ON (n.sf_id = nd.sf_id)
INNER JOIN ?:categories c ON (c.category_id = n.category_id)
WHERE 1 AND c.status = 'A' ?p
ORDER BY n.category_id asc, n.features_hash asc, nd.lang_code asc
", $cond);
return (is_array($names) and !empty($names))?$names:false;
}
public static function get_patterns ($params, $items_per_page = 0, $lang_code = CART_LANGUAGE) {
$default_params = array ('pattern' => array(),
'page' => 1,
'items_per_page' => $items_per_page,
'limit' => 0,
);
$params = array_merge($default_params, $params);
$fields = array (
'pattern',
'lang_code',
'value',
);
$sortings = array ('pattern' => array ('pattern',));
$join = $cond = $limit = '';
$patterns = fn_get_schema('patterns', 'objects');
$cond .= db_quote(" AND pattern in (?a) ", array_keys($patterns));
$cond .= db_quote(" AND lang_code = ?s ", $lang_code);
$sorting = db_sort($params, $sortings, 'pattern', 'asc');
$limit = '';
if (!empty($params['items_per_page'])) {
$params['total_items'] = db_get_field("SELECT COUNT(DISTINCT(pattern)) FROM ?:ab__sf_patterns AS p {$join} WHERE 1 ?p ", $cond);
$limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
}
$data = db_get_hash_array("SELECT " . implode(',', $fields) . " FROM ?:ab__sf_patterns AS p {$join} WHERE 1 ?p ?p ?p", "pattern", $cond, $sorting, $limit);
foreach ($patterns as $pattern=>$pattern_data) {
if (!empty($data[$pattern]['value'])){
$patterns[$pattern]['value'] = $data[$pattern]['value'];
}
}
return array ($patterns, $params);
}
public static function update_pattern ($data, $pattern = 0, $lang_code = CART_LANGUAGE) {
$d = array(
"pattern" => $pattern,
"lang_code" => $lang_code,
"value" => trim($data['value']),
);
db_query("REPLACE INTO ?:ab__sf_patterns ?e", $d);
return true;
}
public static function get_active_filters (){
return db_get_fields("SELECT ?:product_filters.feature_id
FROM ?:product_filters
INNER JOIN ?:product_features ON (?:product_features.feature_id = ?:product_filters.feature_id)
WHERE ?:product_filters.status = 'A' and ?:product_features.status = 'A' and ?:product_features.feature_type in (?a)", static::$feature_rules);
}
public static function canonical_url_page ($page = 1) {
if ($page > 1) {
return '&page=' . $page;
}
return '';
}
public static function get_seo_page_link_info ($category_id = 0, $product_id = 0, $feature_id = 0, $variant_id = 0, $variant = '', $lang_code = CART_LANGUAGE){
$res = false;
if (!empty($category_id) and !empty($variant_id) and !empty($variant)){
$filter_id = db_get_field("SELECT IFNULL(filter_id, 0)
FROM ?:product_filters
WHERE status = 'A' AND feature_id = ?i AND (categories_path ='' OR FIND_IN_SET (?s, categories_path)) ", $feature_id, $category_id);
if (!empty($filter_id)){
$features_hash = $filter_id . "-" . $variant_id;
$name = ABSF::get_name($category_id, $features_hash, $lang_code);
if (!empty($name) and is_array($name)){
$filter = ABSF::get_filter_list($features_hash, $lang_code, " ", true);
$title = $variant;
$ab__sf_seo_variant = db_get_field("SELECT ab__sf_seo_variant FROM ?:product_feature_variant_descriptions WHERE variant_id = ?i AND lang_code = ?s", $variant_id, $lang_code);
if (!empty($ab__sf_seo_variant)){
$title = trim($ab__sf_seo_variant);
}
$title = strlen($name['tag_h1']) ? ABSF::str_replace($name['tag_h1'], fn_get_category_name($category_id, $lang_code), $filter, $title) : $title;
$res = array(
'title' => $title,
'link' => fn_url('categories.view&category_id=' . $category_id . '&features_hash=' . $features_hash, 'C', fn_get_storefront_protocol()),
);
}
}
}
return $res;
}
}
