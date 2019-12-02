@php
// ユーザー数
$new_user_data = $ga_result[0][0]['New Visitor'][0];
$re_user_data = $ga_result[0][0]['Returning Visitor'][0];
$new_users = round($new_user_data / ($new_user_data + $re_user_data) * 100, 2);
$re_users = round($re_user_data / ($new_user_data + $re_user_data) * 100, 2);

// 男女比
$female = $ga_result[0][2]['female'][0];
$male = $ga_result[0][2]['male'][0];
$female_str = round($female / ($female + $male) * 100, 2);
$male_str = round($male / ($female + $male) * 100, 2);

// デバイス
$mobile = $ga_result[0][1]['mobile'][0];
$desktop = $ga_result[0][1]['desktop'][0];
$tablet = $ga_result[0][1]['tablet'][0];
$mobile_str = round($mobile / ($mobile + $desktop + $tablet) * 100, 2);
$desktop_str = round($desktop / ($mobile + $desktop + $tablet) * 100, 2);
$tablet_str = round($tablet / ($mobile + $desktop + $tablet) * 100, 2);

// 年齢
$age = $ga_result[1][2];

// 国
$country = $ga_result[1][0];

// 地域
$area = $ga_result[1][1];

@endphp

@section('content')
<section class="reports">
<div class="container">
<div class="row mx-0 mb-4">
<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-red">
<i class="fas fa-user-plus opacity-color-red"></i>
</span>
<h4 class="h6 text-dark mt-2">新規ユーザー</h4>
<div class="text-center my-4">
<canvas class="m-auto" id="doughnut-chart-1" width="150" height="150"></canvas>
</div>
<div class="row mx-0">
<div class="col text-center">
<p class="opacity-color-red-2 m-0"><i class="fas fa-user-plus h3"></i></p>
<p class="mb-1">新規ユーザー</p>
<p class="m-0 h4 font-weight-bold text-dark">{{ $new_users }}<small class="ml-1 h6">%</small></p>
</div>
<div class="col text-center">
<p class="opacity-color-red m-0"><i class="fas fa-user h3"></i></p>
<p class="mb-1">既存ユーザー</p>
<p class="m-0 h4 font-weight-bold text-dark">{{ $re_users }}<small class="ml-1 h6">%</small></p>
</div>
</div>
</div>
</div>
</div>
<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-orange">
<i class="fas fa-venus-mars opacity-color-orange"></i>
</span>
<h4 class="h6 text-dark mt-2">性別</h4>
<div class="text-center my-4">
<canvas class="m-auto" id="doughnut-chart-2" width="150" height="150"></canvas>
</div>
<div class="row mx-0">
<div class="col text-center">
<p class="opacity-color-blue m-0"><i class="fas fa-male h3"></i></p>
<p class="mb-1">男性</p>
<p class="m-0 h4 font-weight-bold text-dark">{{ $male_str }}<small class="ml-1 h6">%</small></p>
</div>
<div class="col text-center">
<p class="opacity-color-red-2 m-0"><i class="fas fa-female h3"></i></p>
<p class="mb-1">女性</p>
<p class="m-0 h4 font-weight-bold text-dark">{{ $female_str }}<small class="ml-1 h6">%</small></p>
</div>
</div>
</div>
</div>
</div>
<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-blue">
<i class="fas fa-mobile-alt opacity-color-blue"></i>
</span>
<h4 class="h6 text-dark mt-2">デバイス</h4>
<div class="text-center my-4">
<canvas class="m-auto" id="doughnut-chart-3" width="150" height="150"></canvas>
</div>
<div class="row mx-0">
<div class="col text-center">
<p class="m-0"><i class="fas fa-mobile-alt h3" style="color:#007AFF"></i></p>
<p class="mb-1"><small>モバイル</small></p>
<p class="m-0 h5 font-weight-bold text-dark">{{ $mobile_str }}<small class="ml-1 h6">%</small></p>
</div>
<div class="col text-center">
<p class="m-0"><i class="fas fa-desktop h3" style="color:#007AFF99"></i></p>
<p class="mb-1"><small>PC</small></p>
<p class="m-0 h5 font-weight-bold text-dark">{{ $desktop_str }}<small class="ml-1 h6">%</small></p>
</div>
<div class="col text-center">
<p class="m-0"><i class="fas fa-tablet-alt h3" style="color:#007AFF66"></i></p>
<p class="mb-1"><small>タブレット</small></p>
<p class="m-0 h5 font-weight-bold text-dark">{{ $tablet_str }}<small class="ml-1 h6">%</small></p>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="row mx-0 mb-4">

<div class="col-4">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-blue">
<i class="fas fa-user opacity-color-blue"></i>
</span>
<h4 class="h6 text-dark mt-2">年齢</h4>
@foreach ($age as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress mb-3">
@if ($key == 0)
<div class="progress-bar ka-bg-blue" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-blue" style="width:{{ ($value[1]/$age[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$age[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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
<i class="fas fa-globe-asia opacity-color-purple-2"></i>
</span>
<h4 class="h6 text-dark mt-2">国</h4>
@foreach ($country as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress mb-3">
@if ($key == 0)
<div class="progress-bar ka-bg-purple-2" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-purple-2" style="width:{{ ($value[1]/$country[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$country[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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
<i class="fas fa-map-marker-alt opacity-color-purple"></i>
</span>
<h4 class="h6 text-dark mt-2">地域</h4>
@foreach ($area as $key => $value)
<p class="mb-0 overflow-hidden"><span class="float-left">{{ $value[0] }}</span><span class="float-right font-weight-bold h5 text-dark">{{ number_format($value[1]) }}</span></p>
<div class="progress mb-3">
@if ($key == 0)
<div class="progress-bar ka-bg-purple" style="width:100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
@else
<div class="progress-bar ka-bg-purple" style="width:{{ ($value[1]/$area[0][1]*100) }}%" role="progressbar" aria-valuenow="{{ ($value[1]/$area[0][1]*100) }}" aria-valuemin="0" aria-valuemax="100"></div>
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

<script>
  let ctx = $('#doughnut-chart-1');
  var userData = [{{ $new_user_data }}, {{ $re_user_data }}];
  let myChart1 = new Chart(ctx, {
    type: 'doughnut',
    animation: true,
    data: {
      labels: [
        '新規ユーザー', '既存ユーザー'
      ],
      datasets: [
        {
          data: userData,
          backgroundColor: ['rgba(255, 59, 48, 1)', 'rgba(255, 59, 48, 0.6)']
        }
      ]
    },
    options: {
      legend: {
        display: false
      },
      responsive: false,
      cutoutPercentage: 85
    }
  });

  let ctx2 = $('#doughnut-chart-2');
  var userData = [{{ $male_str }}, {{ $female_str }}];
  let myChart2 = new Chart(ctx2, {
    type: 'doughnut',
    animation: true,
    data: {
      labels: [
        '男性', '女性'
      ],
      datasets: [
        {
          data: userData,
          backgroundColor: ['#007AFF', '#FF2D55']
        }
      ]
    },
    options: {
      legend: {
        display: false
      },
      responsive: false,
      cutoutPercentage: 85
    }
  });

  let ctx3 = $('#doughnut-chart-3');
  var userData = [{{ $mobile }}, {{ $desktop }}, {{ $tablet }}];
  let myChart3 = new Chart(ctx3, {
    type: 'doughnut',
    animation: true,
    data: {
      labels: [
        "モバイル", "PC", "タブレット"
      ],
      datasets: [
        {
          data: userData,
          backgroundColor: ['#007AFF', '#007AFF99', '#007AFF66']
        }
      ]
    },
    options: {
      legend: {
        display: false
      },
      responsive: false,
      cutoutPercentage: 85
    }
  });
</script>
@endsection