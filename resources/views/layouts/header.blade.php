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
<a href="{{ route('ga-pdf', $site_id) }}{{ $param }}" class="pdf-btn btn btn-sm btn-outline-secondary d-inline-block ml-auto" target="_blank"><i class="fas fa-file-pdf mr-2"></i>レポートを出力</a>
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
<svg width="105" height="24" viewBox="0 0 105 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)"><path d="M20.79 12.41C17.5778 16.8312 13.6426 20.6785 9.14998 23.79C8.24998 24.4 7.72999 23.56 8.26999 22.88C11.6707 18.6256 15.5798 14.8038 19.91 11.5C20.66 11 21.26 11.74 20.79 12.41ZM16.59 8.06001C17.15 7.28001 16.64 6.49001 15.71 7.15001C15.15 7.54001 6.34998 15.37 4.70998 17.07C3.10998 15.69 1.41998 14.25 1.01998 13.93C0.891169 13.8204 0.724188 13.7662 0.555541 13.7793C0.386894 13.7924 0.230298 13.8718 0.119984 14C0.0257874 14.1159 -0.0256348 14.2607 -0.0256348 14.41C-0.0256348 14.5593 0.0257874 14.7041 0.119984 14.82C1.30342 16.4806 2.59982 18.0576 3.99998 19.54C4.16752 19.7644 4.41634 19.9141 4.69303 19.9571C4.96973 20.0001 5.25226 19.933 5.47998 19.77L5.61998 19.65C9.72396 16.236 13.4066 12.3453 16.59 8.06001ZM4.84998 11.06C7.54879 9.05877 10.0805 6.84147 12.42 4.43001C12.6239 4.22566 12.7385 3.94873 12.7385 3.66001C12.7385 3.37129 12.6239 3.09436 12.42 2.89001L12.36 2.84001C12.09 2.65001 9.46999 0.35001 9.17999 0.14001C8.57998 -0.27999 7.86999 0.31001 8.26999 1.03001C8.66998 1.75001 9.38999 2.89001 9.82998 3.58001C9.45998 3.91001 4.51998 9.50001 3.99998 10.19C3.47998 10.88 3.99998 11.71 4.87998 11.1L4.84998 11.06Z" fill="#FF6200"/><path d="M27.28 5.54999H30.15V11.31L35.42 5.54999H38.88L33.58 11.14L39.12 18.72H35.68L31.68 13.12L30.14 14.7V18.7H27.28V5.54999ZM45.87 5.45999H48.51L54.08 18.72H51.08L49.9 15.77H44.4L43.21 18.72H40.29L45.87 5.45999ZM48.87 13.21L47.15 8.93999L45.42 13.21H48.87ZM55.6 12.21C55.5881 11.3275 55.7502 10.4513 56.077 9.63141C56.4037 8.81155 56.8888 8.06408 57.5045 7.43169C58.1201 6.79931 58.8543 6.2944 59.6652 5.9458C60.476 5.59719 61.3475 5.41173 62.23 5.39999H62.42C63.3505 5.35043 64.2817 5.48478 65.1602 5.79536C66.0387 6.10593 66.8474 6.58664 67.54 7.20999L65.74 9.40999C64.8409 8.51024 63.622 8.00326 62.35 7.99999C61.3119 8.05184 60.3362 8.51185 59.6357 9.27981C58.9352 10.0478 58.5665 11.0614 58.61 12.1C58.5442 13.1379 58.8925 14.1596 59.5785 14.9412C60.2645 15.7228 61.2324 16.2006 62.27 16.27H62.55C63.5109 16.2985 64.4561 16.0219 65.25 15.48V13.63H62.37V11.13H68V16.85C66.467 18.207 64.4874 18.9512 62.44 18.94C61.5805 18.9803 60.7214 18.8509 59.9118 18.5591C59.1023 18.2673 58.3582 17.8188 57.7221 17.2393C57.086 16.6598 56.5702 15.9607 56.2044 15.1818C55.8386 14.4029 55.6298 13.5596 55.59 12.7C55.58 12.5235 55.58 12.3465 55.59 12.17L55.6 12.21ZM76.15 5.45999H78.79L84.37 18.72H81.37L80.18 15.77H74.68L73.5 18.72H70.58L76.15 5.45999ZM79.15 13.21L77.43 8.93999L75.71 13.21H79.15ZM87.3 5.54999H93.24C93.931 5.50646 94.6236 5.60269 95.2765 5.83293C95.9294 6.06316 96.5292 6.42268 97.04 6.88999C97.4157 7.29078 97.7074 7.76266 97.8981 8.27786C98.0887 8.79307 98.1744 9.34119 98.15 9.88999C98.2012 10.785 97.9568 11.6721 97.4545 12.4147C96.9522 13.1573 96.2198 13.7143 95.37 14L98.55 18.7H95.21L92.42 14.5H90.17V18.72H87.31L87.3 5.54999ZM93.07 12C94.46 12 95.26 11.25 95.26 10.14C95.26 8.89999 94.41 8.25999 93.01 8.25999H90.17V12H93.07ZM101.81 5.59999H104.67V18.72H101.81V5.59999Z" fill="white"/></g><defs><clipPath id="clip0"><path d="M0 0H104.67V24H0V0Z" fill="white"/></clipPath></defs></svg>
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
</ul>
</div>
</nav>
@endsection
