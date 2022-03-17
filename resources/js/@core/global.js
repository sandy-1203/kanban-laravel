import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VuePageTransition from 'vue-page-transition'
import jwtPlugin from '@/@core/plugins/jwt.plugin'
import apiPlugin from '@/@core/plugins/api.plugin'
import toastPlugin from '@/@core/plugins/toast.plugin'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// NOTE: Register font-awesome icons
library.add(fas)
Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.use(jwtPlugin)
Vue.use(apiPlugin)
Vue.use(BootstrapVue)
Vue.use(toastPlugin)
Vue.use(VuePageTransition)

import '@/@core/libs/vee-validate.lib'
