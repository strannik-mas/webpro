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


if ($mode == 'update' && !isset($_REQUEST['is_ajax'])) {

    $_cart = $_SESSION['cart'];

    if (!empty($_cart['order_id'])) {
        $old_ship_data = db_get_field("SELECT data FROM ?:order_data WHERE order_id = ?i AND type = ?s", $_cart['order_id'], 'L');
        if (!empty($old_ship_data)) {
            $old_ship_data = unserialize($old_ship_data);
            foreach($old_ship_data as $group_key => $shipping) {
                if ($shipping['service_code'] == 'shoplogistics_pickup' && !empty($shipping['code_id'])) {
                    $_SESSION['cart']['select_pickup'][$shipping['group_key']][$shipping['shipping_id']] = $shipping['code_id'];

                    Registry::get('view')->assign('old_ship_data', $old_ship_data);

                }
            }
        }
    }
}

if ($mode == "update_shipping") {

    if (!empty($_REQUEST['select_pickup'])) {
        foreach($_REQUEST['select_pickup'] as $g_id => $select) {
            foreach($select as $s_id => $o_id) {
                $_SESSION['cart']['select_pickup'][$g_id][$s_id] = $o_id;
            }
        }
    }

}



