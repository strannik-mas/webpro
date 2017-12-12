<div class="sidebar-row">
<h6>{__("search")}</h6>
<form action="{""|fn_url}" name="ab__sf_names_search_form" method="get" class="{$form_meta}">
{if $smarty.request.redirect_url}
<input type="hidden" name="redirect_url" value="{$smarty.request.redirect_url}" />
{/if}
{capture name="simple_search"}
<div class="sidebar-field">
<label for="name">{__("ab__sf.names.search_form.name")} [{$smarty.const.DESCR_SL}]:</label>
<input type="text" name="name" id="name" value="{$search.name}" size="20">
</div>
<div class="sidebar-field">
<label for="name">{__("ab__sf.names.search_form.features_hash")}:</label>
<input type="text" name="features_hash" id="features_hash" value="{$search.features_hash}" size="20">
</div>
<div class="sidebar-field">
<label>{__("ab__sf.names.search_form.by_features")}:</label>
<input type="hidden" name="feature_id" value="" />
<select name="feature_id[]" id="elm_feature_id" multiple="multiple">
{assign var="ungrouped_features" value=""}
{if $features}
{foreach from=$features item=feature}
{if $feature.feature_type == "G"}
<optgroup label="{$feature.description}">
{if !empty($feature.subfeatures) and is_array($feature.subfeatures)}
{foreach from=$feature.subfeatures item="subfeature"}
<option value="{$subfeature.feature_id}" {if !empty($search.feature_id) and is_array($search.feature_id) and in_array($subfeature.feature_id, $search.feature_id)}selected="selected"{/if}>{$subfeature.description}</option>
{/foreach}
{/if}
</optgroup>
{else}
{assign var="selected" value=""}
{if !empty($search.feature_id) and in_array($feature.feature_id,$search.feature_id)}{assign var="selected" value="selected='selected'"}{/if}
{assign var="ungrouped_features" value="{$ungrouped_features}<option {$selected} value='{$feature.feature_id}'>{$feature.description}</option>"}
{/if}
{/foreach}
{if !empty($ungrouped_features)}
<optgroup label="{__("ungroupped_features")}">
{$ungrouped_features nofilter}
</optgroup>
{/if}
{/if}
</select>
</div>
<div class="sidebar-field">
<label>{__("ab__sf.names.search_form.by_fixed")}:</label>
<select name="s_fixed">
<option value="">---</option>
<option value="{"ABSFConfigs::PAGE_STATE_FIXED"|enum}" {if $search.s_fixed == "ABSFConfigs::PAGE_STATE_FIXED"|enum}selected="selected"{/if}>{__("ab__sf.names.search_form.fixed")}</option>
<option value="{"ABSFConfigs::PAGE_STATE_UNFIXED"|enum}" {if $search.s_fixed == "ABSFConfigs::PAGE_STATE_UNFIXED"|enum}selected="selected"{/if}>{__("ab__sf.names.search_form.not_fixed")}</option>
<option value="{"ABSFConfigs::PAGE_STATE_HIDDEN"|enum}" {if $search.s_fixed == "ABSFConfigs::PAGE_STATE_HIDDEN"|enum}selected="selected"{/if}>{__("ab__sf.names.search_form.hidden")}</option>
</select>
</div>
<div class="sidebar-field">
<label>{__("ab__sf_names.search_form.by_categories")}:</label>
{if "categories"|fn_show_picker:$smarty.const.CATEGORY_THRESHOLD}
{if $search.category_id}
{assign var="s_cid" value=$search.category_id}
{else}
{assign var="s_cid" value="0"}
{/if}
{include file="pickers/categories/picker.tpl" company_ids=$picker_selected_companies data_id="location_category" input_name="category_id" item_ids=$s_cid hide_link=true hide_delete_button=true default_name=__("all_categories") extra=""}
{else}
{if $runtime.mode == "picker"}
{assign var="trunc" value="38"}
{else}
{assign var="trunc" value="25"}
{/if}
<select name="category_id">
<option value="0" {if $category_data.parent_id == "0"}selected="selected"{/if}>---</option>
{foreach from=0|fn_get_plain_categories_tree:false:$smarty.const.DESCR_SL:$picker_selected_companies item="search_cat" name=search_cat}
{if $search_cat.store}
{if !$smarty.foreach.search_cat.first}
</optgroup>
{/if}
<optgroup label="{$search_cat.category}">
{assign var="close_optgroup" value=true}
{else}
<option value="{$search_cat.category_id}" {if $search_cat.disabled}disabled="disabled"{/if} {if $search.category_id == $search_cat.category_id}selected="selected"{/if} title="{$search_cat.category}">{$search_cat.category|escape|truncate:$trunc:"...":true|indent:$search_cat.level:"&#166;&nbsp;&nbsp;&nbsp;&nbsp;":"&#166;--&nbsp;" nofilter}</option>
{/if}
{/foreach}
{if $close_optgroup}
</optgroup>
{/if}
</select>
{/if}
</div>
<div class="sidebar-field">
<label for="subcats">{__("ab__sf.rule.subcats")}</label>
<input type="hidden" name="subcats" value="N" />
<input type="checkbox" name="subcats" id="subcats" value="Y" {if $search.subcats == "Y"}checked="checked"{/if} />
</div>
<hr>
<a class="text-button nobg cm-reset-link" style="float: right;">{__("reset")}</a>
{include file="addons/ab__seo_filters/views/components/searchable_option_list.tpl"}
{/capture}
{include file="common/advanced_search.tpl"
simple_search=$smarty.capture.simple_search
dispatch=$dispatch
in_popup=false no_adv_link=true}
</form>
</div><hr>