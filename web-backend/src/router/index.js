import Vue from 'vue'
import Router from 'vue-router'
import Auth from '../auth'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

NProgress.configure({ showSpinner: false })

Vue.use(Router)

const routes = [
  {
    path: '/',
    name: 'Home',
    redirect: '/dashboard',
    component: resolve => require(['../layout/index.vue'], resolve),
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: resolve => require(['../pages/dashboard/index.vue'], resolve),
      },
      {
        path: '/products',
        name: 'Products',
        component: resolve => require(['../pages/product/index.vue'], resolve),
      },
      {
        path: '/collections',
        name: 'Collections',
        component: resolve => require(['../pages/collection/index.vue'], resolve),
      },
      {
        path: '/collections/create',
        name: 'Create Collection',
        component: resolve => require(['../pages/collection/create.vue'], resolve),
      },
      {
        path: '/collections/edit/:id',
        name: 'Edit Collection',
        component: resolve => require(['../pages/collection/edit.vue'], resolve),
      },      
    ]
  },
  {
    path: '/login',
    component: resolve => require(['../pages/login/index.vue'], resolve),
    meta: {
      noNeedLogin: true
    }
  },
  // {
  //   path: '*',
  //   redirect: '/404'
  // }
]

const router = new Router({
  routes: routes
})

router.beforeEach((to, from, next) => {
  NProgress.start()
  // page title
  if (to.name) {
    document.title = to.name
  }  
  let token = Auth.getToken()
  if (token) {
    next()
    NProgress.done();
  } else {
    router.push({path: '/login'})
  } 
  
})

export default router
