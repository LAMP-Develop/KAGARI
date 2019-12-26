@section('content')
<section class="wrap">
<div class="container">
<ul class="list-group list-group-flush">
<li class="list-group-item">
<div class="row">
<div class="col-4"><span class="font-weight-bold text-dark">サイトの名前</span></div>
<div class="col-3"><span class="font-weight-bold text-dark">サイトのジャンル</span></div>
<div class="col-3"><span class="font-weight-bold text-dark">ご契約プラン</span></div>
</div>
</li>
@if (count($add_sites) != 0)
@foreach ($add_sites as $key => $site)
<li class="list-group-item list-group-item-action" data-toggle="collapse" href="#collapse-{{ $key }}" role="button" aria-expanded="false" aria-controls="collapse-{{ $key }}">
<div class="row align-items-center">
<div class="col-4 d-flex align-items-center">
<figure class="m-0 line-height-1">
<img class="d-inline-block align-middle" src="https://www.google.com/s2/favicons?domain={{ $site->url }}" width="16" height="16">
</figure>
<div class="ml-2">
<span class="d-inline-block text-dark">{{ $site->site_name }}</span>
<span class="d-block"><small>{{ $site->url }}</small></span>
</div>
</div>
<div class="col-3">{{ $categories[($site->category - 1)]->cat }}</div>
<div class="col-3">
@if ($site->plan == null)
<form class="" action="{{ route('plan') }}" method="post">
@csrf
<button type="submit" class="btn btn-link p-0">プランを登録する</button>
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
</div>
</div>
<div class="collapse" id="collapse-{{ $key }}">
<hr>
<div class="d-flex justify-content-between align-items-center">
<div class="">
@if ($site->plan != null)
<a href="{{ route('ga-report', $site->id) }}" class="btn btn-sm btn-primary mr-2">レポートを作成する</a>
@endif
@if ($site->plan % 2 == 0 && $site->plan != null)
<a href="{{ route('seo-report', $site->id) }}" class="btn btn-sm btn-secondary">SEO分析する</a>
@endif
</div>
<div class="">
<a href="#" class="btn btn-sm btn-outline-secondary mr-2">プランの変更</a>
<a href="{{ route('sites-edit', $site->id) }}" class="btn btn-sm btn-outline-secondary mr-2">サイト情報変更</a>
<a href="{{ route('send-setting', $site->id) }}" class="btn btn-sm btn-outline-secondary">レポート受信設定</a>
</div>
</div>
</div>
</li>
@endforeach
@endif
</ul>
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
