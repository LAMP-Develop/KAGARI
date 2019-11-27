import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import Index from './pages/Index.vue'
import User from './pages/User.vue'
import Inflow from './pages/Inflow.vue'
import Action from './pages/Action.vue'
import Conversion from './pages/Conversion.vue'
import Ad from './pages/Ad.vue'
import NotFound from './pages/NotFound.vue'

// VueRouterプラグインを使用する
Vue.use(VueRouter);

// パスとコンポーネントのマッピング
const routes = [{
    path: '/report',
    component: Index,
    name: 'index',
  },
  {
    path: '/report/user',
    component: User,
    name: 'User'
  },
  {
    path: '/report/inflow',
    component: Inflow,
    name: 'Inflow'
  },
  {
    path: '/report/action',
    component: Action,
    name: 'Action'
  },
  {
    path: '/report/conversion',
    component: Conversion,
    name: 'Conversion'
  },
  {
    path: '/report/ad',
    component: Ad,
    name: 'Ad'
  },
  {
    path: '*',
    component: NotFound
  }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
  mode: 'history',
  routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
