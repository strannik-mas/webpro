const BackgroundColor = 'rgba(7,42,92,1)';
const LikesColor = '#db2ccd';
const RepostsColor = '#68bd51';
const CommentsColor = '#7b28e1';
const PostsColor = '#3b59be';
const AddsColor = '#4de9e3';
const TextColor = '#4be5e1';
$(function () {
    //поменять запрос на внутренний, без php
	$.get("sample.json")
		.done(function (data) {
//                    console.dir(data);
            
			localStorage.setItem('jsondata', JSON.stringify(data));
			localStorage.setItem('rad_1', 0);
			localStorage.setItem('rad_2', 0);
			localStorage.setItem('rad_3', 0);
			drawGraph();
            
//                    drawGraph(JSON.parse(data).reverse());
            
		})
        .fail(function (jqxhr, textStatus, error) {
            var err = textStatus + ', ' + error;
            console.log("Request Failed: " + err);
        });
                       
});
function drawGraph(curWeekDay = new Date().toLocaleString("ru", {weekday:'short'}), radiusLikes = 0, radiusReposts = 0, radiusComments = 0, anim = true){    
	var dataArr = JSON.parse(localStorage.getItem('jsondata'));
    //массив постов 
    var postsAllArr = dataArr[0].Posts;
    var postsArr = [];      //массив обычных постов
    var addsArr = [];       //массив рекламных постов
    var addsPointsArr = []; //массив точек рекламных постов
    var postWeekDay = '';   //день недели, в который написан пост
    var k = 0;              //счетчик точек массива рекламных постов 
	curWeekDay = curWeekDay.charAt(0).toUpperCase() + curWeekDay.substr(1);
    localStorage.setItem('curday', curWeekDay);
    
    dataArr = dataArr[0].Days.reverse();
    for(let s=0; s<=24; s++){
        addsPointsArr.push({
            x: s,
            y: 0,
            marker: {
                enabled: false
            }
        });
    }
    //массив нерекламных постов и массив рекламных постов
    postsAllArr.forEach(function(item,i){
        item['PublishedAt'] = item['PublishedAt'].replace('Z', '+02:00');
        postWeekDay = new Date(item['PublishedAt']).toLocaleString("ru", {weekday: 'short'});
        postWeekDay = postWeekDay.charAt(0).toUpperCase() + postWeekDay.substr(1);
//        console.log(postWeekDay, item['PublishedAt']);
        if(postWeekDay === curWeekDay){
            if (item["IsAds"] == 'true') {
                var tempHour = item['PublishedAt'].slice(item['PublishedAt'].indexOf('T') + 1, (item['PublishedAt'].indexOf('T') + 6)).split(":");
                
                addsPointsArr.push({
                    x: parseInt(tempHour[0]) + tempHour[1]/60,
                    y: 0,
                    color: AddsColor,
                    id: k++,
                    marker: {
                        enabled: true,
                        fillColor:AddsColor,
                        radius: 4,
                        symbol: "circle"
                    }
                });
//                console.log(tempHour);
                addsArr.push(item);
            } else{
                postsArr.push(item);
            }                
        }
        
    });
    addsPointsArr.sort(sortByX);
//    console.dir(dataArr); 
//    console.dir(postsAllArr);
//    console.dir(postsArr);
    
    
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
	$('.weekdays').html('');
    
	dataArr.forEach(function (item, i) {
        //перевод на пояс UTC +02
        item['Day'] = item['Day'].replace('+03:00', '+02:00');
		weekDay = new Date(item['Day']).toLocaleString("ru", {weekday: 'short'});
		weekDay = weekDay.toLocaleString("ru", {weekday: 'short'});
		weekDay = weekDay.charAt(0).toUpperCase() + weekDay.substr(1);
		weekDaysArr.push(weekDay);
		if (weekDay === curWeekDay) {
			item['HourData'].forEach(function (hour, j) {
//                console.log(j);
				hours.push(hour.Hour < 10 ? '0' + hour.Hour + ':00' : hour.Hour + ':00');
                if(j===0){  
                    comments.push([j, Math.round(Math.random() * 100)]);
                    likes.push([j, Math.round(Math.random() * 100)]);
                    reposts.push([j, Math.round(Math.random() * 100)]);
                    
                }
                if(j===23)
                    hours.push('24:00'); 
                /*random data*/
				comments.push([j+1, Math.round(Math.random() * 100)]);
                likes.push([j+1, Math.round(Math.random() * 100)]);
                reposts.push([j+1, Math.round(Math.random() * 100)]);
                
                
                //линейная интерполяция для точек постов в 3-х графиках
                for(let k=0; k<addsPointsArr.length; k++){
                    if(j < addsPointsArr[k].x && (j+1) > addsPointsArr[k].x){
                        var tempYComments = interpolation(comments[comments.length-2][1], comments[comments.length - 1][1], addsPointsArr[k].x, j, (j+1));
                        var tempYLikes = interpolation(likes[likes.length-2][1], likes[likes.length - 1][1], addsPointsArr[k].x, j, (j+1));
                        var tempYReposts = interpolation(reposts[reposts.length-2][1], reposts[reposts.length - 1][1], addsPointsArr[k].x, j, (j+1));
                        comments.splice(comments.length-1, 0, [addsPointsArr[k].x, tempYComments]);
                        likes.splice(likes.length-1, 0, [addsPointsArr[k].x, tempYLikes]);
                        reposts.splice(reposts.length-1, 0, [addsPointsArr[k].x, tempYReposts]);
    //                    addsPointsArr[k].y = tempYComments+tempYReposts+tempYLikes;
                    }
                }
                
                
				/*
				 comments.push(hour.Comments);
				 likes.push(hour.Likes);
				 reposts.push(hour.Reposts);
				 
				 sum_R += hour.Reposts;
				 sum_L += hour.Likes;
				 sum_C += hour.Comments;
				 sum += hour.Comments + hour.Likes + hour.Reposts;*/

			});
            
            
    console.dir(addsPointsArr); 
            
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
			$htmlstr += '<a class="weekdays active-link" onclick="return false">' + weekDay + '</a>';
		} else
			$htmlstr += '<a class="weekdays" onclick="drawGraph( \'' + weekDay + '\', localStorage.getItem(\'rad_1\'), localStorage.getItem(\'rad_2\'), localStorage.getItem(\'rad_3\'), ((localStorage.getItem(\'rad_1\')*1 + localStorage.getItem(\'rad_2\')*1 + localStorage.getItem(\'rad_3\')*1) === 0 ))">' + weekDay + '</a>';
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
    
//	console.log(sum, sum_R, sum_L, sum_C);
//	console.dir(hours);
	console.dir(comments);

	//
//console.log(typeof anim, anim);

	//построение графиков
	Highcharts.chart('container', {		
		chart: {
			backgroundColor: BackgroundColor,
			type: 'areaspline'
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
			categories: hours,
            crosshair: anim ? {
                width: 1,
                color: '#000',
                snap: false
            } : null,
            lineColor: TextColor,
            tickColor: TextColor,
            labels: {
                style: {
                    color: TextColor
                }
            }
		},
		yAxis: {
			gridLineWidth: 0,
			tickWidth: 1,
			title: {
				text: ''
			},
            lineColor: TextColor,
            tickColor: TextColor,
            labels: {
                style: {
                    color: TextColor
                }
            }
		},
		tooltip: {
            animation: anim,
            hideDelay: anim ? 500 : 10,
//			shared: true,
			valueSuffix: '',
			backgroundColor: BackgroundColor,
			useHTML: true,
			headerFormat: '<div style="float:left; width:16px; height:16px; margin-right:3px"><img src="images/clock.png"/></div><small style="color: #2eb3ec;">{point.key}</small><table>',
			pointFormat: '<tr><td style="color: {series.color}">{series.name}: </td>' +
				'<td style="text-align: right; color: #2eb3ec;"><b>{point.y}</b></td></tr>',
			footerFormat: '</table>'
			
		},
        plotOptions: {
            series: { 
                stacking: 'area',
                stickyTracking: anim,
            /*
                point: {
                    events: {
                        mouseOver: function (e) {
                            console.dir(this.series.chart);
//                            Highcharts.getOptions().tooltip.enabled = true;
                        }
                    }
                },
                */
                animation: {
                    duration: anim ? 1000 : 0
                }               
            }
        },
		series: [{
				name: 'Комментарии',
				data: comments,
				color: CommentsColor,
                marker: {
                    radius: parseInt(radiusComments)
                }
			}, {
				name: 'Репосты',
				data: reposts,
				color: RepostsColor,
                marker: {
                    radius: parseInt(radiusReposts)
                }
			}, {
				name: 'Лайки',
				data: likes,
				color: LikesColor,
                marker: {
                    radius: parseInt(radiusLikes)
                }
			}, {
				name: 'Посты',
				data: addsPointsArr
			}]
	});
    
    /*
	drawPie('container_pie1', sum_C, CommentsColor, "comment.png", anim);
	drawPie('container_pie2', sum_R, RepostsColor, "repost.png", anim);
	drawPie('container_pie3', sum_L, LikesColor, "like.png", anim); 
    $('.pie').each(function(index,element){
        var str = parseInt(localStorage.getItem('rad_' + (index+1))) ? 'скрыть' : 'показать';
        $(element).append('<div class="showlink" onclick="togglePoints('+ (index+1) +')">' + str + '</div>');
    });
    */
}

function togglePoints(i){
    var newradius = parseInt(localStorage.getItem('rad_' + i)) ? 0 : 4;
    localStorage.setItem(('rad_' + i), newradius);
    drawGraph(localStorage.getItem('curday'), localStorage.getItem('rad_1'), localStorage.getItem('rad_2'), localStorage.getItem('rad_3'), ((localStorage.getItem('rad_1')*1 + localStorage.getItem('rad_2')*1 + localStorage.getItem('rad_3')*1) === 0 ));    
}

function drawPie(tag, per, c, filename, anim) {
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
				align: 'center',
				verticalAlign: 'top',
                y: 100,
                useHTML: true,
                text: '<img src="images/' + filename + '"/><span style="color:' + c + '">' + String(per) + '%</span>'
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
                    borderWidth: 0,
					center: ['50%', '50%'],
                    animation: anim
                    /*
                    series: {
                        animation: {
                            duration: anim ? 1000 : 0
                        }               
                    }
                    */
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
function interpolation(y1, y2, x, x1, x2){
    return (y1 + (y2 -y1)*(x-x1)/(x2-x1));
}
function sortByX(a, b){
    return a.x-b.x;
}