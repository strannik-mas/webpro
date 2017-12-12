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

$cart = & $_SESSION['cart'];
if ($mode == 'checkout' || $mode == 'shipping_estimation') {

    if (!empty($cart['product_groups']) && isset($_REQUEST['cur_price'])) {
        foreach ($cart['product_groups'] as $group_key => $group) {
            foreach ($group['shippings'] as $shipping_id => $shipping) {
                if ($shipping['service_code'] == 'shoplogistics_pickup') {
                    $cart['shippings_extra']['shoplogistics_pickup_price'] = $_REQUEST['cur_price'];
                    $cart['shippings_extra']['shoplogistics_pickup_code'] = $_REQUEST['pickup_code'];
                    $cart['shippings_extra']['shoplogistics_pickup_name'] = urldecode($_REQUEST['pickup_name']);
                }
            }
        }
    }
}

if ($mode == 'update_steps' || $mode == 'shipping_estimation') {

    if (!empty($_REQUEST['select_pickup'])) {
        foreach($_REQUEST['select_pickup'] as $g_id => $select) {
            foreach($select as $s_id => $o_id) {
                $_SESSION['cart']['select_pickup'][$g_id][$s_id] = $o_id;
            }
        }
    }

}

if ($mode == 'checkout' || $mode == 'cart') {

    if (!empty($_REQUEST['select_pickup'])) {
        foreach($_REQUEST['select_pickup'] as $g_id => $select) {
            foreach($select as $s_id => $o_id) {
                $_SESSION['cart']['select_pickup'][$g_id][$s_id] = $o_id;
            }
        }
    }

}

