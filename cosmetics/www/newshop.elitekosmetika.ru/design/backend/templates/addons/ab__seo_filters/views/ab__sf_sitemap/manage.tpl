{capture name="mainbox"}
<form action="{""|fn_url}" method="get" name="manage_ab__sf_sitemap_form" id="manage_ab__sf_sitemap_form" class="form-horizontal form-edit cm-processed-form cm-check-changes">
<input type="hidden" name="generate" value="Y">
<div id="content_general">
<div class="control-group">
<label class="control-label">{__("ab__sf.sitemap.languages")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.sitemap.languages.tooltip")}</label>
<div class="controls">
<select name="lang" class="input-large">
<option value="all">{__("ab__sf.sitemap.languages.all")}</option>
{foreach from=$avail_langs item='l' key='k'}
<option value="{$k}" {if $k == $search.lang}selected="selected"{/if}>{$l}</option>
{/foreach}
</select>
</div>
</div>
<div class="control-group">
<label class="control-label">{__("ab__sf.sitemap.fixed")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.sitemap.fixed.tooltip")}</label>
<div class="controls">
<select name="fixed" class="input-large">
<option value="all">{__("ab__sf.sitemap.fixed.all")}</option>
<option value="{"ABSFConfigs::PAGE_STATE_FIXED"|enum}" {if $search.fixed == "ABSFConfigs::PAGE_STATE_FIXED"|enum}selected="selected"{/if}>{__("ab__sf.sitemap.fixed.only_fixed")}</option>
<option value="{"ABSFConfigs::PAGE_STATE_UNFIXED"|enum}" {if $search.fixed == "ABSFConfigs::PAGE_STATE_UNFIXED"|enum}selected="selected"{/if}>{__("ab__sf.sitemap.fixed.only_unfixed")}</option>
</select>
</div>
</div>
</div>
</form>
{if strlen($sitemap)}
<hr>
{__("ab__sf.sitemap.generate.complete", ["[count]"=>$count|default:0, "[sitemap_url]"=>$sitemap_url, "[time]"=>$time|string_format:"%.3f"])}
<br>
<textarea style="background-color: rgba(245, 245, 245, 0.33); height: 600px; width: 100%; overflow: auto; width: 100% !important;">{$sitemap}</textarea>
{/if}
{/capture}
{capture name="buttons"}
{include file="buttons/button.tpl" but_text=__("ab__sf.sitemap.generate") but_name="dispatch[ab__sf_sitemap.manage]" but_role="submit-link" but_target_form="manage_ab__sf_sitemap_form"}
{/capture}
{include file="common/mainbox.tpl"
title=__("ab__sf.sitemap")
content=$smarty.capture.mainbox
buttons=$smarty.capture.buttons
content_id="manage_ab__sf_sitemap"}