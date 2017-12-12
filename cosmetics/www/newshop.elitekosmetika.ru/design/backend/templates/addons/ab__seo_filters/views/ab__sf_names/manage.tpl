{capture name="mainbox"}
<form action="{""|fn_url}" method="post" name="manage_ab__sf_names_form" id="manage_ab__sf_names_form">
{include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id}
{if $ab__sf_names}
{assign var="c_url" value=$config.current_url|fn_query_remove:"sort_by":"sort_order"}
{assign var="rev" value=$smarty.request.content_id|default:"pagination_contents"}
{assign var="c_icon" value="<i class=\"exicon-`$search.sort_order_rev`\"></i>"}
{assign var="c_dummy" value="<i class=\"exicon-dummy\"></i>"}
<table class="table">
<thead>
<tr>
<th width="1%" class="left">
{include file="common/check_items.tpl"}
</th>
<th width="34%"><a class="cm-ajax" href="{"`$c_url`&sort_by=category&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("ab__sf.name.field.category")}{if $search.sort_by == "category"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a>
<th width="25%"><a class="cm-ajax" href="{"`$c_url`&sort_by=name&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("ab__sf.name.field.name")}{if $search.sort_by == "name"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
<th width="25%"><a class="cm-ajax" href="{"`$c_url`&sort_by=features_hash&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("ab__sf.name.field.features_hash")}{if $search.sort_by == "features_hash"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
<th width="11%"><a class="cm-ajax" href="{"`$c_url`&sort_by=fixed&sort_order=`$search.sort_order_rev`"|fn_url}" data-ca-target-id={$rev}>{__("ab__sf.name.field.fixed")}{if $search.sort_by == "fixed"}{$c_icon nofilter}{else}{$c_dummy nofilter}{/if}</a></th>
<th width="5%">&nbsp;</th>
</tr>
</thead>
{foreach from=$ab__sf_names item="n"}
<tr>
<td class="left"><input type="checkbox" name="sf_id[]" value="{$n.sf_id}" class="checkbox cm-item cm-item-status-{$r.status|lower}" /></td>
<td>{$n.category_id|fn_get_category_name:$smarty.const.DESCR_SL}</td>
<td><a target="_blank" href="{"categories.view&category_id=`$n.category_id`&features_hash=`$n.features_hash`"|fn_url:"C":"current":$smarty.const.DESCR_SL}">{$n.name}&nbsp;»</a></td>
<td>
<a class="cm-tooltip" title="{strip}
{if !empty($n.tooltip)}
{foreach from=$n.tooltip key="f" item="v" name="t"}
<b>{$f}</b>: {', '|implode:$v}{if !$smarty.foreach.t.last}<br>{/if}
{/foreach}
{/if}
{/strip}" href="{"ab__sf_names.update?sf_id=`$n.sf_id`"|fn_url}">{$n.features_hash}</a>
</td>
<td class="center">
{if $n.fixed == "ABSFConfigs::PAGE_STATE_FIXED"|enum}
<img title="{__("ab__sf.page_state.fixed")}" src="design/backend/media/images/addons/ab__seo_filters/page_state_fixed.png"/>
{elseif $n.fixed == "ABSFConfigs::PAGE_STATE_UNFIXED"|enum}
<img title="{__("ab__sf.page_state.unfixed")}" src="design/backend/media/images/addons/ab__seo_filters/page_state_unfixed.png"/>
{elseif $n.fixed == "ABSFConfigs::PAGE_STATE_HIDDEN"|enum}
<img title="{__("ab__sf.page_state.hidden")}" src="design/backend/media/images/addons/ab__seo_filters/page_state_hidden.png"/>
{/if}
</td>
<td class="nowrap">
<div class="hidden-tools">
{capture name="tools_list"}
<li>{btn type="list" text=__("edit") href="ab__sf_names.update?sf_id=`$n.sf_id`"}</li>
<li>{btn type="list" text=__("delete") class="cm-confirm cm-post" href="ab__sf_names.delete?sf_id=`$n.sf_id`"}</li>
<li class="divider"></li>
{if $n.fixed == "ABSFConfigs::PAGE_STATE_FIXED"|enum}
<li>{btn type="list" text=__("ab__sf.name.unfix") class="cm-post" href="ab__sf_names.unfix?sf_id=`$n.sf_id`"}</li>
<li>{btn type="list" text=__("ab__sf.name.hide") class="cm-post" href="ab__sf_names.hide?sf_id=`$n.sf_id`"}</li>
{elseif $n.fixed == "ABSFConfigs::PAGE_STATE_UNFIXED"|enum}
<li>{btn type="list" text=__("ab__sf.name.fix") class="cm-post" href="ab__sf_names.fix?sf_id=`$n.sf_id`"}</li>
<li>{btn type="list" text=__("ab__sf.name.hide") class="cm-post" href="ab__sf_names.hide?sf_id=`$n.sf_id`"}</li>
{elseif $n.fixed == "ABSFConfigs::PAGE_STATE_HIDDEN"|enum}
<li>{btn type="list" text=__("ab__sf.name.fix") class="cm-post" href="ab__sf_names.fix?sf_id=`$n.sf_id`"}</li>
<li>{btn type="list" text=__("ab__sf.name.unfix") class="cm-post" href="ab__sf_names.unfix?sf_id=`$n.sf_id`"}</li>
{/if}
<li class="divider"></li>
<li>{btn type="list" target="_blank" text="{__("ab__sf.name.preview")} [`$smarty.const.DESCR_SL`]" class="" href="{"categories.view&category_id=`$n.category_id`&features_hash=`$n.features_hash`"|fn_url:"C":fn_get_storefront_protocol(""):$smarty.const.DESCR_SL}"}</li>
{/capture}
{dropdown content=$smarty.capture.tools_list}
</div>
</td>
</tr>
{/foreach}
</table>
{else}
<p class="no-items">{__("no_data")}</p>
{/if}
<div class="clearfix">
{include file="common/pagination.tpl" div_id=$smarty.request.content_id}
</div>
</form>
{/capture}
{capture name="sidebar"}
{include file="addons/ab__seo_filters/views/ab__sf_names/components/ab__sf_names_search_form.tpl" dispatch="ab__sf_names.manage"}
{/capture}
{capture name="adv_buttons"}
{include file="common/tools.tpl" tool_href="ab__sf_names.add" prefix="top" title=__("ab__sf.name.add") hide_tools=true icon="icon-plus"}
{/capture}
{capture name="buttons"}
{if $ab__sf_names}
{capture name="tools_list"}
<li>{btn type="list" text=__("ab__sf.name.fix_selected") dispatch="dispatch[ab__sf_names.fix]" form="manage_ab__sf_names_form"}</li>
<li>{btn type="list" text=__("ab__sf.name.unfix_selected") dispatch="dispatch[ab__sf_names.unfix]" form="manage_ab__sf_names_form"}</li>
<li>{btn type="list" text=__("ab__sf.name.hide_selected") dispatch="dispatch[ab__sf_names.hide]" form="manage_ab__sf_names_form"}</li>
<li class="divider"></li>
<li>{btn type="list" text=__("ab__sf.export_selected") dispatch="dispatch[ab__sf_names.export_selected]" form="manage_ab__sf_names_form"}</li>
<li>{btn type="list" class="cs-post" text=__("ab__sf.export_search") href="ab__sf_names.manage.export_search"}</li>
<li class="divider"></li>
<li>{btn type="delete_selected" dispatch="dispatch[ab__sf_names.m_delete]" form="manage_ab__sf_names_form"}</li>
{/capture}
{dropdown content=$smarty.capture.tools_list}
{/if}
{/capture}
{include file="common/mainbox.tpl"
title=__("ab__sf.names")
content=$smarty.capture.mainbox
adv_buttons=$smarty.capture.adv_buttons
select_languages=true
buttons=$smarty.capture.buttons
sidebar=$smarty.capture.sidebar
content_id="manage_ab__sf_names"}