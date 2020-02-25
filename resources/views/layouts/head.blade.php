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
gtag('set', 'linker', {'domains': ['report.kagari.ai']});
gtag('js', new Date());
gtag('config', 'UA-79537153-15');
@if(Route::current()->getName() == 'register')
gtag('config', 'UA-79537153-10')
@endif
</script>
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1424654571021609');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1424654571021609&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
@endsection
