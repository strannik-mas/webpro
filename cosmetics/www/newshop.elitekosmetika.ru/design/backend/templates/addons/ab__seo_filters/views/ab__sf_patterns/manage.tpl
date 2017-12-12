{capture name="mainbox"}
<form action="{""|fn_url}" method="post" name="manage_ab__sf_patterns_form" id="manage_ab__sf_patterns_form">
{include file="common/pagination.tpl" save_current_page=true save_current_url=true div_id=$smarty.request.content_id}
{if $ab__sf_patterns}
<table class="table">
<thead>
<tr>
<th width="25%"><span>{__("ab__sf.pattern.pattern")}</span></th>
<th width="75%"><span>{__("ab__sf.pattern.value")}</span></th>
</tr>
</thead>
{foreach from=$ab__sf_patterns item="p" key="kp"}
<tr>
<td><a href="{"ab__sf_patterns.update?pattern=`$kp`"|fn_url}">{__("ab__sf.name.`$kp`")}</a></td>
<td>{$p.value}</td>
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
{include file="common/mainbox.tpl"
title=__("ab__sf.patterns")
content=$smarty.capture.mainbox
adv_buttons=$smarty.capture.adv_buttons
select_languages=true
content_id="manage_ab__sf_patterns"}