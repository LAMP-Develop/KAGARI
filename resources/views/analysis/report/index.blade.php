@push('scripts')
<script src="{{ mix('/js/report.js') }}"></script>
@endpush

@section('title', '解析レポート')

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@include('layouts.report')
