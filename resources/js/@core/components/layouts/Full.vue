<template>
  <vue-page-transition name="fade">
    <router-view />
  </vue-page-transition>
</template>

<script>
export default {
  mounted() {
    document.body.classList.add('full-page')
  },
  beforeDestroy() {
    document.body.classList.remove('full-page')
  },
}
</script>