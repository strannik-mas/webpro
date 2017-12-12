{assign var="id" value=$n.sf_id|default:0}
{capture name="mainbox"}
<form action="{""|fn_url}" method="post" class="form-horizontal form-edit" name="ab__sf_name_form" enctype="multipart/form-data">
<input type="hidden" class="cm-no-hide-input" name="sf_id" value="{$id}" />
<div class="control-group">
<a href="{"ab__sf_names.manage"|fn_url}">{__("ab__sf.all_combinations")}</a>
{if $id}
<a target="_blank" style="display: block; float: right; " href="{"categories.view&category_id=`$n.category_id`&features_hash=`$n.features_hash`"|fn_url:"C":"current":$smarty.const.DESCR_SL}">{__("ab__sf.name.preview")} [{$smarty.const.DESCR_SL}]</a>
{/if}
</div>
<div id="content_general">
{assign var="elm" value="category_id"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
{if "categories"|fn_show_picker:$smarty.const.CATEGORY_THRESHOLD}
{if $n.$elm}
{assign var="s_cid" value=$n.$elm}
{else}
{assign var="s_cid" value="0"}
{/if}
{include file="pickers/categories/picker.tpl" company_ids=$picker_selected_companies data_id="{$elm_id}" input_id="{$elm_id}" input_name="`$elm_name`" item_ids=$s_cid hide_link=true hide_delete_button=true default_name=__("all_categories") extra=""}
{else}
{if $runtime.mode == "picker"}
{assign var="trunc" value="38"}
{else}
{assign var="trunc" value="25"}
{/if}
<select name="{$elm_name}" id="{$elm_id}" class="input-large">
<option value="" {if $category_data.parent_id == "0"}selected="selected"{/if}>---</option>
{foreach from=0|fn_get_plain_categories_tree:false:$smarty.const.DESCR_SL:$picker_selected_companies item="search_cat" name=search_cat}
{if $search_cat.store}
{if !$smarty.foreach.search_cat.first}
</optgroup>
{/if}
<optgroup label="{$search_cat.category}">
{assign var="close_optgroup" value=true}
{else}
<option value="{$search_cat.category_id}" {if $search_cat.disabled}disabled="disabled"{/if} {if $n.$elm == $search_cat.category_id}selected="selected"{/if} title="{$search_cat.category}">{$search_cat.category|escape|truncate:$trunc:"...":true|indent:$search_cat.level:"&#166;&nbsp;&nbsp;&nbsp;&nbsp;":"&#166;--&nbsp;" nofilter}</option>
{/if}
{/foreach}
{if $close_optgroup}
</optgroup>
{/if}
</select>
{/if}
</div>
</div>
{assign var="elm" value="features_hash"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" name="{$elm_name}" id="{$elm_id}" value="{$n.$elm}" size="25" class="input-large" />
<p style="font-size:12px; color:#333;">{strip}
{if !empty($n.tooltip)}
{foreach from=$n.tooltip key="f" item="v" name="t"}
<b>{$f}</b>: {', '|implode:$v}{if !$smarty.foreach.t.last}; {/if}
{/foreach}
{/if}
{/strip}</p>
</div>
</div>
{assign var="elm" value="name"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" name="{$elm_name}" id="{$elm_id}" value="{$n.$elm}" size="25" class="input-large" />
</div>
</div>
{assign var="elm" value="fixed"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<label class="radio inline" for="{$elm_id}_{"ABSFConfigs::PAGE_STATE_FIXED"|enum}">
<input type="radio" name="{$elm_name}" id="{$elm_id}_{"ABSFConfigs::PAGE_STATE_FIXED"|enum}" value="{"ABSFConfigs::PAGE_STATE_FIXED"|enum}" {if $n.$elm == "ABSFConfigs::PAGE_STATE_FIXED"|enum or !$id}checked="checked"{/if}>{__("ab__sf.page_state.fixed")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.page_state.fixed.tooltip")}
</label>
<label class="radio inline" for="{$elm_id}_{"ABSFConfigs::PAGE_STATE_UNFIXED"|enum}">
<input type="radio" name="{$elm_name}" id="{$elm_id}_{"ABSFConfigs::PAGE_STATE_UNFIXED"|enum}" value="{"ABSFConfigs::PAGE_STATE_UNFIXED"|enum}" {if $n.$elm == "ABSFConfigs::PAGE_STATE_UNFIXED"|enum}checked="checked"{/if}>{__("ab__sf.page_state.unfixed")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.page_state.unfixed.tooltip")}
</label>
<label class="radio inline" for="{$elm_id}_{"ABSFConfigs::PAGE_STATE_HIDDEN"|enum}">
<input type="radio" name="{$elm_name}" id="{$elm_id}_{"ABSFConfigs::PAGE_STATE_HIDDEN"|enum}" value="{"ABSFConfigs::PAGE_STATE_HIDDEN"|enum}" {if $n.$elm == "ABSFConfigs::PAGE_STATE_HIDDEN"|enum}checked="checked"{/if}>{__("ab__sf.page_state.hidden")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.page_state.hidden.tooltip")}
</label>
</div>
</div>
{assign var="elm" value="tag_h1"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" value="{$n.$elm}" size="25" class="input-large" />
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="page_title"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" value="{$n.$elm}" size="25" class="input-large" />
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="description"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<textarea placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" class="input-large cm-wysiwyg">{$n.$elm}</textarea>
</div>
</div>
{assign var="elm" value="meta_keywords"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<textarea placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" class="input-large">{$n.$elm}</textarea>
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="meta_description"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<textarea placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" class="input-large">{$n.$elm}</textarea>
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="breadcrumb"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" value="{$n.$elm}" size="25" class="input-large" />
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="product_breadcrumb"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_name_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.name.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" value="{$n.$elm}" size="25" class="input-large" />
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
</div>
</form>
{/capture}
{capture name="buttons"}
{if !$id}
{include file="buttons/save_cancel.tpl" but_role="submit-link" but_target_form="ab__sf_name_form" but_name="dispatch[ab__sf_names.update]"}
{else}
{include file="buttons/save_cancel.tpl" but_name="dispatch[ab__sf_names.update]" but_role="submit-link" but_target_form="ab__sf_name_form" hide_first_button=false hide_second_button=false save=$id}
{capture name="tools_list"}
{if $id}
{assign var="preview" value=__("ab__sf.name.preview")}
<li>{btn type="list" target="_blank" text="`$preview` [`$smarty.const.DESCR_SL`]" class="" href="{"categories.view&category_id=`$n.category_id`&features_hash=`$n.features_hash`"|fn_url:"C":"current":$smarty.const.DESCR_SL}"}</li>
<li class="divider"></li>
{/if}
<li>{btn type="list" text=__("delete") class="cm-confirm cm-post" href="ab__sf_names.delete?sf_id=`$id`"}</li>
{/capture}
{dropdown content=$smarty.capture.tools_list}
{/if}
{/capture}
{notes}
{__("ab__sf.rule.notes")}
{/notes}
{if !$id}
{assign var="title" value=__("ab__sf.name.add")}
{else}
{assign var="title" value="{__("ab__sf.name.edit")} ID: `$id`"}
{/if}
{include file="common/mainbox.tpl" title=$title content=$smarty.capture.mainbox buttons=$smarty.capture.buttons select_languages=true}
