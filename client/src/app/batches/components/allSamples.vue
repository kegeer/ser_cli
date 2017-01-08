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
        <el-button-group style="display: inline-block;">
          <el-button type="primary" icon="search">搜索</el-button>
        </el-button-group>
      </div>

      <el-table v-loading="fetching" :data="samples" stripe border style="width: 100%;">
        <el-table-column prop="id" label="ID" width="80"></el-table-column>
        <el-table-column prop="py_num" label="谱元编号"></el-table-column>
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
      name: ''
    }
  },
  computed: {
    ...mapState({
      samples: state => state.Batches.samples,
      pagination: state => state.Batches.samples_pagination,
      fetching: state => state.fetching
    })
  },
  mounted () {
    this.fetch()
  },
  methods: {
    ...mapActions(['samplesSetData']),
    fetch () {
      this.$http.get('samples')
      .then(({ data }) => {
        this.samplesSetData({
          samples: data.data,
          samples_pagination: data.meta.pagination
        })
      })
    },
    navigate (page) {
      this.$router.push({
        name: 'samples.index',
        query: {
          page
        }
      })
    }
  }
}
</script>

<style lang="css">
</style>
