{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="manage_yd_orders_form">

{include file="common/pagination.tpl" save_current_page=true save_current_url=true}

{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}
{assign var="c_icon" value="<i class=\"exicon-`$search.sort_order_rev`\"></i>"}
{assign var="c_dummy" value="<i class=\"exicon-dummy\"></i>"}

{if !empty($yd_orders)}
<table width="100%" class="table table-middle">
<thead>
<tr>
    <th class="center" width="5%">
        {include file="common/check_items.tpl"}
    </th>
    <th width="15%">
        <a class="cm-ajax" href="{"`$c_url`&sort_by=order_id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("order_id")}{if $search.sort_by == "order_id"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
    </th>
    <th width="10%">
        <a class="cm-ajax" href="{"`$c_url`&sort_by=id&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("shipment_id")}{if $search.sort_by == "id"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
    </th>
    <th width="20%">
        <a class="cm-ajax" href="{"`$c_url`&sort_by=customer&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("customer")}{if $search.sort_by == "customer"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
    </th>
    <th width="5%">&nbsp;</th>

    <th width="20%" class="right">
        <a class="cm-ajax" href="{"`$c_url`&sort_by=status&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("status")}{if $search.sort_by == "status"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
    </th>
</tr>
</thead>

{foreach from=$yd_orders item=order}
<tr>
    <td class="center">
        <input type="checkbox" name="yandex_ids[]" value="{$order.yandex_id}" class=" cm-item" />
    </td>
    <td>
        <span>{$order.yandex_full_num}</span>
    </td>
    <td>
        {if $order.shipment_id}
            <a class="underlined" href="{"shipments.manage?shipment_id=`$order.shipment_id`"|fn_url}"><span>#{$order.shipment_id}</span></a>
        {/if}
    </td>
    <td>
        {if $order.user_id}<a href="{"profiles.update?user_id=`$order.user_id`"|fn_url}">{/if}{$order.s_lastname} {$order.s_firstname}{if $order.user_id}</a>{/if}
        {if $order.company}<p class="muted nowrap">{$order.company}</p>{/if}
    </td>
    <td class="nowrap">

        <div class="hidden-tools">
            {assign var="return_current_url" value=$config.current_url|escape:url}
            {capture name="tools_list"}
                <li>{btn type="list" text=__("update") class="cm-confirm" href="yandex_delivery.update?yandex_ids[]=`$order.yandex_id`&redirect_url=`$return_current_url`" method="POST"}</li>
                <li>{btn type="list" text=__("cancel") class="cm-confirm" href="yandex_delivery.cancel?yandex_ids[]=`$order.yandex_id`&redirect_url=`$return_current_url`" method="POST"}</li>
                <li class="divider"></li>
                <li>{btn type="list" text=__("delete") class="cm-confirm" href="yandex_delivery.delete?yandex_ids[]=`$order.yandex_id`&redirect_url=`$return_current_url`" method="POST"}</li>
            {/capture}
            {dropdown content=$smarty.capture.tools_list}
        </div>

    </td>
    <td class="right">
        <span>{$order.status_name}</span>
    </td>

</tr>
{/foreach}
</table>
{else}
    <p class="no-items">{__("no_data")}</p>
{/if}

{include file="common/pagination.tpl"}
</form>
{/capture}

{capture name="buttons"}
    {capture name="tools_list"}
        {hook name="yandex_delivery:list_tools"}
        {if $yd_orders}
            <li>{btn type="list" text=__("yandex_delivery.yandex_update_selected") dispatch="dispatch[yandex_delivery.update]" form="manage_yd_orders_form"}</li>
            <li>{btn type="list" text=__("yandex_delivery.yandex_cancel_selected") dispatch="dispatch[yandex_delivery.cancel]" form="manage_yd_orders_form"}</li>
        {/if}
        {/hook}
        {if $yd_orders}
            <li class="divider"></li>
            <li>{btn type="delete_selected" dispatch="dispatch[yandex_delivery.delete]" form="manage_yd_orders_form"}</li>
        {/if}
    {/capture}
    {if $smarty.capture.tools_list|trim}
        {dropdown content=$smarty.capture.tools_list}
    {/if}
{/capture}

{capture name="sidebar"}
    {include file="common/saved_search.tpl" dispatch="yandex_delivery.manage" view_type="yandex_delivery"}
    {include file="addons/yandex_delivery/views/yandex_delivery/components/yd_search_form.tpl" dispatch="yandex_delivery.manage"}
{/capture}

{capture name="title"}
    {strip}
    {__("yandex_delivery.orders")}
    {if $smarty.request.yd_order_id}
        &nbsp;({__("order")}&nbsp;#{$smarty.request.yd_order_id})
    {/if}
    {/strip}
{/capture}
{include file="common/mainbox.tpl" title=$smarty.capture.title content=$smarty.capture.mainbox sidebar=$smarty.capture.sidebar buttons=$smarty.capture.buttons}