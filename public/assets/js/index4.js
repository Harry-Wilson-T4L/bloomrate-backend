$(function(e) {
	'use strict'

	//Team chart
	var ctx = document.getElementById("team-chart");
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["2013", "2014", "2015", "2016", "2017", "2018", "2019"],
			type: 'line',
			defaultFontFamily: 'Montserrat',
			datasets: [{
				data: [44, 26, 39, 48, 28, 18, 35],
				label: "Defect rate",
				backgroundColor: 'rgba(110,0,255, 0.7)',
				borderColor: 'rgba(110,0,255)',
				borderWidth: 3.5,
				pointStyle: 'circle',
				pointRadius: 5,
				pointBorderColor: 'transparent',
				pointBackgroundColor: 'rgba(110,0,255)',
			}, ]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#bdbdc1',
				bodyFontColor: '#bdbdc1',
				backgroundColor: '#fff',
				titleFontFamily: 'Montserrat',
				bodyFontFamily: 'Montserrat',
				cornerRadius: 3,
				intersect: false,
			},
			legend: {
				display: false,
				position: 'top',
				labels: {
					usePointStyle: true,
					fontFamily: 'Montserrat',
				},
			},
			scales: {
				xAxes: [{
					ticks: {
						fontColor: "#bbc1ca",
					 },
					display: true,
					gridLines: {
						display: true,
						drawBorder: false,
						color: 'rgba(0, 0, 0,0.07)'
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: 'rgba(0, 0, 0,0.07)'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "#bbc1ca",
					 },
					display: true,
					gridLines: {
						display: true,
						drawBorder: false,
						color: 'rgba(0, 0, 0,0.07)'
					},
					scaleLabel: {
						display: true,
						labelString: 'Value',
						fontColor: 'rgba(0, 0, 0,0.07)'
					}
				}]
			},
			title: {
				display: false,
			}
		}
	});

	/*---- morrisBar8----*/
	//PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	new Morris.Donut({
		element: 'morrisBar8',
		data: [{
			value: 46,
			label: 'Supplier 1'
		}, {
			value: 27,
			label: 'Supplier 2'
		}, {
			value: 36,
			label: 'Supplier 3'
		}, {
			value: 53,
			label: 'Supplier 4'
		}, {
			value: 39,
			label: 'Supplier 5'
		}],
		colors: ['#6e00ff ', '#ff6e00', '#0091ff', '#00ff6e', '#ee00ff'],
		formatter: function(x) {
			return x + "%"
		}
	}).on('click', function(i, row) {
		console.log(i, row);
	});

	/* sparkline_bar1 */
	$(".sparkline_bar1").sparkline([2, 4, 3, 4, 5, 4,5,3,4,5,2,4,5,4,3,5,4,3,4,5], {
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
	$(".sparkline_bar2").sparkline([2, 4, 3, 4, 5, 4,5,3,4,5,2,4,5,4,3,5,4,3,4,5], {
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
	//PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	/* sparkline_bar3 */
	$(".sparkline_bar3").sparkline([2, 4, 3, 4, 5, 4,5,3,4,5,2,4,5,4,3,5,4,3,4,5], {
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
	//PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	/* sparkline_bar4 */
	$(".sparkline_bar4").sparkline([2, 4, 3, 4, 5, 4,5,3,4,5,2,4,5,4,3,5,4,3,4,5], {
		type: 'bar',
		height: 50,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#00ff6e'
	});
	/* sparkline_bar4 end */


	/* Chartcircle */
	if ($('.chart-circle-1').length) {
		$('.chart-circle-1').each(function() {
			let $this = $(this);
			$this.circleProgress({
				fill: {
					color: $this.attr('data-color')
				},
				size: $this.height(),
				startAngle: -Math.PI / 4 * 2,
				emptyFill: 'rgba(0,0,0,0.1)',
				lineCap: 'round'
			});
		});
	}
	/* Chartcircle  closed*/

	/*-----echart6-----*/
	var chartdata3 = [
		{
			type: 'bar',
			data: [14, 18, 20, 14, 29, 37]
		},
	];
	var chart6 = document.getElementById('echart6');
	var barChart6 = echarts.init(chart6);

	var option6 = {
		grid: {
		  top: '6',
		  right: '10',
		  bottom: '17',
		  left: '36',
		},
		tooltip: {
			show: true,
			showContent: true,
			alwaysShowContent: true,
			triggerOn: 'mousemove',
			trigger: 'axis',
			axisPointer:
			{
				label: {
					show: false,
				}
			}

		},
		xAxis: {
		  type: 'value',
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
		yAxis: {
		  type: 'category',
		   data: ['Battery', 'Display', 'Other', 'Sensors', 'Switches', 'Transitors'],
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
		color:[ '#0091ff']
	  };
	  barChart6.setOption(option6);

	/*-----echart6-----*/
	//PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	var chartdata4 = [{
		name: 'Early',
		type: 'bar',
		stack: 'Stack',
		data: [14, 18, 20, 14, 29, 43, 23]
	}, {
		name: 'Ontime',
		type: 'bar',
		stack: 'Stack',
		data: [18, 21, 17, 32, 26, 32, 34]
	}, {
		name: 'Late',
		type: 'bar',
		stack: 'Stack',
		data: [12, 14, 15, 50, 24, 45, 35]
	}];
	var option6 = {
		grid: {
			top: '6',
			right: '10',
			bottom: '17',
			left: '32',
		},
		tooltip: {
			show: true,
			showContent: true,
			alwaysShowContent: true,
			triggerOn: 'mousemove',
			trigger: 'axis',
			axisPointer:
			{
				label: {
					show: false,
				}
			}

		},
		xAxis: {
			data: ['Supplier 1', 'Supplier 2', 'Supplier 3', 'Supplier 4', 'Supplier 5', 'Supplier6', 'Supplier7'],
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
		series: chartdata4,
		color: ['#6e00ff ', '#ff6e00',  '#0091ff']
	};
	var chart6 = document.getElementById('echart7');
	var barChart6 = echarts.init(chart6);
	barChart6.setOption(option6);
});