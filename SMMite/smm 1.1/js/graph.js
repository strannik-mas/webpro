const BackgroundColor = 'rgba(7,42,92,1)';
$(function () {
    //поменять запрос на внутренний, без php
	$.get("getjson.php", {url: "http://smmite.com/smmite-backend/api/core/stats/activity/last-week-group-data/", vkGroupId: "30022666"})
		.done(function (data) {
//                    console.dir(JSON.parse(data));
			localStorage.setItem('jsondata', data);
			drawGraph();
//                    drawGraph(JSON.parse(data).reverse());
		});
//                       
});
function drawGraph(curWeekDay = new Date().toLocaleString("ru", {weekday:'short'})){
	var dataArr = JSON.parse(localStorage.getItem('jsondata')).reverse();
	curWeekDay = curWeekDay.charAt(0).toUpperCase() + curWeekDay.substr(1);
    
	var hours = [];
	var comments = [];                  //количество комментариев
	var reposts = [];                   //количество репостов
	var likes = [];                     //количество лайков
	var weekDay = '';                   //текущий день недели
	var weekDaysArr = [];               //массив дней недели
	var x_fill_begin = 0;               //координата начала заливки выходных
	var x_fill_end = 0;                 //координата конца заливки выходных
	var sum_R = 0;                      //сумма всех репостов   
	var sum_L = 0;                      //сумма всех лайков
	var sum_C = 0;                      //сумма всех комментов   
	var sum = 0;                        //сумма всех репостов, лайков и комментов 
	$htmlstr = '';
	console.dir(dataArr);
	$('.weekdays').html('');
	dataArr.forEach(function (item, i) {
		weekDay = new Date(item['Day']);
		//перевод на летнее время
		weekDay.setHours((weekDay.getHours()) * 1 + 1);
		weekDay = weekDay.toLocaleString("ru", {weekday: 'short'});
		weekDay = weekDay.charAt(0).toUpperCase() + weekDay.substr(1);
		weekDaysArr.push(weekDay);
		if (weekDay === curWeekDay) {
			item['HourData'].forEach(function (hour, j) {
				hours.push(hour.Hour < 10 ? '0' + hour.Hour + ':00' : hour.Hour + ':00');
				/*random data*/
				comments.push(Math.round(Math.random() * 100));
				likes.push(Math.round(Math.random() * 100));
				reposts.push(Math.round(Math.random() * 100));
				/*
				 comments.push(hour.Comments);
				 likes.push(hour.Likes);
				 reposts.push(hour.Reposts);
				 
				 sum_R += hour.Reposts;
				 sum_L += hour.Likes;
				 sum_C += hour.Comments;
				 sum += hour.Comments + hour.Likes + hour.Reposts;*/

			});
			comments.forEach(function (v) {
				sum_C += v;
			});
			likes.forEach(function (v) {
				sum_L += v;
			});
			reposts.forEach(function (v) {
				sum_R += v;
			});
			sum += sum_R + sum_L + sum_C;
			$htmlstr += '<a class="weekdays active-link" onclick="drawGraph( \'' + weekDay + '\')">' + weekDay + '</a>';
		} else
			$htmlstr += '<a class="weekdays" onclick="drawGraph(\'' + weekDay + '\')">' + weekDay + '</a>';
		//если нужен будет график за неделю - это координаты заливки
		/*
		 if(weekDay === "суббота"){
		 x_fill_begin = i - 0.5;
		 x_fill_end = i + 1.5;
		 }
		 */
	});
	$('.weekdays').append($htmlstr);
	if (sum !== 0) {
		$('.diagramm').show();
		sum_R = Math.round(sum_R * 100 / sum);
		sum_L = Math.round(sum_L * 100 / sum);
		sum_C = Math.round(sum_C * 100 / sum);
	} else {
		$('.diagramm').hide();
	}
	console.log(sum, sum_R, sum_L, sum_C);
	console.dir(hours);
	//

	//для графика
	Highcharts.chart('container', {		
		chart: {
			backgroundColor: BackgroundColor,
			type: 'line'
		},
        legend: {
            squareSymbol:false,
            labelFormatter: function () {
                return '<b style="color:' + this.color + '">' + this.name + '</b>';
            }
        },
		title: {
            useHTML: true,
			text: $htmlstr
		},
		xAxis: {
			categories: hours
		},
		yAxis: {
			gridLineWidth: 0,
			tickWidth: 1,
			title: {
				text: ''
			}
		},
		tooltip: {
			shared: true,
			valueSuffix: '',
			backgroundColor: '#091d46',
			useHTML: true,
			headerFormat: '<div style="float:left; width:16px; height:16px; margin-right:3px"><img src="images/clock.png"/></div><small style="color: #2eb3ec;">{point.key}</small><table>',
			pointFormat: '<tr><td style="color: {series.color}">{series.name}: </td>' +
				'<td style="text-align: right; color: #2eb3ec;"><b>{point.y}</b></td></tr>',
			footerFormat: '</table>'
			/*formatter: function () {
				return '<b>' +  this.series.name +  '</b><br/>' +
					this.x + ': ' + this.y;
			}*/
			
		},
		credits: {
			enabled: false
		},
		plotOptions: {
		},
		series: [{
				name: 'Комментарии',
				data: comments,
				color: '#7b28e1'
			}, {
				name: 'Репосты',
				data: reposts,
				color: '#68bd51'
			}, {
				name: 'Лайки',
				data: likes,
				color: '#db2ccd'
			}]
	});
	drawPie('container_pie1', sum_C, '#7b28e1');
	drawPie('container_pie2', sum_R, '#68bd51');
	drawPie('container_pie3', sum_L, '#db2ccd'); 
}
function drawPie(tag, per, c) {
	if (per) {
        
		Highcharts.getOptions().plotOptions.pie.colors = (function () {
			var colors = [c, Highcharts.Color(BackgroundColor).brighten(-0.1).get('rgb')];
			return colors;
		}());
/*
        Highcharts.map(Highcharts.getOptions().colors, function (c) {
            return {
                radialGradient: {
                    cx: 0.5,
                    cy: 0.3,
                    r: 1
                },
                stops: [
                    [0, c],
                    [1, Highcharts.Color(c).brighten(-0.3).get('rgb')] // darken
                ]
            };
        });*/
		Highcharts.chart(tag, {
			chart: {
				plotShadow: false
			},
			title: {
				text: String(per) + '%',
				align: 'center',
				verticalAlign: 'middle'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					dataLabels: {
						enabled: true,
						distance: -50,
						style: {
							fontWeight: 'bold',
							color: 'white'
						}
					},
//					startAngle: 0,
//					endAngle: 360,
					center: ['50%', '50%']
				}
			},
			series: [{
					type: 'pie',
					innerSize: '50%',
					data: [
						['', per],
						['', 100 - per]
					]
				}]
		});
	}
}