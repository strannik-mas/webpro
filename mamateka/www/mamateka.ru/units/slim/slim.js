$(function() {
	$("#tabs").tabs({
		active : localStorage.getItem('tabindex') ? localStorage.getItem('tabindex') : 0
	}).on('click', function(event) {
		//					alert($("#tabs").tabs("option", "active"));
		//console.dir(event);
		localStorage.setItem('tabindex', $("#tabs").tabs("option", "active"));
	});
	//				console.log($("#tabs").tabs("option", "active"));
	//				$( "input" ).checkboxradio();

	$('.range_rost').slider({
		min : 100,
		max : 250,
		slide : function(event, ui) {
			$('.rost').val(ui.value);
		}
	});
	$('.range_rost').slider("value", $('.rost').val());
	$('.range_ves').slider({
		min : 20,
		max : 170,
		slide : function(event, ui) {
			$('.ves').val(ui.value);
		}
	});
	$('.range_ves').slider("value", $('.ves').val());
	$('.range_zhel_ves').slider({
		min : 20,
		max : 170,
		slide : function(event, ui) {
			$('.zhel_ves').val(ui.value);
			if ($('.zhel_ves').val() > $('.ves').val()) {
				changeOption(false);
			} else
				changeOption(true);
		}
	});
	$('.range_zhel_ves').slider("value", $('.zhel_ves').val());
	if ($('.zhel_ves').val() > $('.ves').val()) {
		changeOption(false);
	}
	$('.range_vozr').slider({
		min : 12,
		max : 80,
		slide : function(event, ui) {
			$('.vozr').val(ui.value);
		}
	});
	$('.range_vozr').slider("value", $('.vozr').val());
	$('.range_calories').slider({
		min : 0,
		max : 1500,
		step : 50,
		slide : function(event, ui) {
			$('.calories').val(ui.value);
		}
	});
	$('.range_calories').slider("value", $('.calories').val());
});
function changeOption(flag) {
	if (!flag) {
		$('select[name=tar]').children('option').eq(2).text('Медленного повышения веса');
		$('select[name=tar]').children('option').eq(3).text('Умеренного повышения веса');
		$('select[name=tar]').children('option').eq(4).text('Быстрого повышения веса');
		$('select[name=tar]').children('option').eq(5).text('Экстремального повышения веса');
	} else {
		$('select[name=tar]').children('option').eq(2).text('Медленного снижения веса');
		$('select[name=tar]').children('option').eq(3).text('Умеренного снижения веса');
		$('select[name=tar]').children('option').eq(4).text('Быстрого снижения веса');
		$('select[name=tar]').children('option').eq(5).text('Экстремального снижения веса');
	}
}