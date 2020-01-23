@section('head')
<meta charset="utf-8">
<meta name="robots" content="noindex">
<meta name="viewport" content="width=1366,initial-scale=1">

<link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
<link rel="icon" href="{{ asset('img/cropped-favicon-1-32x32.png') }}" sizes="32x32">
<link rel="icon" href="{{ asset('img/cropped-favicon-1-192x192.png') }}" sizes="192x192">
<link rel="apple-touch-icon-precomposed" href="{{ asset('img/cropped-favicon-1-180x180.png') }}">
<meta name="msapplication-TileImage" content="{{ asset('img/cropped-favicon-1-270x270.png') }}">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Title -->
<title>@yield('title') - {{ setting('site.title') }}</title>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">

<!-- Styles -->
<link rel="stylesheet" href="{{ mix('css/app.css') }}">

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-79537153-15"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-79537153-15');
</script>
@endsection
