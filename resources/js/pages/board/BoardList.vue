<template>
  <b-card>
    <b-container fluid>
      <data-table ref="boardTable" :provider="boardDataTable" :columns="columns">
        <template #cell(user)="{ item }">
          {{ item.user.name }}
        </template>
        <template #cell(action)="{ item }">
          <b-button-toolbar>
            <router-link :to="{ name: 'view-board', params: { id: item.id } }" class="mr-2 btn btn-warning btn-sm">
              <font-awesome-icon icon="file-invoice" />
            </router-link>
            <!-- <b-button variant="danger" size="sm" @click.prevent="remove(item)">
              <font-awesome-icon icon="trash" />
            </b-button> -->
          </b-button-toolbar>
        </template>
      </data-table>
    </b-container>
  </b-card>
</template>

<script>
import DataTable from '@/@core/components/datatable/DataTable.vue'
import { mapActions } from 'vuex'
export default {
  components: { DataTable },
  data() {
    return {
      columns: [
        { key: 'name', label: 'SKU', sortable: true },
        { key: 'user', label: 'user', sortable: true },
        { key: 'action', label: 'Action', sortable: false },
      ],
    }
  },
  methods: {
    ...mapActions('kanban', { boardDataTable: 'boardDataTable', deleteBoard: 'deleteBoard' }),
    remove(item) {
      if (confirm('Are you sure you want to delete this?')) {
        this.$apiHandler.apiResponseWrapper(async () => {
          const res = await this.deleteBoard(item.id)
          this.$refs.boardTable.refresh()
          return res
        })
      }
    },
  },
}
</script>