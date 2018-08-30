import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import crm from './crm'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      auth,
      crm
    }
  })

  if (process.env.DEV && module.hot) {
    module.hot.accept(['./auth', './crm'], () => {
      const newAuth = require('./auth').default
      const newCrm = require('./crm').default
      Store.hotUpdate({
        modules: {
          auth: newAuth,
          crm: newCrm
        }
      })
    })
  }
  return Store
}
