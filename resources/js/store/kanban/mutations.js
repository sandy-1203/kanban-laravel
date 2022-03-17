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
  updateColumn(state, { id, data }) {
    let columns = _.get(state, 'board.columns', [])
    const columnIndex = columns.findIndex(c => c.id == id)
    const columnKey = `[${columnIndex}]`
    columns = _.set(columns, columnKey, _.merge(_.get(columns, columnKey, {}), data))
    _.set(state, 'board.columns', [...columns])
  },
  deleteColumn(state, id) {
    const columns = _.get(state, 'board.columns', [])
    _.set(
      state,
      'board.columns',
      columns.filter(i => i.id != id),
    )
  },
  upsertCard(state, data) {
    const columnKey = 'board.columns'
    let columns = _.get(state, columnKey, []) || []
    const columnIndex = columns.findIndex(c => c.id == data.column_id)
    if (columnIndex == -1) return
    const key = `[${columnIndex}].cards`
    const cards = _.get(state, `${columnKey}${key}`, []) || []
    const cardIndex = cards.findIndex(c => c.id == data.id)
    if (cardIndex == -1) {
      columns = _.set(columns, key, [...cards, data])
    } else {
      columns = _.set(columns, `${key}[${cardIndex}]`, data)
    }
    _.set(state, columnKey, [...columns])
  },
  removeCard(state, { column_id, card_id }) {
    const columnKey = 'board.columns'
    let columns = _.get(state, columnKey, []) || []
    const columnIndex = columns.findIndex(c => c.id == column_id)
    if (columnIndex == -1) return
    const key = `[${columnIndex}].cards`
    const cards = _.get(state, `${columnKey}${key}`, []) || []
    columns = _.set(
      columns,
      key,
      cards.filter(i => i.id != card_id),
    )
    _.set(state, columnKey, [...columns])
  },
  moveCard(state, { card: { id: card_id, column_id: old_column_id }, data: { column_id: new_column_id, newIndex } }) {
    const columnKey = 'board.columns'
    let columns = _.get(state, columnKey, []) || []
    const oldColumnIndex = columns.findIndex(i => i.id == old_column_id)
    const oldColumn = _.get(columns, `[${oldColumnIndex}]`, {}) || {}
    const oldColumnCards = _.get(oldColumn, `cards`, []) || []
    const oldColumnCardIndex = oldColumnCards.findIndex(i => i.id == card_id)
    const card = { ...oldColumnCards[oldColumnCardIndex] }
    oldColumnCards.splice(oldColumnCardIndex, 1)
    _.set(oldColumn, 'cards', [...oldColumnCards])
    _.set(columns, `[${oldColumnIndex}]`, oldColumn)
    const newColumnIndex = columns.findIndex(i => i.id == new_column_id)
    const newColumn = _.get(columns, `[${newColumnIndex}]`, {}) || {}
    const newColumnCards = _.get(newColumn, `cards`, []) || []
    newColumnCards.splice(newIndex, 0, { ...card, column_id: new_column_id })
    _.set(newColumn, 'cards', [...newColumnCards])
    _.set(columns, `[${newColumnIndex}]`, newColumn)
    _.set(state, 'columns', [...columns])
  },
}
