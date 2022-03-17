<template>
  <footer class="main-footer" :class="{ full }">
    <div class="float-right d-none d-sm-block"><b>Version</b> 3.2.0</div>
    <strong>Copyright © 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</template>

<script>
export default {
  props: {
    full: {
      type: Boolean,
      default: false,
    },
  },
}
</script>


<style lang="scss" scoped>
.main-footer {
  &.full {
    margin-left: 0px !important;
  }
}
</style>