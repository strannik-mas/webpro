{if $shipping.service_code == 'shoplogistics_pickup'}
{foreach from=$order_info.shipping item="shipping_method"}
    <li>{if $shipping_method.pickup_data}
            <p class="ty-strong">
                {$shipping_method.pickup_data.info}
            </p>
            <p class="ty-muted">
                {__('shoplogistics_phone')}: {$shipping_method.pickup_data.phone}<br />
                {__('shoplogistics_address')}: {$shipping_method.pickup_data.address}<br />
                {__('shoplogistics_work_time')}: {$shipping_method.pickup_data.worktime}<br />
                {__('shoplogistics_delivery_period')}: {$shipping_method.pickup_data.srok_dostavki} {__('shoplogistics_days')}<br />
            </p>
        {/if}
    </li>
{/foreach}
{/if}