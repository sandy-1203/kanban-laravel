import _ from 'lodash'

export default {
  getState(store) {
    return key => _.get(store, key)
  },
  board(state) {
    return state.board
  },
}
