<template>
  <main>
    <div class="main-left">
      <el-menu default-active="/active" class="el-menu-vertical-demo" :router="true">
        <el-menu-item index="/experiments/splits">样品分装</el-menu-item>
        <el-menu-item index="/experiments/extractions">核酸提取</el-menu-item>
        <el-menu-item index="/experiments/dilutions">模板稀释</el-menu-item>
        <el-menu-item index="/experiments/distributions">样品分布</el-menu-item>
        <el-menu-item index="/experiments/analysises">产物分析</el-menu-item>
        <el-menu-item index="/experiments/poolings">产物Pooling</el-menu-item>
        <el-menu-item index="/experiments/libraries">文库构建</el-menu-item>
        <el-menu-item index="/experiments/sequences">上机测序</el-menu-item>
      </el-menu>
    </div>

    <div class="main-right">
      <transition name="fade">
        <router-view class="view"></router-view>
      </transition>
    </div>
  </main>
</template>
<script>
  export default {
    data () {
      return {
      }
    },
    methods: {
    }
  }
</script>
