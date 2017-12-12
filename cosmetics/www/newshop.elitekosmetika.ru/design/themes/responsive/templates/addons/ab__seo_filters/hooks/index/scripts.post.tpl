{if "`$runtime.controller`.`$runtime.mode`" == "categories.view"}{strip}
<script type="text/javascript">
(function(_, $) {
$.extend(_, {
ab__sf: {
hide_description: '{$addons.ab__seo_filters.hide_description|default:'disabled'|escape:"javascript"}',
more: '{"ab__sf.hide_description.more"|__|escape:"javascript"}',
less: '{"ab__sf.hide_description.less"|__|escape:"javascript"}',
}
});
}(Tygh, Tygh.$));
</script>
{script src="js/addons/ab__seo_filters/ab__sf.js"}
{/strip}{/if}
