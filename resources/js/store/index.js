import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import kanban from './kanban'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    kanban,
  },
  strict: import.meta.env.PROD,
})
