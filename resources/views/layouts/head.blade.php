@section('head')
<meta charset="utf-8">
<meta name="viewport" content="width=1366,initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ setting('site.title') }}</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">

<!-- Styles -->
<link href="{{ mix('css/app.css') }}" rel="stylesheet">

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
@endsection