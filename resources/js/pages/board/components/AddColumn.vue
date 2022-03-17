<template>
  <b-card class="card-row" header-bg-variant="secondary" no-body>
    <template #header>
      <b-form @submit.prevent="onSubmit">
        <b-input-group>
          <template #append>
            <b-button type="submit" variant="success" class="btn-icon">
              <font-awesome-icon icon="plus" />
            </b-button>
          </template>
          <b-form-input placeholder="Title" v-model="form.title" required />
        </b-input-group>
      </b-form>
    </template>
  </b-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  data() {
    return {
      form: {
        title: null,
      },
    }
  },
  computed: {
    ...mapGetters('kanban', { board: 'board' }),
  },
  methods: {
    ...mapActions('kanban', { createColumn: 'createColumn' }),
    onSubmit() {
      this.$apiHandler.apiResponseWrapper(async () => {
        const res = await this.createColumn({
          ...this.form,
          board_id: this.board.id,
        })
        this.form.title = null
        return res
      })
    },
  },
}
</script>