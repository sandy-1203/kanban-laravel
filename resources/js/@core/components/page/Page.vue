<template>
  <div class="content-wrapper" :class="{ full }">
    <page-header />
    <section class="content">
      <slot />
    </section>
  </div>
</template>

<script>
import PageHeader from '@/@core/components/page/PageHeader.vue'
export default {
  components: { PageHeader },
  props: {
    full: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style lang="scss" scoped>
.content-wrapper {
  &.full {
    margin-left: 0px !important;
  }
}
</style>