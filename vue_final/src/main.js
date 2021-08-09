import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import axios from 'axios'

Vue.prototype.$axios = axios;
Vue.config.productionTip = false

router.beforeEach((to, from, next) => {
  //判断是否需要登录
  if (to.meta.requireAuth) {
    //判断是否登录 
    if (store.state.isLogin) {
      next();
    } else {
      next({
        path: '/login',
        query: {
          redirect: to.fullPath,
        }
      })
    }
  }else {
    next();
  }
})



new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
