<template lang="html">
  <el-breadcrumb separator="/">
    <span class="breadcrumb-loc">位置：</span>
    <el-breadcrumb-item v-for="item in breadcrumbs" :to="item">
      {{ item.name }}
    </el-breadcrumb-item>
  </el-breadcrumb>
</template>

<script>
  export default {
    name: 'breadcrumb',
    data () {
      return {
        breadcrumbs: []
      }
    },
    mounted () {
      this.breadcrumbs = (this.$parent && this.$parent.$router && this.$parent.$router.history && this.$parent.$router.history.current && this.$parent.$router.history.current.matched) || []
    }
  }
</script>
<style>
  .breadcrumb-loc {
    float: left;
  }
</style>
