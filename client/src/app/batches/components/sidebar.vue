<template lang="html">
  <div class="main-left">
    <el-menu class="el-menu-vertical-demo" :router="true">
      <el-menu-item index="/batches">批次管理</el-menu-item>
      <el-menu-item index="/samples">样品管理</el-menu-item>
    </el-menu>
    <el-menu default-active="2" class="el-menu-vertical-demo">
      <el-submenu index="1">
        <template slot="title">额外信息</template>
          <el-menu-item index="/store_locations">存放位置管理</el-menu-item>
          <el-menu-item index="/recipients">收样人管理</el-menu-item>
          <el-menu-item index="/clients">样品源管理</el-menu-item>
          <el-menu-item index="/consumers">消费者管理</el-menu-item>
      </el-submenu>
    </el-menu>
  </div>

</template>

<script>
export default {
}
</script>
