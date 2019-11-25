@section('title', '支払い設定')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@section('content')
<section class="wrap">
<div class="container">

<h2 class="text-center text-muted h5 font-weight-bold mb-5">お支払い方法を選択してください</h2>
<form class="payment-form" action="{{ route('payment-done') }}" method="post">
@csrf
<div class="form-group row align-items-start">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">支払い方法</legend>
<div class="col-7 mr-auto">
<div class="form-check">
<input class="form-check-input" type="radio" name="payment_methods" id="inlineRadio1" value="1" checked>
<label class="form-check-label" for="inlineRadio1">クレジットカード</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="payment_methods" id="inlineRadio2" value="2">
<label class="form-check-label" for="inlineRadio2">請求書支払い</label>
</div>
</div>
</div>
<div class="form-group row align-items-start mt-5">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">カード番号</legend>
<div class="col-7 mr-auto">
<input type="text" class="form-control" id="cardnum" name="cn" placeholder="0000111122223333">
<small class="form-text text-muted">※半角英数字(空白なし)でご入力ください</small>
<div class="mt-2">
<img src="{{ asset('/img/credit-card.gif') }}" alt="クレジットカード" width="244">
</div>
</div>
</div>
<div class="form-group row align-items-start mt-5">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">有効期限(月/年)</legend>
<div class="col-7 mr-auto">
<div class="row">
<div class="col-3 m-0">
<input id="ed_month" class="form-control" type="text" name="ed_month" value="" placeholder="01">
</div>
<div class="col-3 m-0">
<input id="ed_year" class="form-control" type="text" name="ed_year" value="" placeholder="20">
</div>
</div>
</div>
</div>
<div class="form-group row align-items-start mt-5">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">セキュリティコード</legend>
<div class="col-7 mr-auto">
<div class="col-3 m-0 p-0">
<input id="cvv" class="form-control" type="text" name="cvv" value="" placeholder="123">
</div>
<small class="form-text text-muted">※カードの裏面にある数字の下3桁を半角数字で入力ください</small>
</div>
</div>
<div class="form-group row align-items-start mt-5">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">カード名義</legend>
<div class="col-7 mr-auto">
<div class="row">
<div class="col">
<input id="ln" class="form-control" type="text" name="ln" value="" placeholder="性（例：KAGARI）">
</div>
<div class="col">
<input id="fn" class="form-control" type="text" name="fn" value="" placeholder="名（例：TAROU）">
</div>
</div>
</div>
</div>
<div class="mt-5 col-11 mx-auto">
<table class="table">
<tbody>
<tr>
<th>ご登録サイト</th>
<td>{{ $site_name }}（<a href="{{ $site_url }}" target="_blank">{{ $site_url }}</a>）</td>
</tr>
<tr>
<th>ご契約プラン</th>
<td>{{ $plan_name }}</td>
</tr>
<tr>
<th>お支払い金額</th>
<td>{{ $plan_price }} 円（税込）</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-5 text-center">
<button type="submit" class="btn btn-primary">上記の内容で登録する</button>
</div>

<input type="hidden" name="site_id" value="{{ $site_id }}">
<input type="hidden" name="site_name" value="{{ $site_name }}">
<input type="hidden" name="site_url" value="{{ $site_url }}">
<input type="hidden" name="plan_id" value="{{ $plan_id }}">
<input type="hidden" name="plan_name" value="{{ $plan_name }}">
<input type="hidden" name="plan_price" value="{{ $plan_price }}">
<input type="hidden" name="plan_period" value="{{ $plan_period }}">

</form>
</div>
</section>
@endsection