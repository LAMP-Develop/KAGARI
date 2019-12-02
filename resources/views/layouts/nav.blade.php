@section('nav')
<section class="mb-4">
<div class="container">
<div class="col-12">
<div class="card">
<div class="card-body pb-0">
<div class="row mx-0 mb-4">
<div class="col">
<h2 class="font-weight-bold h5 text-dark">{{ $site_name }}</h2>
<p class="m-0">{{ $site_url }}</p>
</div>
</div>

<ul class="nav nav-tabs report-nav">
<li class="nav-item">
<a class="nav-link @php if(Route::current()->getName() == 'ga-report') echo 'active'; @endphp" href="{{ route('ga-report', $site_id) }}"><i class="far fa-calendar-alt mr-1"></i>サマリー</a>
</li>
<li class="nav-item">
<a class="nav-link @php if(Route::current()->getName() == 'ga-user') echo 'active'; @endphp" href="{{ route('ga-user', $site_id) }}"><i class="fas fa-users mr-1"></i>ユーザー属性</a>
</li>
<li class="nav-item">
<a class="nav-link @php if(Route::current()->getName() == 'ga-inflow') echo 'active'; @endphp" href="{{ route('ga-inflow', $site_id) }}"><i class="fas fa-project-diagram mr-1"></i>流入元分析</a>
</li>
<li class="nav-item">
<a class="nav-link @php if(Route::current()->getName() == 'ga-action') echo 'active'; @endphp" href="{{ route('ga-action', $site_id) }}"><i class="fas fa-pager mr-1"></i>ユーザー行動分析</a>
</li>
<li class="nav-item">
<a class="nav-link @php if(Route::current()->getName() == 'ga-conversion') echo 'active'; @endphp" href="{{ route('ga-conversion', $site_id) }}"><i class="fas fa-flag mr-1"></i>コンバージョン分析</a>
</li>
<li class="nav-item">
<a class="nav-link @php if(Route::current()->getName() == 'ga-ad') echo 'active'; @endphp" href="{{ route('ga-ad', $site_id) }}"><i class="fas fa-ad mr-1"></i>広告分析</a>
</li>
</ul>

</div>
</div>
</div>
</div>
</section>
@endsection