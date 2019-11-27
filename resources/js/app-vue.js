import Vue from 'vue'
import router from './router'
import Vuetify from 'vuetify/lib'
import App from './App.vue'
import colors from 'vuetify/es5/util/colors'
import 'vuetify/dist/vuetify.min.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';

Vue.use(Vuetify, {
  theme: {
    primary: colors.blue.darken2,
    accent: colors.grey.darken3,
    secondary: colors.amber.darken3,
    info: colors.teal.lighten1,
    warning: colors.amber.base,
    error: colors.deepOrange.accent4,
    success: colors.green.accent3
  }
})
export default new Vuetify();

// Vue.jsの実行
document.addEventListener('DOMContentLoaded', function() {
  new Vue({
    el: '#app',
    router, // ルーティングの定義を読み込む
    // Vuetixfy,
    components: {
      App
    }, // ルートコンポーネントの使用を宣言する
    template: '<App />' // ルートコンポーネントを描画する
  });
});