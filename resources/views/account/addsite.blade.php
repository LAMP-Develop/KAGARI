@section('title', 'サイト追加')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@section('content')
<section class="wrap">
<div class="container">

<h2 class="text-muted h5 font-weight-bold mb-4">GoogleAnalytics登録済みのサイトを選択</h2>

<p class="m-0">
<small>お探しのサイトが無い場合はGoogleAnalyticsにて追加してください。</small>
<br><a href="https://kagari.ai/blog/google-analytics/" target="_blank">
<small><i class="fas fa-link mr-1"></i>GoogleAnalyticsの設定方法</small>
</a>
</p>

<div class="mt-3">
<div class="input-group">
<div class="input-group-prepend">
<div class="input-group-text"><i class="fas fa-search"></i></div>
</div>
<input id="ga-search" class="form-control" type="text" placeholder="キーワードで絞り込み" width="500">
</div>
</div>

<div class="ga-properties mt-4" data-spy="scroll" data-offset="0">

<div class="sites-list list-group list-group-flush">
@foreach ($properties as $key => $property)

<a class="accounts list-group-item list-group-item-action text-body" href="#collapse-{{ $key }}" data-toggle="collapse" aria-expanded="false" aria-controls="collapse-{{ $key }}">
{{ $property['account_name'] }}
</a>

<div id="collapse-{{ $key }}" class="collapse list-group list-group-flush pl-4">
@foreach ($property['data'] as $key_id => $prop)
<a href="#"
class="list-group-item list-group-item-action text-body"
data-toggle="modal"
data-target="#addsite-form"
data-name="{{ $property['account_name'] }}"
data-id="{{ $key_id }}"
data-url="{{ $prop['url'] }}"
data-property="{{ $prop['name'] }}"><i class="fas fa-globe-asia mr-3"></i>{{ $prop['name'] }}</a>
@endforeach
</div>

@endforeach
</div>

</div>

</div>
</section>

<!-- Modal -->
<div class="modal fade" id="addsite-form" tabindex="-1" role="dialog" aria-labelledby="addsite-form-label" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title font-weight-bold" id="addsite-form-label">Modal title</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form id="addsite-form" class="form register-form" method="get" action="{{ route('plan') }}">
@csrf
<div class="form-group mb-4">
<label for="site-name">サイト名</label>
<input id="site-name" type="text" class="form-control" name="site-name" value="{{ old('site-name') }}" required autofocus>
</div>
<div class="form-group mb-4">
<label for="industries">サイトの業種を選択</label>
<select id="industries" class="form-control" name="industries" required>
@foreach ($industries as $key_i => $industry)
<option value="{{ ($key_i+1) }}">{{ $industry->name }}</option>
@endforeach
</select>
</div>
<div class="form-group mb-4">
<label for="genre">サイトのカテゴリーを選択</label>
<select id="genre" class="form-control" name="genre" required>
@foreach ($categories as $key_c => $category)
<option value="{{ ($key_c+1) }}">{{ $category->cat }}</option>
@endforeach
</select>
</div>
<input id="view-id" type="hidden" name="view-id" value="">
<input id="site-url" type="hidden" name="site-url" value="">
<button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
<button id="formsubmit" type="submit" class="btn btn-primary">このサイトを追加しプラン選択へ進む</button>
</form>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>

<script>
$(function() {
  const $searchElem = $('.accounts');
  const excludedClass = 'is-excluded';
  let $searchInput = $('#ga-search');
  function extraction() {
    var keywordArr = $searchInput.val().toLowerCase().replace('　', ' ').split(' ');
    $searchElem.removeClass(excludedClass).show();
    for (var i = 0; i < keywordArr.length; i++) {
      for (var j = 0; j < $searchElem.length; j++) {
        var thisString = $searchElem.eq(j).text().toLowerCase();
        if (thisString.indexOf(keywordArr[i]) == -1) {
          $searchElem.eq(j).addClass(excludedClass);
        }
      }
    }
    $('.' + excludedClass).hide();
  }
  $searchInput.on('load keyup blur', function() {
    extraction();
  });

  $('.accounts').on('click', function() {
    $(this).children('.fas');
  });

  $('[data-toggle="modal"]').on('click', function() {
    let account_name = $(this).attr('data-name');
    let property_name = $(this).attr('data-property');
    let view_id = $(this).attr('data-id');
    let data_url = $(this).attr('data-url');
    $('#addsite-form-label').text(account_name);
    $('#site-name').val(property_name);
    $('#view-id').val(view_id);
    $('#site-url').val(data_url);
  });
});
</script>

@endsection