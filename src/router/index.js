import Vue from 'vue'
import VueRouter from 'vue-router'

import routes from './routes'

Vue.use(VueRouter)

/*
 * If not building with SSR mode, you can
 * directly export the Router instantiation
 */
function authCheck () {
  return authUser() && authToken()
}

function authUser () {
  return JSON.parse(window.localStorage.getItem('user'))
}

function authToken () {
  return JSON.parse(window.localStorage.getItem('token'))
}

export default function ({ store }) {
  const Router = new VueRouter({
    scrollBehavior: () => ({ y: 0 }),
    routes,

    // Leave these as is and change from quasar.conf.js instead!
    // quasar.conf.js -> build -> vueRouterMode
    mode: process.env.VUE_ROUTER_MODE,
    base: process.env.VUE_ROUTER_BASE
  })

  Router.beforeEach((to, from, next) => {
    if (authCheck() && to.path === '/') {
      next({path: '/crm'})
    } else if (to.meta.requiresAuth) {
      if (!authUser() || !authToken()) {
        next({path: '/'})
      }
    } else {
      store.commit('crm/updatePageMeta', to.meta)
    }

    next()
  })

  return Router
}
