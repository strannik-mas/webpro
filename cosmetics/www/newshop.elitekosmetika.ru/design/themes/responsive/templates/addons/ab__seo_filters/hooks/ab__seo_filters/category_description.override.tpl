{strip}
<div class="ty-wysiwyg-content ty-mb-s ab__sf_cat_desc" {if $runtime.customization_mode.live_editor}{live_edit name="category:description:{$category_data.category_id}"}{/if}>
{if $category_data.description}
{if $ab__sf_seo_page == 'Y'}
{$category_data.description|trim nofilter}
{else}
{hook name="ab__multiple_cat_descriptions:category_description"}
{$category_data.description|trim nofilter}
{/hook}
{/if}
{/if}
</div>
{/strip}