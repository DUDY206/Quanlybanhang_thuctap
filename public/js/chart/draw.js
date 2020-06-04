function draw(label,list_data) {
	var list = [];
	function getListData(list_data){
			;
			list_data.forEach((item, i) => {
				var c = [window.chartColors.red, window.chartColors.orange, window.chartColors.blue, window.chartColors.green, window.chartColors.yellow, window.chartColors.purple, window.chartColors.indigo, window.chartColors.grey][i];
				var x = {
					label: item[0],
					backgroundColor:c,
					borderColor: c,
					data: item[1],
					fill: false,
				}
				list.push(x);
			});
			return list;
	}
	// console.log(getListData(list_data));
   var config = {
			type: 'line',
			data: {
				labels: label,
				datasets: getListData(list_data),
			},

			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Thống kê theo tiền thu'
				},
            tooltips: {
               callbacks: {
                   label: function(tooltipItem, data) {
                       return data.datasets[tooltipItem.datasetIndex].label+': '+tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                   },
               },

            },
				scales: {
					yAxes: [{
						ticks: {
                     callback: function(value, index, values) {
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");;
                    }
						}
					}]
				}
			}
		};


			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);


}

function DrawChartPie(lable,data){
	window.chartColors['rose'] = "rgb(247, 202, 201)";
	window.chartColors['serenity'] = "rgb(146, 168, 209)";

	var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: data,
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
						window.chartColors.blue,
						window.chartColors.indigo,
						window.chartColors.purple,
						window.chartColors.rose,
						window.chartColors.serenity,

					],
					label: 'Dataset 1'
				}],
				labels: lable
			},
			options: {
				responsive: true,
				
			}
		};


			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);

}
