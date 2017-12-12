{assign var="usergroups_exist" value=""|fn_sd_loyalty_program_check_usergroups}

{if $card}
    {assign var="id" value=$card.card_id}
{else}
    {assign var="id" value=0}
    
{/if}

{if !$usergroups_exist}
    {assign var="disabled_param" value="disabled=\"disabled\""}
{else}
    {assign var="disabled_param" value=""}
{/if}

{assign var="usergroups" value=["type"=>"C", "status"=>["A", "H"], "include_default"=>false]|fn_get_usergroups}
{assign var="allow_save" value=$card|fn_allow_save_object:"loyalty_program_cards"}

{capture name="mainbox"}

    {capture name="tabsbox"}

        <form action="{""|fn_url}" method="post" class="form-horizontal form-edit  {if !$allow_save} cm-hide-inputs{/if}" name="cards_form" enctype="multipart/form-data">
        <input type="hidden" class="cm-no-hide-input" name="card_id" value="{$id}" />

        <div id="content_general">
            <div class="control-group">
                <label for="elm_card_name" class="control-label cm-required">{__("name")}</label>
                <div class="controls">
                    <input type="text" name="card_data[name]" id="elm_card_name" value="{$card.name}" size="25" class="input-large" {$disabled_param nofilter}/>
                </div>
            </div>

            {if "ULTIMATE"|fn_allowed_for}
                {include file="views/companies/components/company_field.tpl"
                    name="card_data[company_id]"
                    id="card_data_company_id"
                    selected=$card.company_id
                }
            {/if}

            <div class="control-group">
                <label for="elm_card_amount" class="control-label cm-required">{__("addons.sd_loyalty_program.card_value")} ({$currencies.$primary_currency.symbol nofilter})</label>
                <div class="controls">
                    <input type="text" name="card_data[amount]" class="cm-numeric" id="elm_card_amount" value="{$card.amount}" size="3" {$disabled_param nofilter}/>
                </div>
            </div>

            <div class="control-group">
                <label for="elm_card_usergroup" class="control-label cm-required">{__("usergroup")}:</label>
                <div class="controls">
                    <select name="card_data[usergroup_id]" id="elm_card_usergroup" {$disabled_param nofilter}>
                        <option value="">--</option>
                        {foreach from=$usergroups item="usergroup"}
                            <option value="{$usergroup.usergroup_id}" {if $card.usergroup_id == $usergroup.usergroup_id}selected="selected"{/if}>{$usergroup.usergroup}</option>
                        {/foreach}
                    </select>
                </div>
            </div>

            <div class="control-group" id="card_image">
                <label class="control-label">{__("image")}</label>
                <div class="controls">
                    {if $usergroups_exist}
                        {include file="common/attach_images.tpl" image_name="cards_main" image_object_type="loyalty_program" image_pair=$card.main_pair image_object_id=$id no_detailed=true hide_titles=true}
                    {else}
                        {include file="common/image.tpl" image=$card.main_pair.icon image_id=$card.main_pair.image_id image_width=50}
                    {/if}
                </div>
            </div>

            <div class="control-group" id="card_text">
                <label class="control-label" for="elm_card_description">{__("description")}:</label>
                <div class="controls">
                    <textarea id="elm_card_description" name="card_data[description]" cols="35" rows="8" class="cm-wysiwyg input-large" {$disabled_param nofilter}>{$card.description}</textarea>
                </div>
            </div>

            {if $usergroups_exist}
                {include file="common/select_status.tpl" input_name="card_data[status]" id="elm_card_status" obj_id=$id obj=$card hidden=true}
            {elseif $id}
                <div class="control-group" id="card_status">
                    <label class="control-label">{__("status")}</label>
                    <div class="controls">
                        {if $card.status == 'A'} {__("active")} {elseif $card.status == 'D'} {__("disabled")} {else} {__("hidden")}{/if}
                    </div>
                </div>
            {/if}
        </div>

        <div id="content_test">
        </div>
        {capture name="buttons"}
            {if $usergroups_exist}
                {if !$id}
                    {include file="buttons/save_cancel.tpl" but_role="submit-link" but_target_form="cards_form" but_name="dispatch[loyalty_program.update]"}
                {else}
                    {if "ULTIMATE"|fn_allowed_for && !$allow_save}
                        {assign var="hide_first_button" value=true}
                        {assign var="hide_second_button" value=true}
                    {/if}
                    {include file="buttons/save_cancel.tpl" but_name="dispatch[loyalty_program.update]" but_role="submit-link" but_target_form="cards_form" hide_first_button=$hide_first_button hide_second_button=$hide_second_button save=$id}
                {/if}
            {/if}
        {/capture}

        </form>

    {/capture}

    {include file="common/tabsbox.tpl" content=$smarty.capture.tabsbox group_name="loyalty_cards" active_tab=$smarty.request.selected_section track=true}

{/capture}

{if !$id}
    {assign var="title" value=__("addons.sd_loyalty_program.new_card")}
{else}
    {assign var="title" value="{__("addons.sd_loyalty_program.editing_card")}: `$card.name`"}
{/if}
{include file="common/mainbox.tpl" title=$title content=$smarty.capture.mainbox buttons=$smarty.capture.buttons select_languages=true}