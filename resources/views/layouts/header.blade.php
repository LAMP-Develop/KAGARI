@php
$req = $_SERVER['REQUEST_URI'];
@endphp

@section('header')
<nav class="position-relative navbar navbar-expand-md navbar-light bg-white border-bottom px-5">
@if (strpos($req, 'report') != false)
<div class="dropdown switch-drop rounded-lg">
<span class="dropdown-toggle" id="switch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img src="{{ asset('/img/kagari-report.svg') }}" alt="{{ setting('site.title') }}" width="170">
</span>
<div class="dropdown-menu" aria-labelledby="switch">
<a class="dropdown-item" href="{{ route('seo-report', $site_id) }}">
<img src="{{ asset('/img/kagari-seo.svg') }}" alt="{{ setting('site.title') }}" width="120">
<small class="d-block line-hegiht-1 mt-1 text-center">SEOを分析する</small>
</a>
</div>
</div>
@elseif (strpos($req, 'seo') != false)
<div class="dropdown switch-drop rounded-lg">
<span class="dropdown-toggle" id="switch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<img src="{{ asset('/img/kagari-seo.svg') }}" alt="{{ setting('site.title') }}" width="140">
</span>
<div class="dropdown-menu" aria-labelledby="switch">
<a class="dropdown-item" href="{{ route('ga-report', $site_id) }}">
<img src="{{ asset('/img/kagari-report.svg') }}" alt="{{ setting('site.title') }}" width="120">
<small class="d-block line-hegiht-1 mt-1 text-center">レポートを作成</small>
</a>
</div>
</div>
@else
<a class="navbar-brand" href="{{ url('/dashboard') }}">
<img src="{{ asset('/img/kagari.svg') }}" alt="{{ setting('site.title') }}" width="108">
</a>
@endif
<h1 class="head-ttl m-0 font-weight-bold h5">@yield('title')</h1>
@if(strpos($_SERVER['REQUEST_URI'], 'report'))
<?php
$param = strstr($_SERVER["REQUEST_URI"], '?');
if (!$param) {
$param = '';
}
?>
<a href="{{ route('ga-pdf', $site_id) }}{{ $param }}" class="pdf-btn btn btn-sm btn-outline-secondary d-inline-block ml-auto" style="margin-right:5rem" target="_blank"><i class="fas fa-file-pdf mr-2"></i>PDFでレポート出力</a>
@endif
<input class="l-drawer__checkbox" id="drawerCheckbox" type="checkbox">
<!-- ドロワーアイコン -->
<label class="l-drawer__icon" for="drawerCheckbox">
<span class="l-drawer__icon-parts"></span>
<span class="l-drawer__icon-txt">MENU</span>
</label>
<!-- 背景を暗く -->
<label class="l-drawer__overlay" for="drawerCheckbox"></label>
<!-- ドロワーメニュー -->
<div class="l-drawer__menu">
<ul>
@guest
@if (Route::has('register'))
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="{{ route('register') }}">{{ __('Register') }}</a>
</li>
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="{{ route('login') }}"><i class="fas fa-sign-in-alt mr-3"></i>ログイン</a>
</li>
@endif
@endguest
@auth
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="{{ route('dashboard') }}"><i class="fas fa-list-ul mr-3"></i>登録サイト一覧</a>
</li>
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="{{ route('account') }}"><i class="fas fa-user mr-3"></i>アカウント情報</a>
</li>
<li class="l-drawer__item"><hr></li>
@endauth
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="https://seo.kagari.ai/news/" target="_blank"><i class="fas fa-bell mr-3"></i>お知らせ</a>
</li>
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="https://seo.kagari.ai/blog/" target="_blank"><i class="fas fa-book-open mr-3"></i>マニュアル</a>
</li>
<li class="l-drawer__item"><hr></li>
<li class="l-drawer__item contact">
<a class="l-drawer__item-inner text-muted" href="https://kagari.ai/contact/" target="_blank">お問い合わせ</a>
</li>
@auth
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
</li>
@endauth
</ul>
</div>
</nav>
@endsection
