import Vue from 'vue'
import VueRouter from 'vue-router'
import Book from '../views/Book.vue'
Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Book',
    component: Book
  },
  // {
  //   path: '/book',
  //   name: 'Book',
  //   component: Book
  // },
  {
    path: '/hustmaths',
    name: 'Home',
    meta: {
      requireAuth: true
    },
    component: () => import('../views/Home.vue')
  },
  {
    path: '/search',
    name: 'Search',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/Search.vue')
  },
  {
    path:"/login",
    name:"Login",
    component :()=>import('../views/Login.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: "/books/",
  routes
})

export default router
