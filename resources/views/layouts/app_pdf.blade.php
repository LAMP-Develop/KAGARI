<!DOCTYPE html>
<html lang="ja">
<head>
@yield('head')
<meta name="viewport" content="width=1140">
@stack('style')
<style media="screen">
  body {
    margin: 0 auto;
    width: 1140px !important;
  }
  .container {
    width: 1080px !important;
    max-width: 1080px !important;
    min-width: 1080px !important;
  }
</style>
@stack('scripts')
<script src="{{ asset('/js/html2canvas.min.js') }}"></script>
<style media="screen">
  #target2 .nav-item .ac_sumally{
    color: #007aff;
    border-bottom: solid 3px #007aff;
  }
  #target3 .nav-item .ac_user{
    color: #007aff;
    border-bottom: solid 3px #007aff;
  }
  #target4 .nav-item .ac_inflow{
    color: #007aff;
    border-bottom: solid 3px #007aff;
  }
  #target5 .nav-item .ac_action{
    color: #007aff;
    border-bottom: solid 3px #007aff;
  }
  #target6 .nav-item .ac_conv{
    color: #007aff;
    border-bottom: solid 3px #007aff;
  }
  #target7 .nav-item .ac_ad{
    color: #007aff;
    border-bottom: solid 3px #007aff;
  }
</style>
</head>
<body class="drawer drawer--right">
@yield('header')
<a onclick="downloadImage()">画面キャプチャPDFのダウンロード</a>
<!-- <img src="" id="result" /> -->
<main id="target" class="py-5">
<div id="target1">
@yield('content_top')
</div>
<div id="target2">
@yield('nav_pdf')
@yield('content_sumally')
</div>
<div id="target3">
@yield('nav_pdf')
@yield('content_users')
</div>
<div id="target4" >
@yield('nav_pdf')
@yield('content_inflow')
</div>
<div id="target5" >
@yield('nav_pdf')
@yield('content_action')
</div>
<div id="target6" >
@yield('nav_pdf')
@yield('content_conversion')
</div>
<div id="target7" >
@yield('nav_pdf')
@yield('content_ad')
</div>
</main>
@yield('footer')
@stack('scripts-vue')

<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>

  <script>

    // ロードされた際の処理として実施：

    function downloadImage(){
      var pdf = new jsPDF('p', 'pt', 'letter');
      for (var j = 1; j <= 7; j++) {
        // PDF出力するIDを指定
        var getId = "target" + j;
        // PDF出力の機能呼び出し
        toCanvas(pdf, getId, j);
      }
    }

    function toCanvas(pdf, getId, j) {
      html2canvas(document.getElementById(getId))
      .then(function(canvas) {
        if (j > 1) {
          // ２ページ目以降を随時追加
          pdf.addPage();
        }
        // ページにデータをセット
        pdf.setPage(j);
        var imgData = canvas.toDataURL();
        // 横幅をぴったり合わせるため横幅を取得して指定
        var width = pdf.internal.pageSize.width;
        // 第４引数でページの余白を指定
        pdf.addImage(canvas, 'JPEG', 0, 20, width, 0);
        if (j == 7) {
          // PDF出力
          pdf.save('kagari_report.pdf');
        }
      });
    }

  </script>
</body>
</html>
