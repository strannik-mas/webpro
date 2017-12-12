{literal}
<script>
$(function() {
$('#elm_feature_id').searchableOptionList({
maxHeight: '320px',
texts: {
selectAll: "{/literal}{__("ab__sf.optionlist.selectall")}{literal}",
selectNone: "{/literal}{__("ab__sf.optionlist.selectnone")}{literal}",
searchplaceholder: "{/literal}{__("ab__sf.optionlist.searchplaceholder")}{literal}",
itemsSelected: "{/literal}{__("ab__sf.optionlist.itemsselected")}{literal}",
noItemsAvailable: "{/literal}{__("ab__sf.optionlist.noitemsavailable")}{literal}",
},
showSelectAll: false,
events: {
onChange: function(a){
var items = [];
$('div.sol-selected-display-item').each(function (index, value){
items.push($(this).attr('item_id'));
});
$("#sequence_features").val(items.join(','));
}
}
});
});
</script>
{/literal}
