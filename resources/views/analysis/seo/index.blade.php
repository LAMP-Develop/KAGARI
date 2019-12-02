@push('scripts')
<script src="{{ mix('/js/seo.js') }}"></script>
@endpush

@section('title', $url)

@extends('layouts.app')

@include('layouts.head')
@include('layouts.header')
@include('layouts.footer')

@include('layouts.analysis')