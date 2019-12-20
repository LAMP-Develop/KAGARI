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

@if(strpos($_SERVER['REQUEST_URI'], 'report'))
<script>
// コメント編集
let btn = document.getElementById('comment_btn');
function textareaBtn(){
  btn.style.display = "block";
}
function saveTextarea(key,textarea){
  localStorage.setItem(key,textarea.value);
  textarea.classList.remove('border');
  textarea.style.border = '1px solid rgba(52,199,89,0.5)';
  textarea.blur();
  btn.style.display = 'none';
}

if (localStorage.getItem('sumally') != null) {
  let val_sumally = localStorage.getItem('sumally');
  let target_sumally = document.getElementById("comment_sumally");
  target_sumally.innerHTML = val_sumally;
}
if (localStorage.getItem('user') != null) {
  let val_user = localStorage.getItem('user');
  let target_user = document.getElementById("comment_user");
  target_user.innerHTML = val_user;
}
if (localStorage.getItem('inflow') != null) {
  let val_inflow = localStorage.getItem('inflow');
  let target_inflow = document.getElementById("comment_inflow");
  target_inflow.innerHTML = val_inflow;
}
if (localStorage.getItem('action') != null) {
  let val_action = localStorage.getItem('action');
  let target_action = document.getElementById("comment_action");
  target_action.innerHTML = val_action;
}
if (localStorage.getItem('conversion') != null) {
  let val_conversion = localStorage.getItem('conversion');
  let target_conversion = document.getElementById("comment_conversion");
  target_conversion.innerHTML = val_conversion;
}
if (localStorage.getItem('ad') != null) {
  let val_ad = localStorage.getItem('ad');
  let target_ad = document.getElementById("comment_ad");
  target_ad.innerHTML = val_ad;
}
</script>
@endif

</body>
</html>
