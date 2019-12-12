<?php
// 流入チャネル
$channel = $ga_result_inflow[0];
// sns
$sns = $ga_result_inflow[1];
// リファラル
$link = $ga_result_inflow[2];
?>

@section('content_inflow')
<section class="reports">
<div class="container">
<div class="row mx-0 mb-3">

<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-blue">
<img src="{{ asset('/img/fa-project-diagram_blue_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">流入チャネル</h4>
@foreach ($channel as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress">
@if ($key == 0)
<div class="progress-bar ka-bg-blue" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-blue" style="width:{{ ($value[1]/$channel[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$channel[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
@endif
</div>
<p class="mb-3 text-right">
@php
if ($channel[$key][2] != 0) {
$comp = round(($value[1] / (int)$channel[$key][2] - 1) * 100, 2);
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
@endforeach
</div>
</div>
</div>

<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-purple-2">
<img src="{{ asset('/img/fa-retweet_purple-2_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">SNSからの流入</h4>
@foreach ($sns as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress">
@if ($key == 0)
<div class="progress-bar ka-bg-purple-2" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-purple-2" style="width:{{ ($value[1]/$sns[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$sns[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
@endif
</div>
<p class="mb-3 text-right">
@php
if ($sns[$key][2] != 0) {
$comp = round(($value[1] / (int)$sns[$key][2] - 1) * 100, 2);
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
@endforeach
</div>
</div>
</div>

<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-purple">
<img src="{{ asset('/img/fa-link_purple_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">他サイトからのリンク</h4>
@foreach ($link as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress">
@if ($key == 0)
<div class="progress-bar ka-bg-purple" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-purple" style="width:{{ ($value[1]/$link[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$link[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
@endif
</div>
<p class="mb-3 text-right">
@php
if ($link[$key][2] != 0) {
$comp = round(($value[1] / (int)$link[$key][2] - 1) * 100, 2);
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
@endforeach
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
<h3 class="font-weight-bold h5 mt-2">流入元分析の総評</h3>
<textarea class="border-0 form-control px-0 text-secondary" name="name" rows="4">サンプルテキスト</textarea>
</div>
</div>
</div>
</div>
</div>

</div>
</section>
@endsection
