<template>
  <b-modal v-model="modelValue" hide-footer>
    <template #title> Card </template>
    <b-form @submit.prevent="$emit('submit', localCard)">
      <b-form-group label="Title">
        <b-form-input v-model="localCard.title" placeholder="Title" @change="$emit('update:card', localCard)" />
      </b-form-group>
      <b-form-group label="Description">
        <b-textarea v-model="localCard.description" placeholder="Description" @change="$emit('update:card', localCard)" />
      </b-form-group>
      <b-button type="submit" variant="success">Save</b-button>
    </b-form>
  </b-modal>
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      default: false,
    },
    card: {
      type: Object,
      default: null,
    },
  },
  data() {
    return {
      localCard: this.card || {
        title: null,
        description: null,
      },
    }
  },
  computed: {
    modelValue: {
      get() {
        return this.value
      },
      set(value) {
        this.$emit('input', value)
      },
    },
  },
  watch: {
    card() {
      this.localCard = this.card || {
        title: null,
        description: null,
      }
    },
  },
}
</script>