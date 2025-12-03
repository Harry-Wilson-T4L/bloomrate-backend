$(function(e) {
	'use strict'

	//----pie chart
	var ctx = document.getElementById("pieChart");
	ctx.height = 230;
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			datasets: [{
				data: [40, 35, 30],
				backgroundColor: ['#6e00ff', '#ff6e00', '#0091ff'],
				hoverBackgroundColor: ['#6e00ff', '#ff6e00', '#0091ff'],
				borderColor:'transparent',
			}],
			labels: ["Junior", "Mid-level", "Senior"]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				labels: {
					fontColor: "#14171a"
				},
			},
		}
	});

	/* sparkline_bar1 */
	$(".sparkline_bar1").sparkline([5, 4, 3, 4, 5, 4], {
		type: 'bar',
		height: 35,
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
	$(".sparkline_bar2").sparkline([6, 5, 6, 7, 8, 6], {
		type: 'bar',
		height: 35,
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
	$(".sparkline_bar3").sparkline([5, 6, 7, 6, 7, 8], {
		type: 'bar',
		height: 35,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#0091ff'
	});
	/* sparkline_bar3 end */

	/*-----echart6-----*/
	var chartdata3 = [
		{
			type: 'bar',
			data: [14, 18, 20, 14, 29]
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
		   data: ['IT', 'HR', 'Marketing', 'Sales', 'Customer Services'],
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
			color: '#14171a'
		  }
		},
		series: chartdata3,
		color:[ '#6e00ff']
	  };
	  barChart6.setOption(option6);

	  /* Chart-js (#site-executive) */
	  //PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	var myCanvas = document.getElementById("empchart");
	myCanvas.height="260";
	var myChart = new Chart( myCanvas, {
		type: 'line',
		data : {
			labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
			type: 'line',
			 datasets: [
			{
				label: "Part-Time",
				data: [2,7,3,9,4,5,2,8,4,6,5,2,8,4,7,2,4,6,4,8,4],
				 borderColor: "rgb(0,145,255,0.6)",
                 backgroundColor: "rgb(0,145,255,0.8)",
				pointBorderWidth :2,
				pointRadius :4,
				pointHoverRadius :4,
				borderWidth: 2,

			}, {
				label: "Full-Time",
				data: [5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2,7,10],
				 borderColor: "rgb(255,110,0,0.6)",
                 backgroundColor: "rgb(255,110,0,0.8)",
				pointBorderWidth :2,
				pointRadius :4,
				pointHoverRadius :4,
				borderWidth: 2,

			}
		  ]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				display:true
			},
			tooltips: {
				show: true,
				showContent: true,
				alwaysShowContent: true,
				triggerOn: 'mousemove',
				trigger: 'axis',
				axisPointer:
				{
					label: {
						show: false,
					},
				}
			},

			scales: {
				xAxes: [ {
					gridLines: {
						color: '#eaf2f9',
						zeroLineColor: '#bdbdc1'
					},
					ticks: {
						fontSize: 12,
						fontColor: '#bdbdc1',
						 beginAtZero: true,
						padding: 0
					}
				} ],
				yAxes: [ {
					gridLines: {
						color: 'transparent',
						zeroLineColor: '#bdbdc1'
					},
					ticks: {
						fontSize: 12,
						fontColor: '#bdbdc1',
						beginAtZero: false,
						padding: 0
					}
				} ]
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
	})
	/* Chart-js (#empchart) closed */

	/*-----echart-----*///PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	var chartdata = [{
		name: 'sales',
		type: 'bar',
		data: [10, 15, 9, 18, 10, 15, 18, 20, 17, 12, 11, 17]

	}];
	var chart = document.getElementById('linechart');
	var barChart = echarts.init(chart);
	var option = {
		grid: {
			top: '6',
			right: '0',
			bottom: '17',
			left: '25',
		},
		xAxis: {
			data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
		color: ['#00ff6e']
	};
	barChart.setOption(option);
});