@section('header')
<nav class="position-relative navbar navbar-expand-md navbar-light bg-white border-bottom px-5">
<a class="navbar-brand" href="{{ url('/dashboard') }}">
<img src="/storage/{{ setting('site.logo') }}" alt="{{ setting('site.title') }}" width="108">
</a>
<h1 class="head-ttl m-0 font-weight-bold h5">@yield('title')</h1>
<input class="l-drawer__checkbox" id="drawerCheckbox" type="checkbox" >
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
@endif
@endguest
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="#"><i class="fas fa-bell mr-3"></i>お知らせ</a>
</li>
@auth
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="{{ route('account') }}"><i class="fas fa-user mr-3"></i>アカウント情報</a>
</li>
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="{{ route('dashboard') }}"><i class="fas fa-list-ul mr-3"></i>サイト管理</a>
</li>
@endauth
<li class="l-drawer__item">
<a class="l-drawer__item-inner text-muted" href="#"><i class="fas fa-book-open mr-3"></i>マニュアル</a>
</li>
<li class="l-drawer__item"><hr></li>
<li class="l-drawer__item contact">
<a class="l-drawer__item-inner text-muted" href="#">お問い合わせ</a>
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