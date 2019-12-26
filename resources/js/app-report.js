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
    if ($(this).attr('id') == 'start') {
      let com_end = $('#com_end').val();
      let start = $(this).val();
      if (com_end >= start) {
        console.log(start, com_end);
        target.innerHTML = '期間の範囲指定が正しくありません';
      } else {
        target.innerHTML = '';
      }
    }
    if ($(this).attr('id') == 'com_end') {
      let start = $('#start').val();
      let com_end = $(this).val();
      if (com_end >= start) {
        console.log(start, com_end);
        target.innerHTML = '期間の範囲指定が正しくありません';
      } else {
        target.innerHTML = '';
      }
    }
  });
});