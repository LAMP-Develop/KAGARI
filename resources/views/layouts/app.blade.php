<!DOCTYPE html>
<html lang="ja">
<head>
@yield('head')
@stack('style')
@stack('scripts')
</head>
<body class="drawer drawer--right">
@yield('header')
<main class="py-5">
@yield('nav')
@yield('content')
</main>
@yield('footer')
@stack('scripts-vue')
</body>
</html>