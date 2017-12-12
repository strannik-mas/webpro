<?php
namespace Tygh\Shippings\Shoplogistics;
use Tygh\Registry;

class Shoplogistics
  {
    public $api_id = '';
    public $site_name = '';
    public $zabor_places_code = '';
    public $from_city_code = '';
    public $get_products_from_store = '';
    public $products_list = '';
    public $request_url = '';

    public function init() {
      $this->api_id = Registry::get('addons.rus_shoplogistics.api_id');
      $this->site_name = Registry::get('addons.rus_shoplogistics.site_name');
      $this->zabor_places_code = Registry::get('addons.rus_shoplogistics.zabor_places_code');
      $this->from_city_code = Registry::get('addons.rus_shoplogistics.from_city_code');
      $this->get_products_from_store = Registry::get('addons.rus_shoplogistics.get_products_from_store');
      $this->products_list = Registry::get('addons.rus_shoplogistics.products_list');
      $this->request_url = Registry::get('addons.rus_shoplogistics.request_url');
    }
    public function execute()
      {

         if (!extension_loaded('curl')) {
          return array('fatalError' => 'PHP extension CURL not loaded',);
         }

         if (!extension_loaded('SimpleXML')) {
          return array('fatalError' => 'PHP extension SimpleXML not loaded',);
         }

         if (!extension_loaded('dom')) {
          return array('fatalError' => 'PHP extension DOM not loaded',);
         }

         $task = $_REQUEST['sl_task'];
         if ($task == 'send')
           {
           	 return $this->sendOrder();
           }
         else if ($task == 'update')
           {
           	 return $this->updateStatus();
           }
         else if ($task == 'post_send')
           {
           	 return $this->sendPostOrder();
           }
      }
    private function updateStatus() {
         $order_id = $_REQUEST['order_id'];
         $order_info = fn_get_order_info($order_id, false, true, false, true);

         $sl_order = db_get_row("SELECT * FROM ?:rus_shoplogistics_orders WHERE order_id = ?i", $order_id);

         $code = '';
         if (isset($sl_order['id']))
           {
           	 $code = $sl_order['code'];
           }
         else
           {           	 return array('fatalError' => 'Заказ еще не отправлен в ShopLogistics',);           }

         $dom = new \domDocument("1.0", "utf-8");
         $root = $dom->createElement("request");
         $dom->appendChild($root);


         $function = ($sl_order['type'] == 'post') ? 'get_post_deliveries' : 'get_deliveries';
         $child = $dom->createElement("function",$function);
         $root->appendChild($child);

         $child = $dom->createElement("api_id",$this->api_id);
         $root->appendChild($child);

         $child = $dom->createElement("code",$code);
         $root->appendChild($child);

         $xml_content = $this->sendRequest($dom->saveXML());

         try {
           $xml = new \SimpleXMLElement($xml_content);
         } catch (Exception $e) {
           return array('fatalError' => 'Ошибка в структуре xml или не правильно закодированно.',);
         }

         if ($sl_order['type'] != 'post') {
           $update_order = array(
                'status' => trim($xml->deliveries->delivery->status),
                'errors' => trim($xml->deliveries->delivery->errors),
                'current_filial' => trim($xml->deliveries->delivery->current_filial),
                'reciver_filial' => trim($xml->deliveries->delivery->reciver_filial),
                'updated_datetime ' => date('Y-m-d H:i:s')
           );
           db_query('UPDATE ?:rus_shoplogistics_orders SET ?u WHERE order_id = ?i', $update_order, $order_id);
         }
         else {
         if ($xml->deliveries->delivery->post_operation != '')
             {
             $post_status	= $xml->deliveries->delivery->post_operation .', '. $xml->deliveries->delivery->post_operation_attr;
            }
            $update_order = array(
                'status' => trim($xml->deliveries->delivery->status),
                'errors' => trim($xml->deliveries->delivery->errors),
                'post_status' => $post_status,
                'updated_datetime ' => date('Y-m-d H:i:s')
           );

           db_query('UPDATE ?:rus_shoplogistics_orders SET ?u WHERE order_id = ?i', $update_order, $order_id);
         }

         $alert_msg = 'Статус обновлен';

    	 $sl_order = db_get_row("SELECT * FROM ?:rus_shoplogistics_orders WHERE order_id = ?i", $order_id);

         return array(
            'fatalError' => '',
            'alert_msg' => $alert_msg,
            'status' => trim($sl_order['status']),
            'post_status' => trim($sl_order['post_status']),
            'type' => trim($sl_order['type']),
            'errors' => trim($sl_order['errors']),
            'current_filial' => trim($sl_order['current_filial']),
            'reciver_filial' => trim($sl_order['reciver_filial']),
         );
    }

    private function sendOrder() {
         $order_id = $_REQUEST['order_id'];
         $delivery_date = $_REQUEST['delivery_date'];
         $time_from = $_REQUEST['time_from'];
         $time_to = $_REQUEST['time_to'];

         $order_info = fn_get_order_info($order_id, false, true, false, true);

         $sl_order = db_get_row("SELECT * FROM ?:rus_shoplogistics_orders WHERE order_id = ?i", $order_id);

         $code = '';
         if (isset($sl_order['id']))
           {
           	 $code = $sl_order['code'];
           }

         if (isset($sl_order['id']) && $sl_order['type'] == 'post')
           {             return array('fatalError' => 'Доставка уже отпрвлена как почтовая',);           }

          $dom = new \domDocument("1.0", "utf-8");
          $root = $dom->createElement("request");
          $dom->appendChild($root);

          $child = $dom->createElement("function","add_delivery");
          $root->appendChild($child);

          $child = $dom->createElement("api_id",$this->api_id);
          $root->appendChild($child);

          $child = $dom->createElement("deliveries");
          $root->appendChild($child);

           $delivery = $dom->createElement("delivery");
           $child->appendChild($delivery);

            $child2 = $dom->createElement("delivery_date",$delivery_date);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("date_transfer_to_store",date("Y-m-d"));
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("picking_date",$delivery_date);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("from_city",$this->from_city_code);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("to_city",$order_info['s_city'].','.$order_info['s_state_descr']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("time_from",$time_from);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("time_to",$time_to);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("order_id",$order_id);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("address",$order_info['s_address'] .' '. $order_info['s_address_2']);
            $delivery->appendChild($child2);

            $contact_person = $order_info['s_firstname'].' '.$order_info['s_lastname'];
            $child2 = $dom->createElement("contact_person",$contact_person);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("phone",$order_info['s_phone']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("phone_sms",$order_info['s_phone']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("price",$order_info['total']);
            $delivery->appendChild($child2);


            $child2 = $dom->createElement("delivery_discount_for_customer",$order_info['subtotal_discount']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("delivery_discount_porog_for_customer",0);
            $delivery->appendChild($child2);

          //  return array('fatalError' => json_encode($order_info),);

            $child2 = $dom->createElement("ocen_price",$order_info['total'] - $order_info['shipping_cost']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("site_name",$this->site_name);
            $delivery->appendChild($child2);

            $pickup_place = (isset($order_info['shipping'][0]['pickup_data'])) ? $order_info['shipping'][0]['pickup_data']['code_id'] : '';
            $child2 = $dom->createElement("pickup_place",$pickup_place);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("zabor_places_code",$this->zabor_places_code);
            $delivery->appendChild($child2);

            $get_products_from_store = ($this->get_products_from_store == 'Y') ? 1 : 0;
            $child2 = $dom->createElement("add_product_from_disct",intval($get_products_from_store));
            $delivery->appendChild($child2);

/*             $child2 = $dom->createElement("additional_info",$order_info['notes']);
            $delivery->appendChild($child2); */

            $child2 = $dom->createElement("address_index",$order_info['s_zipcode']);
            $delivery->appendChild($child2);


            if ($this->products_list == 'Y') {

            $child2 = $dom->createElement("products");
            $delivery->appendChild($child2);

            $products = $order_info['products'];
            while (list($key,$value) = each($products))
              {
              	$child3 = $dom->createElement("product");
                $child2->appendChild($child3);

              	$child4 = $dom->createElement("articul",$value['product_code']);
                $child3->appendChild($child4);

              	$child4 = $dom->createElement("name",$value['product']);
                $child3->appendChild($child4);

              	$child4 = $dom->createElement("quantity",$value['amount']);
                $child3->appendChild($child4);

              	$child4 = $dom->createElement("item_price",$value['price']);
                $child3->appendChild($child4);
              }
            }

        $xml_content = $this->sendRequest($dom->saveXML());
        try {
          $xml = new \SimpleXMLElement($xml_content);
        } catch (Exception $e) {
          return array('fatalError' => 'Ошибка в структуре xml или не правильно закодированно.',);
        }

        if ($xml->error == 1)
          {
          	return array('fatalError' => 'Ошибка: не найден API ID',);
          }


        $alert_msg = '';
        if (isset($sl_order['id']))
          {
            if ($xml->deliveries->delivery->error_code == 0 || $xml->deliveries->delivery->error_code == 5)
              {
                $update_order = array(
                      'order_id' => $order_id,
                      'code' => trim($xml->deliveries->delivery->code),
                      'type' => 'delivery',
                      'delivery_date' => $delivery_date,
                      'delivery_time_from' => $time_from,
                      'delivery_time_to' => $time_to,
                      'status' => trim($xml->deliveries->delivery->status),
                      'errors' => trim($xml->deliveries->delivery->errors),
                      'updated_datetime' => date('Y-m-d H:i:s')
                );
                db_query('UPDATE ?:rus_shoplogistics_orders SET ?u WHERE id = ?i', $update_order, $sl_order['id']);

                $alert_msg = 'Заявка на доставку обновлена в ShopLogistics';
              }
            else
              {
                $update_order = array(
                      'status' => trim($xml->deliveries->delivery->status),
                      'errors' => trim($xml->deliveries->delivery->errors),
                      'is_edit' => 0,
                      'updated_datetime ' => date('Y-m-d H:i:s')
                );
                db_query('UPDATE ?:rus_shoplogistics_orders SET ?u WHERE id = ?i', $update_order, $sl_order['id']);

                $alert_msg = 'Статус ShopLogistics не позволяет изменять заявку на доставку';
              }

          }
        else
          {
            $update_order = array(
               'order_id' => $order_id,
               'code' => trim($xml->deliveries->delivery->code),
               'type' => 'delivery',
               'delivery_date' => $delivery_date,
               'delivery_time_from' => $time_from,
               'delivery_time_to' => $time_to,
               'status' => trim($xml->deliveries->delivery->status),
               'errors' => trim($xml->deliveries->delivery->errors),
               'datetime' => date('Y-m-d H:i:s')
            );

            db_query("INSERT INTO ?:rus_shoplogistics_orders ?e", $update_order);

            $alert_msg = 'Заявка на доставку добавлена в ShopLogistics';
          }

          $sl_order = db_get_row("SELECT * FROM ?:rus_shoplogistics_orders WHERE order_id = ?i", $order_id);

          return array(
            'fatalError' => '',
            'alert_msg' => $alert_msg,
            'status' => trim($sl_order['status']),
            'post_status' => trim($sl_order['post_status']),
            'type' => trim($sl_order['type']),
            'errors' => trim($sl_order['errors']),
            'current_filial' => trim($sl_order['current_filial']),
            'reciver_filial' => trim($sl_order['reciver_filial']),
            );
 }
 private function sendPostOrder() {
         $order_id = $_REQUEST['order_id'];

         $order_info = fn_get_order_info($order_id, false, true, false, true);

         $sl_order = db_get_row("SELECT * FROM ?:rus_shoplogistics_orders WHERE order_id = ?i", $order_id);


         $code = '';
         if (isset($sl_order['id']))
           {
           	 $code = $sl_order['code'];
           }

         if (isset($sl_order['id']) && $sl_order['type'] == 'delivery')
           {
             return array('fatalError' => 'Доставка уже отпрвлена как обычная',);
           }

          $dom = new \domDocument("1.0", "utf-8");
          $root = $dom->createElement("request");
          $dom->appendChild($root);


          $child = $dom->createElement("function","add_post_delivery");
          $root->appendChild($child);

          $child = $dom->createElement("api_id",$this->api_id);
          $root->appendChild($child);

          $child = $dom->createElement("deliveries");
          $root->appendChild($child);

           $delivery = $dom->createElement("delivery");
           $child->appendChild($delivery);

            $child2 = $dom->createElement("order_id",$order_id);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("date_transfer_to_store",date("Y-m-d"));
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("zip",$order_info['s_zipcode']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("region",$order_info['s_state_descr']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("city",$order_info['s_city']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("address",$order_info['s_address'] .' '. $order_info['s_address_2']);
            $delivery->appendChild($child2);

            $contact_person = $order_info['s_firstname'].' '.$order_info['s_lastname'];
            $child2 = $dom->createElement("person",$contact_person);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("nested_type",'разное');
            $delivery->appendChild($child2);

            $price = $order_info['total'];
            $child2 = $dom->createElement("cash_on_delivery",$price);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("valuably",$order_info['total'] - $order_info['shipping_cost']);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("post_service",'Почта');
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("phone",$order_info['s_phone']);
            $delivery->appendChild($child2);			            $child2 = $dom->createElement("email",$order_info['email']);            $delivery->appendChild($child2);


            /*
            $ar = $contact->getFirst('email');
            $child2 = $dom->createElement("email",$ar['value']);
            $delivery->appendChild($child2);
            */

            $child2 = $dom->createElement("site_name",$this->site_name);
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("add_product_from_disct",intval($this->get_products_from_store));
            $delivery->appendChild($child2);

            $child2 = $dom->createElement("comments",$order_info['notes']);
            $delivery->appendChild($child2);

            if ($this->products_list == 1) {

            $child2 = $dom->createElement("products");
            $delivery->appendChild($child2);

            $products = $order_info['products'];
            while (list($key,$value) = each($products))
              {
              	$child3 = $dom->createElement("product");
                $child2->appendChild($child3);

              	$child4 = $dom->createElement("articul",$value['product_code']);
                $child3->appendChild($child4);

              	$child4 = $dom->createElement("name",$value['product']);
                $child3->appendChild($child4);

              	$child4 = $dom->createElement("quantity",$value['amount']);
                $child3->appendChild($child4);

              	$child4 = $dom->createElement("item_price",$value['price']);
                $child3->appendChild($child4);
              }
            }


        $xml_content = $this->sendRequest($dom->saveXML());
        try {
          $xml = new \SimpleXMLElement($xml_content);
        } catch (Exception $e) {
          return array('fatalError' => 'Ошибка в структуре xml или не правильно закодированно.',);
        }

        if ($xml->error == 1)
          {
          	return array('fatalError' => 'Ошибка: не найден API ID',);
          }

        $alert_msg = '';
        if (isset($sl_order['id']))
          {
            if ($xml->deliveries->delivery->error_code == 10)
              {              	return array('fatalError' => 'Номер заказа не задан, доставка не может быть добавлена',);              }
            if ($xml->deliveries->delivery->error_code == 12)
              {
                $update_order = array(
                      'order_id' => $order_id,
                      'code' => trim($xml->deliveries->delivery->code),
                      'type' => 'post',
                      'status' => trim($xml->deliveries->delivery->status),
                      'errors' => trim($xml->deliveries->delivery->errors),
                      'updated_datetime' => date('Y-m-d H:i:s')
                );
                db_query('UPDATE ?:rus_shoplogistics_orders SET ?u WHERE id = ?i', $update_order, $sl_order['id']);
                $alert_msg = 'Заявка на доставку обновлена в ShopLogistics';
              }
            else
              {
                $update_order = array(
                      'status' => trim($xml->deliveries->delivery->status),
                      'errors' => trim($xml->deliveries->delivery->errors),
                      'is_edit' => 0,
                      'updated_datetime ' => date('Y-m-d H:i:s')
                );
                db_query('UPDATE ?:rus_shoplogistics_orders SET ?u WHERE id = ?i', $update_order, $sl_order['id']);
                $alert_msg = 'Статус ShopLogistics не позволяет изменять заявку на доставку';
              }

          }
        else
          {
            $update_order = array(
               'order_id' => $order_id,
               'code' => trim($xml->deliveries->delivery->code),
               'type' => 'post',
               'status' => trim($xml->deliveries->delivery->status),
               'errors' => trim($xml->deliveries->delivery->errors),
               'datetime' => date('Y-m-d H:i:s')
            );
            db_query("INSERT INTO ?:rus_shoplogistics_orders ?e", $update_order);
            $alert_msg = 'Заявка на доставку добавлена в ShopLogistics';
          }

          $sl_order = db_get_row("SELECT * FROM ?:rus_shoplogistics_orders WHERE order_id = ?i", $order_id);

          return array(
            'fatalError' => '',
            'alert_msg' => $alert_msg,
            'status' => trim($sl_order['status']),
            'post_status' => trim($sl_order['post_status']),
            'type' => trim($sl_order['type']),
            'errors' => trim($sl_order['errors']),
            'current_filial' => trim($sl_order['current_filial']),
            'reciver_filial' => trim($sl_order['reciver_filial']),
            );
 }
 private function sendRequest($xml)
  {

  	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $this->request_url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($curl, CURLOPT_POSTFIELDS, 'xml='.urlencode(base64_encode($xml)));
    curl_setopt($curl, CURLOPT_USERAGENT, 'Opera 10.00');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
  }

 }
