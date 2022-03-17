<template>
  <div class="wrapper">
    <nav-bar />
    <side-bar />
    <page>
      <template #default>
        <vue-page-transition name="fade">
          <router-view />
        </vue-page-transition>
      </template>
    </page>
    <a-footer />
  </div>
</template>

<script>
import NavBar from '@/@core/components/navbar/NavBar.vue'
import SideBar from '@/@core/components/sidebar/SideBar.vue'
import Page from '@/@core/components/page/Page.vue'
import AFooter from '@/@core/components/footer/Footer.vue'

export default {
  components: {
    NavBar,
    SideBar,
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