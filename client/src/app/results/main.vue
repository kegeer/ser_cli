<template>
<main>
  <div class="main-left">
    <el-menu default-active="/active" class="el-menu-vertical-demo" :router="true">
      <el-menu-item index="/active">所有结果</el-menu-item>
    </el-menu>
  </div>

  <div class="main-right">
    <breadcrumb></breadcrumb>
    <div class="filters">
      <div class="filter">
        谱元编号
        <el-input placeholder="请输入谱元编号" v-model="name"></el-input>
      </div>
      <el-button-group style="display: inline-block;">
        <el-button type="primary" @click="search" icon="search">搜索</el-button>
      </el-button-group>
    </div>

    <el-table v-loading="fetching" :data="results" stripe border style="width: 100%;">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="sample_id" label="样品ID"></el-table-column>
      <el-table-column prop="product" label="产品类型"></el-table-column>
      <el-table-column prop="major" label="合作方"></el-table-column>
      <el-table-column prop="sub" label="报告版本"></el-table-column>
      <el-table-column prop="created_at" label="结果生成日期"></el-table-column>
      <el-table-column inline-template label="操作" width="180">
        <div>
          <el-button @click="show($index)" type="primary" icon="plus" size="mini">
          </el-button>
          <el-button @click="askRemove($index)" type="warning" icon="delete" size="mini">
          </el-button>
        </div>
      </el-table-column>
    </el-table>

    <div class="pagination">
      <el-pagination @current-change="navigate" :current-page="pagination.current_page" :page-size="pagination.per_page" layout="total, prev, pager, next, jumper" :total="pagination.total"></el-pagination>
    </div>
  </div>
</main>
</template>

<script>
import { mapState, mapActions } from 'vuex'
export default {
  data () {
    return {
      name: '',
      active: false
    }
  },
  mounted () {
    this.fetch()
  },
  computed: {
    ...mapState({
      results: state => state.Results.results,
      pagination: state => state.Results.results_pagination,
      fetching: state => state.fetching
    }),
    currentPage () {
      return parseInt(this.$route.query.page, 10) || 1
    }
  },
  watch: {
    currentPage: 'fetch'
  },
  methods: {
    ...mapActions(['setFetching', 'resultsSetData']),
    fetch () {
      this.setFetching({
        fetching: true
      })
      this.$http.get(`results?page=${this.currentPage}`)
        .then(({
          data
        }) => {
          this.resultsSetData({
            results: data.data,
            results_pagination: data.meta.pagination
          })
          this.setFetching({
            fetching: false
          })
        })
    },
    search () {
      console.log('search')
    },
    show (index) {
      const { id } = this.results[index]
      this.$router.push({
        name: 'results.show',
        params: {
          id
        }
      })
    },
    askRemove (index) {
      const result = this.results[index]
      this.$confirm('确认删除记录吗？', '提示', {
        type: 'warning'
      }).then(() => {
        this.$http.delete(`results/${result.id}`)
          .then(() => {
            this.fetch()
            this.$notify({
              title: '成功',
              message: '删除成功',
              type: 'success'
            })
          })
          .catch((error) => {
            this.$notify({
              title: '糟糕',
              message: error.response.data.messages[0],
              type: 'error'
            })
          })
      })
    },
    navigate (page) {
      this.$router.push({
        name: 'results.index',
        query: {
          page
        }
      })
    }
  }
}
</script>
