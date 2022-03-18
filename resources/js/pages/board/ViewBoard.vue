<template>
  <b-row>
    <b-col cols="12">
      <b-container fluid class="float-left">
        <column v-for="(column, i) of columns" :key="i" :column="column" />
        <add-column />
      </b-container>
    </b-col>
    <b-col cols="12">
      <b-button class="float-right fixed-bottom-right" variant="success" @click.prevent="exportDB">Export DB</b-button>
    </b-col>
  </b-row>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

import AddColumn from '@/pages/board/components/AddColumn.vue'
import Column from '@/pages/board/components/Column.vue'

export default {
  components: {
    AddColumn,
    Column,
  },
  computed: {
    ...mapGetters('kanban', { board: 'board' }),
    columns() {
      return this.board.columns || []
    },
  },
  mounted() {
    this.getBoardById(this.$route.params.id).catch(() => {
      this.$router.push({
        name: 'home',
      })
    })
  },
  methods: {
    ...mapActions('kanban', { getBoardById: 'getBoardById', exportDB: 'exportDB' }),
  },
}
</script>

<style lang="scss">
.btn {
  &.fixed-bottom-right {
    position: fixed;
    bottom: 4rem !important;
    right: 10px !important;
  }
}
</style>