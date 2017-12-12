<div class="ty-grid-list__image">
    {include file="views/products/components/product_icon.tpl" product=$product show_gallery=true}
    {assign var="discount_label" value="discount_label_`$obj_prefix``$obj_id`"}
    {$smarty.capture.$discount_label nofilter}
</div>

<div class="ty-grid-list__item-name">
    {if $item_number == "Y"}
        <span class="item-number">{$cur_number}.&nbsp;</span>
        {math equation="num + 1" num=$cur_number assign="cur_number"}
    {/if}

    {assign var="name" value="name_$obj_id"}
    {$smarty.capture.$name nofilter}

    <div class="category-name">{$product.category_ids[0]|fn_get_category_name nofilter}</div>
</div>

<div class="ty-grid-list__item-info">

    <div class="ty-grid-list__rating">
        {include file="addons/discussion/views/discussion/components/stars.tpl" stars=$product.average_rating|fn_get_discussion_rating}
    </div>

    <div class="ty-grid-list__price {if $product.price == 0}ty-grid-list__no-price{/if}">
        {assign var="old_price" value="old_price_`$obj_id`"}
        {if $smarty.capture.$old_price|trim}{$smarty.capture.$old_price nofilter}{/if}

        {assign var="price" value="price_`$obj_id`"}
        {$smarty.capture.$price nofilter}

        {assign var="clean_price" value="clean_price_`$obj_id`"}
        {$smarty.capture.$clean_price nofilter}

        {assign var="list_discount" value="list_discount_`$obj_id`"}
        {$smarty.capture.$list_discount nofilter}
    </div>
    <div class="ty-grid-list__reviews">
        {assign var="discussion" value=$product.product_id|fn_get_discussion:'P':true:$smarty.request}
        {if $discussion && !$details_page }
            <a class="ty-discussion__review-a" href="{"products.view?product_id=`$product.product_id`&selected_section=discussion#discussion"|fn_url}">{if $discussion.posts}{$discussion.search.total_items} {__("reviews", [$discussion.search.total_items])}{else}{__("write_review")}{/if}</a>
        {/if}
    </div>
</div>

<div class="ty-grid-list__control">
    {if $settings.Appearance.enable_quick_view == 'Y'}
        {include file="views/products/components/quick_view_link.tpl" quick_nav_ids=$quick_nav_ids}
    {/if}

    {if $show_add_to_cart}
        <div class="button-container">
            {assign var="add_to_cart" value="add_to_cart_`$obj_id`"}
            {$smarty.capture.$add_to_cart nofilter}
        </div>
    {/if}
</div>