{foreach from=$order_info.shipping item="shipping_method"}
    {if $shipping_method.service_code == 'shoplogistics'}
        {assign var="shoplogistics_shipping" value=true}
    {/if}
{/foreach}

{if $shoplogistics_shipping}
{/if}