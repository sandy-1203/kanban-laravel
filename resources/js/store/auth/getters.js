import _ from 'lodash'

export default {
  getState(store) {
    return key => _.get(store, key)
  },
  currentUser(state) {
    return state.user
  },
  isAuthenticated(state) {
    return state.isAuthenticated
  },
}
