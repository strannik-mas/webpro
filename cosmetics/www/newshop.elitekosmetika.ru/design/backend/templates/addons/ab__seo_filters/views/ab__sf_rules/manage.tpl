{capture name="mainbox"}
<form action="{""|fn_url}" method="post" name="manage_ab__sf_rules_form" id="manage_ab__sf_rules_form">
{include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id}
{if $ab__sf_rules}
<table class="table">
<thead>
<tr>
<th width="1%" class="left">
{include file="common/check_items.tpl" check_statuses=''|fn_get_default_status_filters:false:$smarty.const.DESCR_SL}
</th>
<th width="1%"><span>{__("ab__sf.rule.field.id")}</span></th>
<th width="5%"><span>{__("ab__sf.rule.field.position")}</span></th>
<th width="45%"><span>{__("ab__sf.rule.field.category")}</span></th>
<th width="15%"><span>{__("ab__sf.rule.field.feature")}</span></th>
<th width="5%" nowrap><span>{__("ab__sf.rule.field.generated_categories")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.generated_categories.tooltip")}</span></th>
<th width="5%" nowrap><span>{__("ab__sf.name.field.fixed")}</span></th>
<th width="5%">&nbsp;</th>
<th width="10%" class="right">{__("ab__sf.rule.field.status")}</th>
</tr>
</thead>
{foreach from=$ab__sf_rules item="r"}
<tr>
<td class="left"><input type="checkbox" name="rule_id[]" value="{$r.rule_id}" class="checkbox cm-item cm-item-status-{$r.status|lower}" /></td>
<td><a class="ab__sf_rule" href="{"ab__sf_rules.update?rule_id=`$r.rule_id`"|fn_url}">#{$r.rule_id}</a></td>
<td>{$r.position}</td>
<td>{", "|implode:$r.categories_description}</td>
<td>
{foreach from=$r.feature_name item="fn" key="kfn" name="fn"}
<a target="_blank" href="{"product_features.update&feature_id=`$kfn`"|fn_url}">{$fn}</a>{if !$smarty.foreach.fn.last}, {/if}
{/foreach}
</td>
<td>{if $r.generated_categories == 'by_all_filter_categories'}Y{else}-{/if}</td>
<td class="center">
{if $r.fixed == "ABSFConfigs::PAGE_STATE_FIXED"|enum}
<img title="{__("ab__sf.page_state.fixed")}" src="design/backend/media/images/addons/ab__seo_filters/page_state_fixed.png"/>
{elseif $r.fixed == "ABSFConfigs::PAGE_STATE_UNFIXED"|enum}
<img title="{__("ab__sf.page_state.unfixed")}" src="design/backend/media/images/addons/ab__seo_filters/page_state_unfixed.png"/>
{elseif $r.fixed == "ABSFConfigs::PAGE_STATE_HIDDEN"|enum}
<img title="{__("ab__sf.page_state.hidden")}" src="design/backend/media/images/addons/ab__seo_filters/page_state_hidden.png"/>
{/if}
</td>
<td class="nowrap">
<div class="hidden-tools">
{capture name="tools_list"}
<li>{btn type="list" text=__("edit") href="ab__sf_rules.update?rule_id=`$r.rule_id`"}</li>
<li>{btn class="cm-post" type="list" text=__("ab__sf.rule.generate") href="ab__sf_rules.generate?rule_id=`$r.rule_id`"}</li>
<li class="divider"></li>
<li>{btn type="list" text=__("ab__sf.rule.delete_name_not_deleted") class="cm-confirm cm-post" href="ab__sf_rules.delete?rule_id=`$r.rule_id`"}</li>
{/capture}
{dropdown content=$smarty.capture.tools_list}
</div>
</td>
<td class="right nowrap">
{include file="common/select_popup.tpl" popup_additional_class="dropleft" id=$r.rule_id status=$r.status hidden=false object_id_name="rule_id" table="ab__sf_rules"}
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
{include file="addons/ab__seo_filters/views/ab__sf_rules/components/ab__sf_rules_search_form.tpl" dispatch="ab__sf_rules.manage"}
{/capture}
{capture name="adv_buttons"}
{include file="common/tools.tpl" tool_href="ab__sf_rules.add" prefix="top" title=__("ab__sf.rule.add") hide_tools=true icon="icon-plus"}
{/capture}
{capture name="buttons"}
{if $ab__sf_rules}
{capture name="tools_list"}
<li>{btn type="list" text=__("ab__sf.rule.generate") dispatch="dispatch[ab__sf_rules.generate]" form="manage_ab__sf_rules_form"}</li>
<li class="divider"></li>
<li>{btn type="delete_selected" dispatch="dispatch[ab__sf_rules.m_delete]" form="manage_ab__sf_rules_form"}</li>
{/capture}
{dropdown content=$smarty.capture.tools_list}
{/if}
{/capture}
{include file="common/mainbox.tpl"
title=__("ab__sf.rules")
content=$smarty.capture.mainbox
adv_buttons=$smarty.capture.adv_buttons
select_languages=true
buttons=$smarty.capture.buttons
sidebar=$smarty.capture.sidebar
content_id="manage_ab__sf_rules"}