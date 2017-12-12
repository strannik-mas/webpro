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

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    fn_trusted_vars('card_data');

    $suffix = '.manage';

    if ($mode == 'update') {

        if (!empty($_REQUEST['card_data'])) {
            $card_id = fn_sd_loyalty_program_update_card($_REQUEST['card_data'], $_REQUEST['card_id'], DESCR_SL);
        }

        $suffix = ".update?card_id=$card_id";
    }

    if ($mode == 'delete') {

        if (!empty($_REQUEST['card_id'])) {
            fn_sd_loyalty_program_delete_card($_REQUEST['card_id']);
        }

    }

    if ($mode == 'm_delete') {

        foreach ($_REQUEST['card_ids'] as $v) {
            fn_sd_loyalty_program_delete_card($v);
        }

    }

    if ($mode == 'm_assign') {

        if (!empty($_REQUEST['card_ids'])) {
            fn_sd_loyalty_program_assign_usergroups($_REQUEST['card_ids'], Registry::get('runtime.company_id'));
            fn_set_notification('N', __('notice'), __('addons.sd_loyalty_program.usergroups_assigned_successfully'));
        }

    }

    return array(CONTROLLER_STATUS_OK, 'loyalty_program' . $suffix);
}

if ($mode == 'manage') {

    list($cards, $search) = fn_sd_loyalty_program_get_cards($_REQUEST, Registry::get('settings.Appearance.admin_elements_per_page'), DESCR_SL);

    Registry::get('view')->assign(array(
        'cards' => $cards,
        'usergroups_exist' => fn_sd_loyalty_program_check_usergroups(),
        'search' => $search
    ));

} elseif ($mode == 'update') {

    Registry::set('navigation.tabs', array (
        'general' => array (
            'title' => __('general'),
            'js' => true
        )
    ));

    if (!empty($_REQUEST['card_id'])) {
        $card = fn_sd_loyalty_program_get_card_data($_REQUEST['card_id'], DESCR_SL);
    }
    if (empty($card)) {
        return array(CONTROLLER_STATUS_NO_PAGE);
    } else {
        fn_sd_loyalty_program_check_selected_card($card['usergroup_id']);
    }

    Registry::get('view')->assign('card', $card);
}