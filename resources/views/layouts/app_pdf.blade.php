<!DOCTYPE html>
<html lang="ja">
<head>
@yield('head')
<meta name="viewport" content="width=1140">
@stack('style')
@stack('scripts')
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
  #target>div {
    max-height: 1612px;
    min-height: 1612px;
    height: 1612px;
    background-color: #fff;
    margin-bottom: 60px;
  }
  .spinner {
    z-index: 999;
    position: fixed;
    top: 0;
    left:0 ;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.3);
  }
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
<div class="spinner">
<div class="spinner-grow text-primary" role="status">
<span class="sr-only">Loading...</span>
</div>
</div>
<!-- <a onclick="downloadImage()">画面キャプチャPDFのダウンロード</a> -->
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
<script src="{{ asset('/js/html2canvas.min.js') }}"></script>
<script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
<script>
$(window).on('load', function() {
  setTimeout(function(){
     downloadImage();
  },5000);
  setTimeout(function(){
     $('.spinner').css('display', 'none');
  },5500);
});
function downloadImage(){
  var pdf = new jsPDF('p', 'pt', 'letter');
  for (var j = 1; j <= 7; j++) {
    var getId = "target" + j;
    toCanvas(pdf, getId, j);
  }
}
function toCanvas(pdf, getId, j) {
  html2canvas(document.getElementById(getId))
  .then(function(canvas) {
    if (j > 1) {
      pdf.addPage();
    }
    pdf.setPage(j);
    var imgData = canvas.toDataURL();
    var width = pdf.internal.pageSize.width;
    pdf.addImage(canvas, 'JPEG', 0, 20, width, 0);
    if (j == 7) {
      pdf.save('kagari_report.pdf');
    }
  });
}
</script>
</body>
</html>