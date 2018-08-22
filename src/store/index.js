import Vue from 'vue'
import Vuex from 'vuex'

import crm from './crm'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      crm
    }
  })

  if (process.env.DEV && module.hot) {
    module.hot.accept(['./crm'], () => {
      const newCrm = require('./crm').default
      Store.hotUpdate({modules: {crm: newCrm}})
    })
  }
  return Store
}
