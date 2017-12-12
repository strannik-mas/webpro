{capture name="mainbox_title"}
{__("ab__sf.help")} {__("ab__seo_filters")}
{/capture}
{capture name="mainbox"}
{include file="common/subheader.tpl" meta="" title="{__('ab__sf.help.installation_completion.title')}" target="#ab__sf_help_installation_completion"}
{$hook_theme_name=""}
{if $settings.theme_name == 'basic' or $settings.theme_name == 'responsive'}
{$hook_theme_name="_`$settings.theme_name`"}
{/if}
{$theme_name=$settings.theme_name}
{if !file_exists("`$config.dir.root`/design/themes/`$theme_name`/templates/addons/seo/hooks/index/meta.post.tpl")}
{$theme_name="[`$config.base_theme`] or [parent_theme of your theme]"}
{/if}
{$add_hook_seo_variant_by_version=""}
{if version_compare($smarty.const.PRODUCT_VERSION, '4.3.8') < 0}
{$add_hook_seo_variant_by_version="_less438"}
{/if}
<div id="ab__sf_help_installation_completion" class="in collapse" style="padding: 0 20px">{__('ab__sf.help.installation_completion.text', ['[theme_name]'=>$theme_name, '[hook_theme_name]'=>$hook_theme_name, '[add_hook_seo_variant_by_version]'=>$add_hook_seo_variant_by_version])}</div>
{include file="common/subheader.tpl" meta="" title="{__('ab__sf.help.config_create_rule.title')}" target="#ab__sf_help_config_create_rule"}
<div id="ab__sf_help_config_create_rule" class="in collapse" style="padding: 0 20px">{__('ab__sf.help.config_create_rule.text')}</div>
{include file="common/subheader.tpl" meta="" title="{__('ab__sf.help.config_create_name.title')}" target="#ab__sf_help_config_create_name"}
<div id="ab__sf_help_config_create_name" class="in collapse" style="padding: 0 20px">{__('ab__sf.help.config_create_name.text')}</div>
{include file="common/subheader.tpl" meta="" title="{__('ab__sf.help.config_sitemap.title')}" target="#ab__sf_help_config_sitemap"}
<div id="ab__sf_help_config_sitemap" class="in collapse" style="padding: 0 20px">{__('ab__sf.help.config_sitemap.text')}</div>
{include file="common/subheader.tpl" meta="" title="{__('ab__sf.help.field_seo_variant.title')}" target="#ab__sf_help_field_seo_variant"}
<div id="ab__sf_help_field_seo_variant" class="in collapse" style="padding: 0 20px">{__('ab__sf.help.field_seo_variant.text')}</div>
{include file="common/subheader.tpl" meta="" title="{__('ab__sf.help.export.title')}" target="#ab__sf_help_export"}
<div id="ab__sf_help_export" class="in collapse" style="padding: 0 20px">{__('ab__sf.help.export.text')}</div>
{/capture}
{include file="common/mainbox.tpl" title=$smarty.capture.mainbox_title content=$smarty.capture.mainbox buttons=$smarty.capture.buttons adv_buttons=$smarty.capture.adv_buttons sidebar=$smarty.capture.sidebar}
