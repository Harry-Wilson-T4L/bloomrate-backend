$(function(e) {
	'use strict'

	/*-----Updating charts-----*/
	$("span.graph").peity("pie")
	var updatingChart = $(".updating-chart1").peity("line", {
		width: "100%",
		height: 140
	})
	setInterval(function() {
		var random = Math.round(Math.random() * 20)
		var values = updatingChart.text().split(",")
		values.shift()
		values.push(random)
		updatingChart.text(values.join(",")).change()
	}, 2500)
	/*-----echart1-----*/
	var chartdata = [{
		name: 'Total Budget',
		type: 'bar',
		data: [10, 15, 9, 18, 10, 15, 7, 14],
		symbolSize: 10,
		itemStyle: {
			normal: {
				barBorderRadius: [0, 0, 0, 0],
				color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
					offset: 0,
					color: '#6e00ff '
				}, {
					offset: 1,
					color: '#6e00ff'
				}])
			}
		},
	}, {
		name: 'Total Amount',
		type: 'bar',
		data: [10, 14, 10, 15, 9, 25, 15, 18],
		symbolSize: 10,
		itemStyle: {
			normal: {
				barBorderRadius: [0, 0, 0, 0],
				color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
					offset: 0,
					color: '#0091ff'
				}, {
					offset: 1,
					color: '#0091ff'
				}])
			}
		},
	}];
	var chart = document.getElementById('echart');
	var barChart = echarts.init(chart);
	var option = {
		grid: {
			top: '6',
			right: '0',
			bottom: '17',
			left: '25',
		},
		xAxis: {
			data: ['2015', '2016', '2017', '2018', '2019'],
			axisLine: {
				lineStyle: {
					color: 'rgba(0, 0, 0,0.07)'
				}
			},
			axisLabel: {
				fontSize: 10,
				color: '#bdbdc1'
			}
		},
		tooltip: {
			show: true,
			showContent: true,
			alwaysShowContent: true,
			triggerOn: 'mousemove',
			trigger: 'axis',
			axisPointer: {
				label: {
					show: false,
				}
			}
		},
		yAxis: {
			splitLine: {
				lineStyle: {
					color: 'rgba(0, 0, 0,0.07)'
				}
			},
			axisLine: {
				lineStyle: {
					color: 'rgba(0, 0, 0,0.07)'
				}
			},
			axisLabel: {
				fontSize: 10,
				color: '#bdbdc1'
			}
		},
		series: chartdata,
		color: ['#6e00ff', '#0091ff']
	};
	barChart.setOption(option);
	/*-----WidgetChart1 CHARTJS-----*/
	var ctx = document.getElementById("widgetChart1");
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
			type: 'line',
			datasets: [{
				label: "This Week",
				backgroundColor: "#6e00ff",
				data: [2, 7, 3, 9, 4, 5, 2, 8, 4, 6, 5, 2, 8, 4, 7, 2, 4, 6, 4, 8, 4]
			}, {
				label: "Last Week",
				backgroundColor: "#ff6e00",
				data: [5, 3, 9, 6, 5, 9, 7, 3, 5, 2, 5, 3, 9, 6, 5, 9, 7, 3, 5, 2]
			}]
		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: false
			},
			responsive: true,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#000',
				bodyFontColor: '#000',
				backgroundColor: '#fff',
				cornerRadius: 0,
				intersect: false,
			},
			scales: {
				xAxes: [{
					gridLines: {
						color: 'transparent',
						zeroLineColor: 'transparent'
					},
					ticks: {
						fontSize: 2,
						fontColor: 'transparent'
					}
				}],
				yAxes: [{
					display: false,
					ticks: {
						display: false,
					}
				}]
			},
			title: {
				display: false,
			},
			elements: {
				line: {
					borderWidth: 2
				},
				point: {
					radius: 0,
					hitRadius: 10,
					hoverRadius: 4
				}
			}
		}
	});
	/*---- MorrisDonutChart----*/
	new Morris.Donut({
		element: 'morrisBar8',
		data: [{
			value: 50,
			label: 'Complete'
		}, {
			value: 25,
			label: 'Pending'
		}, {
			value: 15,
			label: 'Future'
		}],
		colors: ['#6e00ff ', '#ff6e00', '#0091ff'],
		formatter: function(x) {
			return x + "%"
		}
	}).on('click', function(i, row) {
		console.log(i, row);
	});
	var chartdata = [{
		name: 'Complete',
		type: 'bar',
		data: [10, 15, 9, 18, 10, 15]
	}, {
		name: 'Pending',
		type: 'line',
		smooth: true,
		data: [8, 5, 25, 10, 10]
	}, {
		name: 'Future',
		type: 'bar',
		data: [10, 14, 10, 15, 9, 25]
	}];

	/* sparkline_bar1 */
	$(".sparkline_bar1").sparkline([2, 4, 3, 4, 5, 4], {
		type: 'bar',
		height: 50,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#6e00ff'
	});
	/* sparkline_bar1 end */

	/* sparkline_bar2 */
	$(".sparkline_bar2").sparkline([2, 4, 3, 4, 5, 4], {
		type: 'bar',
		height: 50,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#ff6e00'
	});
	/* sparkline_bar2 end */

	/* sparkline_bar3 */
	$(".sparkline_bar3").sparkline([2, 4, 3, 4, 5, 4], {
		type: 'bar',
		height: 50,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#0091ff'
	});
	/* sparkline_bar3 end */

});