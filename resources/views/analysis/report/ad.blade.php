<?php
// 広告費用
$cost = $ga_result[0][0][0];
if ($cost == 0) {
    $bool = false;
} else {
    $bool = true;
}
if ($bool) {
    $click = $ga_result[0][0][1];
    $cv = $ga_result[0][0][2];
    $price = round($cost/$click, 1);

    $old_cost = $ga_result[0][1][0];
    $old_click = $ga_result[0][1][1];
    $old_cv = $ga_result[0][1][2];
    $old_price = round($old_cost/$old_click, 1);

    $comp_price = round(($price / $old_price - 1) * 100, 2);
    $comp_click = round(($click / $old_click - 1) * 100, 2);
    $comp_cost = round(($cost / $old_cost - 1) * 100, 2);
    $comp_cv = round(($cv / $old_cv - 1) * 100, 2);

    $arr_click = [];
    $arr_cost = [];
    $arr_price = [];
    $arr_cv = [];
    $arr_cv_r = [];
    foreach ($ga_result[1] as $key => $val) {
        $arr_click[] = $val[0][0][1];
        $arr_cost[] = $val[0][0][2];
        $arr_price[] = $val[0][0][3];
        $arr_cv[] = $val[0][0][4];
        $arr_cv_r[] = $val[0][0][5];
    }
    rsort($arr_click);
    rsort($arr_cost);
    rsort($arr_price);
    rsort($arr_cv);
    rsort($arr_cv_r);
}
?>

@section('content')
<section class="reports">
<div class="container">
@if($bool)
<div class="row mx-0 mb-4">
<div class="col">
<div class="card">
<div class="card-body">
<div class="row mx-0 align-items-center">
<div class="col-6 text-center">
<span class="opacity-item opacity-bg-blue">
<i class="fas fa-yen-sign opacity-color-blue"></i>
</span>
<h4 class="h6 text-dark mt-4">広告費用</h4>
<p class="h4 font-weight-bold text-dark"><i class="fas fa-yen-sign mr-1"></i>{{ number_format(round($cost, 0)) }}</p>
<p class="m-0"><small class="text-secondary"><i class="fas fa-arrows-alt-h mr-1"></i>{{ number_format(round($old_cost, 0)) }}</small></p>
</div>
<div class="col-1">
<p class="m-0"><i class="fas fa-equals opacity-color-blue"></i></p>
</div>
<div class="col-5">
<p class="overflow-hidden opacity-bg-blue m-0 p-3 rounded-lg text-center text-dark">
<span>クリック単価</span>
<span class="d-block h4 font-weight-bold text-dark"><i class="fas fa-yen-sign mr-1"></i>{{ $price }}</span>
<span class="d-block">
@if($comp_price <= 0)
<small class="opacity-color-green"><i class="fas fa-caret-down mr-1"></i>
@else
<small class="opacity-color-red"><i class="fas fa-caret-up mr-1"></i>
@endif
{{ $comp_price }}%</small>
</span>
</p>
<p class="my-2 opacity-color-blue text-center"><i class="fas fa-times"></i></p>
<p class="overflow-hidden opacity-bg-blue m-0 p-3 rounded-lg text-center text-dark">
<span>クリック数</span>
<span class="d-block h4 font-weight-bold text-dark">{{ number_format($click) }}</span>
<span class="d-block">
@if($comp_click >= 0)
<small class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<small class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp_click }}%</small>
</span>
</p>
</div>
</div>
<hr>
<small class="d-block text-left text-secondary">期間内で消化された広告費⽤。</small>
</div>
</div>
</div>

<div class="col">
<div class="card">
<div class="card-body">
<div class="row mx-0 align-items-center">
<div class="col-6 text-center">
<span class="opacity-item opacity-bg-purple">
<i class="fas fa-yen-sign opacity-color-purple"></i>
</span>
<h4 class="h6 text-dark mt-4">コンバージョン単価</h4>
<p class="h4 font-weight-bold text-dark"><i class="fas fa-yen-sign mr-1"></i>{{ number_format(round($cost/$cv, 0)) }}</p>
<p class="m-0"><small class="text-secondary"><i class="fas fa-arrows-alt-h mr-1"></i>{{ number_format(round($old_cost/$old_cv, 0)) }}</small></p>
</div>
<div class="col-1">
<p class="m-0"><i class="fas fa-equals opacity-color-purple"></i></p>
</div>
<div class="col-5">
<p class="overflow-hidden opacity-bg-purple m-0 p-3 rounded-lg text-center text-dark">
<span>コンバージョン数</span>
<span class="d-block h4 font-weight-bold text-dark">{{ $cv }}</span>
<span class="d-block">
@if($comp_cv >= 0)
<small class="opacity-color-green"><i class="fas fa-caret-up mr-1"></i>
@else
<small class="opacity-color-red"><i class="fas fa-caret-down mr-1"></i>
@endif
{{ $comp_cv }}%</small>
</span>
</p>
<p class="my-2 opacity-color-purple text-center"><i class="fas fa-times"></i></p>
<p class="overflow-hidden opacity-bg-purple m-0 p-3 rounded-lg text-center text-dark">
<span>広告費用</span>
<span class="d-block h4 font-weight-bold text-dark"><i class="fas fa-yen-sign mr-1"></i>{{ number_format($cost) }}</span>
<span class="d-block">
@if($comp_cost <= 0)
<small class="opacity-color-green"><i class="fas fa-caret-down mr-1"></i>
@else
<small class="opacity-color-red"><i class="fas fa-caret-up mr-1"></i>
@endif
{{ $comp_cost }}%</small>
</span>
</p>
</div>
</div>
<hr>
<small class="d-block text-left text-secondary">コンバージョン数1に対する広告費⽤。</small>
</div>
</div>
</div>

</div>

<div class="col-12 mb-4">
<div class="card">
<div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-borderless">
<thead>
<tr>
<th class="font-weight-normal align-top"></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-blue"><i class="fas fa-mouse-pointer opacity-color-blue"></i></span><small class="mt-2 d-block">クリック数</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-purple-2"><i class="fas fa-yen-sign opacity-color-purple-2"></i></span><small class="mt-2 d-block">費用</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-blue-2"><i class="fas fa-yen-sign opacity-color-blue-2"></i></span><small class="mt-2 d-block">クリック単価</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-orange"><i class="fas fa-flag opacity-color-orange"></i></span><small class="mt-2 d-block">コンバージョン数</small></th>
<th class="font-weight-normal text-center align-top"><span class="opacity-item opacity-bg-purple"><i class="far fa-flag opacity-color-purple"></i></span><small class="mt-2 d-block">コンバージョン率</small></th>
</tr>
</thead>
<tbody>
<?php foreach ($ga_result[1] as $key => $val): ?>
<tr>
<td><small class="text-dark font-weight-bold">{{ $val[0][0][0][0] }}</small></td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ number_format($val[0][0][1]) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-blue" style="width:{{ ($val[0][0][1]/$arr_click[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][1]/$arr_click[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold"><i class="fas fa-yen-sign mr-1"></i>{{ number_format(round($val[0][0][2], 2)) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-purple-2" style="width:{{ ($val[0][0][2]/$arr_cost[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][2]/$arr_cost[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold"><i class="fas fa-yen-sign mr-1"></i>{{ number_format($val[0][0][3]) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-blue-2" style="width:{{ ($val[0][0][3]/$arr_price[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][3]/$arr_price[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ number_format($val[0][0][4]) }}</span>
<div class="progress">
<div class="progress-bar ka-bg-orange" style="width:{{ ($val[0][0][4]/$arr_cv[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][4]/$arr_cv[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</td>
<td class="text-right">
<span class="text-dark font-weight-bold">{{ round($val[0][0][5], 2) }}%</span>
<div class="progress">
<div class="progress-bar ka-bg-purple" style="width:{{ ($val[0][0][5]/$arr_cv_r[0]*100) }}%" role="progressbar" aria-valuenow="{{ ($val[0][0][5]/$arr_cv_r[0]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
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
<h3 class="font-weight-bold h5 mt-2">見出し</h3>
<textarea class="border-0 form-control px-0 text-secondary" name="name" rows="4">サンプルテキスト</textarea>
</div>
</div>
</div>
</div>
</div>
@else
<div class="col-12">
  <div class="alert alert-warning">
    <p class="m-0">Google広告と連携されていないか、広告設定が正しくありません。</p>
  </div>
</div>
@endif
</div>
</section>
@endsection