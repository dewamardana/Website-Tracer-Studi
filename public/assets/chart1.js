var options = {
    series: [{
    data: [400]
  }],
    chart: {
    type: 'bar',
    height: 350
  },
  plotOptions: {
    bar: {
      borderRadius: 4,
      borderRadiusApplication: 'end',
      horizontal: true,
    }
  },
  dataLabels: {
    enabled: false
  },
  xaxis: {
    categories: ['aji'],
  }
  };

  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();