export default {
  async signIn({ commit }, payload) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.post('/auth/sign-in', payload)).data
      commit('setState', {
        key: 'loading',
        value: false,
      })
      commit('setAuth', {
        user: res.data.user,
        accessToken: res.data.access_token,
      })
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },
  async signUp({ commit }, payload) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.post('/auth/sign-up', payload)).data
      commit('setState', {
        key: 'loading',
        value: false,
      })
      commit('setAuth', {
        user: res.data.user,
        accessToken: res.data.access_token,
      })
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },
  async logout({ commit }) {
    // await this.$api.post('/auth/delete')
    commit('purgeAuth')
  },
  async verifyAuth({ commit, state }) {
    const _vm = this._vm
    if (!state.isAuthenticated && _vm.$jwt.getToken()) {
      try {
        const res = (await _vm.$api.get('/auth/profile')).data
        commit('setAuth', {
          user: res.data.user,
          accessToken: _vm.$jwt.getToken(),
        })
        return true
      } catch ({ response }) {
        commit('purgeAuth')
        return false
      }
    } else if (!_vm.$jwt.getToken()) {
      commit('purgeAuth')
      return false
    }
    return true
  },
}
