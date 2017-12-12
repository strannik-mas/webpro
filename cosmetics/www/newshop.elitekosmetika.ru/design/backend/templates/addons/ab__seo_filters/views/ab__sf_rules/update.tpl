{assign var="id" value=$r.rule_id|default:0}
{capture name="mainbox"}
<form action="{""|fn_url}" method="post" class="form-horizontal form-edit" name="ab__sf_rule_form" enctype="multipart/form-data">
<input type="hidden" class="cm-no-hide-input" name="rule_id" value="{$id}" />
<div id="content_general">
{assign var="elm" value="feature_id"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`][]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<input type="hidden" name="ab__sf_rule_data[sequence_features]" id="sequence_features" value="{if is_array($r.$elm)}{","|implode:$r.$elm}{/if}">
{if is_array($r.$elm)}
<span style="font-weight: bold;">{__("ab__sf.rule.features_sequence")}:</span>
{foreach from=$r.feature_name item="fn" key="kfn" name="fn"}
<a target="_blank" href="{"product_features.update&feature_id=`$kfn`"|fn_url}">{$fn}</a>{if !$smarty.foreach.fn.last}, {/if}
{/foreach}
<hr style="margin: 5px 0">
{/if}
<select name="{$elm_name}" id="{$elm_id}" class="input-large" multiple="multiple" size="1">
{assign var="ungrouped_features" value=""}
{if $features}
{foreach from=$features item="feature"}
{if $feature.feature_type == "G"}
<optgroup label="{$feature.description}">
{if !empty($feature.subfeatures) and is_array($feature.subfeatures)}
{foreach from=$feature.subfeatures item="subfeature"}
{assign var="disabled" value="disabled"}
{if !empty($filters) and in_array($subfeature.feature_id,$filters)}{assign var="disabled" value=""}{/if}
<option class="{$disabled}" {$disabled} value="{$subfeature.feature_id}" {if !empty($r.$elm) && in_array($subfeature.feature_id,$r.$elm)}selected="selected"{/if}>{$subfeature.description} [{$subfeature.feature_id}]</option>
{/foreach}
{/if}
</optgroup>
{else}
{assign var="selected" value=""}
{if !empty($r.$elm) and in_array($feature.feature_id,$r.$elm)}{assign var="selected" value="selected='selected'"}{/if}
{assign var="disabled" value="disabled"}
{if !empty($filters) and in_array($feature.feature_id, $filters)}{assign var="disabled" value=""}{/if}
{assign var="ungrouped_features" value="{$ungrouped_features}<option class='{$disabled}' {$disabled} {$selected} value='{$feature.feature_id}'>{$feature.description} [{$feature.feature_id}]</option>"}
{/if}
{/foreach}
{/if}
{if !empty($ungrouped_features)}
<optgroup label="{__("ungroupped_features")}">
{$ungrouped_features nofilter}
</optgroup>
{/if}
</select>
<br><code>{__("ab__sf.rule.limit_max_filters", ["[limit]"=>$addons.addons.ab__seo_filters.max_filters|default:4])}</code>
</div>
</div>
{assign var="elm" value="categories"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
{math equation="rand()" assign="rnd"}
<label for="celm_categories_{$rnd}_ids" class="control-label cm-required">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls" style="min-height: 300px; max-height: 300px; overflow-y: auto;">
{if $r.$elm}
{assign var="items" value=","|explode:$r.$elm}
{/if}
{include file="pickers/categories/picker.tpl" multiple=true input_name="ab__sf_rule_data[categories]" rnd=$rnd item_ids=$items data_id=$elm_id hide_link=true disable_no_item_text=true show_active_path=true use_keys="N" but_meta="pull-right"}
</div>
</div>
{assign var="elm" value="subcats"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<input type="hidden" name="{$elm_name}" value="N" />
<input type="checkbox" name="{$elm_name}" id="{$elm_id}" value="Y" {if $r.$elm == "Y"}checked="checked"{/if} />
</div>
</div>
{assign var="elm" value="generated_categories"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<select name="ab__sf_rule_data[generated_categories]" id="{$elm_id}" class="input-large">
<option value="">---</option>
<option {if $r.generated_categories == "by_all_filter_categories"}selected="selected"{/if} value="by_all_filter_categories">{__("ab__sf.rule.generated_categories.by_all_filter_categories")}</option>
<option {if $r.generated_categories == "by_non_empty_filter_categories" or !$id}selected="selected"{/if} value="by_non_empty_filter_categories">{__("ab__sf.rule.generated_categories.by_non_empty_filter_categories")}</option>
</select>
</div>
</div>
{assign var="elm" value="fixed"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required">{__("ab__sf.name.fixed")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.name.fixed.tooltip")}</label>
<div class="controls">
<label class="radio inline" for="{$elm_id}_{"ABSFConfigs::PAGE_STATE_UNFIXED"|enum}">
<input type="radio" name="{$elm_name}" id="{$elm_id}_{"ABSFConfigs::PAGE_STATE_UNFIXED"|enum}" value="{"ABSFConfigs::PAGE_STATE_UNFIXED"|enum}" {if $r.$elm == "ABSFConfigs::PAGE_STATE_UNFIXED"|enum or !$id}checked="checked"{/if}>{__("ab__sf.page_state.unfixed")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.page_state.unfixed.tooltip")}
</label>
<label class="radio inline" for="{$elm_id}_{"ABSFConfigs::PAGE_STATE_HIDDEN"|enum}">
<input type="radio" name="{$elm_name}" id="{$elm_id}_{"ABSFConfigs::PAGE_STATE_HIDDEN"|enum}" value="{"ABSFConfigs::PAGE_STATE_HIDDEN"|enum}" {if $r.$elm == "ABSFConfigs::PAGE_STATE_HIDDEN"|enum}checked="checked"{/if}>{__("ab__sf.page_state.hidden")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.page_state.hidden.tooltip")}
</label>
</div>
</div>
{assign var="elm" value="tag_h1"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" value="{$r.$elm}" size="25" class="input-large" />
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="page_title"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" value="{$r.$elm}" size="25" class="input-large" />
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="meta_description"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<textarea placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" class="input-large">{$r.$elm}</textarea>
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="meta_keywords"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<textarea placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" class="input-large">{$r.$elm}</textarea>
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="breadcrumb"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" value="{$r.$elm}" size="25" class="input-large" />
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="product_breadcrumb"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label cm-required cm-trim">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" placeholder="%category% %variant%" name="{$elm_name}" id="{$elm_id}" value="{$r.$elm}" size="25" class="input-large" />
{if !empty($patterns.$elm.value)}<br><code pattern-id="{$elm_id}" class="hand" title="{__("ab__sf.pattern.copy")}">»</code><code>{$patterns.$elm.value}</code>{/if}
</div>
</div>
{assign var="elm" value="position"}{assign var="elm_id" value="elm_`$elm`"}{assign var="elm_name" value="ab__sf_rule_data[`$elm`]"}
<div class="control-group">
<label for="{$elm_id}" class="control-label">{__("ab__sf.rule.`$elm`")} {include file="common/tooltip.tpl" tooltip=__("ab__sf.rule.`$elm`.tooltip")}</label>
<div class="controls">
<input type="text" name="{$elm_name}" id="{$elm_id}" value="{$r.$elm}" size="25" class="cm-select-text" />
</div>
</div>
{include file="common/select_status.tpl" input_name="ab__sf_rule_data[status]" id="elm_status" obj_id=$id obj=$r hidden=false}
</div>
</form>
{include file="addons/ab__seo_filters/views/components/searchable_option_list.tpl"}
<hr>
{if $id > 0}
{assign var="cron_key" value=$addons.ab__seo_filters.cron_key|trim}
{if strlen($cron_key) < 5 or strlen($cron_key) > 10}
{assign var="cron_key" value=__('ab__sf.errors.cron_key')}
{/if}
{assign var="cron_cmd" value="* * 1 * * php `$config.dir.root`/`$config.admin_index` --dispatch=ab__sf_rules.generate_cron --rule_id=`$id` --cron_key=`$cron_key`"}
{assign var="cron_url" value="ab__sf_rules.generate_cron?rule_id=`$id`&cron_key=`$cron_key`"|fn_url}
<p>{__('ab__sf.rule.generate_link', ['[cron_cmd]'=>$cron_cmd, '[cron_url]'=>$cron_url])}</p>
{/if}
{/capture}
{capture name="buttons"}
{if !$id}
{include file="buttons/save_cancel.tpl" but_role="submit-link" but_target_form="ab__sf_rule_form" but_name="dispatch[ab__sf_rules.update]"}
{else}
{include file="buttons/save_cancel.tpl" but_name="dispatch[ab__sf_rules.update]" but_role="submit-link" but_target_form="ab__sf_rule_form" hide_first_button=false hide_second_button=false save=$id}
{capture name="tools_list"}
<li>{btn type="list" text=__("delete") class="cm-confirm cm-post" href="ab__sf_rules.delete?rule_id=`$r.rule_id`"}</li>
{/capture}
{dropdown content=$smarty.capture.tools_list}
{/if}
{/capture}
{notes}{__("ab__sf.rule.notes")}{/notes}
{if !$id}
{assign var="title" value=__("ab__sf.rule.add")}
{else}
{assign var="title" value="{__("ab__sf.rule.edit")} ID: `$id`"}
{/if}
{include file="common/mainbox.tpl" title=$title content=$smarty.capture.mainbox buttons=$smarty.capture.buttons select_languages=true}
