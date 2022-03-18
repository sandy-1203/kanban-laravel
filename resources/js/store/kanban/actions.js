export default {
  async createColumn({ commit, state }, payload) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.post('/column', payload)).data
      commit('setState', [
        {
          key: 'loading',
          value: true,
        },
        {
          key: 'board.columns',
          value: [...(state.board?.columns || []), { ...res.data, cards: [] }],
        },
      ])
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },
  async updateColumn({ commit }, { id, data }) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.post(`/column/${id}`, data)).data
      commit('setState', [
        {
          key: 'loading',
          value: true,
        },
      ])
      commit('updateColumn', { id, data })
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },
  async getBoardById({ commit }, id) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.get(`/board/${id}`)).data
      commit('setState', [
        {
          key: 'loading',
          value: true,
        },
        {
          key: 'board',
          value: res.data,
        },
      ])
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },

  async deleteColumn({ commit }, id) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.delete(`/column/${id}`)).data
      commit('setState', {
        key: 'loading',
        value: true,
      })
      commit('deleteColumn', id)
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },
  async upsertCard({ commit }, payload) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.post('/card/upsert', payload)).data
      commit('setState', {
        key: 'loading',
        value: true,
      })
      commit('upsertCard', res.data)
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },
  async deleteCard({ commit }, { column_id, card_id }) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.delete(`/card/${card_id}`)).data
      commit('setState', {
        key: 'loading',
        value: true,
      })
      commit('removeCard', { column_id, card_id })
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },

  async moveCard({ commit }, { card, data }) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.post(`/card/${card.id}/move`, data)).data
      commit('setState', {
        key: 'loading',
        value: true,
      })
      commit('moveCard', { card, data })
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },
  exportDB() {
    this._vm.$api.get(`/export-db`, {
      responseType: 'blob',
    })
  },
  async createBoard({ commit }, payload) {
    commit('setState', {
      key: 'loading',
      value: true,
    })
    try {
      const res = (await this._vm.$api.post('/board', payload)).data
      commit('setState', {
        key: 'loading',
        value: true,
      })
      commit('resetBoard')
      return res
    } catch (err) {
      commit('setState', {
        key: 'loading',
        value: false,
      })
      throw err
    }
  },
  async deleteBoard(_, id) {
    return (await this._vm.$api.delete(`/board/${id}`)).data
  },
  async boardDataTable(_, params) {
    return (await this._vm.$api.post('/board/list', params, { cancelToken: 'DATATABLE' })).data.data
  },
}
