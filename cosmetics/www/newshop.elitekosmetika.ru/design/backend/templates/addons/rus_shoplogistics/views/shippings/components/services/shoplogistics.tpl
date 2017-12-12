<fieldset>

<div class="control-group">
    <label class="control-label" for="authlogin">{__("shoplogistics_api_id")}</label>
    <div class="controls">
    <input id="authlogin" type="text" name="shipping_data[service_params][api_id]" size="60" value="{$shipping.service_params.api_id}" /><br>
    <span style="font-size:11px;">({__("shoplogistics_api_id_descr")})</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="authlogin">{__("shoplogistics_customer_code")}</label>
    <div class="controls">
    <input id="authlogin" type="text" name="shipping_data[service_params][customer_code]" size="60" value="{$shipping.service_params.customer_code}" /><br>
    <span style="font-size:11px;">({__("shoplogistics_customer_code_descr")})</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="authlogin">{__("shoplogistics_from_city_code_id")}</label>
    <div class="controls">
    <input id="authlogin" type="text" name="shipping_data[service_params][from_city_code_id]" size="60" value="{$shipping.service_params.from_city_code_id}" /><br>
    <span style="font-size:11px;">({__("shoplogistics_from_city_code_id_descr")})</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="authlogin">{__("shoplogistics_avg_num")}</label>
    <div class="controls">
    <input id="authlogin" type="text" name="shipping_data[service_params][avg_num]" size="60" value="{$shipping.service_params.avg_num}" /><br>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="authlogin">{__("shoplogistics_avg_weight")}</label>
    <div class="controls">
    <input id="authlogin" type="text" name="shipping_data[service_params][avg_weight]" size="60" value="{$shipping.service_params.avg_weight}" /><br>
    <span style="font-size:11px;">({__("shoplogistics_avg_weight_descr")})</span>
    </div>
</div>

</fieldset>
