<!DOCTYPE html>
<html lang="ja">
<head>
@yield('head')
@stack('scripts')
</head>
<body class="drawer drawer--right">
@yield('header')
<main>
@yield('content')
</main>
@yield('footer')
</body>
</html>