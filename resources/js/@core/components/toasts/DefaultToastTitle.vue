<template>
  <div>
    <font-awesome-icon class="mr-2" :icon="icon" />
    <strong class="mr-auto">{{ title }}</strong>
    <small v-if="subtitle"> {{ subtitle }} </small>
  </div>
</template>
<script>
export default {
  props: {
    title: {
      type: String,
      required: true,
    },
    icon: {
      type: String,
      required: true,
    },
    subtitle: {
      type: String,
      default: '',
    },
  },
}
</script>