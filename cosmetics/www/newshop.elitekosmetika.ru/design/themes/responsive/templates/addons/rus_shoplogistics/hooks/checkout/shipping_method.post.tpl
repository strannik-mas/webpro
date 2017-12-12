{if $cart.chosen_shipping.$group_key == $shipping.shipping_id && $shipping.service_code == 'shoplogistics_pickup'}

    {assign var="shipping_id" value=$shipping.shipping_id}
    {assign var="old_pickup_id" value=$select_pickup.$group_key.$shipping_id}

    <div class="shoplogistics-block clearfix" >
        <div>
            <div>
                <div style="padding-left:50px;">
                    <input type="hidden" id="shoplogistics_var_name" value="select_pickup[{$group_key}][{$shipping.shipping_id}]" />

                    <input type="hidden" name="select_pickup[{$group_key}][{$shipping.shipping_id}]" value="{$old_pickup_id}" id="select_pickup" >
                    {script src="http://client-shop-logistics.ru/catalog/view/javascript/pickup_vidjet.js"}
                    {script src="js/addons/rus_shoplogistics/func.js"}
                  {foreach from=$shipping.data.pickups item=pickup}
                    {if $old_pickup_id == $pickup.code_id}
                       <div style="padding-left:20pz;">
                       <b>{$pickup.info}</b><br>
                       {__('shoplogistics_phone')}: {$pickup.phone}<br>
                       {__('shoplogistics_address')}: {$pickup.address}<br>
                       {__('shoplogistics_work_time')}: {$pickup.worktime}<br>
                       {__('shoplogistics_delivery_period')}: {$pickup.srok_dostavki} {__('shoplogistics_days')}<br>
                       </div>
                    {/if}
                   {/foreach}
                  <a href="#" onClick="openSL(setPickupPlace,'{$cart.user_data.s_city},{$cart.user_data.s_state_descr}',1,{$cart.subtotal},{$shipping.service_params.customer_code}); return false;">{__('shoplogistics_select_pickup')}</a>
                </div>
            </div>
        </div>
    </div>

{/if}