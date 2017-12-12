{$discussion = $object_id|fn_get_discussion:$object_type:true:$smarty.request}

{*if $discussion && $discussion.type != "D"*}
{include file="common/subheader.tpl" title=$title}
    <div class="discussion-block-view-reviews">
        <div id="posts_list_{$object_id}">
        {if $discussion.posts}
            <div class="ty-mb-l">
                <div class="ty-scroller-discussion-list">
                    <div id="scroll_list_discussion" class="owl-carousel ty-scroller-list">
                        {foreach from=$discussion.posts item=post}
                            <div class="ty-discussion-post__content ty-scroller-discussion-list__item">

                                <div class="row-fluid">
                                    <span class="span4">
                                        <span class="ty-discussion-post__author">{$post.name}</span>
                                        <span class="ty-discussion-post__date">{$post.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}</span>
                                    </span>
                                    <span class="span12">
                                         {if $discussion.type == "R" || $discussion.type == "B" && $post.rating_value > 0}
                                             <div class="clearfix ty-discussion-post__rating">
                                                <a href="{"discussion.view?thread_id=`$discussion.thread_id`&post_id=`$post.post_id`"|fn_url}#post_{$post.post_id}">
                                                    {include file="addons/discussion/views/discussion/components/stars.tpl" stars=$post.rating_value|fn_get_discussion_rating}
                                                </a>
                                            </div>
                                         {/if}

                                        <a href="{"discussion.view?thread_id=`$discussion.thread_id`&post_id=`$post.post_id`"|fn_url}#post_{$post.post_id}">
                                            <div class="ty-discussion-post {cycle values=", ty-discussion-post_even"}" id="post_{$post.post_id}">
                                                {if $discussion.type == "C" || $discussion.type == "B"}
                                                    <div class="ty-discussion-post__message">{$post.message|truncate:100|nl2br nofilter}</div>
                                                {/if}
                                            </div>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        {else}
            <p class="ty-no-items">{__("no_data")}</p>
        {/if}
        <!--posts_list_{$object_id}--></div>

        {if $object_type == "P"}
            {$new_post_title = __("write_review")}
        {else}
            {$new_post_title = __("new_post")}
        {/if}
    </div>
    <div class="row-fluid">
        <div class="span8 feedback-form-wrapper">
            {include file="addons/ek_theme/overrides/addons/discussion/views/discussion/components/new_post.tpl" new_post_title=$new_post_title}
        </div>
    </div>


    {$block = ["block_id" => "discussion", "properties" => ["item_quantity" => 2, "scroll_per_page" => "Y", "not_scroll_automatically" => "Y", "outside_navigation" => true]]}
    {include file="common/scroller_init.tpl" block=$block}

{*/if*}