import _ from 'lodash'

export default {
  setState(state, payload) {
    if (_.isArray(payload)) {
      payload.forEach(item => {
        _.set(state, item.key, item.value)
      })
    } else {
      _.set(state, payload.key, payload.value)
    }
  },
  setAuth(state, { user, accessToken }) {
    state.isAuthenticated = true
    state.user = user
    this._vm.$jwt.setToken(accessToken)
  },
  setError(state, error) {
    state.errors = error
  },
  purgeAuth(state) {
    state.isAuthenticated = false
    state.user = {}
    state.errors = {}
    this._vm.$jwt.clearToken()
  },
}
