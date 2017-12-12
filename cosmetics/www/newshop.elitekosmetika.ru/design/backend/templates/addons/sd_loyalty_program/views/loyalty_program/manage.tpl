{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="loyalty_program_form" class=" cm-hide-inputs" enctype="multipart/form-data">

{include file="common/pagination.tpl" save_current_url=true}

{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}
{assign var="c_icon" value="<i class=\"exicon-`$search.sort_order_rev`\"></i>"}
{assign var="c_dummy" value="<i class=\"exicon-dummy\"></i>"}

{if $cards}
<table class="table table-middle sortable">
<thead>
<tr>
    <th width="1%" class="left">
        {include file="common/check_items.tpl" class="cm-no-hide-input"}</th>
    <th><a class="cm-ajax{if $search.sort_by == "name"} sort-link-{$search.sort_order_rev}{/if}" href="{"`$c_url`&sort_by=name&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("addons.sd_loyalty_program.card")}{if $search.sort_by == "name"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
    <th><a class="cm-ajax{if $search.sort_by == "amount"} sort-link-{$search.sort_order_rev}{/if}" href="{"`$c_url`&sort_by=amount&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("addons.sd_loyalty_program.card_value")} ({$currencies.$primary_currency.symbol nofilter}){if $search.sort_by == "amount"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
    <th><a class="cm-ajax{if $search.sort_by == "usergroup"} sort-link-{$search.sort_order_rev}{/if}" href="{"`$c_url`&sort_by=usergroup&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("usergroup")}{if $search.sort_by == "usergroup"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
    <th width="6%">&nbsp;</th>
    <th width="10%" class="right"><a class="cm-ajax{if $search.sort_by == "status"} sort-link-{$search.sort_order_rev}{/if}" href="{"`$c_url`&sort_by=status&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id="pagination_contents">{__("status")}{if $search.sort_by == "status"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
</tr>
</thead>
{foreach from=$cards item=card}
<tr class="cm-row-status-{$card.status|lower}">
    {assign var="allow_save" value=$card|fn_allow_save_object:"loyalty_program_cards"}

    {if $allow_save}
        {assign var="no_hide_input" value="cm-no-hide-input"}
    {else}
        {assign var="no_hide_input" value=""}
    {/if}

    <td class="left">
        <input type="checkbox" name="card_ids[]" value="{$card.card_id}" class="cm-item {$no_hide_input}" /></td>
    <td class="{$no_hide_input}">
        {if $usergroups_exist}
            <a class="row-status" href="{"loyalty_program.update?card_id=`$card.card_id`"|fn_url}">{$card.name}</a>
        {else}
            {$card.name}
        {/if}
        {include file="views/companies/components/company_name.tpl" object=$card}
    </td>
    <td class="nowrap row-status {$no_hide_input}">{$card.amount}</td>
    <td class="nowrap row-status {$no_hide_input}">{$card.usergroup_id|fn_get_usergroup_name}</td>
    <td>
        {capture name="tools_list"}
        {if $usergroups_exist}
            <li>{btn type="list" text=__("edit") href="loyalty_program.update?card_id=`$card.card_id`"}</li>
        {/if}
        {if $allow_save}
            <li>{btn type="list" class="cm-confirm cm-post" text=__("delete") href="loyalty_program.delete?card_id=`$card.card_id`"}</li>
        {/if}
        {/capture}
        <div class="hidden-tools">
            {dropdown content=$smarty.capture.tools_list}
        </div>
    </td>
    <td class="right">
        {include file="common/select_popup.tpl" id=$card.card_id status=$card.status object_id_name="card_id" table="loyalty_program" popup_additional_class="`$no_hide_input` dropleft" non_editable=!$usergroups_exist hidden=true}
    </td>
</tr>
{/foreach}
</table>
{else}
    <p class="no-items">{__("no_data")}</p>
{/if}

{include file="common/pagination.tpl"}

{capture name="buttons"}
    {capture name="tools_list"}
        {if $cards}
            <li>{btn type="delete_selected" dispatch="dispatch[loyalty_program.m_delete]" form="loyalty_program_form"}</li>
            {if $usergroups_exist}
                <li>{btn type="list" text=__("addons.sd_loyalty_program.assign_selected") dispatch="dispatch[loyalty_program.m_assign]" form="loyalty_program_form"}</li>
            {/if}
        {/if}
    {/capture}
    {dropdown content=$smarty.capture.tools_list}
{/capture}
{capture name="adv_buttons"}
    {if $usergroups_exist}
        {include file="common/tools.tpl" tool_href="loyalty_program.add" prefix="top" hide_tools="true" title=__("addons.sd_loyalty_program.add_card") icon="icon-plus"}
    {/if}
{/capture}

</form>

{/capture}
{include file="common/mainbox.tpl" title=__("addons.sd_loyalty_program.loyalty_program") content=$smarty.capture.mainbox buttons=$smarty.capture.buttons adv_buttons=$smarty.capture.adv_buttons select_languages=true}