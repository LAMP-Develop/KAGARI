require('@fortawesome/fontawesome-free/js/all.js');
require('./bootstrap');
require('bootstrap-datepicker');
require('tablesorter');
require('xlsx');
require('file-saverjs');
require('tableexport');

$(function() {
  // サイト追加
  const $searchElem = $('.accounts');
  const excludedClass = 'is-excluded';
  let $searchInput = $('#ga-search');

  function extraction() {
    var keywordArr = $searchInput.val().toLowerCase().replace('　', ' ').split(' ');
    $searchElem.removeClass(excludedClass).show();
    for (var i = 0; i < keywordArr.length; i++) {
      for (var j = 0; j < $searchElem.length; j++) {
        var thisString = $searchElem.eq(j).text().toLowerCase();
        if (thisString.indexOf(keywordArr[i]) == -1) {
          $searchElem.eq(j).addClass(excludedClass);
        }
      }
    }
    $('.' + excludedClass).hide();
  }
  $searchInput.on('load keyup blur', function() {
    extraction();
  });
  $('.accounts').on('click', function() {
    $(this).children('.fas');
  });
  $('[data-toggle="modal"]').on('click', function() {
    let account_name = $(this).attr('data-name');
    let property_name = $(this).attr('data-property');
    let view_id = $(this).attr('data-id');
    let data_url = $(this).attr('data-url');
    $('#addsite-form-label').text(account_name);
    $('#site-name').val(property_name);
    $('#view-id').val(view_id);
    $('#site-url').val(data_url);
  });

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

  // 課題ハイライト
  // $('#highlight').on('click', function() {
  //   if ($(this).hasClass('active')) {
  //     $(this).removeClass('active')
  //     $('.highlight').removeClass('on');
  //   } else {
  //     $(this).addClass('active')
  //     $('.highlight').addClass('on');
  //   }
  // });
  // $('[data-name="click"].highlight').attr('data-content', 'クリック数に課題があります。<br><a href="https://seo.kagari.ai/blog/clicks/" target="_blank">改善方法をみる</a>');
  // $('[data-name="impressions"].highlight').attr('data-content', '表示回数に課題があります。<br><a href="https://seo.kagari.ai/blog/impressions/" target="_blank">改善方法をみる</a>');
  // $('[data-name="ctr"].highlight').attr('data-content', 'CTRに課題があります。<br><a href="https://seo.kagari.ai/blog/ctr/" target="_blank">改善方法をみる</a>');
  // $('[data-name="position"].highlight').attr('data-content', '掲載順位に課題があります。<br><a href="https://seo.kagari.ai/blog/position/" target="_blank">改善方法をみる</a>');
  // $('[data-name="ps"].highlight').attr('data-content', 'ページ/セッションに課題があります。<br><a href="https://seo.kagari.ai/blog/sessions/" target="_blank">改善方法をみる</a>');
  // $('[data-name="time"].highlight').attr('data-content', '平均ページ滞在時間に課題があります。<br><a href="https://seo.kagari.ai/blog/page-stay-time/" target="_blank">改善方法をみる</a>');
  // $('[data-name="br"].highlight').attr('data-content', '直帰率に課題があります。<br><a href="https://seo.kagari.ai/blog/bounce-rate/" target="_blank">改善方法をみる</a>');
  // $('.highlight').popover({
  //   html: true,
  //   trigger: 'manual'
  // }).on('mouseenter', function() {
  //   if ($(this).hasClass('on')) {
  //     var _this = this;
  //     $(this).popover('show');
  //     $('.popover').on('mouseleave', function() {
  //       $(_this).popover('hide');
  //     });
  //   }
  // }).on('mouseleave', function() {
  //   var _this = this;
  //   setTimeout(function() {
  //     if (!$('.popover:hover').length) {
  //       $(_this).popover('hide')
  //     }
  //   }, 100);
  // });

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
    let time = year + '_' + month + '_' + day + '_' + hours + '_' + minutes + '_' + seconds;

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
      filename: 'seo_' + time,
      exportButtons: false,
    });
  });

  // datepicker
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    language: 'ja'
  });
});