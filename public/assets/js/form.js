$(document).ready(function () {
  //Date picker
  const $startDate = $('#historical_quotes_search_startDate');
  const $endDate = $('#historical_quotes_search_endDate');

  function createStartDateDatapicker() {
    $startDate.datepicker({
      'format': 'yyyy-mm-dd',
      'autoclose': true,
      'endDate': $endDate.val(),
    });
  }

  function createEndDateDatapicker() {
    $endDate.datepicker({
      'format': 'yyyy-mm-dd',
      'autoclose': true,
      'startDate': $startDate.val(),
      'endDate': new Date(),
    });
  }

  createStartDateDatapicker();
  createEndDateDatapicker();

  $startDate.datepicker().on('changeDate', function (e) {
    $endDate.datepicker('destroy');
    createEndDateDatapicker();
  });

  $endDate.datepicker().on('changeDate', function (e) {
    $startDate.datepicker('destroy');
    createStartDateDatapicker();
  })

  //Symbol validation
  const $companySymbol = $('#historical_quotes_search_companySymbol');
  $companySymbol.blur(function (event) {
    let symbol = $companySymbol.val();
    const errorBlock = `<div class="invalid-feedback d-block">${symbol} is not valid company symbol</div>`;

    if ($companySymbol.siblings('.invalid-feedback')) {
      $companySymbol.siblings('.invalid-feedback').remove();
    }

    if ($companySymbol.val().trim() === '') {
      return;
    }

    $.get('/validation/validate/' + symbol, function (data) {
      if (!data.isValid) {
        $(errorBlock).insertAfter($companySymbol);
      }
    })
  });
})
