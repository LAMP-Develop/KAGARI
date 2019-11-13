@section('title', '新規会員登録')
@extends('layouts.app')
@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')
@section('content')
<section class="form-signin-wrap">
<div class="container">
<h2 class="text-center text-muted h5 font-weight-bold">{{ __('Register') }}</h2>
<form class="form-signin mt-5" method="POST" action="{{ route('register') }}">
@csrf
<div class="form-group">
<label for="name">{{ __('Name') }}</label>
<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="山田 太郎" required autocomplete="name" autofocus>
@error('name')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<div class="form-group">
<label for="email">{{ __('E-Mail Address') }}</label>
<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="info@example.com" required autocomplete="email">
@error('email')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<div class="form-group">
<label for="password">{{ __('Password') }}</label>
<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
@error('password')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<div class="form-group">
<label for="password-confirm">{{ __('Confirm Password') }}</label>
<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
</div>
<div class="form-group mb-0 text-center mt-5">
<button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
</div>
</form>
</div>
</section>
@endsection
