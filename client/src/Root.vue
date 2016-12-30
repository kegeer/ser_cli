<template lang="html">
  <div id="app">
    <header class="header" :class="{ 'header-fixed': 'headerFixed'}">
      <el-row>
        <el-col :span="24">
          <el-menu default-active='samples' class="el-menu-demo" mode="horizontal" @select="handleSelect">
            <el-menu-item index="/batches">样品录入</el-menu-item>
            <el-menu-item index="/projects">项目管理</el-menu-item>
            <el-menu-item index="/pipelines">技术路线管理</el-menu-item>
            <el-menu-item index="/experiments">实验管理</el-menu-item>
            <el-menu-item index="/qcs">数据审核</el-menu-item>
            <el-menu-item index="/results">结果管理</el-menu-item>
          </el-menu>
        </el-col>
      </el-row>
    </header>

    <div v-show="headerFixed" style="position: relative;height: 60px; width: 100%;"></div>
    <transition name="fade">
      <router-view class="view"></router-view>
    </transition>

  </div>
</template>

<script>
export default {
  data () {
    return {
      headerFixed: true,
      active: true
    }
  },
  methods: {
    handleSelect (key, keyPath) {
      console.log(key, keyPath)
      this.$router.push({
        path: key
      })
    }
  }
}
</script>

<style lang="css">

</style>
