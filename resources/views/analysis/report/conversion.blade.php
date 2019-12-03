<?php
// cv数
$cv = $ga_result[1][0][1];
$old_cv = $ga_result[1][1][1];
$comp_cv = round(($cv/$old_cv-1)*100, 2);
// cv率
$cv_r = round($ga_result[1][0][2], 2);
$old_cv_r = round($ga_result[1][1][2], 2);
$comp_cv_r = round(($cv/$old_cv-1)*100, 2);
// セッション
$ss = $ga_result[1][0][0];
// 直帰
$ex = $ga_result[1][0][3];

$arr_cv = [];
$arr_cv_r = [];
$arr_uu = [];
$arr_ex = [];
$arr_ps = [];
$arr_time = [];

foreach ($ga_result[0] as $key => $val) {
    $arr_cv[] = (float)$val[0][0][1];
    $arr_cv_r[] = (float)$val[0][0][2];
    $arr_uu[] = (float)$val[0][0][3];
    $arr_ex[] = (float)$val[0][0][4];
    $arr_ps[] = (float)$val[0][0][5];
    $arr_time[] = (float)$val[0][0][6];
}
rsort($arr_cv);
rsort($arr_cv_r);
rsort($arr_uu);
rsort($arr_ex);
rsort($arr_ps);
rsort($arr_time);
?>

@section('content')
<section class="reports">
<div class="container">
<div class="row mx-0 mb-3">
<div class="col-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-orange">
<i class="fas fa-user opacity-color-orange"></i>
</span>
<h4 class="h6 text-dark mt-3">コンバージョン数</h4>
<p class="h4 font-weight-bold text-dark">{{ $cv }}</p>
<p class="m-0">
<span class="text-secondary"><i class="fas fa-arrows-alt-h mr-1"></i>{{ $old_cv }}</span>
</p>
<p class="m-0">
@if($comp_cv >= 0)
<span class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<span class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp_cv }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">Googleアナリティクスに設定された「⽬標」の達成数。</small>
</div>
</div>
</div>
<div class="col-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-purple">
<i class="far fa-flag opacity-color-purple"></i>
</span>
<h4 class="h6 text-dark mt-3">コンバージョン率</h4>
<p class="h4 font-weight-bold text-dark">{{ $cv_r }}<small class="ml-1">%</small></p>
<p class="m-0">
<span class="text-secondary"><i class="fas fa-arrows-alt-h mr-1"></i>{{ $old_cv_r }}</span>
</p>
<p class="m-0">
@if($comp_cv_r >= 0)
<span class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<span class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp_cv_r }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">コンバージョンに達成したセッション数の割合。</small>
</div>
</div>
</div>
<div class="col-6">
<div class="card">
<div class="card-body">
<p class="overflow-hidden opacity-bg-blue opacity-color-blue m-0 p-3 rounded-lg">
<span class="float-left line-height">セッション数</span>
<span class="float-right font-weight-bold h5 line-height m-0">{{ number_format($ss) }}</span>
</p>
<p class="text-right my-2 text-dark"><i class="fas fa-long-arrow-alt-down mr-2"></i>{{ round(100 - $ex, 2) }}%</p>
<p class="overflow-hidden opacity-bg-blue opacity-color-blue m-0 p-3 rounded-lg">
<span class="float-left line-height">サイト内閲覧数</span>
<span class="float-right font-weight-bold h5 line-height m-0">{{ number_format(round($ss * (100 - $ex) / 100, 0)) }}</span>
</p>
<p class="text-right my-2 text-dark"><i class="fas fa-long-arrow-alt-down mr-2"></i>{{ round($cv / round($ss * (100 - $ex) / 100, 0) * 100, 2) }}%</p>
<p class="overflow-hidden opacity-bg-blue opacity-color-blue m-0 p-3 rounded-lg">
<span class="float-left line-height">コンバージョン数</span>
<span class="float-right font-weight-bold h5 line-height m-0">{{ $cv }}</span>
</p>
</div>
</div>
</div>
</div>

<div class="col-12 mb-3">
<div class="card">
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-borderless">
<thead>
<tr>
<th class="font-weight-normal align-top"></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-orange"><i class="fas fa-bolt opacity-color-orange"></i></span><small class="mt-2 d-block">コンバージョン<br>数</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-purple"><i class="fas fa-eye opacity-color-purple"></i></span><small class="mt-2 d-block">コンバージョン<br>率</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-blue"><i class="fas fa-pager opacity-color-blue"></i></span><small class="mt-2 d-block">ユーザー数</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-purple-2"><i class="fas fa-user opacity-color-purple-2"></i></span><small class="mt-2 d-block">直帰率</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-blue-2"><i class="far fa-clock opacity-color-blue-2"></i></span><small class="mt-2 d-block">ページ/<br>セッション</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-red"><i class="fas fa-arrow-alt-circle-left opacity-color-red"></i></span><small class="mt-2 d-block">平均<br>セッション時間</small></th>
</tr>
</thead>
<tbody>
<?php foreach ($ga_result[0] as $key => $val): ?>
<tr>
<td><span class="text-dark">{{ $val[0][0][0][0] }}</span></td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ number_format($val[0][0][1]) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-orange" style="width:{{ ($val[0][0][1]/$arr_cv[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][1]/$arr_cv[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p class="text-right">
@php
if ($val[1][0][1] != 0) {
$comp = round(($val[0][0][1] / $val[1][0][1] - 1) * 100, 2);
} else {
$comp = 0;
}
@endphp
@if($comp >= 0)
<span class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<span class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ round($val[0][0][2], 2) }}%</span>
<div class="progress">
<div class="progress-bar ka-bg-purple" style="width:{{ ($val[0][0][2]/$arr_cv_r[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][2]/$arr_cv_r[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p class="text-right">
@php
if ($val[1][0][2] != 0) {
$comp = round(($val[0][0][2] / $val[1][0][2] - 1) * 100, 2);
} else {
$comp = 0;
}
@endphp
@if($comp >= 0)
<span class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<span class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ number_format($val[0][0][3]) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-blue" style="width:{{ ($val[0][0][3]/$arr_uu[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][3]/$arr_uu[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p class="text-right">
@php
if ($val[1][0][3] != 0) {
$comp = round(($val[0][0][3] / $val[1][0][3] - 1) * 100, 2);
} else {
$comp = 0;
}
@endphp
@if($comp >= 0)
<span class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<span class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ round($val[0][0][4], 2) }}%</span>
<div class="progress">
<div class="progress-bar ka-bg-purple-2" style="width:{{ ($val[0][0][4]/$arr_ex[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][4]/$arr_ex[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p class="text-right">
@php
if ($val[1][0][4] != 0) {
$comp = round(($val[0][0][4] / $val[1][0][4] - 1) * 100, 2);
} else {
$comp = 0;
}
@endphp
@if($comp >= 0)
<span class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<span class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ round($val[0][0][5], 2) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-blue-2" style="width:{{ ($val[0][0][5]/$arr_ps[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][5]/$arr_ps[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p class="text-right">
@php
if ($val[1][0][5] != 0) {
$comp = round(($val[0][0][5] / $val[1][0][5] - 1) * 100, 2);
} else {
$comp = 0;
}
@endphp
@if($comp >= 0)
<span class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<span class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ round($val[0][0][6], 1) }}秒</span>
<div class="progress">
<div class="progress-bar ka-bg-red" style="width:{{ ($val[0][0][6]/$arr_time[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][6]/$arr_time[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<p class="text-right">
@php
if ($val[1][0][6] != 0) {
$comp = round(($val[0][0][6] / $val[1][0][6] - 1) * 100, 2);
} else {
$comp = 0;
}
@endphp
@if($comp >= 0)
<span class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<span class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp }}%</span>
</p>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<div class="col-12">
<div id="comment" class="card">
<div class="card-body">
<div class="row">
<div class="col-1 text-center">
<span class="opacity-item opacity-bg-orange">
<i class="fas fa-comment-dots opacity-color-orange"></i>
</span>
</div>
<div class="col-11">
<h3 class="font-weight-bold h5 mt-2">コンバージョン分析の総評</h3>
<textarea class="border-0 form-control px-0 text-secondary" name="name" rows="4">サンプルテキスト</textarea>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection