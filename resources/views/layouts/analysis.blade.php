@php
$url_array = [];
@endphp

@section('content')
<section id="seo-report" class="wrap">
<div class="container">
<header class="seo-nav">
<!-- エクスポートと期間選択 -->
<div class="row justify-content-between align-items-end mx-0">
<form class="col-10 p-0" method="get">
<div class="form-row align-items-end m-0">
<div class="col-3 pl-0">
<label for="start"><i class="far fa-calendar-alt mr-1"></i>開始日</label>
<input id="start" type="date" name="start" class="form-control form-control-sm" value="{{ $start }}" min="2005-01-01">
</div>
<div class="col-3">
<label for="end"><i class="far fa-calendar-alt mr-1"></i>終了日</label>
<input id="end" type="date" name="end" class="form-control form-control-sm" value="{{ $end }}" max="{{ $today }}">
</div>
<div class="col-2">
<button type="submit" class="btn btn-primary btn-sm">期間で絞り込む</button>
</div>
</div>
</form>
<div class="col-2 p-0 text-right">
<div class="dropdown">
<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="export" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">エクスポート</button>
<div class="dropdown-menu" aria-labelledby="export">
<button tableexport-id="2280ca-xlsx" class="dropdown-item text-muted" type="button"><i class="fas fa-file-excel mr-1"></i>Excel</button>
<button tableexport-id="3a8efbb5-csv" class="dropdown-item text-muted" type="button"><i class="fas fa-file-csv mr-1"></i>CSV</button>
<button tableexport-id="399d2dcb-txt" class="dropdown-item text-muted" type="button"><i class="fas fa-file-alt mr-1"></i>TXT</button>
</div>
</div>
</div>
</div>
<!-- スクロールとハイライト -->
<div class="row justify-content-between align-items-end mt-3 mx-0">
<div class="col-3 p-0">
<label>分析</label>
<ul class="horizontal-scroll">
<li class="active seo"><i class="fas fa-search mr-1"></i>SEO</li>
<li class="site"><i class="fas fa-chart-bar mr-1"></i>サイト</li>
</ul>
</div>
<div class="col p-0 text-right">
<div class="custom-control custom-switch">
<input type="checkbox" class="custom-control-input" id="customSwitch1">
<label class="custom-control-label" for="customSwitch1">課題ハイライト</label>
</div>
</div>
</div>
</header>
<!-- 解析テーブル -->
<section id="seo-report-detail" class="mt-4">
<div class="table-responsive">
<table class="table table-bordered table-hover table-fixed">
<thead>
<tr class="row-head">
<th colspan="2" class="sort-none"></th>
<th colspan="5" class="sort-none active seo">SEO分析</th>
<th colspan="7" class="sort-none site">サイト分析</th>
</tr>
<tr class="column-head">
<th class="No">No.</th>
<th class="page-name">ページタイトル</th>
<th class="keyword-seo">最も多くヒットした<br>検索キーワード</th>
<th>検索結果で<br>クリックされた数</th>
<th>検索結果の<br>表示回数</th>
<th>検索結果で<br>クリックされた率</th>
<th>検索結果の<br>平均順位</th>
<th>セッション数</th>
<th>PV数</th>
<th>ページ/<br>セッション</th>
<th>訪問ユーザー数</th>
<th>平均ページ<br>滞在時間</th>
<th>直帰率</th>
<th>目標達成数</th>
</tr>
</thead>
<tbody>
@foreach ($ga as $key => $val)
@php
$num = $key+1;
if (preg_match("/\/$/", $url)) {
    $url = substr($url, 0, -1);
}

$no = ($this_page*100-100)+$num;
$page_name = $val[0];
$page_url = $url.$val[1];
$ss = number_format($val[2]);
$pv = number_format($val[3]);
$ps = round($val[4], 2);
$u = number_format($val[5]);
$time = round($val[6], 0);
$br = round($val[7], 2);
$value = $val[8];
$cv = $val[9];
$load = $val[10];
if (isset($sc[$page_url])) {
    $click = number_format($sc[$page_url]['clicks']);
    $ctr = $sc[$page_url]['ctr'];
    $impressions = number_format($sc[$page_url]['impressions']);
    $position = $sc[$page_url]['position'];
} else {
    $click = '0';
    $ctr = '0';
    $impressions = '0';
    $position = '-';
}

array_push($url_array, $page_url);

@endphp
<tr content-url="{{ $page_url }}" content-name="{{ $page_name }}">
<td class="No">{{ $no }}</td>
<td class="page-name" data-toggle="modal" data-target="#seo-detail">{{ $page_name }}</td>
<!-- seo -->
<td id="kyes-{{ $num }}" class="keyword-seo" data-toggle="modal" data-target="#seo-detail"></td>
<td class="unit-kai">{{ $click }}</td>
<td class="unit-kai">{{ $impressions }}</td>
<td class="unit-par">{{ $ctr }}</td>
<td class="unit-rank">{{ $position }}</td>
<!-- ga -->
<td>{{ $ss }}</td>
<td>{{ $pv }}</td>
<td>{{ $ps }}</td>
<td class="unit-nin">{{ $u }}</td>
<td class="unit-seconds">{{ $time }}</td>
<td class="unit-par">{{ $br }}</td>
<td class="unit-kai">{{ $cv }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</section>

<!-- ページネーション -->
<form class="mt-3 pagenavi" method="get">
@for ($i = 1; $i <= $all_pages; $i++)
@if ($i == $this_page)
<button class="active btn btn-primary btn-sm" type="submit" name="page" disabled>{{ $i }}</button>
@else
<button class="btn btn-outline-primary btn-sm" type="submit" name="page" value="{{ $i }}">{{ $i }}</button>
@endif
@endfor

<!-- 期間設定 -->
@if (isset($_GET['start']))
@php
$start = $_GET['start'];
$end = $_GET['end'];
@endphp
<input type="hidden" name="start" value="{{ $start }}">
<input type="hidden" name="end" value="{{ $end }}">
@endif
</form>

</div>
</section>

<!-- モーダル -->
<div id="seo-detail" class="modal" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">
「<span></span>」
<a class="h6 d-block" href="#" target="_blank">
<small>
<i class="fas fa-link mr-1"></i>
<span></span>
</small>
</a>
</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<div class="table-responsive">
<table id="seo-detail-table" class="table table-bordered table-hover table-fixed">
<thead>
<tr>
<th class="No">No</th>
<th class="keyword-seo">検索キーワード</th>
<th>検索結果で<br>クリックされた数</th>
<th>検索結果の<br>表示回数</th>
<th>検索結果で<br>クリックされた率</th>
<th>検索結果の<br>平均順位</th>
</tr>
</thead>
<tbody id="seo-detail-tbody">
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>

@php
$urls_json = json_encode($url_array, JSON_UNESCAPED_UNICODE);
@endphp

<input id="site_overview"
  type="hidden"
  site-id="{{ $site_id }}"
  data-url="{{ $url }}"
  start="{{ $start }}"
  end="{{ $end }}"
  site-id="{{ $site_id }}"
  view-id="{{ $view_id }}">

<input id="get_seo_kyes"
  type="hidden"
  name="get_seo_kyes"
  action="{{ action('AjaxController@get_seo_kyes', $site_id) }}"
  value="{{ $urls_json }}">

<input id="get_seo_detail"
  type="hidden"
  name="get_seo_detail"
  action="{{ action('AjaxController@get_seo_detail', $site_id) }}">
@endsection