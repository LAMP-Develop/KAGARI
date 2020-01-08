require('chart.js');

$(function() {
  // datepicker
  $('.datepicker, .input-daterange').datepicker({
    autoclose: true,
    format: 'yyyy-mm-dd',
    language: 'ja',
    endDate: '-1d',
  }).on('changeDate', function(e) {
    let target = document.getElementById("check_range");
    let change_btn = document.getElementById("data_change_btn");
    // if ($(this).attr('id') == 'start') {
      let com_end = $('#com_end').val();
      let start = $(this).val();
      let end = $('#end').val();
      let com_start = $('#com_start').val();
      if (start <= com_end
        || start >= end
        || com_start >= com_end
        || com_start >= end) {
        console.log(start, end, com_start, com_end);
        target.innerHTML = '期間の範囲指定が正しくありません';
        change_btn.disabled = "disabled";
      } else {
        target.innerHTML = '';
        change_btn.disabled = "";
      }
    // }
  });
});
