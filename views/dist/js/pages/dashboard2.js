function CreaGrafico(){

  

    var ctx = document.getElementById('salesChart').getContext('2d');
    window.myLine = Chart.Line(ctx, {
      data: lineChartData,
      options: {
        responsive: true,
        tooltips: {
					mode: 'index',
					intersect: false,
				},
        hover: {
					mode: 'nearest',
					intersect: true
				},
        stacked: false,
        title: {
          display: true,
          text: 'Reporte Anual de Siniestros por Aseguradora'
        },
        scales: {
          yAxes: [
            {
              type: 'linear', 
              display: true,
              position: 'left',
              id: 'y-axis-1',
            }, 
            {
              type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
              display: true,
              position: 'right',
              id: 'y-axis-2',
              gridLines: {
                drawOnChartArea: false, // only want the grid lines for one axis to show up
              },
            }
          ],
        }
      }
    });
  

  
}