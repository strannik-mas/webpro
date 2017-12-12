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
use Tygh\Languages\Languages;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_sd_loyalty_program_get_cards($params = array(), $items_per_page = 0, $lang_code = CART_LANGUAGE)
{
    $default_params = array(
        'page' => 1,
        'items_per_page' => $items_per_page,
    );

    $params = array_merge($default_params, $params);

    $sortings = array(
        'name' => '?:loyalty_program_descriptions.name',
        'amount' => '?:loyalty_program.amount',
        'status' => '?:loyalty_program.status',
        'usergroup' => '?:usergroup_descriptions.usergroup'
    );

    $condition = $limit = '';

    if (!empty($params['limit'])) {
        $limit = db_quote(' LIMIT 0, ?i', $params['limit']);
    }

    $sorting = db_sort($params, $sortings, 'amount', 'asc');

    $condition = (AREA == 'A') ? '' : db_quote(' AND ?:loyalty_program.status = ?s', 'A');

    $fields = array (
        '?:loyalty_program.card_id',
        '?:loyalty_program.amount',
        '?:loyalty_program.status',
        '?:loyalty_program.usergroup_id',
        '?:loyalty_program_descriptions.name',
        '?:loyalty_program_images.card_image_id',
        '?:usergroup_descriptions.usergroup',
        '?:loyalty_program_descriptions.description'
    );

    if (fn_allowed_for('ULTIMATE')) {
        $fields[] = '?:loyalty_program.company_id';
        $condition .= fn_get_company_condition('?:loyalty_program.company_id');
    }

    $limit = '';
    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT COUNT(*) FROM ?:loyalty_program WHERE 1 ?p", $condition);
        $limit = db_paginate($params['page'], $params['items_per_page'], $params['total_items']);
    }

    $cards = db_get_array(
        'SELECT ?p FROM ?:loyalty_program ' .
        'LEFT JOIN ?:loyalty_program_descriptions ON ?:loyalty_program_descriptions.card_id = ?:loyalty_program.card_id AND ?:loyalty_program_descriptions.lang_code = ?s ' .
        'LEFT JOIN ?:loyalty_program_images ON ?:loyalty_program_images.card_id = ?:loyalty_program.card_id AND ?:loyalty_program_images.lang_code = ?s ' .
        'LEFT JOIN ?:usergroup_descriptions ON ?:loyalty_program.usergroup_id = ?:usergroup_descriptions.usergroup_id AND ?:usergroup_descriptions.lang_code = ?s ' .
        'WHERE 1 ?p ?p ?p',
        implode(", ", $fields), $lang_code, $lang_code, $lang_code, $condition, $sorting, $limit
    );

    foreach ($cards as $k => $v) {
        $cards[$k]['main_pair'] = fn_get_image_pairs($v['card_image_id'], 'loyalty_program', 'M', true, false, $lang_code);
    }

    return array($cards, $params);
}

function fn_sd_loyalty_program_get_card_data($card_id, $lang_code = CART_LANGUAGE)
{
    $status_condition = (AREA == 'A') ? '' : db_quote(' AND ?:loyalty_program.status IN (?a) ', array('A', 'H'));

    $fields = array (
        '?:loyalty_program.card_id',
        '?:loyalty_program.amount',
        '?:loyalty_program.status',
        '?:loyalty_program.usergroup_id',
        '?:loyalty_program_descriptions.name',
        '?:loyalty_program_descriptions.description',
        '?:loyalty_program_descriptions.lang_code',
        '?:loyalty_program_images.card_image_id',
    );

    if (fn_allowed_for('ULTIMATE')) {
        $fields[] = '?:loyalty_program.company_id as company_id';
    }

    $card = db_get_row(
        'SELECT ?p FROM ?:loyalty_program ' .
        'LEFT JOIN ?:loyalty_program_descriptions ON ?:loyalty_program_descriptions.card_id = ?:loyalty_program.card_id AND ?:loyalty_program_descriptions.lang_code = ?s ' .
        'LEFT JOIN ?:loyalty_program_images ON ?:loyalty_program_images.card_id = ?:loyalty_program.card_id AND ?:loyalty_program_images.lang_code = ?s' .
        'WHERE ?:loyalty_program.card_id = ?i ?p',
        implode(", ", $fields), $lang_code, $lang_code, $card_id, $status_condition
    );

    if (!empty($card)) {
        $card['main_pair'] = fn_get_image_pairs($card['card_image_id'], 'loyalty_program', 'M', true, false, $lang_code);
    }

    return $card;
}

function fn_sd_loyalty_program_update_card($data, $card_id, $lang_code = DESCR_SL)
{
    if (!empty($card_id)) {
        db_query('UPDATE ?:loyalty_program SET ?u WHERE card_id = ?i', $data, $card_id);
        db_query('UPDATE ?:loyalty_program_descriptions SET ?u WHERE card_id = ?i AND lang_code = ?s', $data, $card_id, $lang_code);

        $card_image_id = fn_sd_loyalty_program_get_card_image_id($card_id, $lang_code);
        $card_image_exist = !empty($card_image_id);
        $image_is_update = fn_sd_loyalty_program_need_image_update();

        if ($card_image_exist && $image_is_update) {
            fn_delete_image_pairs($card_image_id, 'loyalty_program');
            db_query('DELETE FROM ?:loyalty_program_images WHERE card_id = ?i AND lang_code = ?s', $card_id, $lang_code);
            $card_image_exist = false;
        }

        if ($image_is_update && !$card_image_exist) {
            $card_image_id = db_query('INSERT INTO ?:loyalty_program_images (card_id, lang_code) VALUE(?i, ?s)', $card_id, $lang_code);
        }
        $pair_data = fn_attach_image_pairs('cards_main', 'loyalty_program', $card_image_id, $lang_code);

    } else {
        $card_id = $data['card_id'] = db_query('REPLACE INTO ?:loyalty_program ?e', $data);

        foreach (Languages::getAll() as $data['lang_code'] => $v) {
            db_query('REPLACE INTO ?:loyalty_program_descriptions ?e', $data);
        }

        if (fn_sd_loyalty_program_need_image_update()) {
            $data_card_image = array(
                'card_id' => $card_id,
                'lang_code' => $lang_code
            );

            $card_image_id = db_get_next_auto_increment_id('loyalty_program_images');
            $pair_data = fn_attach_image_pairs('cards_main', 'loyalty_program', $card_image_id, $lang_code);
            if (!empty($pair_data)) {
                db_query('INSERT INTO ?:loyalty_program_images ?e', $data_card_image);
                fn_sd_loyalty_program_image_all_links($card_id, $pair_data, $lang_code);
            }
        }
    }

    return $card_id;
}

function fn_sd_loyalty_program_get_card_image_id($card_id, $lang_code = DESCR_SL)
{
    return db_get_field('SELECT card_image_id FROM ?:loyalty_program_images WHERE card_id = ?i AND lang_code = ?s', $card_id, $lang_code);
}

function fn_sd_loyalty_program_need_image_update()
{
    if (!empty($_REQUEST['file_cards_main_image_icon']) && array($_REQUEST['file_cards_main_image_icon'])) {
        $card_image = reset($_REQUEST['file_cards_main_image_icon']);

        if ($card_image == 'cards_main') {
            return false;
        }
    }

    return true;
}

function fn_sd_loyalty_program_image_all_links($card_id, $pair_data, $main_lang_code = DESCR_SL)
{
    if (!empty($pair_data)) {
        $pair_id = reset($pair_data);

        $lang_codes = Languages::getAll();
        unset($lang_codes[$main_lang_code]);

        foreach ($lang_codes as $lang_code => $lang_data) {
            $card_image_id = db_query('INSERT INTO ?:loyalty_program_images (card_id, lang_code) VALUE(?i, ?s)', $card_id, $lang_code);
            fn_add_image_link($card_image_id, $pair_id);
        }
    }
}

function fn_sd_loyalty_program_delete_card($card_id)
{
    if (!empty($card_id) && fn_check_company_id('loyalty_program', 'card_id', $card_id)) {
        db_query('DELETE FROM ?:loyalty_program WHERE card_id = ?i', $card_id);
        db_query('DELETE FROM ?:loyalty_program_descriptions WHERE card_id = ?i', $card_id);

        $card_images_ids = db_get_fields('SELECT card_image_id FROM ?:loyalty_program_images WHERE card_id = ?i', $card_id);

        foreach ($card_images_ids as $card_images_id) {
            fn_delete_image_pairs($card_images_id, 'loyalty_program');
        }

        db_query('DELETE FROM ?:loyalty_program_images WHERE card_id = ?i', $card_id);
    }
}

function fn_sd_loyalty_program_change_order_status($status_to, $status_from, $order_info, $force_notification, $order_statuses, $place_order)
{
    $allowed_order_status = Registry::get('addons.sd_loyalty_program.order_status');
    if (!empty($order_info['user_id']) && $status_to == $allowed_order_status) {
        $total_orders_sum = db_get_field('SELECT sum(total) FROM ?:orders WHERE user_id = ?i AND status = ?s', $order_info['user_id'], $allowed_order_status);
        $total_orders_sum += $order_info['total'];
        if (!empty($total_orders_sum)) {
            $company_id = db_get_field('SELECT company_id FROM ?:users WHERE user_id = ?i', $order_info['user_id']);
            $usergroup_list = fn_sd_loyalty_program_get_usergroups_by_order_total($total_orders_sum, $company_id);
            if (!empty($usergroup_list)) {
                fn_sd_loyalty_program_delete_old_usergroups($order_info['user_id'], $usergroup_list);
                foreach ($usergroup_list as $usergroup_id) {
                    fn_change_usergroup_status('A', $order_info['user_id'], $usergroup_id);
                    fn_sd_loyalty_program_update_cumulative_usergroup_link($order_info['user_id'], $usergroup_id);
                }
            }
        }
    }
}

function fn_sd_loyalty_program_get_usergroups_by_order_total($total_orders_sum, $company_id, $card_list = array())
{
    $usergroup_list = array();
    if (!empty($total_orders_sum)) {
        $shared_card_list = db_get_fields('SELECT share_object_id FROM ?:ult_objects_sharing WHERE share_object_type = ?s AND share_company_id = ?i', 'loyalty_program', $company_id);
        if (!empty($shared_card_list)) {
            $condition = db_quote('status = ?s', 'A');
            if (!empty($card_list) && !empty($shared_card_list)) {
                $new_card_list = array_intersect($shared_card_list, $card_list);
                $condition .= db_quote('AND card_id IN (?n) ', $new_card_list);
            } else {
                $condition .= db_quote('AND card_id IN (?n) ', $shared_card_list);
            }
            $usergroup_list = db_get_fields(
                'SELECT usergroup_id '
                . 'FROM ?:loyalty_program '
                . 'WHERE ?p AND amount = ('
                    . 'SELECT max(amount) '
                    . 'FROM ?:loyalty_program '
                    . 'WHERE amount <= ?i AND amount != ?i AND ?p'
                . ')', 
                $condition, $total_orders_sum, 0, $condition
            );
        }

    }

    return $usergroup_list;
}

function fn_sd_loyalty_program_delete_old_usergroups($user_id, $usergroup_list)
{
    if (!empty($user_id) && !empty($usergroup_list)) {
        db_query(
            'DELETE FROM ?:usergroup_links '
            . 'WHERE cumulative = ?s AND user_id = ?i AND usergroup_id NOT IN (?n)', 
            'Y', $user_id, $usergroup_list
        );
    }
}

function fn_sd_loyalty_program_update_cumulative_usergroup_link($user_id, $usergroup_id)
{
    if (!empty($user_id) && !empty($usergroup_id)) {
        db_query(
            'UPDATE ?:usergroup_links '
            . 'SET cumulative = ?s '
            . 'WHERE user_id = ?i AND usergroup_id = ?i', 
            'Y', $user_id, $usergroup_id
        );
    }
}

function fn_sd_loyalty_program_assign_usergroups($card_list, $company_id)
{
    if (!empty($card_list)) {
        $params = array(
            'user_type' => 'C'
        );
        if (fn_allowed_for('ULTIMATE')) {
            $params['company_id'] = $company_id;
        }
        list($users, $search) = fn_get_users($params, $_SESSION['auth']);
        $allowed_order_status = Registry::get('addons.sd_loyalty_program.order_status');
        foreach ($users as $user) {
            $total_orders_sum = db_get_field('SELECT sum(total) FROM ?:orders WHERE user_id = ?i AND status = ?s', $user['user_id'], $allowed_order_status);
            if (!empty($total_orders_sum)) {
                $company_id = db_get_field('SELECT company_id FROM ?:users WHERE user_id = ?i', $user['user_id']);
                $usergroup_list = fn_sd_loyalty_program_get_usergroups_by_order_total($total_orders_sum, $company_id, $card_list);
                if (!empty($usergroup_list)) {
                    fn_sd_loyalty_program_delete_old_usergroups($user['user_id'], $usergroup_list);
                    foreach ($usergroup_list as $usergroup_id) {
                        fn_change_usergroup_status('A', $user['user_id'], $usergroup_id);
                        fn_sd_loyalty_program_update_cumulative_usergroup_link($user['user_id'], $usergroup_id);
                    }
                }
            }
        }
    }
}

function fn_sd_loyalty_program_check_usergroups()
{
    $usergroups_exist = true;
    $usergroups = fn_get_usergroups(
        array(
            'type'            => 'C',
            'status'          => array('A', 'H'),
            'include_default' => false
        )
    );

    if (empty($usergroups)) {
        fn_set_notification('W', __('warning'), __('addons.sd_loyalty_program.no_available_usergroups'));
        $usergroups_exist = false;
    }

    return $usergroups_exist;
}

function fn_sd_loyalty_program_check_selected_card($card_usergroup_id)
{
    if (fn_sd_loyalty_program_check_usergroups() && !empty($card_usergroup_id)) {
        $usergroup_id = db_get_field('SELECT usergroup_id FROM ?:usergroups WHERE usergroup_id = ?i AND status IN (?a)', $card_usergroup_id, array('A', 'H'));
        if (empty($usergroup_id)) {
            fn_set_notification('W', __('warning'), __('addons.sd_loyalty_program.saved_usergroup_not_exists'));
        }
    }
}

function fn_settings_variants_addons_sd_loyalty_program_order_status()
{
    return fn_get_simple_statuses(STATUSES_ORDER);
}

function fn_sd_loyalty_program_loyalty_program_page_info()
{
    return __('addons.sd_loyalty_program.page_info');
}