{if $app.antibot->getDriver()|get_class == "Tygh\Addons\Recaptcha\RecaptchaDriver"}
    <div class="captcha ty-control-group">
        <label for="recaptcha_{$id}" class="cm-required cm-recaptcha ty-captcha__label">{__("image_verification_label")}</label>
        <div id="recaptcha_{$id}" class="cm-recaptcha"></div>
    </div>
{/if}