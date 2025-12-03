$(function(e){
  'use strict'

	/*--Sparkline--*/
	$(".sparkline_bar1").sparkline([2, 4, 3, 4, 5, 4, 5, 0, 3, 5, 6, 4, 4, 4, 5, 3, 5], {
		type: 'bar',
		height: 60,
		width:250,
		barWidth: 4,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#6e00ff'
	});
	/*--Sparkline--*/

	/*--areachart--*/
	var ctx = document.getElementById( "AreaChart1" );
	var myChart = new Chart( ctx, {
		type: 'line',
		data: {
			labels: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
			type: 'line',
			datasets: [ {
				data: [45, 55, 32, 67, 49, 72, 52],
				label: 'orders',
				backgroundColor: '#ff6e00',
				borderColor: '#ff6e00',
				borderWidth: '5',
				pointBorderColor: '#ff6e00',
				pointBackgroundColor: '#ff6e00',
			}
			]
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
				titleFontColor: '#bdbdc1',
				bodyFontColor: '#bdbdc1',
				backgroundColor: '#fff',
				titleFontFamily: 'Montserrat',
				bodyFontFamily: 'Montserrat',
				cornerRadius: 3,
				intersect: false,
			},
			scales: {
				xAxes: [ {
					gridLines: {
						color: 'transparent',
						zeroLineColor: 'transparent'
					},
					ticks: {
						fontSize: 2,
						fontColor: 'transparent'
					}
				} ],
				yAxes: [ {
					display:false,
					ticks: {
						display: false,
					}
				} ]
			},
			title: {
				display: false,
			},
			elements: {
				line: {
					borderWidth: 1
				},
				point: {
					radius: 2,
					hitRadius: 10,
					hoverRadius: 4
				}
			}
		}
	} );
	/*--End areachart--*/

	//----pie chart//PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	var ctx = document.getElementById("pieChart");
	ctx.height = 240;
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			datasets: [{
				data: [40, 35, 30],
				backgroundColor: ['#6e00ff', '#ff6e00', '#0091ff'],
				hoverBackgroundColor: ['#6e00ff', '#ff6e00', '#0091ff'],
				borderColor:'transparent',
			}],
			labels: ["Mens", "Womens", "Kids"]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				labels: {
					fontColor: "#bbc1ca"
				},
			},
		}
	});

	//----pie chart1
	var ctx = document.getElementById("pieChart1");
	ctx.height = 400;
	var myChart = new Chart(ctx, {
		type: 'pie',
		data: {
			datasets: [{
				data: [37, 55, 60, 45, 77],
				backgroundColor: ['#6e00ff', '#ff6e00', '#0091ff', '#00ff6e', '#ee00ff'],
				hoverBackgroundColor: ['#6e00ff', '#ff6e00', '#0091ff', '#00ff6e', '#ee00ff'],
				borderColor:'transparent',
			}],
			labels: ["Defective Item", "Damaged Item", "Item Does Not fit", "Late Delivery", "Wrong Item Delivered"]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				labels: {
					fontColor: "#bbc1ca"
				},
			},
		}
	});
	/*-----echart2-----*///PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
	//feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=
	var chartdata = [{
		name: 'New Customers',
		type: 'bar',
		data: [17, 13, 18, 20, 10, 12, 14]
	}, {
		name: 'Ratio',
		type: 'line',
		smooth: true,
		data: [19, 15, 22, 11, 15, 21, 34]
	}, {
		name: 'Returning Customers',
		type: 'bar',
		data: [13, 15, 18, 23, 15, 23, 22]
	}];
	var chart = document.getElementById('echart1');
	var barChart = echarts.init(chart);
	var option = {
		grid: {
			top: '6',
			right: '0',
			bottom: '17',
			left: '25',
		},
		xAxis: {
			data: ['2013' ,'2014', '2015', '2016', '2017', '2018', '2019'],
			axisLine: {
				lineStyle: {
					color: 'rgba(255,255,255, 0.08)'
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
					color: 'rgba(255,255,255, 0.08)'
				}
			},
			axisLine: {
				lineStyle: {
					color: 'rgba(255,255,255, 0.08)'
				}
			},
			axisLabel: {
				fontSize: 10,
				color: '#bdbdc1'
			}
		},
		series: chartdata,
		color: ['#6e00ff ', '#ff6e00', '#0091ff', ]
	};
	barChart.setOption(option);



});








