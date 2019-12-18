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
<script>
// コメント編集ボタン
  let btn = document.getElementById('comment_btn');

  function textareaBtn(){
    btn.style.display = "block";
  }

  function saveTextarea(key,textarea){
    localStorage.setItem(key,textarea.value);
    textarea.classList.remove('border');
    textarea.style.border = "1px solid rgba(52,199,89,0.5)";
    textarea.blur();
    btn.style.display = 'none';
  }
</script>
</body>
</html>
