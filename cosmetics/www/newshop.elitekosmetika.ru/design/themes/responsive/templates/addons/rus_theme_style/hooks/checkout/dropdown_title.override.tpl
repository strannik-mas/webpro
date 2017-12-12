<i class="ty-minicart__icon ty-icon-basket{if $smarty.session.cart.amount} filled{else} empty{/if}"></i>
<span class="ty-minicart-title{if !$smarty.session.cart.amount} empty-cart{/if} ty-hand">
	<span class="ty-block ty-minicart-title__header">{__("my_cart")} {if $smarty.session.cart.amount}<i>({$smarty.session.cart.amount}) {decliner qty=$smarty.session.cart.amount word='товар, товара, товаров'}</i> {else}<i>(0)</i>{/if}</span>
	   <span class="ty-block">
        {if $smarty.session.cart.amount}
            {__("cart_price")} - {include file="common/price.tpl" value=$smarty.session.cart.display_subtotal}
        {else}
            {*{__("cart_is_empty")}*}
        {/if}
       </span>
</span>

<!--span class="ty-block ty-minicart-title__header ty-uppercase">{__("my_cart")} <i>({$smarty.session.cart.amount})</i>
	</span>
</span-->
