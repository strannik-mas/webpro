<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

use Tygh\Registry;
use Tygh\Storage;
use Tygh\Settings;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_rus_exim_1c_install()
{
    $category = db_get_row("SELECT * FROM ?:categories");

    db_query("UPDATE ?:settings_objects SET value = ?s WHERE name = 'exim_1c_default_category'", $category['category_id']);
}

function fn_settings_variants_addons_rus_exim_1c_exim_1c_order_statuses()
{
    $order_statuses = fn_get_simple_statuses('O', false, false, CART_LANGUAGE);

    return $order_statuses;
}

function fn_update_default_category_settings($setting)
{
    if (isset($setting)) {
        Settings::instance()->updateValue($setting['setting_name'], $setting['setting_value']);
    }
}

function fn_get_default_category_settings($lang_code = DESCR_SL)
{
    $default_category = "";

    $settings = Settings::instance()->getValues('rus_exim_1c', 'ADDON');
    if (!empty($settings['general']['exim_1c_default_category'])) {
        $default_category = $settings['general']['exim_1c_default_category'];
    }

    return $default_category;
}

function fn_settings_variants_addons_rus_exim_1c_exim_1c_lang()
{
    $langs = fn_get_simple_languages();

    return $langs;
}

function fn_rus_exim_1c_get_information()
{
    $storefront_url = Registry::get('config.http_location');

    $exim_1c_info = '';
    if (!empty($storefront_url)) {
        $exim_1c_info = __('addons.rus_exim_1c.information', array(
            '[http_location]' => $storefront_url . '/' . 'exim_1c',
        )) . __('addons.rus_exim_1c.info_store');
    }

    return $exim_1c_info;
}

function fn_rus_exim_1c_get_information_shipping_features()
{
    $exim_1c_info_features = __('exim_1c_information_shipping_features');

    return $exim_1c_info_features;
}

function fn_rus_exim_1c_get_orders($params, $fields, $sortings, &$condition, $join, $group)
{
    $number_for_orders = trim(Registry::get('addons.rus_exim_1c.exim_1c_from_order_id'));
    if (isset($params['place'])) {
        if (!empty($number_for_orders)) {
            $order_id = Registry::get('addons.rus_exim_1c.exim_1c_from_order_id');
            if (!empty($order_id)) {
                $condition .= db_quote(" AND ?:orders.order_id >= ?i", $order_id);
            }
        }
    }
}

function fn_rus_exim_1c_update_product_feature_variant($feature_id, $feature_type, $variant, $lang_code, &$variant_id)
{
    $join = db_quote('INNER JOIN ?:product_feature_variants fv ON fv.variant_id = fvd.variant_id');
    $n_variant_id = db_get_field("SELECT fvd.variant_id FROM ?:product_feature_variant_descriptions AS fvd $join WHERE variant = ?s AND feature_id = ?i", $variant['variant'], $feature_id);

    if (!empty($n_variant_id)) {
        $variant_id = $n_variant_id;
    }
}

/**
 * Sets company_id depending on the current user.
 *
 * @param  array  $user_data  The array with information about the user.
 *
 * @return void
 */
function fn_commerceml_change_company_store($user_data)
{
    if (PRODUCT_EDITION == 'ULTIMATE') {
        if (Registry::get('runtime.simple_ultimate')) {
            $company_id = Registry::get('runtime.forced_company_id');
        } else {
            if ($user_data['company_id'] != 0) {
                $company_id = $user_data['company_id'];
                Registry::set('runtime.company_id', $company_id);
            }
        }

    } elseif ($user_data['user_type'] == 'V') {
        if ($user_data['company_id'] != 0) {
            $company_id = $user_data['company_id'];
            Registry::set('runtime.company_id', $company_id);
        }

    } else {
        Registry::set('runtime.company_id', $company_id);
    }
}

function fn_rus_exim_1c_look_through_variants_update_combination($combination, &$_data, $product_id, $amount, $options, $variants)
{
    $old_data = db_get_row(
        'SELECT external_id '
        . 'FROM ?:product_options_inventory '
        . 'WHERE product_id = ?i AND combination_hash = ?i AND temp = ?s',
        $product_id, $_data['combination_hash'], 'Y'
    );

    $_data['external_id'] = isset($old_data['external_id']) ? $old_data['external_id'] : '';
}

function fn_rus_exim_1c_before_dispatch()
{
    if (!empty($_REQUEST['dispatch']) && $_REQUEST['dispatch'] == 'exim_1c') {
        if (!empty($_REQUEST[Tygh::$app['session']->getName()])) {
            unset($_REQUEST[Tygh::$app['session']->getName()]);
        }
    }
}
