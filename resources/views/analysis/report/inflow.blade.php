<?php
// 流入チャネル
$channel = $ga_result[0];
// sns
$sns = $ga_result[1];
// リファラル
$link = $ga_result[2];
?>

@section('content')
<section class="reports">
<div class="container">
<div class="row mx-0 mb-4">

<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-blue">
<i class="fas fa-project-diagram opacity-color-blue"></i>
</span>
<h4 class="h6 text-dark mt-2">流入チャネル</h4>
@foreach ($channel as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress mb-3">
@if ($key == 0)
<div class="progress-bar ka-bg-blue" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-blue" style="width:{{ ($value[1]/$channel[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$channel[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
@endif
</div>
@endforeach
</div>
</div>
</div>

<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-purple-2">
<i class="fas fa-retweet opacity-color-purple-2"></i>
</span>
<h4 class="h6 text-dark mt-2">SNSからの流入</h4>
@foreach ($sns as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress mb-3">
@if ($key == 0)
<div class="progress-bar ka-bg-purple-2" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-purple-2" style="width:{{ ($value[1]/$sns[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$sns[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
@endif
</div>
@endforeach
</div>
</div>
</div>

<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-purple">
<i class="fas fa-link opacity-color-purple"></i>
</span>
<h4 class="h6 text-dark mt-2">他サイトからのリンク</h4>
@foreach ($link as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress mb-3">
@if ($key == 0)
<div class="progress-bar ka-bg-purple" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-purple" style="width:{{ ($value[1]/$link[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$link[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
@endif
</div>
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

</div>
</section>
@endsection