{capture name="mainbox"}
{strip}
{if isset($ab_addons.list) and is_array($ab_addons.list) and !empty($ab_addons.list)}
<table width="100%" class="table table-sort table-middle ab_addons_list">
<thead>
<tr>
<th width="1%">#</th>
<th width="1%">&nbsp;</th>
<th width="45%">{__('ab__am_addon_name')}</th>
<th class="center" width="6%">{__('ab__am_current_version')}</th>
<th class="center" width="20%">{__('ab__am_updates')}</th>
<th class="center" width="6%">{__('ab__am_actions')}</th>
</tr>
</thead>
{foreach from=$ab_addons.list item="a" name="a"}
{assign var="is_upd" value="N"}
{if isset($ab_addons.cs[$a.addon].lv) and !empty($ab_addons.cs[$a.addon].lv) and is_array($ab_addons.cs[$a.addon].lv)}
{assign var="is_upd" value="Y"}
{/if}
<tbody>
<tr>
<td style="vertical-align: top"><small>{$smarty.foreach.a.iteration}</small></td>
<td style="vertical-align: top"><div class="ab_logo"></div></td>
<td><div class="ab-md-title">{$a.name}</div><p>{$a.description nofilter}</p></td>
<td class="center">v{$a.version}</td>
<td class="center">
{if $ab_addons.cs[$a.addon].s == 'Error'}
<span class="ab_addon_no_upd">{__('ab__am_upd_error')}</span>
{else}
{if $is_upd == "N"}
<span class="type_of_update_No">{__('ab__am_upd_actual')}</span>
{else}
{if $ab_addons.cs[$a.addon].lv.p == 'N'}
<span class="type_of_update_{$ab_addons.cs[$a.addon].lv.p}">{__('ab__am_upd_general')}</span>
{elseif $ab_addons.cs[$a.addon].lv.p == 'M'}
<span class="type_of_update_{$ab_addons.cs[$a.addon].lv.p}">{__('ab__am_upd_mandatory')}</span>
{/if}
<br>
<small>v{$ab_addons.cs[$a.addon].lv.v} {__('ab__am_built_on')} {$ab_addons.cs[$a.addon].lv.t|fn_parse_date|date_format:"%d-%b-%Y"}</small>
{/if}
{/if}
{if $ab_addons.cs[$a.addon].ss == 'E' and $ab_addons.cs[$a.addon].sd > 0}
<br><small class="subscription">{__('ab__am_updates_are_available')}<br>{$ab_addons.cs[$a.addon].sd|date_format:"%d-%b-%Y"}</small>
{elseif $ab_addons.cs[$a.addon].ss == 'D'}
<br><small class="subscription">{__('ab__am_subscribe_to_updates_has_expired')}<br>{$ab_addons.cs[$a.addon].sd|date_format:"%d-%b-%Y"}</small>
{/if}
</td>
<td class="center">
{if $is_upd == "Y" and ($ab_addons.cs[$a.addon].ss == 'E' or $ab_addons.cs[$a.addon].ss == 'I')}
{include file="buttons/button.tpl" but_text=__('ab__am_button_update') but_role="button" but_onclick="var ui=$(this).parent().parent().next(); if(ui.hasClass('hidden')) ui.removeClass('hidden'); else ui.addClass('hidden');" but_meta="btn"}
{/if}
</td>
</tr>
{if $is_upd == "Y"}
<tr class="upd_info hidden">
<td>&nbsp;</td>
<td colspan="5">
{__('ab__am_upd_text_msg', ["[name]" => $a.name])}
{if $a.addon == 'ab__addons_manager'}
{__("ab__am_upd_text_msg_manager", ["[href_api]" => "https://cs-cart.alexbranding.com/api/?r=gm&c=`$addons[$a.addon].code`&o=`$ab_addons.cs[$a.addon].lv.o`","[name]" => $a.name,"[href_addons]" => fn_url("addons.manage")])}
{else}
{__('ab__am_upd_text_msg_addon', ["[name]" => $a.name, "[href_addons]" => fn_url("addons.manage"), "[code]" => $addons[$a.addon].code, "[href_ab__am_addons]"=>fn_url("ab__am.addons"), "[ab__am_addons]"=>__('ab__am_addons')])}
{/if}
<br>
{if strlen($ab_addons.cs[$a.addon].lv.c)}
{capture name="changes"}{$ab_addons.cs[$a.addon].lv.c|nl2br nofilter}{/capture}
{__('ab__am_upd_text_changes', ["[version]" => $ab_addons.cs[$a.addon].lv.v, "[date]" => $ab_addons.cs[$a.addon].lv.t|fn_parse_date|date_format:"%d-%b-%Y", "[changes]" => $smarty.capture.changes])}
{/if}
</td>
</tr>
{/if}
{/foreach}
</tbody>
</table>
{else}
<p class="no-items">{__("no_data")}</p>
{/if}
{/strip}
{/capture}
{capture name="sidebar"}
{include file="addons/ab__addons_manager/views/ab__am/components/install_form.tpl"}
{/capture}
{include file="common/mainbox.tpl" title=__('ab__am_addons') content=$smarty.capture.mainbox buttons=$smarty.capture.buttons sidebar=$smarty.capture.sidebar}
