@section('title', 'プラン選択')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@section('content')
<form action="{{ route('payment') }}" method="post">
@csrf
<section class="wrap">
<div class="container">
<h2 class="text-muted h5 font-weight-bold mb-4">サイトのプランを選択してください</h2>
<p>1サイトごとの税込料金です。登録サイトごとに料金プランをお選びいただけます。</p>
@if ($e_message != '')
<div class="alert alert-warning alert-dismissible fade show" role="alert">
@php
echo $e_message;
@endphp
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif
@if ($message != '')
<div class="alert alert-warning alert-dismissible fade show" role="alert">
@php
echo $message;
@endphp
<a class="ml-2" href="{{ url('/') }}">トップへ戻る<i class="ml-1 fas fa-chevron-right"></i></a>
</div>
@endif
<ul class="nav nav-pills mt-5 justify-content-center">
<li class="nav-item">
<a href="#annual" class="nav-link active" data-toggle="tab">年間契約</a>
</li>
<li class="nav-item">
<a href="#half" class="nav-link" data-toggle="tab">半年契約</a>
</li>
<li class="nav-item">
<a href="#month" class="nav-link" data-toggle="tab">月間契約</a>
</li>
</ul>
<div class="tab-content pt-4">
<!-- 年間契約 -->
<div id="annual" class="tab-pane active">
<div class="row justify-content-center">
<div class="col-4">
<div class="card py-5 shadow-sm rounded-lg">
<div class="card-body">
<h3 class="font-weight-bold text-center text-primary card-title mb-4">Report</h3>
<p class="text-center h2 font-weight-bold mb-0">¥4,000/月</p>
<p class="text-center"><small>¥48,000/年間</small></p>
<p class="text-center my-4 font-weight-bold">すべてのレポート作成機能を<br>ご利用いただけるプラン</p>
<ul class="list-group list-group-flush">
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>アクセス解析</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>レポーティング機能</li>
<li class="border-0 p-0 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>AI改善提案</li>
</ul>
<div class="mt-5 text-center">
<button type="submit" name="plan" value="1" class="btn btn-outline-primary">このプランで登録する</button>
</div>
</div>
</div>
</div>
<div class="col-4">
<div class="card py-5 shadow-sm rounded-lg">
<div class="card-body">
<h3 class="font-weight-bold text-center text-primary card-title mb-4">SEO</h3>
<p class="text-center h2 font-weight-bold mb-0">¥7,000/月</p>
<p class="text-center"><small>¥84,000/年間</small></p>
<p class="text-center my-4 font-weight-bold">ページごとのSEO分析に特化した<br>分析機能付きのプラン</p>
<ul class="list-group list-group-flush">
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>アクセス解析</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>レポーティング機能</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>AI改善提案</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>検索順位/キーワードのレポーティング</li>
<li class="border-0 p-0 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>ページごとのSEO解析</li>
</ul>
<div class="mt-5 text-center">
@if ($e_message != '')
<button type="submit" name="plan" value="2" class="btn btn-outline-primary" disabled>このプランで登録する</button>
@else
<button type="submit" name="plan" value="2" class="btn btn-outline-primary">このプランで登録する</button>
@endif
<p class="text-center mt-1 mb-0"><small>※Search Consoleと連携します</small></p>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- 半年契約 -->
<div id="half" class="tab-pane">
<div class="row justify-content-center">
<div class="col-4">
<div class="card py-5 shadow-sm rounded-lg">
<div class="card-body">
<h3 class="font-weight-bold text-center text-primary card-title mb-4">Report</h3>
<p class="text-center h2 font-weight-bold mb-0">¥5,000/月</p>
<p class="text-center"><small>¥60,000/年間</small></p>
<p class="text-center my-4 font-weight-bold">すべてのレポート作成機能を<br>ご利用いただけるプラン</p>
<ul>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>アクセス解析</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>レポーティング機能</li>
<li class="border-0 p-0 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>AI改善提案</li>
</ul>
<div class="mt-5 text-center">
<button type="submit" name="plan" value="3" class="btn btn-outline-primary">このプランで登録する</button>
</div>
</div>
</div>
</div>
<div class="col-4">
<div class="card py-5 shadow-sm rounded-lg">
<div class="card-body">
<h3 class="font-weight-bold text-center text-primary card-title mb-4">SEO</h3>
<p class="text-center h2 font-weight-bold mb-0">¥8,000/月</p>
<p class="text-center"><small>¥96,000/年間</small></p>
<p class="text-center my-4 font-weight-bold">ページごとのSEO分析に特化した<br>分析機能付きのプラン</p>
<ul>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>アクセス解析</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>レポーティング機能</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>AI改善提案</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>検索順位/キーワードのレポーティング</li>
<li class="border-0 p-0 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>ページごとのSEO解析</li>
</ul>
<div class="mt-5 text-center">
@if ($e_message != '')
<button type="submit" name="plan" value="4" class="btn btn-outline-primary" disabled>このプランで登録する</button>
@else
<button type="submit" name="plan" value="4" class="btn btn-outline-primary">このプランで登録する</button>
@endif
<p class="text-center mt-1 mb-0"><small>※Search Consoleと連携します</small></p>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- 月間契約 -->
<div id="month" class="tab-pane">
<div class="row justify-content-center">
<div class="col-4">
<div class="card py-5 shadow-sm rounded-lg">
<div class="card-body">
<h3 class="font-weight-bold text-center text-primary card-title mb-4">Report</h3>
<p class="text-center h2 font-weight-bold mb-0">¥6,000/月</p>
<p class="text-center"><small>¥72,000/年間</small></p>
<p class="text-center my-4 font-weight-bold">すべてのレポート作成機能を<br>ご利用いただけるプラン</p>
<ul>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>アクセス解析</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>レポーティング機能</li>
<li class="border-0 p-0 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>AI改善提案</li>
</ul>
<div class="mt-5 text-center">
<button type="submit" name="plan" value="5" class="btn btn-outline-primary">このプランで登録する</button>
</div>
</div>
</div>
</div>
<div class="col-4">
<div class="card py-5 shadow-sm rounded-lg">
<div class="card-body">
<h3 class="font-weight-bold text-center text-primary card-title mb-4">SEO</h3>
<p class="text-center h2 font-weight-bold mb-0">¥9,000/月</p>
<p class="text-center"><small>¥108,000/年間</small></p>
<p class="text-center my-4 font-weight-bold">ページごとのSEO分析に特化した<br>分析機能付きのプラン</p>
<ul>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>アクセス解析</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>レポーティング機能</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>AI改善提案</li>
<li class="border-0 p-0 mb-1 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>検索順位/キーワードのレポーティング</li>
<li class="border-0 p-0 list-group-item"><i class="fas fa-check mr-1 text-primary"></i>ページごとのSEO解析</li>
</ul>
<div class="mt-5 text-center">
@if ($e_message != '')
<button type="submit" name="plan" value="6" class="btn btn-outline-primary" disabled>このプランで登録する</button>
@else
<button type="submit" name="plan" value="6" class="btn btn-outline-primary">このプランで登録する</button>
@endif
<p class="text-center mt-1 mb-0"><small>※Search Consoleと連携します</small></p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<input type="hidden" name="site-id" value="{{ $site_id }}">
</form>
@endsection