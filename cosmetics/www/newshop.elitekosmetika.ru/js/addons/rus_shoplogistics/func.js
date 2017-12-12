
function setPickupPlace(request) {
  checkout = true;
  method_request = 'get';
  url = fn_url('checkout.checkout');
  /*
  method_request = 'post';
  url = fn_url('order_management.update_shipping');
  */

  params = [];

  params.push({name: 'cur_price', value: request['price']});
  params.push({name: 'pickup_code', value: request['code_id']});
  params.push({name: 'pickup_name', value: request['info']});
  params.push({name: $('#shoplogistics_var_name').val(), value: request['code_id']});

  document.getElementById('select_pickup').vaule = request['code_id'];


  for (i in params) {
     url += '&' + params[i]['name'] + '=' + params[i]['value'];
  }

  $.ceAjax('request', url, {
     result_ids: 'shipping_rates_list,checkout_info_summary_*,checkout_info_order_info_*,shipping_estimation',
     method: method_request,
     full_render: true
  });
}

(function(_, $) {

    $(document).ready(function() {
        $( "#step_three_but" ).click(function() {
           var var_name = '';
           try {
              var_name = $("#shoplogistics_var_name").val();
           }
           catch (e) {}
           if(typeof var_name !== 'undefined')
             {
               if ($("#select_pickup").val() == '')
                 {
                   alert('Выберите пункт выдачи!');
                   return false;
                 }
             }
        });

    })

}(Tygh, Tygh.$));


