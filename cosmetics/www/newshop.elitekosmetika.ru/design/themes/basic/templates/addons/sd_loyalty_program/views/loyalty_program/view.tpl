{if $cards}
    <div class="sd-loyalty-program">
        {foreach from=$cards item="card"}
            <div class="sd-loyalty-program__card">
                {if $card.main_pair}
                    {include file="common/image.tpl" images=$card.main_pair}
                {/if}

                {if $card.name}
                    <h2 class="ty-mainbox-simple-title">{$card.name}</h2>
                {/if}

                {if $card.amount}
                    <div class="ty-price">
                        <span class="ty-price-num">{__("addons.sd_loyalty_program.amount_from")} {include file="common/price.tpl" value=$card.amount}</span>
                    </div>
                {/if}

                {if $card.description}
                    <div class="sd-loyalty-program-desc">{$card.description nofilter}</div>
                {/if}
            </div>
        {/foreach}
    </div>
{/if}
