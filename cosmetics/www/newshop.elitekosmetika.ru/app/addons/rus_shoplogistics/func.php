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


if ( !defined('AREA') ) { die('Access denied'); }

use Tygh\Registry;
use Tygh\Languages\Languages;

function fn_rus_shoplogistics_install()
{



    $shoplogistics_id = db_query("INSERT INTO ?:settings_objects (`edition_type`, `name`, `section_id`, `section_tab_id`, `type`, `value`, `position`, `is_global`) VALUES ('ROOT', 'shoplogistics_enabled', '7', '0', 'C', 'Y', '90', 'Y')");

    foreach (Languages::getAll() as $lang_code => $lang_data) {
        db_query("INSERT INTO ?:settings_descriptions (`object_id`, `object_type`, `lang_code`, `value`, `tooltip`) VALUES (?i, 'O', ?s, 'Включить ShopLogistics', '')", $shoplogistics_id, $lang_code);
    }

    $delivery_types = fn_rus_shoplogistics_get_delivery_types();
    for ($i = 0; $i < count($delivery_types); $i++)
      {
        $service = array(
          'status' => 'A',
          'module' => 'shoplogistics',
          'code' => $delivery_types[$i]['alias'],
          'sp_file' => '',
          'description' => $delivery_types[$i]['description'],
        );

        $service['service_id'] = db_query('INSERT INTO ?:shipping_services ?e', $service);

        foreach (Languages::getAll() as $service['lang_code'] => $lang_data) {
          db_query('INSERT INTO ?:shipping_service_descriptions ?e', $service);
        }
      }
    return true;
}

function fn_rus_shoplogistics_uninstall()
{
    $shoplogistics_id = db_get_field('SELECT object_id FROM ?:settings_objects WHERE name = ?s', 'shoplogistics_enabled');
    if (!empty($shoplogistics_id)) {
        db_query('DELETE FROM ?:settings_objects WHERE object_id = ?i', $shoplogistics_id);
        db_query('DELETE FROM ?:settings_descriptions WHERE object_id = ?i', $shoplogistics_id);
    }

    $delivery_types = fn_rus_shoplogistics_get_delivery_types();
    for ($i = 0; $i < count($delivery_types); $i++) {
      $service_ids = db_get_fields('SELECT service_id FROM ?:shipping_services WHERE module = ?s', $delivery_types[$i]['alias']);
      if (!empty($service_ids)) {
        db_query('DELETE FROM ?:shipping_services WHERE service_id IN (?a)', $service_ids);
        db_query('DELETE FROM ?:shipping_service_descriptions WHERE service_id IN (?a)', $service_ids);
       }
    }
    return true;
}

function fn_rus_shoplogistics_get_delivery_types()
{
  $ar = array(array('alias' => 'shoplogistics', 'description' => 'ShopLogistics - курьерская доставка'),
              array('alias' => 'shoplogistics_pickup', 'description' => 'ShopLogistics - доставка в пункты самовывоза')
             );
  return $ar;
}

function fn_rus_shoplogistics_place_order($order_id, $action, $order_status, $cart, $auth)
{

}



function fn_rus_shoplogistics_calculate_cart_taxes_pre(&$cart, $cart_products, &$product_groups)
{
    //service_code
    if (!empty($cart['shippings_extra']['data'])) {

        if (!empty($cart['select_pickup'])) {
            $select_pickup = $cart['select_pickup'];
        } elseif (!empty($_REQUEST['select_pickup'])) {
            $select_pickup = $cart['select_pickup'] = $_REQUEST['select_pickup'];
        }

        if (!empty($select_pickup)) {
            foreach ($product_groups as $group_key => $group) {
                if (!empty($group['chosen_shippings'])) {
                    foreach ($group['chosen_shippings'] as $shipping_key => $shipping) {
                        $shipping_id = $shipping['shipping_id'];

                        if($shipping['service_code'] != 'shoplogistics_pickup') {
                            continue;
                        }
                        if (!empty($cart['shippings_extra']['data'][$group_key][$shipping_id])) {
                            $shippings_extra = $cart['shippings_extra']['data'][$group_key][$shipping_id];

                            $product_groups[$group_key]['chosen_shippings'][$shipping_key]['data'] = $shippings_extra;

                            if (!empty($select_pickup[$group_key][$shipping_id])) {
                                $code_id = $select_pickup[$group_key][$shipping_id];
                                $product_groups[$group_key]['chosen_shippings'][$shipping_key]['code_id'] = $code_id;
                                if (!empty($shippings_extra['pickups'][$code_id])) {
                                    $pickup_data = $shippings_extra['pickups'][$code_id];
                                    $product_groups[$group_key]['chosen_shippings'][$shipping_key]['pickup_data'] = $pickup_data;
                                }
                            }
                        }
                    }
                }
            }
        }


        if (!empty($cart['shippings_extra']['data'])) {
            foreach($cart['shippings_extra']['data'] as $group_key => $shippings) {
                foreach($shippings as $shipping_id => $shippings_extra) {

                    if (!empty($product_groups[$group_key]['shippings'][$shipping_id]['service_code'])) {
                        $module = $product_groups[$group_key]['shippings'][$shipping_id]['service_code'];
                        if ($module == 'shoplogistics_pickup' && !empty($shippings_extra)) {
                            $product_groups[$group_key]['shippings'][$shipping_id]['data'] = $shippings_extra;

                            if (!empty($shippings_extra['delivery_time'])) {
                                $product_groups[$group_key]['shippings'][$shipping_id]['delivery_time'] = $shippings_extra['delivery_time'];
                            }
                        }
                    }
                }
            }
        }


        foreach ($product_groups as $group_key => $group) {
            if (!empty($group['chosen_shippings'])) {
                foreach ($group['chosen_shippings'] as $shipping_key => $shipping) {
                    $shipping_id = $shipping['shipping_id'];
                    $module = $shipping['service_code'];
                    if ($module == 'shoplogistics_pickup' && !empty($cart['shippings_extra']['data'][$group_key][$shipping_id])) {
                        $shipping_extra = $cart['shippings_extra']['data'][$group_key][$shipping_id];
                        $product_groups[$group_key]['chosen_shippings'][$shipping_key]['data'] = $shipping_extra;
                    }

                }
            }
        }

    }

}
