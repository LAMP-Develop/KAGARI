<?php
  $pic_url = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?screenshot=true&strategy=desktop&url=".$url;
  $json = file_get_contents($pic_url);
  $data = json_decode( $json, true );
  $screenshot = $data['screenshot']['data'];
  $screenshot = str_replace( '_', '/', $screenshot );
  $screenshot = str_replace( '-', '+', $screenshot );
?>

@section('content_top')
<section class="top_page">
<div class="container">
<h1 class="text-black font-weight-bold">アクセス解析レポート</h1>
<h2 class="py-4 font-weight-bold">ANARYTICS REPORT</h2>
<img src="data:image/png;base64,<?php echo $screenshot; ?>">
<!-- <ul class="list-unstyled">
<li>期間<span>@php echo $start; @endphp 〜 @php echo $end; @endphp</span></li>
<li class="py-4">サイト名<span>@php echo $site_name; @endphp</span></li>
<li>URL<span>@php echo $url; @endphp</span></li>
</ul> -->
<table class="table table-borderless">
<tbody>
<tr>
<th scope="row">期間</th>
<td>@php echo $start; @endphp 〜 @php echo $end; @endphp</td>
</tr>
<tr>
<th scope="row">サイト名</th>
<td>@php echo $site_name; @endphp</td>
</tr>
<tr>
<th scope="row">URL</th>
<td>@php echo $url; @endphp</td>
</tr>
</table>
</div>
</section>
@endsection
