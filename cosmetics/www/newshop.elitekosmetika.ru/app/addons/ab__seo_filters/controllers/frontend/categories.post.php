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
if ($mode == 'view') {
if (!empty($_REQUEST['page']) and intval($_REQUEST['page']) >= 2){
$category_data = Registry::get('view')->getTemplateVars('category_data');
$category_data['description'] = "";
Registry::get('view')->assign('category_data', $category_data);
}
if (defined('AJAX_REQUEST')){
if (isset($_REQUEST['category_id'])){
$lang_code = !empty($_REQUEST['sl'])?$_REQUEST['sl']:Registry::get('settings.Appearance.frontend_default_language');
$ab__seo_name = ABSF::get_name($_REQUEST['category_id'], isset($_REQUEST['features_hash'])?$_REQUEST['features_hash']:"", $lang_code);
$category_data = Registry::get('view')->getTemplateVars('category_data');
$ab__sf_data = array(
"tag_h1" => trim($category_data['category']),
"description" => trim($category_data['description']),
"page_title" => Registry::get('view')->getTemplateVars('page_title'),
);
if (Registry::get('addons.ab__custom_category_h1.status') == "A"
and !empty($category_data['ab__custom_category_h1'])
and strlen(trim($category_data['ab__custom_category_h1']))
){
$ab__sf_data["tag_h1"] = trim($category_data['ab__custom_category_h1']);
}
if (is_array($ab__seo_name) and !empty($ab__seo_name)){
$category = $category_data['category'];
$variant = ABSF::get_variant_list ($_REQUEST['features_hash'], $lang_code, " ");
$filter = ABSF::get_filter_list($_REQUEST['features_hash'], $lang_code, " ", true);
$ab__custom_category_h1 = '';
if (Registry::get('addons.ab__custom_category_h1.status') == "A" and !empty($category_data['ab__custom_category_h1'])){
$ab__custom_category_h1 = trim($category_data['ab__custom_category_h1']);
}
$ab__sf_data['tag_h1'] = ABSF::str_replace($ab__seo_name['tag_h1'], $category, $filter, $variant, $ab__custom_category_h1);
$ab__sf_data['description'] = ABSF::str_replace($ab__seo_name['description'], $category, $filter, $variant, $ab__custom_category_h1);
if (!empty($_REQUEST['page']) and intval($_REQUEST['page']) >= 2) {
$ab__sf_data['description'] = "";
}
$ab__sf_data['page_title'] = ABSF::str_replace($ab__seo_name['page_title'], $category, $filter, $variant, $ab__custom_category_h1);
fn_add_breadcrumb(ABSF::str_replace($ab__seo_name['breadcrumb'], $category, $filter, $variant, $ab__custom_category_h1), '');
}else{
if (!empty($category_data['ab__mcd_descs']) and (empty($_REQUEST['page']) or $_REQUEST['page'] == 1)){
Registry::get('view')->assign("category_data", $category_data);
$ab__sf_data['description'] = Registry::get('view')->fetch('addons/ab__multiple_cat_descriptions/hooks/ab__multiple_cat_descriptions/category_description.override.tpl');
}
}
Registry::get('ajax')->assign("ab__sf_data", $ab__sf_data);
}
}elseif (isset($_SESSION['ab__seo_data']) and is_array($_SESSION['ab__seo_data'])){
$ab__seo_data = $_SESSION['ab__seo_data'];
unset($_SESSION['ab__seo_data']);
list($ab__seo_name) = ABSF::get_names(array('sf_id' => (array)$ab__seo_data['sf_id']), 0, $ab__seo_data['lang_code']);
$ab__seo_name = $ab__seo_name[$ab__seo_data['sf_id']];
$category_data = Registry::get('view')->getTemplateVars('category_data');
$category = $category_data['category'];
$variant = ABSF::get_variant_list ($ab__seo_data['features_hash'], $ab__seo_data['lang_code'], " ");
$filter = ABSF::get_filter_list($_REQUEST['features_hash'], $ab__seo_data['lang_code'], " ", true);
$ab__custom_category_h1 = '';
if (Registry::get('addons.ab__custom_category_h1.status') == "A" and !empty($category_data['ab__custom_category_h1'])){
$ab__custom_category_h1 = trim($category_data['ab__custom_category_h1']);
}
$category_data['category'] = ABSF::str_replace($ab__seo_name['tag_h1'], $category, $filter, $variant, $ab__custom_category_h1);
$category_data['description'] = ABSF::str_replace($ab__seo_name['description'], $category, $filter, $variant, $ab__custom_category_h1);
if (!empty($_REQUEST['page']) and intval($_REQUEST['page']) >= 2) {
$category_data['description'] = "";
}
Registry::get('view')->assign('category_data', $category_data);
Registry::get('view')->assign('page_title', ABSF::str_replace($ab__seo_name['page_title'], $category, $filter, $variant, $ab__custom_category_h1));
Registry::get('view')->assign('meta_keywords', ABSF::str_replace($ab__seo_name['meta_keywords'], $category, $filter, $variant, $ab__custom_category_h1));
Registry::get('view')->assign('meta_description', ABSF::str_replace($ab__seo_name['meta_description'], $category, $filter, $variant, $ab__custom_category_h1));
fn_add_breadcrumb(ABSF::str_replace($ab__seo_name['breadcrumb'], $category, $filter, $variant, $ab__custom_category_h1), '');
$seo_canonical = array();
$search = Registry::get('view')->getTemplateVars('search');
if ($search['total_items'] > $search['items_per_page']) {
$pagination = fn_generate_pagination($search);
if (!empty($pagination['prev_page'])) {
$seo_canonical['prev'] = fn_url('categories.view&category_id=' . $_REQUEST['category_id'] . '&features_hash=' . $ab__seo_data['features_hash'] . ABSF::canonical_url_page($pagination['prev_page']), 'C', fn_get_storefront_protocol());
}
if (!empty($pagination['next_page'])) {
$seo_canonical['next'] = fn_url('categories.view&category_id=' . $_REQUEST['category_id'] . '&features_hash=' . $ab__seo_data['features_hash'] . ABSF::canonical_url_page($pagination['next_page']), 'C', fn_get_storefront_protocol());
}
}
$seo_canonical['current'] = fn_url('categories.view&category_id=' . $_REQUEST['category_id'] . '&features_hash=' . $ab__seo_data['features_hash'] . ABSF::canonical_url_page($search['page']), 'C', fn_get_storefront_protocol());
$seo_canonical['noindex_nofollow'] = ($ab__seo_name['fixed'] == ABSFConfigs::PAGE_STATE_HIDDEN)?'Y':'N';
Registry::get('view')->assign('ab__sf_seo_page', 'Y');
Registry::get('view')->assign('ab__sf_seo_canonical', $seo_canonical);
}
}
