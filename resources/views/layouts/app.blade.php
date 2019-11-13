<!DOCTYPE html>
<html lang="ja">
<head>
@yield('head')
@stack('scripts')
</head>
<body class="drawer drawer--right">
@yield('header')
<main class="py-5">
@yield('content')
</main>
@yield('footer')
</body>
</html>