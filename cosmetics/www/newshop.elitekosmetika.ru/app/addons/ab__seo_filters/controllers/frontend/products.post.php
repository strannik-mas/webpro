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
if (!defined('BOOTSTRAP')) { die('Access denied'); }
use Tygh\ABSF;
use Tygh\Enum\ABSFConfigs;
use Tygh\Registry;
use Tygh\Enum\ProductFeatures;
if ($mode == 'view' and !defined('AJAX_REQUEST')) {
$amount_breadcrumbs_in_product = intval(Registry::get('addons.ab__seo_filters.amount_breadcrumbs_in_product'));
if (!empty($_REQUEST['product_id']) and intval($_REQUEST['product_id']) and $amount_breadcrumbs_in_product > 0){
$product = Registry::get('view')->getTemplateVars('product');
$lang_code = !empty($product['lang_code'])?$product['lang_code']:Registry::get('settings.Appearance.frontend_default_language');
$product_features = fn_get_product_features_list($product, 'A');
$ab__sf_features = array();
if (is_array($product_features) and !empty($product_features)){
foreach ($product_features as $id => $feature){
if (isset($feature['features_hash'])){
if ($feature['feature_type'] == ProductFeatures::MULTIPLE_CHECKBOX){
list($filter_id) = explode("-", $feature['features_hash']);
$key = key($feature['variants']);
$feature['features_hash'] = $filter_id . "-" . $key;
$feature['variant'] = $feature['variants'][$key]['variant'];
}
$name = ABSF::get_name($product['main_category'], $feature['features_hash'], $lang_code, true, array(ABSFConfigs::PAGE_STATE_FIXED, ABSFConfigs::PAGE_STATE_UNFIXED));
if (is_array($name) and !empty($name)){
$filter = ABSF::get_filter_list($feature['features_hash'], $lang_code, " ", true);
$feature['variant'] = (!empty($feature['prefix'])?$feature['prefix']:"") . $feature['variant'] . (!empty($feature['suffix'])?$feature['suffix']:"");
$feature['ab__sf_seo_variant'] = db_get_field("SELECT ab__sf_seo_variant FROM ?:product_feature_variant_descriptions WHERE variant_id = ?i AND lang_code = ?s", $feature['variant_id'], $lang_code);
if (!empty($feature['ab__sf_seo_variant'])){
$feature['variant'] = trim($feature['ab__sf_seo_variant']);
}
$name['f_hash'] = $feature['features_hash'];
$name['f_desc'] = $feature['description'];
$name['f_variant'] = strlen($name['product_breadcrumb']) ? ABSF::str_replace($name['product_breadcrumb'], fn_get_category_name($product['main_category'], $lang_code), $filter, $feature['variant']) : $feature['variant'];
$ab__sf_features[$id] = $name;
}
}
}
}
if (!empty($ab__sf_features) and is_array($ab__sf_features)){
$sorting_feature_id = db_get_fields("SELECT ?:product_filters.feature_id
FROM ?:product_filters
INNER JOIN ?:product_filter_descriptions pfd ON (pfd.filter_id = ?:product_filters.filter_id)
WHERE ?:product_filters.feature_id in (?n) AND pfd.lang_code = ?s
ORDER BY ?:product_filters.position, pfd.filter
LIMIT ?i
", array_keys($ab__sf_features), $lang_code, $amount_breadcrumbs_in_product);
if (!empty($sorting_feature_id) and is_array($sorting_feature_id)){
$bc = Registry::get('view')->getTemplateVars('breadcrumbs');
$last_element = $bc[count($bc)-1];
unset($bc[count($bc)-1]);
foreach ($sorting_feature_id as $id){
$bc[] = array(
'title' => $ab__sf_features[$id]['f_variant'],
'link' => fn_url("categories.view&category_id={$product['main_category']}&features_hash={$ab__sf_features[$id]['f_hash']}", "C", fn_get_storefront_protocol(), $lang_code),
'nofollow' => false,
);
}
$bc[] = $last_element;
Registry::get('view')->assign('breadcrumbs', $bc);
}
}
}
}