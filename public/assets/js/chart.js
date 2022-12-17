$(document).ready(function() {
  class QuoteChart {
    constructor() {
      this.init(this.readData());
    }

    init(data) {
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

    readData() {
      const $rows = document.querySelectorAll('tr.price-data');
      const data = [];
      for (const $row of $rows) {
        data.unshift({
            date: $($row).data('date'),
            open: $($row).data('open'),
            close: $($row).data('close'),
          });
        console.log($row);
      }

      return data;
    }
  }

  chart = new QuoteChart();
})
