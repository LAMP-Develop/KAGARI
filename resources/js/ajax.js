$(function() {
  // 変数定義
  const csrf = $('meta[name="csrf-token"]').attr('content');
  const url = $('#site_overview').attr('data-url');
  const start = $('#site_overview').attr('start');
  const end = $('#site_overview').attr('end');
  const site_id = $('#site_overview').attr('site-id');
  const view_id = $('#site_overview').attr('view-id');
  const content_urls = $('#get_seo_kyes').val().replace('[', '').replace(']', '').split(',');
  let number = 0;

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': csrf
    }
  });

  // ページごとのキーワード取得
  $.each(content_urls, function(n, value) {
    $.ajax({
      url: $('#get_seo_kyes').attr('action'),
      type: 'post',
      datatype: 'json',
      data: {
        content_url: value,
        url: url,
        start: start,
        end: end,
      }
    }).done(function(data) {
      number = n + 1;
      $('#kyes-'+number).text(data);
    });
  });

  // 個別ページのSEOデータ取得
  $('[data-target="#seo-detail"]').on('click', function() {
    const content_url = $(this).parent('tr').attr('content-url');
    const content_name = $(this).parent('tr').attr('content-name');
    const action = $('#get_seo_detail').attr('action');
    let number = 0;
    let body = $('#seo-detail-tbody');
    body.html('');
    body.append('<tr><td class="load"><i class="fas fa-spinner mr-1"></i>取得中</td><td></td><td></td><td></td><td></td><td></td></tr>');
    $('#seo-detail .modal-title>span').html(content_name);
    $('#seo-detail .modal-title>a>small>span').html(content_url);
    $('#seo-detail .modal-title>a').attr('href', content_url);
    $.ajax({
      type: 'post',
      datatype: 'json',
      url: '/seo-detail/' + site_id,
      data: {
        url: url,
        content_url: content_url,
        start: start,
        end: end
      }
    }).done(function(data) {
      if (data.length != 0) {
        body.html('');
        $.each(data, function(n, value) {
          let keywords = value['keys'][0];
          let clicks = value['clicks'];
          let display = value['impressions'];
          let rate = roundFloat(value['ctr'] * 100, 2);
          let rank = roundFloat(value['position'], 2);
          body.append('<tr><td class="No">' + (n + 1) + '</td><td class="keyword-seo">' + keywords + '</td><td class="unit-kai">' + clicks + '</td><td class="unit-kai">' + display + '</td><td class="unit-par">' + rate + '</td><td class="unit-rank">' + rank + '</td></tr>');
        });
      } else {
        body.append('<tr><td>データがありませんでした。</td><td></td><td></td><td></td><td></td><td></td></tr>');
      }
    }).fail(function(data) {
      console.log('SC-DETAIL-Error：' + data);
    });
  });
});

// 少数点切り上げ
function roundFloat(number, n) {
  var _pow = Math.pow(10, n);
  return Math.round(number * _pow) / _pow;
}