<template>
  <ul v-if="items.length" class="nav">
    <side-bar-item v-for="({ title, icon, subItems, to }, i) of items" :key="i" :title="title" :icon="icon" :to="to" :subItems="subItems" />
  </ul>
</template>

<script>
export default {
  components: {
    SideBarItem: () => import('@/@core/components/sidebar/SideBarItem.vue'),
  },
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
}
</script>