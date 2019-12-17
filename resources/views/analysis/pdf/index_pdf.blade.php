@push('scripts')
<script src="{{ mix('/js/report.js') }}"></script>
@endpush

@push('style')
<style media="screen">
  body {
    background-color: #fafafa;
  }
</style>
@endpush

{{-- 変数定義 --}}
@php
$route_name = Route::current()->getName();
$site_id = $add_site->id;
$site_url = $add_site->url;
$site_name = $add_site->site_name;
@endphp

@section('title', '解析レポート - '.$site_name)

@extends('layouts.app_pdf')
@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')
@include('layouts.nav_pdf')

@include('analysis.pdf.top_pdf')
@include('analysis.pdf.sumally_pdf')
@include('analysis.pdf.users_pdf')
@include('analysis.pdf.inflow_pdf')
@include('analysis.pdf.action_pdf')
@include('analysis.pdf.conversion_pdf')
@include('analysis.pdf.ad_pdf')