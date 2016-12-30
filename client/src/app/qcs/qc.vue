<template lang="html">
  <main>
    <div class="main-left">
      <el-menu default-active="/active" class="el-menu-vertical-demo" :router="true">
        <el-menu-item index="/active">所有质控</el-menu-item>
      </el-menu>
    </div>
    <div class="main-right">
      <breadcrumb></breadcrumb>
      <div class="figure">
        <!-- <table style="table">
          <thead>
            <th>Index1</th>
            <th>Index2</th>
            <th>Index3</th>
            <th>Index4</th>
            <th>Index5</th>
            <th>Index6</th>
          </thead>
          <tbody>
            <tr v-for="i in index.index">
              <td>{{ i[0] }}</td>
              <td>{{ i[1] }}</td>
              <td>{{ i[2] }}</td>
              <td>{{ i[3] }}</td>
              <td>{{ i[4] }}</td>
              <td>{{ i[5] }}</td>
            </tr>
            <tr>
              <td>{{ qc.total[0] }}</td>
              <td>{{ qc.total[1] }}</td>
              <td>{{ qc.total[2] }}</td>
              <td>{{ qc.total[3] }}</td>
              <td>{{ qc.total[4] }}</td>
              <td>{{ qc.total[5] }}</td>
            </tr>
          </tbody>
        </table> -->
        <bar-chart></bar-chart>
        <line-chart></line-chart>
        <new-chart></new-chart>
      </div>

    </div>
  </main>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import NewChart from './components/newChart'
import LineChart from './components/lineChart'
import BarChart from './components/barChart'
export default {
  data () {
    return {
    }
  },
  components: {
    NewChart,
    BarChart,
    LineChart
  },
  mounted () {
    this.fetch()
  },
  computed: {
    ...mapState({
      qc: state => state.Qcs.qc
    }),
    index () {
      return this.qc.index
    },
    summary () {
      return this.qc.summary
    }
  },
  methods: {
    ...mapActions(['qcSetData']),
    fetch () {
      this.$http.get(`qcs/${this.$route.params.id}`)
      .then(({ data }) => {
        this.qcSetData({
          qc: data.data
        })
      })
    }
  }
}
</script>

<style lang="css" scoped>
  .figure {
    margin: 0 auto;
    padding: 60px 0;
    max-width: 800px;
  }
  .table {
    border: 2px solid #efefef;
  }
  .table th, .table td {
    padding: 6px 12px;
  }
</style>
