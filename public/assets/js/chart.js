function createChart (data) {
  const myChart = new Chart("acquisitions", {
    type: 'line',
    data: {
      labels: data.map(row => row.date),
      datasets: [
        {
          label: 'Open prices',
          data: data.map(row => row.open)
        },
        {
          label: 'Close prices',
          data: data.map(row => row.close)
        }
      ]
    }
  });
}
