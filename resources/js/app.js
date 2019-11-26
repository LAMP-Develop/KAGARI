// fortawesome
import '../../node_modules/@fortawesome/fontawesome-free/js/all.min.js';

require('./bootstrap');
require('tablesorter');
require('xlsx');
require('file-saverjs');
require('tableexport');

$(function() {
  // テーブルソート
  let table_sort = $('#seo-report-detail table').tablesorter();

  // テーブルエクスポート
  let table_export = $('#seo-report-detail .table-responsive .table').tableExport({
    formats: ['xlsx', 'csv', 'txt'],
    bootstrap: true,
    filename: 'kagari_seo_report',
    exportButtons: false
  });
  let table_export_seo = $('#seo-detail-table').tableExport({
    formats: ['xlsx', 'csv', 'txt'],
    bootstrap: true,
    filename: 'kagari_seo_report_detail',
    exportButtons: false
  });

  // テーブルスクロール
  $('.horizontal-scroll li').on('click', function() {
    const wrap = $('#seo-report-detail .table-responsive');
    const wrap_w = wrap.outerWidth();

    $('.horizontal-scroll li').removeClass('active');
    $('.row-head th').removeClass('active');

    $(this).addClass('active');
    if ($(this).hasClass('seo')) {
      wrap.animate({
        scrollLeft: -wrap_w
      });
      $('.row-head th.seo').addClass('active');
    } else {
      wrap.animate({
        scrollLeft: wrap_w
      });
      $('.row-head th.site').addClass('active');
    }
  });

  $(document).ajaxStop(function() {
    // 時間取得
    let today = new Date();
    let year = today.getFullYear();
    let month = today.getMonth() + 1;
    let day = today.getDate();
    let hours = today.getHours();
    let minutes = today.getMinutes();
    let seconds = today.getSeconds();
    let time = year+'_'+month+'_'+day+'_'+hours+'_'+minutes+'_'+seconds;

    // テーブルソート
    table_sort.trigger('update', true);
    // テーブルエクスポート
    table_export.update({
      formats: ['xlsx', 'csv', 'txt'],
      bootstrap: true,
      filename: time,
      exportButtons: false,
    });
    table_export_seo.update({
      formats: ['xlsx', 'csv', 'txt'],
      bootstrap: true,
      filename: 'seo_'+time,
      exportButtons: false,
    });

    console.log('ajax stop');
  });
});