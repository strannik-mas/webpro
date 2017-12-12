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
error_reporting(1);

if (!defined('BOOTSTRAP')) { die('Access denied'); }

use Tygh\Registry;
use Tygh\Shippings\Shoplogistics\Shoplogistics;


if ($_REQUEST['sl_task'] != '')
  {
    $sl_api = new Shoplogistics();
    $sl_api->init();
    $data['data'] = $sl_api->execute();
//    $data['data'] = array('fatalError' => 'Доставка dgdgcgvxdc',);
    echo json_encode($data);
    exit;
  }

if ($mode == 'details') {

    $order_id = intval($_REQUEST['order_id']);
    $sl_order = db_get_row("SELECT * FROM ?:rus_shoplogistics_orders WHERE order_id = ?i", $order_id);

    if (isset($sl_order['id']))
      {
        $delivery_date = $sl_order['delivery_date'];
        $delivery_time_from = substr($sl_order['delivery_time_from'],0,2);
        $delivery_time_to = substr($sl_order['delivery_time_to'],0,2);
      }
    else
      {
        $delivery_date = date("Y-m-d",mktime(0, 0, 0, date('m') , date('d')+1, date('Y')));
        $delivery_time_from = 10;
        $delivery_time_to = 18;
      }

    Registry::get('view')->assign('sl_delivery_date', $delivery_date);
    Registry::get('view')->assign('sl_delivery_time_from', $delivery_time_from . ':00:00');
    Registry::get('view')->assign('sl_delivery_time_to', $delivery_time_to . ':00:00');
    Registry::get('view')->assign('sl_order_info', $sl_order);
    Registry::get('view')->assign('sl_order_id', $order_id);

}


