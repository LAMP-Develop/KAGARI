@section('header')
<nav class="position-relative navbar navbar-expand-md navbar-light bg-white shadow-sm px-5">
<a class="navbar-brand" href="{{ url('/dashboard') }}">
<img src="/storage/{{ setting('site.logo') }}" alt="{{ setting('site.title') }}" width="108">
</a>
<input class="l-drawer__checkbox" id="drawerCheckbox" type="checkbox" >
<!-- ドロワーアイコン -->
<label class="l-drawer__icon" for="drawerCheckbox">
<span class="l-drawer__icon-parts"></span>
</label>
<!-- 背景を暗く -->
<label class="l-drawer__overlay" for="drawerCheckbox"></label>
<!-- ドロワーメニュー -->
<div class="l-drawer__menu">
<ul>
@guest
@if (Route::has('register'))
<li class="l-drawer__item">
<a class="l-drawer__item-inner" href="{{ route('register') }}">{{ __('Register') }}</a>
</li>
@endif
@endguest
<li class="l-drawer__item">
<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
</li>
</ul>
</div>
</nav>
@endsection