@section('title', 'サイト追加')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@section('content')

<!-- $properties - ga_properties
$categories - sites_category
$industries - sites_industry -->

<section class="wrap">
  <div class="container">
    <h2 class="text-muted h5 font-weight-bold mb-4">GoogleAnalyticsのビューを選択してください</h2>
    <p class="m-0">
      <small>お探しのサイトが無い場合はGoogleAnalyticsにて追加してください。</small>
      <br><a href="https://kagari.ai/blog/google-analytics/" target="_blank">
        <small><i class="fas fa-link mr-1"></i>GoogleAnalyticsの設定方法</small>
      </a>
    </p>
    <div class="ga-properties" data-spy="scroll" data-offset="0">
      <ul>
        @foreach ($properties as $key => $property)
        <li view-id="{{ $property->defaultProfileId }}" site-url="{{ $property->websiteUrl }}">

        </li>
        @endforeach
      </ul>
    </div>
  </div>
</section>

@endsection