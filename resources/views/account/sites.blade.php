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
<tr>
<td>
<div class="d-flex align-items-center">
<i class="fas fa-globe-americas h4"></i>
<div class="ml-3">
<span class="d-block">せんたくのーと</span>
<span class="d-block"><small>https://sentakunote.com</small></span>
</div>
</div>
</td>
<td>メディアサイト</td>
<td>
<div class="d-flex align-items-center justify-content-between">
<span>スタンダードプラン</span>
<div class="d-flex align-items-center justify-content-end">
<a href="#" class="btn btn-outline-primary mr-2">レポートを作成する</a>
<a href="#" class="btn btn-outline-secondary disabled">SEO分析する</a>
</div>
</div>
</td>
</tr>
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
<a href="{{ route('addsite') }}" class="stretched-link text-primary">サイトを追加する</a>
</div>
@endif
</div>
</section>
@endsection