<template lang="html">
  <main>
    <sidebar></sidebar>
    <div class="main-right">
      <breadcrumb></breadcrumb>
      <div class="filters">
        <div class="filter">
          谱元编号：
          <el-input placeholder="请输入谱元编号" v-model="name"></el-input>
        </div>
        <div class="filter">
          起止时间：
          <el-date-picker v-model="startEndTime" type="datetimerange" placeholder="选择时间范围" style="width: 350px;"></el-date-picker>
        </div>
        <el-button-group style="display: inline-block;">
          <el-button type="primary" icon="search">搜索</el-button>
        </el-button-group>
      </div>

      <el-table v-loading="fetching" :data="tasks" stripe border style="width: 100%;">
        <el-table-column prop="id" label="ID" width="80"></el-table-column>
        <el-table-column prop="name" label="任务名称"></el-table-column>
        <el-table-column prop="pipeline_id" label="技术路线"></el-table-column>
      </el-table>

      <div class="pagination">
        <el-pagination @current-change="navigate" :current-page="pagination.current_page" :page-size="pagination.per_page" layout="total, prev, pager, next, jumper" :total="pagination.total"></el-pagination>
      </div>
    </div>
  </main>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import Sidebar from './sidebar'
export default {
  components: {
    Sidebar
  },
  data () {
    return {
      name: '',
      startEndTime: []
    }
  },
  computed: {
    ...mapState({
      tasks: state => state.Projects.tasks,
      pagination: state => state.Projects.tasks_pagination,
      fetching: state => state.fetching
    })
  },
  mounted () {
    this.fetch()
  },
  methods: {
    ...mapActions(['tasksSetData']),
    fetch () {
      this.$http.get('tasks')
      .then(({ data }) => {
        this.tasksSetData({
          tasks: data.data,
          tasks_pagination: data.meta.pagination
        })
      })
    },
    navigate (page) {
      this.$router.push({
        name: 'tasks.index',
        query: {
          page
        }
      })
    }
  }
}
</script>

<style>
  .text {
    font-size: 14px;
  }

  .item {
    padding: 18px 0;
  }

  .clearfix:before,
  .clearfix:after {
      display: table;
      content: "";
  }
  .clearfix:after {
      clear: both
  }

  .box-card {
    width: 480px;
  }
</style>
