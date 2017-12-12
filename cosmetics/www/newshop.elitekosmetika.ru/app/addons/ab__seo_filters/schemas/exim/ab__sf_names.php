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
use Tygh\Registry;
include_once(Registry::get('config.dir.addons') . 'ab__seo_filters/schemas/exim/ab__sf_names.functions.php');
$schema = array(
'section' => 'ab__seo_filters',
'pattern_id' => 'ab__sf_names',
'name' => __('ab__seo_filters'),
'key' => array('sf_id'),
'table' => 'ab__sf_names',
'references' => array(
'ab__sf_name_descriptions' => array(
'reference_fields' => array('sf_id' => '#key', 'lang_code' => '#lang_code'),
'join_type' => 'INNER'
),
),
'export_fields' => array (
'Language' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'lang_code',
'type' => 'languages',
'required' => true,
'multilang' => true
),
'*Category Name' => array(
'process_get' => array('fn_exim_absf_get_category_name', '#key', '#lang_code'),
'linked' => false,
),
'*Filter Name' => array(
'process_get' => array('fn_exim_absf_get_filter_name', '#key', '#lang_code'),
'linked' => false,
),
'*Variant list' => array(
'process_get' => array('fn_exim_absf_get_variants', '#key', '#lang_code'),
'linked' => false,
),
'Category (ID)' => array (
'db_field' => 'category_id',
'required' => true,
'alt_key' => true,
),
'Features Hash of the filter' => array (
'db_field' => 'features_hash',
'required' => true,
'alt_key' => true,
),
'SEO link' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'name',
'multilang' => true,
'required' => true,
),
'Status of SEO page' => array (
'db_field' => 'fixed',
'required' => true,
),
'H1 of the page' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'tag_h1',
'multilang' => true,
'convert_put' => array('fn_exim_absf_is_empty', '#this'),
),
'Title of the page' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'page_title',
'multilang' => true,
'convert_put' => array('fn_exim_absf_is_empty', '#this'),
),
'SEO description of the page' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'description',
'multilang' => true,
'convert_put' => array('fn_exim_absf_is_empty', '#this'),
),
'Meta keywords of the page' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'meta_keywords',
'multilang' => true,
'convert_put' => array('fn_exim_absf_is_empty', '#this'),
),
'Meta description of the page' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'meta_description',
'multilang' => true,
'convert_put' => array('fn_exim_absf_is_empty', '#this'),
),
'Breadcrumbs of the page' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'breadcrumb',
'multilang' => true,
'convert_put' => array('fn_exim_absf_is_empty', '#this'),
),
'Breadcrumbs of the product page' => array(
'table' => 'ab__sf_name_descriptions',
'db_field' => 'product_breadcrumb',
'multilang' => true,
'convert_put' => array('fn_exim_absf_is_empty', '#this'),
),
),
'range_options' => array(
'selector_url' => 'ab__sf_names.manage',
'object_name' => __('ab__sf.names'),
),
'options' => array(
'lang_code' => array(
'title' => 'language',
'type' => 'languages',
'default_value' => array(DEFAULT_LANGUAGE),
),
),
);
return $schema;
