@section('title', 'お支払い完了')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@section('content')
<section class="wrap">
<div class="container">
<h2 class="text-center text-muted h4 font-weight-bold mb-5">ご登録ありがとうございます</h2>
<div class="mt-5 col-11 mx-auto">
<h3 class="h5 font-weight-bold mb-4">ご登録内容詳細</h3>
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
<div class="mt-5 text-center">
<a class="btn btn-primary" href="{{ route('dashboard') }}">サイト一覧に戻る</a>
</div>
</div>
</div>
</section>
@endsection
