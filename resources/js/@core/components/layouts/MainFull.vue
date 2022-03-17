<template>
  <div class="wrapper">
    <nav-bar full />
    <page class="kanban" full>
      <template #default>
        <vue-page-transition name="fade">
          <router-view />
        </vue-page-transition>
      </template>
    </page>
    <a-footer full />
  </div>
</template>

<script>
import NavBar from '@/@core/components/navbar/NavBar.vue'
import Page from '@/@core/components/page/Page.vue'
import AFooter from '@/@core/components/footer/Footer.vue'

export default {
  components: {
    NavBar,
    Page,
    AFooter,
  },
  mounted() {
    document.body.classList.add('sidebar-mini', 'layout-fixed')
  },
  beforeDestroy() {
    document.body.classList.remove('sidebar-mini', 'layout-fixed')
  },
}
</script>