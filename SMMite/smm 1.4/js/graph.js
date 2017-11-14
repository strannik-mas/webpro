const BackgroundColor = 'rgba(7,42,92,1)';
const BackgroundTooltipColor = '#091d45';
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
			drawGraph();
            
//                    drawGraph(JSON.parse(data).reverse());
            
		})
        .fail(function (jqxhr, textStatus, error) {
            var err = textStatus + ', ' + error;
            console.log("Request Failed: " + err);
        });
                       
});

function drawGraph(curWeekDay = new Date().toLocaleString("ru", {weekday:'short'}), radiusAddsPosts = 0, radiusPosts = 0, anim = true){   
	var dataArr = JSON.parse(localStorage.getItem('jsondata'));
    //массив постов 
    var postsAllArr = dataArr[0].Posts;
    
    var addsPointsArr = []; //массив точек рекламных постов
    var postsPointsArr = []; //массив точек обычных постов
    var postWeekDay = '';   //день недели, в который написан пост
    var averagePosts = 0;               //средне количество постов за неделю
    var percentPosts = 0;               //средн. процент постов
    var averageAdds = 0;               //средне количество постов за неделю
    var percentAdds = 0;               //средн. процент рекламы
    var sum_P = 0;                      //сумма всех постов   
	var sum_A = 0;                      //сумма всех реклам
    
	curWeekDay = curWeekDay.charAt(0).toUpperCase() + curWeekDay.substr(1);
    localStorage.setItem('curday', curWeekDay);
    
    dataArr = dataArr[0].Days.reverse();

    //массив нерекламных постов и массив рекламных постов
    postsAllArr.forEach(function(item,i){
        item['PublishedAt'] = item['PublishedAt'].replace('Z', '+02:00');
        postWeekDay = new Date(item['PublishedAt']).toLocaleString("ru", {weekday: 'short'});
        postWeekDay = postWeekDay.charAt(0).toUpperCase() + postWeekDay.substr(1);
//        console.log(postWeekDay, item['PublishedAt']);
        if(postWeekDay === curWeekDay && !anim){
            var tempHour = item['PublishedAt'].slice(item['PublishedAt'].indexOf('T') + 1, (item['PublishedAt'].indexOf('T') + 6)).split(":");
            if (item["IsAds"] == 'true' && radiusAddsPosts != 0) {                
                addToPointsArray(addsPointsArr, tempHour, radiusAddsPosts, item, AddsColor);                
            } else if(item["IsAds"] == 'false' && radiusPosts != 0){
                addToPointsArray(postsPointsArr, tempHour, radiusPosts, item, PostsColor);
            }                
        }
        if (item["IsAds"] == 'true'){
            sum_A++;
        }else{
            sum_P++;
        }
    });
    averagePosts = Math.round(sum_P/7);
    averageAdds = Math.round(sum_A/7);
    percentPosts = Math.round(averagePosts*100/sum_P);
    percentAdds = Math.round(averageAdds*100/sum_A);
//    console.dir(dataArr); 
//    console.dir(averageAdds, averagePosts);
//    console.dir(postsArr);
    
    
	var hours = [];
	var comments = [];                  //количество комментариев
	var reposts = [];                   //количество репостов
	var likes = [];                     //количество лайков
	var weekDay = '';                   //текущий день недели
	var weekDaysArr = [];               //массив дней недели
	var x_fill_begin = 0;               //координата начала заливки выходных
	var x_fill_end = 0;                 //координата конца заливки выходных
    
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
                        addsPointsArr[k].y = tempYComments;
                        comments.splice(comments.length-1, 0, addsPointsArr[k]);
                        likes.splice(likes.length-1, 0, [addsPointsArr[k].x, tempYLikes]);
                        reposts.splice(reposts.length-1, 0, [addsPointsArr[k].x, tempYReposts]);
                        
                    }
                }
                for(let k=0; k<postsPointsArr.length; k++){
                    if(j < postsPointsArr[k].x && (j+1) > postsPointsArr[k].x){
                        
                        var tempYComments = interpolation(comments[comments.length-2][1] ? comments[comments.length-2][1] : comments[comments.length-2].y, comments[comments.length - 1][1] ? comments[comments.length - 1][1] : comments[comments.length - 1].y, postsPointsArr[k].x, j, (j+1));
                        var tempYLikes = interpolation(likes[likes.length-2][1], likes[likes.length - 1][1], postsPointsArr[k].x, j, (j+1));
                        var tempYReposts = interpolation(reposts[reposts.length-2][1], reposts[reposts.length - 1][1], postsPointsArr[k].x, j, (j+1));
                        postsPointsArr[k].y = tempYComments;
                        comments.splice(comments.length-1, 0, postsPointsArr[k]);
                        likes.splice(likes.length-1, 0, [postsPointsArr[k].x, tempYLikes]);
                        reposts.splice(reposts.length-1, 0, [postsPointsArr[k].x, tempYReposts]);
                        
                    }
                }
                
				/*
				 comments.push(hour.Comments);
				 likes.push(hour.Likes);
				 reposts.push(hour.Reposts);*/

			});
            
            
//    console.dir(addsPointsArr); 
			$htmlstr += '<a class="weekdays active-link" onclick="return false">' + weekDay + '</a>';
		} else
			$htmlstr += '<a class="weekdays" onclick="drawGraph( \'' + weekDay + '\', localStorage.getItem(\'rad_1\'), localStorage.getItem(\'rad_2\'), ((localStorage.getItem(\'rad_1\')*1 + localStorage.getItem(\'rad_2\')*1 ) === 0 ))">' + weekDay + '</a>';
	});
	$('.weekdays').append($htmlstr);
	
    var xObj = anim ? {
			categories: hours,
            crosshair: {
//                width: 1,
//                color: '#000',
                snap: true
            },
            lineColor: TextColor,
            tickColor: TextColor,
            labels: {
                style: {
                    color: TextColor
                }
            }
		} : {
			categories: hours,
            lineColor: TextColor,
            tickColor: TextColor,
            labels: {
                style: {
                    color: TextColor
                }
            }
		};
//	console.dir(hours);
//	console.dir(comments);

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
		xAxis: xObj,
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
        plotOptions: {
            series: { 
                stacking: 'area',
                stickyTracking: anim,
                animation: {
                    duration: anim ? 1000 : 0
                }
            }
            
        },        
        tooltip: {
			shared: true,
//            enabled: anim,
			backgroundColor: BackgroundColor,
			useHTML: true,
            formatter: function () {
                var min = this.x - Math.floor(this.x);             
                var timeStr = this.x;
                if(min > 0){
                    min = Math.round(min*60) < 10 ? '0' + Math.round(min*60) : Math.round(min*60);
                    timeStr = Math.floor(this.x) < 10 ? '0' + Math.floor(this.x) + ":" + min : Math.floor(this.x) + ":" + min;
                }
                var s = '<div style="float:left; width:16px; height:16px; margin-right:3px"><img src="images/clock.png"/></div><small style="color: #2eb3ec;">' + timeStr + '</small>';               
                $.each(this.points, function () {
                    s += '<br/><b style="color: ' + this.series.color + '">' + this.series.name + ': ' +
                    Math.round(this.y) + '</b>';
                });
                return s;
            }
		},        
		series: [{
				name: 'Комментарии',
				data: comments,
				color: CommentsColor,
                marker: {
                    radius: 0,
                    states: {
                        hover: {
//                            enabled: false
                        }
                    }
                },
			}, {
				name: 'Репосты',
				data: reposts,
				color: RepostsColor,
                marker: {
                    radius: 0,
                    states: {
                        hover: {
//                            radiusPlus: anim ? 2 : 0
                        }
                    }
                }
			}, {
				name: 'Лайки',
				data: likes,
				color: LikesColor,
                marker: {
                    radius: 0,
                    states: {
                        hover: {
//                            enabled: anim                        
                        }
                    }
                }
			}]
	});
    
//    averagePosts += ' ' + getEnding(averagePosts, ['пост', 'поста', 'постов']);
    var postStr ='<p>(в день)</p>';
    if(sum_P !== 0)
        drawPie('container_pie1', percentPosts, averagePosts, PostsColor, "post.png", anim);
    else $('#container_pie1').hide();
    if(sum_A !== 0)
        drawPie('container_pie2', percentAdds, averageAdds, AddsColor, "add.png", anim);
    else $('#container_pie2').hide();
    $('.pie').each(function(index,element){
        if($(element).css('display') !== 'none'){
            var str = parseInt(localStorage.getItem('rad_' + (index+1))) ? 'скрыть' : 'показать';
            if(str === 'скрыть' && index == 1)
                $(element).append('<div class="showlink" onclick="togglePoints('+ (index+1) +', \'post\')">' + str + '</div>');
            else if(str === 'скрыть' && index == 0)
                $(element).append('<div class="showlink" onclick="togglePoints('+ (index+1) +', \'add\')">' + str + '</div>');
            else $(element).append('<div class="showlink" onclick="togglePoints('+ (index+1) +')">' + str + '</div>');
        }        
    });
    
}

function togglePoints(i, cClose = ''){
    var newradius = parseInt(localStorage.getItem('rad_' + i)) ? 0 : 4;
//    console.log(i, cClose);
    localStorage.setItem(('rad_' + i), newradius);
    if (cClose != '') closeWindow(cClose);
    drawGraph(localStorage.getItem('curday'), localStorage.getItem('rad_1'), localStorage.getItem('rad_2'), ((localStorage.getItem('rad_1')*1 + localStorage.getItem('rad_2')*1) === 0 ));    
}

function drawPie(tag, per, text, c, filename, anim) {
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
                text: '<img src="images/' + filename + '" class="img_pie"/><span style="color:' + c + '">' + String(text) + ' (в день)</span>'
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
function closeWindow(c = ''){
    if(c != '' && typeof c === 'string'){
        $('.' + c)
            .animate({opacity: 0, top: '45%'}, 200, 
                function () { 
                    $(this).css('display', 'none'); 
                }
            );
    }
    else {    
        $('#modal')
            .animate({opacity: 0, top: '45%'}, 200, 
                function () { 
                    $(this).css('display', 'none'); 
                }
            );
    }
}
function addToPointsArray(arr, tempHour, radius, item, color){
    arr.push({
        x: parseInt(tempHour[0]) + tempHour[1] / 60,
        y: 0,
        color: color,
        marker: {
            enabled: true,
            fillColor: color,
            radius: parseInt(radius),
            symbol: "circle"
        },
        events: {
            mouseOver: function (e) {
                var chart = this.series.chart;
                chart.tooltip.options.enabled = false;
                
                $('#modal').html('').removeClass().addClass(item['IsAds'] == 'true' ? 'add' : 'post');
                $htmlModalStr = `<span id="modal_close">Х</span>
                            <div class="clock_icon"><img src="images/clock.png"/></div>
                            <small style="color: ` + TextColor + `">` + tempHour[0] + `:` + tempHour[1] + `</small>
                            <div  class="postdata">
                            <table>
                                <tr style="color: ` + LikesColor + `">
                                    <td><img src="images/like_ico.png"/></td>
                                    <td>-</td>
                                    <td>` + item.CurrentLikes
                    + `</td>
                                </tr>
                                <tr style="color: ` + RepostsColor + `">
                                    <td><img src="images/repost_ico.png"/></td>
                                    <td>-</td>
                                    <td>` + item.CurrentReposts
                    + `</td>
                                </tr>
                                <tr style="color: ` + CommentsColor + `">
                                    <td><img src="images/comment_ico.png"/></td>
                                    <td>-</td>
                                    <td>` + item.CurrentComments
                    + `</td>
                                </tr>
                            </table>
                            </div>
                            <div class="thumbs_pic">
                                <img src="` + item.ScreenshotUrl + `"><br><a href="` + item.VkPostUrl + `">Подробнее</a>
                            </div`;
//                                console.dir(e.target);
//                                console.dir(item);
                $('#modal')
                    .html($htmlModalStr)
                    .css({
                        'display': 'block',
                        'border': '3px ' + color + ' solid',
                        'background': BackgroundTooltipColor
                    })
                    .animate({
                        opacity: 0.85,
//                        top: Math.round(e.target.plotY) + 50,
                        top: 150,
                        left: Math.round(e.target.clientX) + ((e.target.clientX > (parseInt($('#container').css('width')) - 400)) ? -150 : 220)
                    }, 100);
                //закрытие модального окна
                $('#modal_close').click(closeWindow);

            },
            mouseOut: function(e){
                var chart = this.series.chart;
                setTimeout(chart.tooltip.options.enabled = true, 3000);
            }
        }

    });
}
function getEnding(n, arr){
    var endingStr, i;
    n = n%100;
    if(n >= 11 && n <= 19){
        endingStr = arr[2];
    }else{
        i = n%10;
        
        switch(i){
            case(1): 
                endingStr = arr[0];
                break;
            case(2):
            case(3):
            case(4): endingStr = arr[1]; break;
            default : endingStr = arr[2];
        }
    }
    return endingStr;
}