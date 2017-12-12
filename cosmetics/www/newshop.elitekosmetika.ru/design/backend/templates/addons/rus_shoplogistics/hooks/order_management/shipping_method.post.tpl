{foreach from=$cart.shipping item=shoplogistics_pickup_shipping}
    {if $shoplogistics_pickup_shipping.service_code == 'shoplogistics_pickup'}
        {if $product_groups}
            {foreach from=$product_groups key=group_key item=group}
                {if $group.shippings && !$group.shipping_no_required}

                        {foreach from=$group.shippings item=shipping}
                            {if $cart.chosen_shipping.$group_key == $shipping.shipping_id}

                                {assign var="shipping_id" value=$shipping.shipping_id}
                                {assign var="old_pickup_id" value=$select_pickup.$group_key.$shipping_id}

                                <input type="hidden" id="shoplogistics_var_name" value="select_pickup[{$group_key}][{$shipping.shipping_id}]" />
                                <input type="hidden" name="select_pickup[{$group_key}][{$shipping.shipping_id}]" value="" id="select_pickup" >
                                <input type="hidden" id="update_mode" value="order_management.update_shipping" />

                                {script src="http://client-shop-logistics.ru/catalog/view/javascript/pickup_vidjet.js"}
                                {script src="js/addons/rus_shoplogistics/func.js"}

                                <a href="#" onClick="openSL(setPickupPlace,'{$cart.user_data.s_city},{$cart.user_data.s_state_descr}',1,{$cart.subtotal},{$shipping.service_params.customer_code}); return false;">{__('shoplogistics_select_pickup')}</a>
                            {/if}
                        {/foreach}
                {/if}
            {/foreach}
        {/if}
    {/if}
{/foreach}
