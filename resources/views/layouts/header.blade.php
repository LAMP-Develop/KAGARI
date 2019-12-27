@php
$req = $_SERVER['REQUEST_URI'];
@endphp

@section('header')
<nav class="position-relative navbar navbar-expand-md navbar-light bg-white border-bottom px-5">
<h1 class="head-ttl m-0 font-weight-bold h5">@yield('title')</h1>
@if(strpos($_SERVER['REQUEST_URI'], 'report'))
@php
$param = strstr($_SERVER["REQUEST_URI"], '?');
if (!$param) {
    $param = '';
}
@endphp
<a href="{{ route('send-setting', $site_id) }}" class="pdf-btn btn btn-sm btn-outline-secondary d-inline-block ml-auto mr-2" target="_blank">レポート受信設定</a>
<a href="{{ route('ga-pdf', $site_id) }}{{ $param }}" class="pdf-btn btn btn-sm btn-outline-secondary d-inline-block" target="_blank"><i class="fas fa-file-pdf mr-2"></i>レポートを出力</a>
@elseif (strpos($_SERVER['REQUEST_URI'], 'seo'))
<div class="dropdown d-inline-block ml-auto">
<button class="pdf-btn btn btn-sm btn-outline-secondary dropdown-toggle load" type="button" id="export" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-spinner mr-1"></i>エクスポート</button>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="export">
<button tableexport-id="2280ca-xlsx" class="dropdown-item text-muted" type="button"><i class="fas fa-file-excel mr-1"></i>Excel</button>
<button tableexport-id="3a8efbb5-csv" class="dropdown-item text-muted" type="button"><i class="fas fa-file-csv mr-1"></i>CSV</button>
<button tableexport-id="399d2dcb-txt" class="dropdown-item text-muted" type="button"><i class="fas fa-file-alt mr-1"></i>TXT</button>
</div>
</div>
@endif
<input class="l-drawer__checkbox" id="drawerCheckbox" type="checkbox">
<!-- ドロワーアイコン -->
<label class="l-drawer__icon" for="drawerCheckbox">
<span class="l-drawer__icon-parts"></span>
<span class="l-drawer__icon-txt">MENU</span>
@if (strpos($req, 'report') != false && isset($plan))
<img src="{{ asset('/img/kagari-report.svg') }}" alt="{{ setting('site.title') }}" width="170">
@elseif (strpos($req, 'seo') != false && isset($plan) && $plan%2 == 0)
<img src="{{ asset('/img/kagari-seo.svg') }}" alt="{{ setting('site.title') }}" width="140">
@else
<img src="{{ asset('/img/kagari.svg') }}" alt="{{ setting('site.title') }}" width="108">
@endif
</label>
<!-- 背景を暗く -->
<label class="l-drawer__overlay" for="drawerCheckbox"></label>
<!-- ドロワーメニュー -->
<div class="l-drawer__menu">
<ul>
<li class="l-drawer__item mb-4">
<a class="l-drawer__item-inner" href="{{ route('dashboard') }}">
<img src="{{ asset('/img/logo_white.svg') }}" alt="{{ setting('site.title') }}" width="108">
</a>
</li>

@if (isset($plan))
@if (strpos($req, 'report') != false || strpos($req, 'seo') != false)
<li class="l-drawer__item l-drawer__app mb-2">
<a class="l-drawer__item-inner text-white text-center active" href="{{ route('ga-report', $site_id) }}">
@if (strpos($req, 'report') != false)
<i class="fas fa-caret-right mr-2"></i>
@endif
レポートを作成する
</a>
</li>
@if ($plan%2 == 0)
<li class="l-drawer__item l-drawer__app">
<a class="l-drawer__item-inner text-white text-center active" href="{{ route('seo-report', $site_id) }}">
@if (strpos($req, 'seo') != false)
<i class="fas fa-caret-right mr-2"></i>
@endif
SEO分析する
</a>
</li>
@endif
<li class="l-drawer__item"><hr></li>
@endif
@endif

@guest
@if (Route::has('register'))
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-white" href="{{ route('register') }}">{{ __('Register') }}</a>
</li>
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-white" href="{{ route('login') }}">
<span><i class="fas fa-sign-in-alt"></i></span>ログイン
</a>
</li>
@endif
@endguest
@auth
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-white" href="{{ route('dashboard') }}">
<span><i class="fas fa-home"></i></span>登録サイト一覧
</a>
</li>
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-white" href="{{ route('account') }}">
<span><i class="fas fa-user"></i></span>アカウント情報
</a>
</li>
<li class="l-drawer__item"><hr></li>
@endauth
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-white" href="https://seo.kagari.ai/news/" target="_blank">
<span><i class="fas fa-bell"></i></span>お知らせ
</a>
</li>
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-white" href="https://seo.kagari.ai/blog/" target="_blank">
<span><i class="fas fa-book-open"></i></span>マニュアル
</a>
</li>
<li class="l-drawer__item"><hr></li>
<li class="l-drawer__item contact">
<a class="l-drawer__item-inner text-white" href="https://kagari.ai/contact/" target="_blank">お問い合わせ</a>
</li>
@auth
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
</li>
@endauth
<li class="l-drawer__item">
<a class="l-drawer__item-inner" href="https://marketing.kagari.ai" target="_blank">
<img class="img-fluid" src="{{ asset('img/banner_marketing.png') }}" alt="KAGARI Marketing">
</a>
</li>
</ul>
</div>
</nav>
@endsection
