{capture name="mainbox"}
{strip}
{if isset($ab_addons) and is_array($ab_addons) and !empty($ab_addons)}
<table width="100%" class="table table-sort table-middle ab_addons_list">
<thead>
<tr>
<th width="1%">#</th>
<th width="1%">&nbsp;</th>
<th width="50%">{__('ab__am_addon_name')}</th>
<th class="center" width="10%">{__('ab__am_current_version')}</th>
<th class="center" width="10%">{__('ab__am_price')}</th>
<th class="center" width="10%">{__('ab__am_rating')}</th>
</tr>
</thead>
{foreach from=$ab_addons item="a" name="a"}
<tbody>
<tr>
<td style="vertical-align: top"><small>{$smarty.foreach.a.iteration}</small></td>
<td style="vertical-align: top"><div class="ab_logo"></div></td>
<td>
<a target="_blank" href="{$a.product.url}" class="ab-md-title">{$a.product.name}</a>
<br>{$a.product.description nofilter}
{if isset($a.build)}
<div class="compatible-info">
<span class="compatible-title">{__('ab__am_compatible')}&nbsp;<b class="caret"></b></span>{if $a.build.c == "Y" and !in_array($a.key,$installed_ab_addons)}<span class="compatible-status" title="{__('ab__am_compatible_with_your_store')}">&nbsp</span>{/if}<br>
<div class="compatible-text hidden">
<p><label>CS-Cart Ultimate:</label> <b>{$a.build.u}</b></p>
<p><label>CS-Cart Multivendor:</label> <b>{if $a.build.m == "No"}{__('ab__am_no')}{else}{$a.build.m}{/if}</b></p>
<p><label>{__('ab__am_multiple_store')}:</label> <b>{if $a.build.s == "Y"}{__('ab__am_yes')}{else}{__('ab__am_no')}{/if}</b></p>
<p><label>{__('ab__am_supported_languages')}:</label> <b>{$a.build.l}</b></p>
</div>
</div>
{/if}
</td>
<td class="center">{if isset($a.build.v)}
<b>v{$a.build.v}</b><br>
<small>{__('ab__am_built_on')} {$a.build.t|fn_parse_date|date_format:"%d-%b-%Y"}</small><br>
{if in_array($a.key,$installed_ab_addons)}<span class="installed">{__('ab__am_already_installed')}</span>{/if}
{else}{__('ab__am_no_data')}{/if}</td>
<td class="center">
{__('ab__am_from')} <b>${$a.product.price|intval}</b>
</td>
<td class="center">
{if $a.product.rating > 0}
<div class="star-ratings-sprite"><span style="width:{math equation="20*y" y=$a.product.rating}%" class="rating"></span></div>
{/if}
{if $a.product.reviews > 0}
<span class="reviews" onclick="var ui=$(this).parent().parent().next(); if(ui.hasClass('hidden')) ui.removeClass('hidden'); else ui.addClass('hidden');">{__('ab__am_reviews')}: {$a.product.reviews}</span>
{/if}
{if !in_array($a.key,$installed_ab_addons)}{include file="buttons/button.tpl" but_text=__('ab__am_to_buy') but_role="action" but_target="_blank" but_meta="btn btn-primary" but_href="`$a.product.url`"}{/if}
</td>
</tr>
{if $a.product.reviews > 0}
<tr class="upd_info hidden" id="posts_list">
<td colspan="6">
{foreach from=$a.product.posts item='p' name='p'}
<div class="ty-discussion-post__content">
<span class="ty-discussion-post__author">{$p.author}</span> <small>{$p.timestamp|fn_parse_date|date_format:"%d-%b-%Y"}</small>
<div class="ty-discussion-post">
<span class="ty-caret"><span class="ty-caret-outer"></span> <span class="ty-caret-inner"></span></span>
<div class="clearfix ty-discussion-post__rating">
<div class="star-ratings-sprite"><span style="width:{math equation="20*y" y=$p.rating}%" class="rating"></span></div>
</div>
<div class="ty-discussion-post__message">{$p.message}</div>
</div>
</div>
{/foreach}
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
{include file="common/mainbox.tpl" title=__("ab__am_store") content=$smarty.capture.mainbox buttons=$smarty.capture.buttons sidebar=$smarty.capture.sidebar}
