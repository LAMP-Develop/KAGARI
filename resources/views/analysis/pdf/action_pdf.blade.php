<?php
$ss = [];
$pv = [];
$ps = [];
$uu = [];
$time = [];
$br = [];
foreach ($ga_result_action as $key => $val) {
    $ss[] = (float)$val[0][0][1];
    $pv[] = (float)$val[0][0][2];
    $ps[] = (float)$val[0][0][3];
    $uu[] = (float)$val[0][0][4];
    $time[] = (float)$val[0][0][5];
    $br[] = (float)$val[0][0][6];
}
rsort($ss);
rsort($pv);
rsort($ps);
rsort($uu);
rsort($time);
rsort($br);
?>

@section('content_action')
<section class="reports">
<div class="container">
<div class="col-12 mb-3">
<div class="card">
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-borderless">
<thead>
<tr>
<th class="font-weight-normal align-top"></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-orange"><img src="{{ asset('/img/fa-bolt_orange_16.png') }}"></span><small class="mt-2 d-block">セッション数</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-green"><img src="{{ asset('/img/fa-eye_green_16.png') }}"></span><small class="mt-2 d-block">PV数</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-blue-2"><img src="{{ asset('/img/fa-pager_blue-2_16.png') }}"></span><small class="mt-2 d-block">ページ/<br>セッション</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-blue"><img src="{{ asset('/img/fa-user_blue_16.png') }}"></span><small class="mt-2 d-block">ユーザー数</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-red"><img src="{{ asset('/img/fa-clock_red_16.png') }}"></span><small class="mt-2 d-block">平均ページ<br>滞在時間</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-purple-2"><img src="{{ asset('/img/fa-arrow-alt-circle-left_purple-2_16.png') }}"></span><small class="mt-2 d-block">直帰率</small></th>
</tr>
</thead>
<tbody>
<?php foreach ($ga_result_action as $key => $val): ?>
<tr>
<td><span class="text-dark">{{ $val[0][0][0][0] }}</span></td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ number_format($val[0][0][1]) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-orange" style="width:{{ ($val[0][0][1]/$ss[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][1]/$ss[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ number_format($val[0][0][2]) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-green" style="width:{{ ($val[0][0][2]/$pv[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][2]/$pv[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ round($val[0][0][3], 2) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-blue-2" style="width:{{ ($val[0][0][3]/$ps[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][3]/$ps[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ number_format($val[0][0][4]) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-blue" style="width:{{ ($val[0][0][4]/$uu[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][4]/$uu[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ round($val[0][0][5], 1) }}秒</span>
<div class="progress">
<div class="progress-bar ka-bg-red" style="width:{{ ($val[0][0][5]/$time[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][5]/$time[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp }}%</span>
</p>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ round($val[0][0][6], 1) }}%</span>
<div class="progress">
<div class="progress-bar ka-bg-purple-2" style="width:{{ ($val[0][0][6]/$br[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][6]/$br[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
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
<img src="{{ asset('/img/fa-comment-dots_orange_16.png') }}" alt="">
</span>
</div>
<div class="col-11">
<h3 class="font-weight-bold h5 mt-2">ユーザー行動分析の総評</h3>
<textarea class="border-0 form-control px-0 text-secondary" name="name" rows="4">サンプルテキスト</textarea>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
