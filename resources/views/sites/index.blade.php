@section('content')
<section class="wrap">
<div class="container">
<table class="table text-muted">
<thead>
<tr>
<th scope="col">サイトの名前</th>
<th scope="col">サイトのジャンル</th>
<th scope="col">ご契約プラン
<!-- <a class="float-right font-weight-normal" href="{{ route('sites-edit') }}"><i class="fas fa-edit mr-1"></i>編集する</a> -->
</th>
</tr>
</thead>
<tbody>
@if (count($add_sites) != 0)
@foreach ($add_sites as $key => $site)
<tr>
<td>
<div class="d-flex align-items-center">
<figure class="m-0 line-height-1">
<img class="d-inline-block align-middle" src="https://www.google.com/s2/favicons?domain={{ $site->url }}" width="16" height="16">
</figure>
<div class="ml-2">
<span class="d-block text-dark">{{ $site->site_name }}</span>
<span class="d-block"><small>{{ $site->url }}</small></span>
</div>
</div>
</td>
<td>{{ $categories[($site->category - 1)]->cat }}</td>
<td>
<div class="d-flex align-items-center justify-content-between">
<span>
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
</span>
<div class="d-flex align-items-center justify-content-end">
@if ($site->plan == null)
<a href="#" class="btn btn-sm btn-outline-primary mr-2 disabled">レポートを作成する</a>
@else
<a href="{{ route('ga-report', $site->id) }}" class="btn btn-sm btn-outline-primary mr-2">レポートを作成する</a>
@endif
@if ($site->plan % 2 != 0 || $site->plan == null)
<a href="#" class="btn btn-sm btn-outline-secondary disabled">SEO分析する</a>
@else
<a href="{{ route('seo-report', $site->id) }}" class="btn btn-sm btn-outline-secondary">SEO分析する</a>
@endif
</div>
</div>
</td>
</tr>
@endforeach
@else
<tr>
<td colspan="3">まだサイトが登録されていません。</td>
</tr>
@endif
</tbody>
</table>
@if (count($add_sites) == 0)
<div class="mt-5 text-center">
<a href="{{ route('addsite') }}" class="btn btn-primary">サイトを追加する</a>
</div>
@else
<div class="mt-3">
<a href="{{ route('addsite') }}" class="text-primary"><i class="fas fa-plus mr-1"></i>サイトを追加する</a>
</div>
@endif
</div>
</section>
@endsection