@section('title', '登録情報編集')
@extends('layouts.app')
@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')
@section('content')
<section class="wrap">
<div class="container">
<form class="register-form form-signin mt-5" method="post" action="{{ action('UserController@account_edit') }}" onSubmit="return check()">
@csrf
<div class="form-group mb-4">
<label for="company">法人組織名</label>
<input id="company" type="text" class="form-control @error('name') is-invalid @enderror" name="company" value="{{ $user->company }}" required autofocus>
@error('name')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<div class="form-group mb-4">
<label for="name">{{ __('Name') }}</label>
<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name">
@error('name')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<div class="form-group mb-4">
<label for="tel">電話番号(半角・ハイフン無し)</label>
<input id="tel" type="tel" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{ $user->tel }}" required>
@error('tel')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<div class="form-group mb-4">
<label for="email">{{ __('E-Mail Address') }}</label>
<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">
@error('email')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<!-- <div class="form-group mb-4">
<label for="password">{{ __('Password') }}(8文字以上)</label>
<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
@error('password')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<div class="form-group mb-4">
<label for="password-confirm">{{ __('Confirm Password') }}</label>
<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
</div> -->
<div class="form-group mb-0 text-center mt-5">
<button type="submit" class="btn btn-primary">変更する</button>
</div>

<input type="hidden" name="user_id" value="{{ $user->id }}">
</form>
</div>
</section>

<script>
function check() {
  if(window.confirm('変更してもよろしいですか？')) {
    return true;
  } else {
    return false;
  }
}
</script>
@endsection
