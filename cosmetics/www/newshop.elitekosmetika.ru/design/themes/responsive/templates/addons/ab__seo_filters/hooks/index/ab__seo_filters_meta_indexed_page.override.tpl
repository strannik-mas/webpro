{if isset($ab__sf_seo_canonical) and is_array($ab__sf_seo_canonical) and !empty($ab__sf_seo_canonical)}
{if $ab__sf_seo_canonical.current}
<link rel="canonical" href="{$ab__sf_seo_canonical.current}" />
{/if}
{if $ab__sf_seo_canonical.prev}
<link rel="prev" href="{$ab__sf_seo_canonical.prev}" />
{/if}
{if $ab__sf_seo_canonical.next}
<link rel="next" href="{$ab__sf_seo_canonical.next}" />
{/if}
{if $ab__sf_seo_canonical.noindex_nofollow == 'Y'}
<meta name="robots" content="noindex,nofollow" />
{/if}
{else}
<meta name="robots" content="noindex{if $settings.Security.secure_storefront == "partial" && 'HTTPS'|defined},nofollow{/if}" />
{/if}