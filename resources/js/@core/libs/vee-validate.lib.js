import Vue from 'vue'
import { ValidationObserver, ValidationProvider, extend } from 'vee-validate'

import * as rules from 'vee-validate/dist/rules'

for (const rule in rules) extend(rule, rules[rule])

Vue.component('validation-observer', ValidationObserver)
Vue.component('validation-provider', ValidationProvider)
