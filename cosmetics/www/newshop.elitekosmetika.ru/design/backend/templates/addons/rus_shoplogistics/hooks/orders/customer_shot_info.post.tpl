{foreach from=$order_info.shipping item="shipping" key="shipping_id" name="f_shipp"}
    {if ($shipping.service_code == 'shoplogistics_pickup') && ($shipping.pickup_data)}
            <div class="well orders-right-pane form-horizontal">

			<p class="strong">
			{$shipping.pickup_data.info}
			</p>
			<p class="muted">
			{__('shoplogistics_code_id')}: {$shipping.pickup_data.code_id}<br />
			{__('shoplogistics_address')}: {$shipping.pickup_data.address}<br />
			{__('shoplogistics_phone')}: {$shipping.pickup_data.phone}<br />
            {__('shoplogistics_work_time')}: {$shipping.pickup_data.worktime}<br />
            {__('shoplogistics_delivery_period')}: {$shipping.pickup_data.srok_dostavki}<br />
			</p>
		</div>
	{/if}
{/foreach}
<div class="well orders-right-pane form-horizontal">
<b>{__('shoplogistics_admin_header')}:</b>
<div id="shop_logistics_div">
  {__('shoplogistics_delivery_date')}:<br>
  {html_select_date prefix='dd_' time=$sl_delivery_date  end_year='+1' month_format='%m' day_extra='style="width:50px;" id="dd_day"' month_extra='style="width:50px;" id="dd_month"' year_extra='style="width:80px;" id="dd_year"' field_order = 'DMY' }<br>
  {__('shoplogistics_delivery_time')}:<br>
  {__('shoplogistics_time_from')} {html_select_time prefix='from_' time=$sl_delivery_time_from use_24_hours=true display_minutes=FALSE display_seconds=FALSE hour_extra='style="width:50px;" id="time_from"' }
  {__('shoplogistics_time_to')} {html_select_time prefix='to_' time=$sl_delivery_time_to use_24_hours=true display_minutes=FALSE display_seconds=FALSE  hour_extra='style="width:50px;" id="time_to"'}<br>

  <div id="shop_logistics_div_status" style="padding:5px;">
  {if $sl_order_info.id > 0 }
      {if $sl_order_info.type == 'post' }
         <b>{__('shoplogistics_post_delivery')}</b><br>
         <b>{__('shoplogistics_status')}:</b> {$sl_order_info.status}
         <br><b>{__('shoplogistics_post_status')}:</b> {$sl_order_info.post_status}
      {else}
         <b>{__('shoplogistics_status')}:</b> {$sl_order_info.status}
         <br><b>{__('shoplogistics_current_filial')}:</b> {$sl_order_info.current_filial}
         <br><b>{__('shoplogistics_reciver_filial')}:</b> {$sl_order_info.reciver_filial}
      {/if}
      {if $sl_order_info.errors != '' }
        <br><font color="red">{__('shoplogistics_errors')}: {$sl_order_info.errors}</font>
      {/if}
  {/if}
  </div>
  <input type="button"  id="shopLogisitcs_button_send" value=" {__('shoplogistics_btn_send')} " OnClick="sendOrderToShopLogisitcs('send');"><br><br>
  <input type="button"  id="shopLogisitcs_button_post_send" value=" {__('shoplogistics_btn_send_post')} " OnClick="sendOrderToShopLogisitcs('post_send');" >
</div>
<div id="shop_logistics_div_status" style="padding:5px;">

</div>
<input type="button"  id="shopLogisitcs_button_update" value=" {__('shoplogistics_btn_update_status')} " OnClick="sendOrderToShopLogisitcs('update');">

<script type="text/javascript" >
  function sendOrderToShopLogisitcs(task) {

    var delivery_date = $("#dd_year").val() + '-' + $("#dd_month").val() + '-' + $("#dd_day").val();
    var time_from = $("#time_from").val() + ':00:00';
    var time_to = $("#time_to").val() + ':00:00';

    $("#shopLogisitcs_button_send").prop( "disabled", true );
    $("#shopLogisitcs_button_post_send").prop( "disabled", true );

    $.get('admin.php?dispatch=orders.details&order_id={$sl_order_id}&sl_task='+ task +'&delivery_date='+ delivery_date +'&time_from='+ time_from +'&time_to='+ time_to +'', function (responseText) {
       var json = eval('(' + responseText + ')');
       if (json.data.fatalError != '')
         {
           alert(json.data.fatalError);
         }
       else
         {
           alert(json.data.alert_msg);
           var content = '';
           if (json.data.type == 'post')
             {
               content += '<b>Почтовая доставка</b> <br>';
             }
           content += '<b>Статус:</b> ' + json.data.status;
           if (json.data.type != 'post')
             {
               content += '<br><b>Филиал получатель:</b> ' + json.data.reciver_filial;
               content += '<br><b>Текущий филиал:</b> ' + json.data.current_filial;
             }
           else
             {
               content += '<br><b>Статус почты:</b> ' + json.data.post_status;
             }
           if (json.data.errors != '')
             {
               content += '<br><font color="red"><b>Ошибки:</b> ' + json.data.errors + '</font>';
             }
           $("#shop_logistics_div_status").html(content);
         }
       $("#shopLogisitcs_button_send").prop( "disabled", false );
       $("#shopLogisitcs_button_post_send").prop( "disabled", false );

    });

  }
</script>

</div>

