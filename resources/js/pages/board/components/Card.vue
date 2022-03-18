<template>
  <b-card header-text-variant="dark" body-text-variant="dark" @click="$emit('edit', card)" :style="{ cursor: 'pointer' }">
    <template #header>
      <b-card-title class="text-bold">{{ card.title }}</b-card-title>
      <b-button-group size="sm" class="float-right">
        <!-- <b-button variant="warning" class="btn-icon" @click.prevent="$emit('edit', card)" :style="{ fontSize: '0.6rem' }">
          <font-awesome-icon icon="pen" />
        </b-button> -->
        <b-button variant="danger" class="btn-icon" @click.prevent="handleDelete" :style="{ fontSize: '0.6rem' }">
          <font-awesome-icon icon="trash" />
        </b-button>
      </b-button-group>
    </template>
    {{ card.description }}
  </b-card>
</template>

<script>
export default {
  props: {
    card: {
      type: Object,
      required: true,
    },
  },
  methods: {
    handleDelete(e) {
      e.stopPropagation()
      if (confirm('Are you sure want to delete this?')) {
        this.$emit('delete', this.card)
      }
    },
  },
}
</script>