// Trends Chart
var trendsOptions = {
  series: [
    {
      name: "Birth",
      data: [31, 40, 28, 51, 42, 109, 100],
    },
    {
      name: "Marriage",
      data: [11, 32, 45, 32, 34, 52, 41],
    },
    {
      name: "Death",
      data: [15, 11, 32, 18, 9, 24, 11],
    },
  ],
  chart: {
    height: 350,
    type: "area",
    toolbar: {
      show: false,
    },
  },
  colors: ["#4CAF50", "#E91E63", "#78909C"],
  fill: {
    type: "gradient",
    gradient: {
      shadeIntensity: 1,
      inverseColors: false,
      opacityFrom: 0.45,
      opacityTo: 0.05,
      stops: [20, 100, 100, 100],
    },
  },
  stroke: {
    curve: "smooth",
    width: 2,
  },
  xaxis: {
    categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
  },
  tooltip: {
    shared: true,
  },
};

var trendsChart = new ApexCharts(
  document.querySelector("#trendsChart"),
  trendsOptions
);
trendsChart.render();

// Distribution Chart
var distributionOptions = {
  series: [44, 55, 13],
  chart: {
    type: "donut",
    height: 350,
  },
  labels: ["Birth", "Marriage", "Death"],
  colors: ["#4CAF50", "#E91E63", "#78909C"],
  legend: {
    position: "bottom",
  },
  responsive: [
    {
      breakpoint: 480,
      options: {
        chart: {
          width: 200,
        },
        legend: {
          position: "bottom",
        },
      },
    },
  ],
};

var distributionChart = new ApexCharts(
  document.querySelector("#distributionChart"),
  distributionOptions
);
distributionChart.render();
