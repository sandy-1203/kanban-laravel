<template>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <router-link :to="{ name: 'home' }" class="brand-link">
      <img
        :src="require('@/@core/assets/img/AdminLTELogo.png')"
        alt="AdminLTE Logo"
        class="brand-image img-circle elevation-3"
        style="opacity: 0.8"
      />
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </router-link>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img :src="require('@/@core/assets/img/user2-160x160.jpg')" class="img-circle elevation-2" alt="User Image" />
        </div>
        <div class="info">
          <a href="#" class="d-block"> {{ user.name }} </a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <side-bar-item v-for="(item, i) of list" :key="i" v-bind="item" />
        </ul>
      </nav>
    </div>
  </aside>
</template>

<script>
import { mapGetters } from 'vuex'
import SideBarItem from '@/@core/components/sidebar/SideBarItem.vue'
export default {
  components: {
    SideBarItem,
  },
  data() {
    return {
      list: [
        {
          title: 'Manage Boards',
          icon: 'tachometer-alt',
          to: { name: 'board-list' },
        },
        {
          title: 'Create Board',
          icon: 'tachometer-alt',
          to: { name: 'create-board' },
        },
      ],
    }
  },
  computed: {
    ...mapGetters('auth', { user: 'currentUser' }),
  },
}
</script>