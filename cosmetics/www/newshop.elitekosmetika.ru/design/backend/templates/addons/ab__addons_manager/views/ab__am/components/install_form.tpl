<div class="sidebar-row sidebar-ab">
<h6>{__('ab__am_install_addon')}</h6>
<form action="{""|fn_url}" name="ab_install_form" method="post">
<input type="hidden" name="dispatch" value="ab__am.install" />
<div class="sidebar-field">
<label class="cm-required" for="ab_code">{__('ab__am_install_code')} {include file="common/tooltip.tpl" tooltip=__('ab__am_install_code_tooltip')}</label>
<input type="text" id="ab_code" size="20" value="" onfocus="this.select();" class="input-text" name="ab_code" />
</div>
{include file="buttons/button.tpl" but_text=__('ab__am_install_addon') but_id="ab_install" but_role="submit"}
</form>
<span class="info">{__('ab__am_install_info')}</span>
</div>