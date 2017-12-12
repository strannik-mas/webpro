{if $feature_type == "ProductFeatures::TEXT_SELECTBOX"|enum or $feature_type == "ProductFeatures::MULTIPLE_CHECKBOX"|enum}
<td>
<input type="text" name="feature_data[variants][{$num}][ab__sf_seo_variant]" value="" class="span4 cm-trim cm-feature-value" />
</td>
{/if}
