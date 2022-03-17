<template>
  <section class="content-header">
    <b-container fluid>
      <b-row class="mb-2">
        <b-col col sm="6">
          <h1>{{ meta.title }}</h1>
        </b-col>
        <b-col col sm="6" v-if="breadcrumbs.length">
          <b-breadcrumb class="float-sm-right">
            <component
              v-for="(br, i) of breadcrumbs"
              :key="i"
              :is="'b-breadcrumb-item'"
              :to="br.to"
              :active="br.active"
              active-class="active"
              >{{ br.title }}</component
            >
          </b-breadcrumb>
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>
import { BContainer, BRow, BCol, BBreadcrumb, BBreadcrumbItem } from 'bootstrap-vue'
export default {
  components: { BContainer, BRow, BCol, BBreadcrumb, BBreadcrumbItem },
  computed: {
    breadcrumbs() {
      return this.$route.meta?.breadcrumbs || []
    },
    meta() {
      return this.$route.meta || {}
    },
  },
}
</script>