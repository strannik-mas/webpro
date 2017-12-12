{if $product}
    {assign var="obj_id" value=$product.product_id}
    {include file="common/product_data.tpl" product=$product but_role="big" but_text=__("add_to_cart")}
    <div class="ty-product-block__img-wrapper">
 
        {hook name="products:image_wrap"}
        {if !$no_images}
            <div class="ty-product-block__img cm-reload-{$product.product_id}" id="product_images_{$product.product_id}_update">

                {assign var="discount_label" value="discount_label_`$obj_prefix``$obj_id`"}
                {$smarty.capture.$discount_label nofilter}

                {include file="views/products/components/product_images.tpl" product=$product show_detailed_link="Y" image_width=$settings.Thumbnails.product_details_thumbnail_width image_height=$settings.Thumbnails.product_details_thumbnail_height}
                <!--product_images_{$product.product_id}_update--></div>
        {/if}
        {/hook}
    </div>
    <div class="ty-product-block__left">
        <div class="row-fluid">
            <div class="span8" id="new_span8">

                {assign var="rating" value="rating_`$obj_id`"}
                {$smarty.capture.$rating nofilter}

                {if $product.discussion.posts}
                    <a class="ty-discussion__review-a cm-external-click" data-ca-scroll="content_discussion" data-ca-external-click-id="discussion">{$product.discussion.search.total_items} {__("reviews", [$product.discussion.search.total_items])}</a>
                {/if}

                <!--div class="cat-name">Категория товара</div-->
                <div class="ty-product-block__advanced-option clearfix">
                    {if $capture_options_vs_qty}{capture name="product_options"}{$smarty.capture.product_options nofilter}{/if}
                    {assign var="advanced_options" value="advanced_options_`$obj_id`"}
                    {$smarty.capture.$advanced_options nofilter}
                    {if $capture_options_vs_qty}{/capture}{/if}
                </div>

                {hook name="products:brand"}
                    <div class="brand">
                        <div class="ty-features-list">
                            <span>Бренд: </span>
                            {include file="views/products/components/product_features_short_list.tpl" features=$product.header_features}
                        </div>
                        <style>
                            .ty-features-list .ty-features-list { display: inline; }
                        </style>
                    </div>
                {/hook}



                <div class="ty-product-block__sku">
                    {assign var="sku" value="sku_`$obj_id`"}
                    {$smarty.capture.$sku nofilter}
                </div>
                <div class="amount">
                    <span>Статус: </span>
                    {assign var="product_amount" value="product_amount_`$obj_id`"}
                    {$smarty.capture.$product_amount nofilter}
                    
                </div>
            </div>
            <div class="span8 ty-product-block-right-column" id="new_ty-product-block-right-column">

                {assign var="form_open" value="form_open_`$obj_id`"}
                {$smarty.capture.$form_open nofilter}

                {hook name="products:main_info_title"}
                    {*{if !$hide_title}*}
                    {*<h1 class="ty-product-block-title" {live_edit name="product:product:{$product.product_id}"}>{$product.product nofilter}</h1>*}

                    {*{/if}*}
                    {**}
                    
                {/hook}

                {assign var="old_price" value="old_price_`$obj_id`"}
                {assign var="price" value="price_`$obj_id`"}
                {assign var="clean_price" value="clean_price_`$obj_id`"}
                {assign var="list_discount" value="list_discount_`$obj_id`"}
                {assign var="discount_label" value="discount_label_`$obj_id`"}

                {hook name="products:promo_text"}
                {if $product.promo_text}
                    <div class="ty-product-block__note">
                        {$product.promo_text nofilter}
                    </div>
                {/if}
                {/hook}

                <div class="{if $smarty.capture.$old_price|trim || $smarty.capture.$clean_price|trim || $smarty.capture.$list_discount|trim}prices-container {/if}price-wrap">
                    {if $smarty.capture.$old_price|trim || $smarty.capture.$clean_price|trim || $smarty.capture.$list_discount|trim}
                    <div class="ty-product-prices">
                        {if $smarty.capture.$old_price|trim}{$smarty.capture.$old_price nofilter}{/if}
                        {/if}

                        {if $smarty.capture.$price|trim}
                            <div class="price_actual">
                                <span>Цена (р.) </span>
                                <div class="ty-product-block__price-actual">
                                    {$smarty.capture.$price nofilter}
                                </div>
                                
                            </div>
                        {/if}

                        {if $smarty.capture.$old_price|trim || $smarty.capture.$clean_price|trim || $smarty.capture.$list_discount|trim}
                        {$smarty.capture.$clean_price nofilter}
                        {$smarty.capture.$list_discount nofilter}
                    </div>
                    {/if}
                </div>

                {if $capture_options_vs_qty}{capture name="product_options"}{$smarty.capture.product_options nofilter}{/if}
                {if $capture_options_vs_qty}{/capture}{/if}

                {if $capture_options_vs_qty}{capture name="product_options"}{$smarty.capture.product_options nofilter}{/if}
                <div class="ty-product-block__option">
                    {assign var="product_options" value="product_options_`$obj_id`"}
                    {$smarty.capture.$product_options nofilter}
                </div>
                {if $capture_options_vs_qty}{/capture}{/if}

                {assign var="product_edp" value="product_edp_`$obj_id`"}
                {$smarty.capture.$product_edp nofilter}

                {if $show_descr}
                    {assign var="prod_descr" value="prod_descr_`$obj_id`"}
                    <h3 class="ty-product-block__description-title">{__("description")}</h3>
                    <div class="ty-product-block__description">{$smarty.capture.$prod_descr nofilter}</div>
                {/if}

                {if $capture_buttons}{capture name="buttons"}{/if}
                <div class="ty-product-block__button">

                    {assign var="qty" value="qty_`$obj_id`"}
                    {$smarty.capture.$qty nofilter}

                    {assign var="min_qty" value="min_qty_`$obj_id`"}
                    {$smarty.capture.$min_qty nofilter}

                    {if $show_details_button}
                        {include file="buttons/button.tpl" but_href="products.view?product_id=`$product.product_id`" but_text=__("view_details") but_role="submit"}
                    {/if}

                    {assign var="add_to_cart" value="add_to_cart_`$obj_id`"}
                    {$smarty.capture.$add_to_cart nofilter}

                    {assign var="list_buttons" value="list_buttons_`$obj_id`"}
                    {$smarty.capture.$list_buttons nofilter}
                </div>
                {if $capture_buttons}{/capture}{/if}

                {assign var="form_close" value="form_close_`$obj_id`"}
                {$smarty.capture.$form_close nofilter}

                {if $show_product_tabs}
                    {include file="views/tabs/components/product_popup_tabs.tpl"}
                    {$smarty.capture.popupsbox_content nofilter}
                {/if}
            </div>
        </div>
        <div class="row-fluid">
            <div class="span16">
                {hook name="products:product_detail_bottom"}
                {/hook}
            </div>
        </div>
    <div class="detail">
        <a href="/dostavka-i-oplata/" class="delivery-pay">Доставка и оплата</a>
        <a href="/guarantees" class="guarantee">Гарантии качества товара</a>
        <a href="/benefits" class="privilege">Преимущества покупки у нас</a>
        <a href="/giftcard" class="gift-certificates">Подарочные сертификаты</a>
    
        
    </div>
    </div>

{/if}

<script type="text/javascript">
    // extend standart function;
    function fn_post_process_form_files(data, params) {
        fn_post_process_form_files_original(data, params);
        if(typeof(OptionsStylingModule) !== 'undefined') {
            OptionsStylingModule.init();
        }
    }


    // original function from js/tygh/exceptions.js
    function fn_post_process_form_files_original(data, params)
    {
        var $ = Tygh.$;
        var container = {};
        container = $('#file_container');

        $('div.control-group, div.ty-control-group', container).each(function(idx, elm){
            var jelm = $(elm);
            var elm_id = jelm.prop('id').replace('moved_', '');
            var target = $('#' + elm_id);
            target.html('');
            jelm.children().appendTo(target);
        });

        container.remove();
    }



</script>

<style>
@media screen and (min-width:768px) and (max-width:979px) {
    html body .search-block-grid {
        margin-top: 0;
        float: left;
        width: 100% !important;
    }

    html body .cart-content-grid {
        margin-top: 0;
        float: left;
        width: 100% !important;   
    }

}
html body .ty-product-block__price-actual .ty-no-price { margin-top: 11px; }

</style>