$(function(e) {
	'use strict'

	/* Echart */
	var chartdata3 = [{
		name: 'Last Period',
		type: 'bar',
		stack: 'Stack',
		data: [14, 18, 20, 14, 29, 21, 25, 14, 24, 54, 43, 39]
	}, {
		name: 'Current Period',
		type: 'bar',
		stack: 'Stack',
		data: [12, 14, 15, 50, 24, 24, 10, 20, 30, 38, 45, 46]
	}];
	var option5 = {
		grid: {
			top: '6',
			right: '0',
			bottom: '17',
			left: '25',
		},
		xAxis: {
			data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
		series: chartdata3,
		color: ['#6e00ff ', '#ff6e00']
	};
	var chart5 = document.getElementById('echart');
	var barChart5 = echarts.init(chart5);
	barChart5.setOption(option5);

	$(".sparkline_bar1").sparkline([2, 4, 3, 4, 5, 4, 5, 0, 3, 5, 6, 4, 4, 4, 5, 3, 5], {
		type: 'bar',
		height: 40,
		width:250,
		barWidth: 4,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#f5f3f3'
	});
	
});