@php
// 現在のデータ
$users = $ga_result_data['sumally'][0][2];
$session = $ga_result_data['sumally'][0][0];
$pv = $ga_result_data['sumally'][0][6];
$ps = $ga_result_data['sumally'][0][1];
$session_time = $ga_result_data['sumally'][0][5];
$page_time = $ga_result_data['sumally'][0][3];
$exit_rate = $ga_result_data['sumally'][0][4];
$bounce_rate = $ga_result_data['sumally'][0][7];
$users_str = number_format($users);
$session_str = number_format($session);
$pv_str = number_format($pv);
$ps_str = round($ps, 2);
$session_time_str = round($session_time, 2);
$page_time_str = round($page_time, 2);
$exit_rate_str = round($exit_rate, 2);
$bounce_rate_str = round($bounce_rate, 2);
// 過去のデータ
$old_users = $ga_result_data['sumally'][1][2];
$old_session = $ga_result_data['sumally'][1][0];
$old_pv = $ga_result_data['sumally'][1][6];
$old_ps = $ga_result_data['sumally'][1][1];
$old_session_time = $ga_result_data['sumally'][ 1][5];
$old_page_time = $ga_result_data['sumally'][1][3];
$old_exit_rate = $ga_result_data['sumally'][1][4];
$old_bounce_rate = $ga_result_data['sumally'][1][7];
$old_users_str = number_format($old_users);
$old_session_str = number_format($old_session);
$old_pv_str = number_format($old_pv);
$old_ps_str = round($old_ps, 2);
$old_session_time_str = round($old_session_time, 2);
$old_page_time_str = round($old_page_time, 2);
$old_exit_rate_str = round($old_exit_rate, 2);
$old_bounce_rate_str = round($old_bounce_rate, 2);
// 比較のデータ
$comp_users = $ga_result_data['comp'][2];
$comp_session = $ga_result_data['comp'][0];
$comp_pv = $ga_result_data['comp'][6];
$comp_ps = $ga_result_data['comp'][1];
$comp_session_time = $ga_result_data['comp'][5];
$comp_page_time = $ga_result_data['comp'][3];
$comp_exit_rate = $ga_result_data['comp'][4];
$comp_bounce_rate = $ga_result_data['comp'][7];
@endphp
@section('content_sumally')
<section class="reports">
<div class="container">
<div class="col-12">
<div class="card mb-3">
<div class="card-body">
<div class="row align-items-center">
<div class="col-3 text-center">
<span class="opacity-item opacity-bg-blue">
<img src="{{asset('/img/fa-user_blue_16.png')}}" alt="fa-user">
</span>
<h3 class="text-dark font-weight-bold h6 mt-3">ユーザー</h3>
<p class="m-0">
<small><img class="mr-1" src="{{ asset('/img/fa-calendar-alt-h_red_11.png') }}" alt="fa-calendar">{{ $start }} ~ {{ $end }}</small>
</p>
<p class="m-0">
<small><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_red_11.png')}}" alt="fa-arrows">{{ $com_start }} ~ {{ $com_end }}</small>
</p>
</div>
<div class="col-9">
<canvas id="user-chart" class="line-chart" width="900" height="200"></canvas>
</div>
</div>
</div>
</div>
</div>

<div class="row mx-0 mb-3">
<div class="col-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-blue">
<img src="{{asset('/img/fa-user_blue_16.png')}}" alt="fa-user">
</span>
<h4 class="h6 text-dark mt-3">ユーザー</h4>
<p class="h4 font-weight-bold text-dark">{{ $users_str }}</p>
<p class="m-0">
<span class="text-secondary"><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_text-secondary_14.png')}}" alt="fa-arrows">
{{ $old_users_str }}</span>
</p>
<p class="m-0">
@if($comp_users >= 0)
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp_users }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">期間中に１回以上のセッションを開始したユーザー数。</small>
</div>
</div>
</div>
<div class="col-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-orange">
<img src="{{ asset('/img/fa-bolt_orange_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">セッション</h4>
<p class="h4 font-weight-bold text-dark">{{ $session_str }}</p>
<p class="m-0">
<span class="text-secondary"><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_text-secondary_14.png')}}" alt="fa-arrows">
{{ $old_session_str }}</span>
</p>
<p class="m-0">
@if($comp_session >= 0)
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp_session }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">ユーザーがサイトを訪問した回数。</small>
</div>
</div>
</div>
<div class="col-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-green">
<img src="{{ asset('/img/fa-eye_green_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">ページビュー数</h4>
<p class="h4 font-weight-bold text-dark">{{ $pv_str }}</p>
<p class="m-0">
<span class="text-secondary"><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_text-secondary_14.png')}}" alt="fa-arrows">
{{ $old_pv_str }}</span>
</p>
<p class="m-0">
@if($comp_pv >= 0)
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp_pv }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">ウェブサイト内の特定のページが開かれた回数。</small>
</div>
</div>
</div>
<div class="col-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-blue-2">
<img src="{{ asset('/img/fa-pager_blue-2_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">ページ/セッション</h4>
<p class="h4 font-weight-bold text-dark">{{ $ps_str }}</p>
<p class="m-0">
<span class="text-secondary"><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_text-secondary_14.png')}}" alt="fa-arrows">
{{ $old_ps_str }}</span>
</p>
<p class="m-0">
@if($comp_ps >= 0)
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp_ps }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">1セッション中に閲覧されたページビュー数の平均。</small>
</div>
</div>
</div>
<div class="col-3 mt-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-red-2">
<img src="{{ asset('/img/fa-clock_red-2_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">平均セッション時間</h4>
<p class="h4 font-weight-bold text-dark">{{ $session_time_str }}<small class="ml-1 h6">秒</small></p>
<p class="m-0">
<span class="text-secondary"><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_text-secondary_14.png')}}" alt="fa-arrows">
{{ $old_session_time_str }}</span>
</p>
<p class="m-0">
@if($comp_session_time >= 0)
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp_session_time }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">ユーザーの1回のサイト訪問における滞在時間の平均。</small>
</div>
</div>
</div>
<div class="col-3 mt-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-red">
<img src="{{ asset('/img/fa-clock_red_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">平均ページ滞在時間</h4>
<p class="h4 font-weight-bold text-dark">{{ $page_time_str }}<small class="ml-1 h6">秒</small></p>
<p class="m-0">
<span class="text-secondary"><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_text-secondary_14.png')}}" alt="fa-arrows">
{{ $old_page_time_str }}</span>
</p>
<p class="m-0">
@if($comp_page_time >= 0)
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp_page_time }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">1ページあたりのユーザーの滞在時間。</small>
</div>
</div>
</div>
<div class="col-3 mt-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-purple-2">
<img src="{{ asset('/img/fa-arrow-alt-circle-left_purple-2_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">直帰率</h4>
<p class="h4 font-weight-bold text-dark">{{ $exit_rate_str }}<small class="ml-1 h6">%</small></p>
<p class="m-0">
<span class="text-secondary"><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_text-secondary_14.png')}}" alt="fa-arrows">
{{ $old_exit_rate_str }}</span>
</p>
<p class="m-0">
@if($comp_exit_rate <= 0)
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp_exit_rate }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">1ページあたりのユーザーの滞在時間。</small>
</div>
</div>
</div>
<div class="col-3 mt-3">
<div class="card">
<div class="card-body text-center">
<span class="opacity-item opacity-bg-purple">
<img src="{{ asset('/img/fa-times-circle_purple_16.png') }}" alt="">
</span>
<h4 class="h6 text-dark mt-3">離脱率</h4>
<p class="h4 font-weight-bold text-dark">{{ $bounce_rate_str }}<small class="ml-1 h6">%</small></p>
<p class="m-0">
<span class="text-secondary"><img class="mr-1" src="{{asset('/img/fa-arrows-alt-h_text-secondary_14.png')}}" alt="fa-arrows">
{{ $old_bounce_rate_str }}</span>
</p>
<p class="m-0">
@if($comp_bounce_rate <= 0)
<span class="opacity-color-green"><span class="mr-1">↑</span>
@else
<span class="opacity-color-red"><span class="mr-1">↓</span>
@endif
{{ $comp_bounce_rate }}%</span>
</p>
<hr>
<small class="d-block text-left text-secondary">すべてのページで、そのページが最後の閲覧ページになった割合。</small>
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
<h3 class="font-weight-bold h5 mt-2">解析結果の総評</h3>
<p id="comment_sumally">
@if (($comp_users+$comp_session+$comp_pv) > 0)
・アクセス状況は上昇傾向にあります。
<br>
@else
・アクセス状況は下降傾向にあります。
<br>
@endif
@if ($comp_session_time+$comp_page_time < 0)
・ユーザーの滞在時間が下降傾向にあるのでユーザーが求めると配信コンテンツがマッチしていない可能性があります。
<br>
@endif
@if ($comp_exit_rate+$comp_bounce_rate < 0)
・ユーザーの直帰率・離脱率が下降傾向にありユーザーがコンテンツに満足し始めいていると言えます。
@else
・ユーザーの直帰率・離脱率が上昇傾向にありユーザーがコンテンツに満足していない可能性があります。
@endif
</p>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<script>
  let ctx = $('#user-chart');
  let originUser = @json($ga_result_data['transition']['original'], JSON_PRETTY_PRINT);
  let compareUser = @json($ga_result_data['transition']['compare'], JSON_PRETTY_PRINT);
  let arrayLabel = [];
  let arrayLabel2 = [];
  let arrayDataOne = [];
  let arrayDataTwo = [];
  for (var key in originUser) {
    arrayLabel.push(key);
    arrayDataOne.push(originUser[key]);
  }
  for (var key in compareUser) {
    arrayLabel2.push(key);
    arrayDataTwo.push(compareUser[key]);
  }
  let myChart = new Chart(ctx, {
    type: 'line',
    animation: false,
    data: {
      labels: arrayLabel,
      datasets: [
        {
          label: '今期間',
          borderColor: '#007AFF',
          borderWidth: 2,
          backgroundColor: 'rgba(0,122,255,.05)',
          pointBackgroundColor: '#007AFF',
          pointRadius: 2,
          pointBorderWidth: 0,
          data: arrayDataOne
        }, {
          label: '前期間',
          borderColor: '#FF2D55',
          borderWidth: 2,
          backgroundColor: 'rgba(0, 0, 0, 0)',
          pointBackgroundColor: '#FF2D55',
          pointRadius: 2,
          pointBorderWidth: 0,
          data: arrayDataTwo
        }
      ]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        xAxes: [
          {
            scaleLabel: {
              fontColor: '#EDEDED'
            },
            gridLines: {
              display: false
            },
            ticks: {
              display: false
            }
          }
        ],
        yAxes: [
          {
            scaleLabel: {
              fontColor: '#EDEDED'
            },
            gridLines: {},
            ticks: {
              suggestedMin: 0,
              autoSkip: true
            }
          }
        ]
      }
    }
  });
</script>
@endsection
