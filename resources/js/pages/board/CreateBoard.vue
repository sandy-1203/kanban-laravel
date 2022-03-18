<template>
  <b-card>
    <b-container fluid>
      <b-row>
        <b-col sm="12" md="4">
          <validation-observer ref="boardForm" v-slot="{ handleSubmit, invalid }">
            <b-form @submit.prevent="handleSubmit(onSubmit)">
              <validation-provider rules="required" name="Name" vid="name" v-slot="{ errors }">
                <b-form-group label="Name" class="mb-3" :state="!errors.length" :invalid-feedback="errors[0]">
                  <b-form-input v-model="form.name" placeholder="Name" :class="{ 'is-invalid': errors.length }" />
                </b-form-group>
              </validation-provider>
              <b-row>
                <b-col>
                  <b-button type="submit" variant="primary" :disabled="invalid">Create</b-button>
                </b-col>
              </b-row>
            </b-form>
          </validation-observer>
        </b-col>
      </b-row>
    </b-container>
  </b-card>
</template>

<script>
import { mapActions, mapMutations, mapState } from 'vuex'
export default {
  components: {},
  data() {
    return {}
  },
  computed: {
    ...mapState('kanban', { form: 'board' }),
  },
  methods: {
    ...mapActions('kanban', { createBoard: 'createBoard' }),
    ...mapMutations('kanban', { resetBoard: 'resetBoard' }),
    onSubmit() {
      this.$apiHandler.apiResponseWrapper(async () => {
        const res = await this.createBoard(this.form)
        this.resetBoard()
        this.$router.push({
          name: 'board-list',
        })
        return res
      }, this.$refs.boardForm)
    },
  },
  beforeDestroy() {
    this.resetBoard()
  },
}
</script>