<template lang="html">
  <div class="main-left">
    <el-menu class="el-menu-vertical-demo" :router="true">
      <el-menu-item index="/projects">所有项目</el-menu-item>
      <el-menu-item index="/tasks">所有任务</el-menu-item>
      <el-menu-item index="/manager">负责人管理</el-menu-item>
    </el-menu>
  </div>
</template>

<script>
export default {
}
</script>
