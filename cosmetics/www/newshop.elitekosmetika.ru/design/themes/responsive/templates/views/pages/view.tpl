<div class="ty-wysiwyg-content {if $page.parent_id > 0}single_article{/if}">
    {hook name="pages:page_content"}
        {*{if $page.parent_id > 0}*}
            <div {live_edit name="page:description:{$page.page_id}"}>{$page.description nofilter}</div>

            {*Социальные кнопочки*}

            <script type="text/javascript">(function() {
                    if (window.pluso)if (typeof window.pluso.start == "function") return;
                    if (window.ifpluso==undefined) { window.ifpluso = 1;
                        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                        s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                        s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                        var h=d[g]('body')[0];
                        h.appendChild(s);
                    }})();</script>
            <div class="pluso" data-background="transparent" data-options="medium,square,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir"></div>

            {*Социальные кнопочки*}

        {*{/if}*}
    {/hook}
</div>

{capture name="mainbox_title"}<span {live_edit name="page:page:{$page.page_id}"}>{$page.page}</span>{/capture}
    
{hook name="pages:page_extra"}{/hook}