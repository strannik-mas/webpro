
<div id="{$id}">

<form name="call_requests_form{if !$product}_main{/if}" id="form_{$id}" action="{""|fn_url}" method="post" class="cm-ajax{if !$product} cm-ajax-full-render{/if}"{if $product} data-ca-product-form="product_form_{$obj_prefix}{$product.product_id}"{/if}>
<input type="hidden" name="result_ids" value="{$id}" />
<input type="hidden" name="return_url" value="{$config.current_url}" />

{if $product}
    <input type="hidden" name="call_data[product_id]" value="{$product.product_id}" />
    <div class="ty-cr-product-info-container">
        <div class="ty-cr-product-info-image">
            {include file="common/image.tpl" images=$product.main_pair image_width=$settings.Thumbnails.product_cart_thumbnail_width image_height=$settings.Thumbnails.product_cart_thumbnail_height}
        </div>
        <div class="ty-cr-product-info-header">
            <h3 class="ty-product-block-title">{$product.product}</h3>
        </div>
    </div>
{/if}

<div class="ty-control-group">
    <input placeholder="{__("your_name")}" id="call_data_{$id}_name" size="50" class="ty-input-text-full" type="text" name="call_data[name]" value="{$call_data.name}" />
</div>

<div class="ty-control-group">
    <input placeholder="{__("phone")}" id="call_data_{$id}_phone" class="ty-input-text-full cm-cr-mask-phone" size="50" type="text" name="call_data[phone]" value="{$call_data.phone}" />
</div>

{if $product}

    <div class="ty-cr-or">— {__("or")} —</div>

    <div class="ty-control-group">
        <label for="call_data_{$id}_email" class="ty-control-group__title cm-email">{__("email")}</label>
        <input id="call_data_{$id}_email" class="ty-input-text-full" size="50" type="text" name="call_data[email]" value="{$call_data.email}" />
    </div>

    <div class="cr-popup-error-box">
        <div class="hidden cm-cr-error-box help-inline">
            <p>{__("call_requests.enter_phone_or_email_text")}</p>
        </div>
    </div>

{else}

    <div class="ty-control-group" style="text-align:right; font-size: 16px; color: #999;">
        {__("call_time")}&nbsp;&nbsp;<input id="call_data_{$id}_convenient_time_from" class="ty-input-text cm-cr-mask-time" size="6" type="text" name="call_data[time_from]" value="" placeholder="{$smarty.const.CALL_REQUESTS_DEFAULT_TIME_FROM}" /> до
        <input id="call_data_{$id}_convenient_time_to" class="ty-input-text cm-cr-mask-time" size="6" type="text" name="call_data[time_to]" value="" placeholder="{$smarty.const.CALL_REQUESTS_DEFAULT_TIME_TO}" />
    </div>

    <div class="ty-control-group">
        <textarea rows="6" style="width: 100%;" id="call_data_{$id}_message" name="call_data[message]" placeholder="{__("call_message")}"></textarea>
    </div>


{/if}

{include file="common/image_verification.tpl" option="call_request"}

<div class="buttons-container">
    {include file="buttons/button.tpl" but_name="dispatch[call_requests.request]" but_text=__("call_me_button") but_role="submit" but_meta="ty-btn__primary ty-btn__big cm-form-dialog-closer ty-btn"}
</div>

</form>

<!--{$id}--></div>