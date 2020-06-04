function draw(label,data) {

	// console.log(getListData(list_data));
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
						window.chartColors.grey
					],
					label: 'Dataset 1'
				}],
				labels:label
			},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

}
