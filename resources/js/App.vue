<template>
  <component id="app" :is="layout">
    <vue-page-transition name="fade">
      <router-view />
    </vue-page-transition>
  </component>
</template>

<script>
import LayoutFull from '@/@core/components/layouts/Full.vue'
import LayoutMain from '@/@core/components/layouts/Main.vue'
import LayoutMainFull from '@/@core/components/layouts/MainFull.vue'

export default {
  components: {
    LayoutFull,
    LayoutMain,
    LayoutMainFull,
  },
  computed: {
    layout() {
      if (!this.$store.getters['auth/isAuthenticated']) return 'layout-full'
      if (this.$route.meta?.layout == 'main') return 'layout-main'
      if (this.$route.meta?.layout == 'main-full') return 'layout-main-full'
      return 'layout-full'
    },
  },
}
</script>