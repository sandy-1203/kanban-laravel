<template>
  <li class="nav-item" :class="{ 'menu-is-opening menu-open': open }">
    <component :is="link" :to="to" class="nav-link" @click="open = !open">
      <font-awesome-icon class="nav-icon" :icon="icon" />
      <p>
        {{ title }}
        <font-awesome-icon v-if="subItems.length" class="right" icon="angle-left" />
      </p>
    </component>
    <transition v-if="subItems.length" name="fade">
      <side-bar-item-group v-show="open" :items="subItems" class="nav-treeview" />
    </transition>
  </li>
</template>

<script>
export default {
  components: { SideBarItemGroup: () => import('@/@core/components/sidebar/SideBarItemGroup.vue') },
  props: {
    title: {
      type: String,
      required: true,
    },
    icon: {
      type: String,
      required: true,
    },
    to: {
      type: [String, Object],
      default: null,
    },
    subItems: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return { open: false }
  },
  computed: {
    link() {
      if (this.to) return 'router-link'
      return 'a'
    },
  },
}
</script>
<style lang="scss" scoped>
@import 'vue2-animate/src/sass/vue2-animate.scss';
</style>