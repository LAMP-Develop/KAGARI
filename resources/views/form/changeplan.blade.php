@section('title', 'プラン変更申請')
@extends('layouts.app')
@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')
@section('content')
<section class="wrap">
<div class="container">

<form class="register-form form-signin" method="post" action="{{ route('change-plan.confirm') }}">
@csrf

<div class="form-group mb-4">
<label class="font-weight-bold" for="name">{{ __('Name') }}</label>
<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" placeholder="山田 太郎" required autocomplete="name">
@error('name')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>

<div class="form-group mb-4">
<label class="font-weight-bold" for="email">{{ __('E-Mail Address') }}</label>
<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" placeholder="info@example.com" required autocomplete="email">
@error('email')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
<small class="form-text text-muted">※こちらのメールアドレスにプラン変更確認のメールが送信されます。</small>
</div>

<div class="form-group mb-4">
<label class="font-weight-bold" for="site">対象サイト</label>
<input id="site" type="text" class="form-control @error('site') is-invalid @enderror" name="site_name" value="{{ $site_name }}" required autocomplete="site">
@error('site')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>

<div class="form-group mb-4">
<label class="font-weight-bold" for="plan">変更したいプラン／解約</label>
<select class="form-control" id="plan" name="plan_name">
@foreach ($plan as $key => $val)
@php
if ($key == 6 || $key == 7) {
    continue;
}
@endphp
<option value="{{ $val->name }}">{{ $val->name }}</option>
@endforeach
<option value="解約">解約</option>
</select>
<small class="form-text text-muted">現在ご契約のプラン：{{ $plan[($site_plan - 1)]->name }}</small>
</div>

<input type="hidden" name="site_id" value="{{ $site_id }}">
<input type="hidden" name="site_url" value="{{ $site_url }}">
<input type="hidden" name="now" value="{{ $plan[($site_plan - 1)]->name }}">

<div class="form-group mb-0 text-center mt-5">
<button type="submit" class="btn btn-primary">確認する</button>
</div>

</form>

</div>
</section>
@endsection