@section('title', '支払い設定')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@section('content')

@php
if ($plan_id == 1 || $plan_id == 2) {
  $str = '年';
} elseif ($plan_id == 3 || $plan_id == 4) {
  $str = '半年';
} else {
  $str = '月';
}
@endphp

<section class="wrap">
<div class="container">

<h2 class="text-center text-muted h5 font-weight-bold mb-5">お支払い方法を選択してください</h2>
<form class="payment-form" action="{{ route('payment-done') }}" method="post" name="payment_kagari">
@csrf
<div class="form-group row align-items-start">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">支払い方法</legend>
<div class="col-7 mr-auto">
<div class="form-check">
<input class="form-check-input" type="radio" name="payment_methods" id="inlineRadio1" value="1" onclick="changeForm();" checked>
<label id="credit_card" class="form-check-label" for="inlineRadio1">クレジットカード</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="payment_methods" id="inlineRadio2" value="2" onclick="changeForm();">
<label id="billing_sheet" class="form-check-label" for="inlineRadio2">請求書支払い</label>
</div>
</div>
</div>
<div id="card_info">
<div class="form-group row align-items-start mt-5">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">ご登録クレジットカード</legend>
<div class="col-7 mr-auto row m-0">
<div class="col-8 p-0">
<select class="form-control" name="cards">
<option>---</option>
@foreach ($card as $key => $val)
@php
$nums = 'カード番号下4桁（'.substr(\Crypt::decryptString($val->numbers), -4).'）';
@endphp
<option value="{{ $val->id }}">{{ $nums }}</option>
@endforeach
</select>
</div>
<div class="col-4">
<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#payment-form">カード追加</button>
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
</div>
<div id="bill_info" style="display:none;">
<div class="form-group row align-items-start mt-5">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">会社名</legend>
<div class="col-7 mr-auto">
<input type="text" class="form-control" id="com_name" name="cn" placeholder="株式会社KAGARI">
</div>
</div>
<div class="form-group row align-items-start mt-5">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">宛名</legend>
<div class="col-7 mr-auto">
<input type="text" class="form-control" id="per_name" name="pn" placeholder="">
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
<td>{{ $plan_price }} 円（税込）/ {{ $str }}</td>
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

<!-- Modal -->
<div class="modal fade" id="payment-form" tabindex="-1" role="dialog" aria-labelledby="credit-card-regi" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title font-weight-bold" id="credit-card-regi">クレジットカード追加</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div id="card-form" class="modal-body">
<div class="form-group row align-items-start mt-4">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">カード番号</legend>
<div class="col-7 mr-auto">
<input type="text" class="form-control @error('cn') is-invalid @enderror" id="cardnum" name="cn" placeholder="0000111122223333" required>
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
<input id="ed_month" class="form-control @error('ed_month') is-invalid @enderror" type="text" name="ed_month" value="" placeholder="01" required>
</div>
<div class="col-3 m-0">
<input id="ed_year" class="form-control @error('ed_year') is-invalid @enderror" type="text" name="ed_year" value="" placeholder="20" required>
</div>
</div>
</div>
</div>
<div class="form-group row align-items-start mt-5">
<legend class="ml-auto col-form-label col-3 pt-0 font-weight-bold">カード名義</legend>
<div class="col-7 mr-auto">
<div class="row">
<div class="col">
<input id="ln" class="form-control @error('ln') is-invalid @enderror" type="text" name="ln" value="" placeholder="性（例：KAGARI）" required>
</div>
<div class="col">
<input id="fn" class="form-control @error('fn') is-invalid @enderror" type="text" name="fn" value="" placeholder="名（例：TAROU）" required>
</div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
<button id="addcard" type="submit" class="btn btn-primary">保存する</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
</div>
</div>
</div>
</div>

<script>
// 支払い方法切り替え
function changeForm() {
  var radio = document.getElementsByName('payment_methods');
  if(radio[0].checked){
    document.getElementById('card_info').style.display = "";
    document.getElementById('bill_info').style.display = "none";
  } else if(radio[1].checked){
    document.getElementById('card_info').style.display = "none";
    document.getElementById('bill_info').style.display = "";
  }
}

$('#addcard').on('click', function() {
  const csrf = $('meta[name="csrf-token"]').attr('content');
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': csrf
    }
  });
  $.ajax({
    url: "{{ route('add.card') }}",
    type: 'post',
    datatype: 'json',
    data: {
      cn: $('#cardnum').val(),
      ed_month: $('#ed_month').val(),
      ed_year: $('#ed_year').val(),
      ln: $('#ln').val(),
      fn: $('#fn').val()
    }
  }).done(function(data) {
    location.reload();
  });
});
</script>
@endsection
