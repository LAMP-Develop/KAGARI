@section('title', '支払い設定')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@section('content')
<section class="wrap">
<div class="container">
  <h2 class="text-center text-muted h5 font-weight-bold mb-4">お支払い方法を選択してください</h2>
  <form class="payment-form" action="{{ route('payment-done') }}" method="post">
    <div class="form-group row align-items-center">
      <label for="staticEmail" class="col-sm-2 col-form-label font-weight-bold">支払い方法</label>
      <div class="col-sm-10">
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="payment_methods" id="inlineRadio1" value="1" checked>
          <label class="form-check-label" for="inlineRadio1">クレジットカード</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="payment_methods" id="inlineRadio2" value="2">
          <label class="form-check-label" for="inlineRadio2">請求書支払い</label>
        </div>
      </div>
    </div>
  </form>
</div>
</section>
@endsection