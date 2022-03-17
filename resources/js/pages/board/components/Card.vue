<template>
  <b-card header-bg-variant="info" header-text-variant="white" border-variant="info">
    <template #header>
      <b-card-title>{{ card.title }}</b-card-title>
      <b-button-group size="sm" class="float-right">
        <b-button variant="warning" class="btn-icon" @click.prevent="$emit('edit', card)">
          <font-awesome-icon icon="pen" />
        </b-button>
        <b-button variant="danger" class="btn-icon" @click.prevent="$emit('delete', card)">
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
}
</script>