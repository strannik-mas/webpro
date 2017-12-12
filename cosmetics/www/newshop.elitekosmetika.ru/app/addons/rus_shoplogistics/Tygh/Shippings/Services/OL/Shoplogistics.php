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

// rus_build_edost dbazhenov

namespace Tygh\Shippings\Services;

use Tygh\Shippings\IService;
use Tygh\Registry;
use Tygh\Http;

/**
 * Edost shipping service
 */
class Shoplogistics implements IService
{
    /**
     * Abailability multithreading in this module
     *
     * @var array $_allow_multithreading
     */
    private $_allow_multithreading = false;

    /**
     * Stack for errors occured during the preparing rates process
     *
     * @var array $_error_stack
     */
    private $_error_stack = array();

    protected static $_error_descriptions = array(

    );

    /**
     * Current Company id environment
     *
     * @var int $company_id
     */
    public $company_id = 0;

    /**
     * Collects errors during preparing and processing request
     *
     * @param string $error
     */
    private function _internalError($error)
    {
        $this->_error_stack[] = $error;
    }

    /**
     * Gets numeric representation of Country/Region/City
     *
     * @param  array $destination Country, Region, City of geographic place
     * @return int   Numeric representation
     */
    private function _getDestinationCode($destination)
    {


    }

    /**
     * Checks if shipping service allows to use multithreading
     *
     * @return bool true if allow
     */
    public function allowMultithreading()
    {
        return $this->_allow_multithreading;
    }

    /**
     * Gets error message from shipping service server
     *
     * @param  string $resonse Reponse from Shipping service server
     * @return string Text of error or false if no errors
     */
    public function processErrors($response)
    {

    }

    /**
     * Sets data to internal class variable
     *
     * @param array $shipping_info
     */
    public function prepareData($shipping_info)
    {
$group_key = $shipping_info['keys']['group_key'];
       $shipping_id = $shipping_info['keys']['shipping_id'];


   /*
      print_r($_SESSION['cart']);
      exit;

      echo count($_SESSION['cart']['shippings_extra']['data'][$group_key][$shipping_id]['pickups']);
       exit;
      //  print_r($_SESSION['cart']);
      //  exit;
      */
        $this->_shipping_info = $shipping_info;
        $this->company_id = Registry::get('runtime.company_id');
    }
  private function sendRequest($xml)
  {

  	$curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://client-shop-logistics.ru/index.php?route=deliveries/api');
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

    /**
     * Prepare request information
     *
     * @return array Prepared data
     */
    public function getRequestData()
    {
      $city = $this->_shipping_info['package_info']['location']['city'] . ', ' . $this->_shipping_info['package_info']['location']['state_descr'];
      $order_price = $this->_shipping_info['package_info']['C'];
      $weight = ($this->_shipping_info['package_info']['W'] > 0) ? $this->_shipping_info['package_info']['W'] : $this->_shipping_info['service_params']['avg_weight'];
      if ($weight < 0.5) {$weight = 0.5;}

      $dom = new \domDocument("1.0", "utf-8");
      if ($this->_shipping_info['service_code'] == 'shoplogistics_pickup')
        {
           $root = $dom->createElement("request");
           $dom->appendChild($root);

           $child = $dom->createElement("function","get_deliveries_tarifs");
           $root->appendChild($child);

           $child = $dom->createElement("api_id",$this->_shipping_info['service_params']['api_id']);
           $root->appendChild($child);

           $child = $dom->createElement("from_city",$this->_shipping_info['service_params']['from_city_code_id']);
           $root->appendChild($child);

           $child = $dom->createElement("to_city",$city);
           $root->appendChild($child);

           $child = $dom->createElement("weight",$weight);
           $root->appendChild($child);

           $child = $dom->createElement("order_price",$order_price);
           $root->appendChild($child);

           $child = $dom->createElement("num",$this->_shipping_info['service_params']['avg_num']);
           $root->appendChild($child);
        }
      else
        {
          $root = $dom->createElement("request");
          $dom->appendChild($root);

          $child = $dom->createElement("function","get_delivery_price");
          $root->appendChild($child);

          $child = $dom->createElement("api_id",$this->_shipping_info['service_params']['api_id']);
          $root->appendChild($child);

          $child = $dom->createElement("from_city",$this->_shipping_info['service_params']['from_city_code_id']);
          $root->appendChild($child);

          $child = $dom->createElement("to_city",$city);
          $root->appendChild($child);

          $child = $dom->createElement("pickup_place",0);
          $root->appendChild($child);

          $child = $dom->createElement("weight",$weight);
          $root->appendChild($child);

          $child = $dom->createElement("num",$this->_shipping_info['service_params']['avg_num']);
          $root->appendChild($child);

          $child = $dom->createElement("tarifs_type",1);
          $root->appendChild($child);

          $child = $dom->createElement("price_options",1);
          $root->appendChild($child);

          $child = $dom->createElement("order_price",$order_price);
          $root->appendChild($child);

          $child = $dom->createElement("delivery_partner",'');
          $root->appendChild($child);

        }
      return $dom->saveXML();
    }

    /**
     * Process simple request to shipping service server
     *
     * @return string Server response
     */
    public function getSimpleRates()
    {
      $res = $this->sendRequest($this->getRequestData());

	  try {
          $xml = new \SimpleXMLElement($res);
      } catch (Exception $e) {
          return 'Ошибка получения данных';
      }
      return $xml;
    }

    /**
     * Gets shipping cost and information about possible errors
     *
     * @param  string $resonse Reponse from Shipping service server
     * @return array  Shipping cost and errors
     */
    public function processResponse($response)
    {
        $city = $this->_shipping_info['package_info']['location']['city'] . ', ' . $this->_shipping_info['package_info']['location']['state_descr'];

        if ($this->_shipping_info['service_code'] == 'shoplogistics_pickup')
          {
          	 $rates = $this->_getRates($response);
          	 $this->_fillSessionData($rates);

          	 if (count($rates['pickups']) > 0)
          	   {
          	     $return = array(
                    'cost' => $rates['price'],
                    'delivery_time' => $rates['date'],
                    'error' => false,
                 );
               }
             else
               {
               	 $return = array(
                    'cost' => false,
                    'error' => true,
                 );
               }
             return $return;
          }
        else
          {
            if ($response->error_code > 0)
		      {
			    $return = array(
                    'cost' => false,
                    'delivery_time' => 0,
                    'error' => false,
                );
                return $return;
		      }
            $price = $response->price;
            $ar = explode('-',$response->srok_dostavki);

            $return = array(
                    'cost' => $price,
                    'delivery_time' => $ar[count($ar)-1],
                    'error' => true,
                );
            return $return;
          }
    }
    /**
     * Process' server response and gets information in needed format
     *
     * @param  string $response XML server response
     * @return array  Prepared data
     */
    private function _getRates($response)
    {

       $shipping_info = $this->_shipping_info;

       $group_key = $shipping_info['keys']['group_key'];
       $shipping_id = $shipping_info['keys']['shipping_id'];

       $rates = array();
       $pickups = array();

       if ($this->_shipping_info['service_code'] == 'shoplogistics_pickup')
        {

          foreach ($response->tarifs->tarif as $tarif) {
            if ($tarif->pickup_place_code > 0)
              {
                $pickups[(string)$tarif->pickup_place_code] = array('code_id' => trim($tarif->pickup_place_code), 'info' => trim($tarif->pickup_place), 'address' => trim($tarif->address), 'price' => trim($tarif->price), 'phone' => trim($tarif->phone), 'srok_dostavki' => trim($tarif->srok_dostavki), 'worktime' => trim($tarif->worktime));
              }
          }

          if (isset($_SESSION['cart']['select_pickup'][$group_key][$shipping_id]) && isset($pickups[$_SESSION['cart']['select_pickup'][$group_key][$shipping_id]]['price']))
            {
              $rates['price'] = $pickups[$_SESSION['cart']['select_pickup'][$group_key][$shipping_id]]['price'];
              $rates['date'] = $pickups[$_SESSION['cart']['select_pickup'][$group_key][$shipping_id]]['srok_dostavki'];
            }
          else if (isset($_SESSION['cart']['shipping'][0]['code_id']) && isset($pickups[$_SESSION['cart']['shipping'][0]['code_id']]['price']))
            {
              $rates['price'] = $pickups[$_SESSION['cart']['shipping'][0]['code_id']]['price'];
              $rates['date'] = $pickups[$_SESSION['cart']['shipping'][0]['code_id']]['srok_dostavki'];
            }
          else
            {
              $rates['price'] = 1;
              $rates['date'] = '';
            }

          if (count($pickups) > 0) {
            $rates['pickups'] = $pickups;
          } else {
            $rates['pickups'] = array();
            $rates['clear'] = true;
          }
        }
      return $rates;
    }

    private function _fillSessionData($rates = array())
    {

        $shipping_info = $this->_shipping_info;

        $group_key = $shipping_info['keys']['group_key'];
        $shipping_id = $shipping_info['keys']['shipping_id'];

        if (!empty($rates['pickups'])){
            $_SESSION['cart']['shippings_extra']['data'][$group_key][$shipping_id]['pickups'] = $rates['pickups'];
        }

        if (!empty($rates['date'])){
            $_SESSION['cart']['shippings_extra']['data'][$group_key][$shipping_id]['delivery_time'] = $rates['date'];
        }

        if (!empty($rates['clear'])) {
            unset($_SESSION['cart']['shippings_extra']['data'][$group_key][$shipping_id]['pickups']);
        }

        return true;
    }


}
