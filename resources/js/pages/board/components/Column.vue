<template>
  <b-card class="card-row" header-bg-variant="secondary">
    <template #header>
      <template v-if="editMode">
        <b-form-group>
          <b-input-group>
            <b-form-input v-model="form.title" placeholder="Title" />
            <template #append>
              <b-button-group size="sm" class="float-right">
                <b-button variant="success" class="btn-icon" @click.prevent="saveColumn">
                  <font-awesome-icon icon="file" />
                </b-button>
                <b-button variant="warning" class="btn-icon" @click.prevent="editMode = false">
                  <font-awesome-icon icon="close" />
                </b-button>
                <b-button variant="danger" class="btn-icon" @click.prevent="clickTrash">
                  <font-awesome-icon icon="trash" />
                </b-button>
              </b-button-group>
            </template>
          </b-input-group>
        </b-form-group>
      </template>
      <template v-else>
        <b-card-title class="text-bold"> {{ column.title }} </b-card-title>
        <b-button-group size="sm" class="float-right">
          <b-button variant="warning" class="btn-icon" @click.prevent="editMode = true" :style="{ fontSize: '0.6rem' }">
            <font-awesome-icon icon="pen" />
          </b-button>
          <b-button variant="danger" class="btn-icon" @click.prevent="clickTrash" :style="{ fontSize: '0.6rem' }">
            <font-awesome-icon icon="trash" />
          </b-button>
        </b-button-group>
      </template>
    </template>
    <draggable :value="cards" class="mb-2" group="cards" @change="change">
      <card v-for="(card, i) of cards" :key="i" :card="card" @edit="editCard" @delete="handleDeleteCard" />
    </draggable>
    <b-button block variant="success" @click.prevent="addNewCard">
      <font-awesome-icon icon="plus" />
    </b-button>
    <add-card v-model="showModel" :card.sync="card" @submit="submitCard" />
  </b-card>
</template>

<script>
import { mapActions } from 'vuex'
import Draggable from 'vuedraggable'

import Card from '@/pages/board/components/Card.vue'
import AddCard from '@/pages/board/components/AddCard.vue'

export default {
  components: {
    Card,
    AddCard,
    Draggable,
  },
  props: {
    column: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      form: {
        title: this.column.title,
      },
      showModel: false,
      editMode: false,
      card: null,
    }
  },
  computed: {
    cards() {
      return this.column.cards || []
    },
  },
  methods: {
    ...mapActions('kanban', {
      deleteColumn: 'deleteColumn',
      upsertCard: 'upsertCard',
      deleteCard: 'deleteCard',
      updateColumn: 'updateColumn',
      moveCard: 'moveCard',
    }),
    clickTrash() {
      if (confirm('Are you sure want to delete this?')) {
        this.$apiHandler.apiResponseWrapper(() => this.deleteColumn(this.column.id))
      }
    },
    addNewCard() {
      this.card = null
      this.showModel = true
    },
    submitCard() {
      this.$apiHandler.apiResponseWrapper(async () => {
        const res = await this.upsertCard({ ...this.card, column_id: this.column.id })
        this.showModel = false
        this.card = null
        return res
      })
    },
    editCard(card) {
      this.card = { ...card }
      this.showModel = true
    },
    handleDeleteCard(card) {
      this.$apiHandler.apiResponseWrapper(() => this.deleteCard({ column_id: this.column.id, card_id: card.id }))
    },
    saveColumn() {
      this.$apiHandler.apiResponseWrapper(async () => {
        const res = await this.updateColumn({ id: this.column.id, data: this.form })
        this.editMode = false
        return res
      })
    },
    async change(e) {
      const event = e?.added || e?.moved
      if (event) {
        this.$apiHandler.apiResponseWrapper(async () => {
          const res = await this.moveCard({ card: event.element, data: { newIndex: event.newIndex, column_id: this.column.id } })
          this.editMode = false
          return res
        })
      }
    },
  },
}
</script>

<style lang="scss" >
.card {
  &.card-row {
    height: fit-content !important;
    > .card-body {
      background-color: #bcbcbc;
    }
  }
}
</style>