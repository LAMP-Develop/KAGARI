@section('title', 'サイト編集')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@section('content')
<section class="wrap">
<div class="container">
<table class="table text-muted">
<thead>
<tr>
<th scope="col">サイトの名前</th>
<th scope="col">サイトのジャンル</th>
<th scope="col">ご契約プラン</th>
</tr>
</thead>
<tbody>
@if (count($add_sites) != 0)
@foreach ($add_sites as $key => $site)
<tr>
<td>
<div class="d-flex align-items-center">
<i class="fas fa-globe-americas h4"></i>
<div class="ml-3">
<span class="d-block text-dark">{{ $site->site_name }}</span>
<span class="d-block"><small>{{ $site->url }}</small></span>
</div>
</div>
</td>
<td>{{ $categories[($site->category - 1)]->cat }}</td>
<td>
@if ($site->plan == null)
<form class="" action="{{ route('plan') }}" method="get">
<button type="submit" class="btn btn-link">プランを登録する</button>
<input type="hidden" name="site-id" value="{{ $site->id }}">
<input type="hidden" name="view-id" value="{{ $site->VIEW_ID }}">
<input type="hidden" name="site-url" value="{{ $site->url }}">
<input type="hidden" name="site-name" value="{{ $site->site_name }}">
<input type="hidden" name="industries" value="{{ $site->industry }}">
<input type="hidden" name="genre" value="{{ $site->category }}">
</form>
@else
{{ $plans[($site->plan - 1)]->name }}
@endif
</td>
</tr>
@endforeach
@endif
</tbody>
</table>
</div>
</section>
@endsection