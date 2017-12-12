$(".list li").click(function() {
	var group = $(this).attr("data-value");
	$(".selection-group select option").attr('selected', false);
	$(".selection-group select option[value=" + group + "]").attr('selected', true);
	// $(".selection-group select").val(group);
});