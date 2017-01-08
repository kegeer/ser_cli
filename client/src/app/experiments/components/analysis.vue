z<template>
  <div>
    <breadcrumb></breadcrumb>
    <div class="filters">
      <div class="filter">
        谱元编号：
        <el-input placeholder="请输入谱元编号" v-model="name"></el-input>
      </div>
      <el-button-group style="display: inline-block;">
        <el-button type="primary" @click="search" icon="search">搜索</el-button>
        <el-button @click="askConfirm" type="primary" icon="plus">
          完成
        </el-button>
      </el-button-group>
    </div>


    <el-table v-loading="fetching" :data="analysises" stripe border style="width: 100%;" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="55" @selectable="canConfirm($index)"> </el-table-column>
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="sample_id" label="样品编号">
      </el-table-column>
      <el-table-column prop="status" label="目前状态">
      </el-table-column>
      <el-table-column label="板位分布">
        <el-table-column prop="quality.primer" label="引物" width="120"></el-table-column>
        <el-table-column prop="quality.cycle" label="循环数" width="120"></el-table-column>
        <el-table-column prop="quality.c" label="浓度" width="120"></el-table-column>
        <el-table-column prop="quality.v" label="体积" width="120"></el-table-column>
        <el-table-column prop="quality.e_map" label="电泳结果/电泳图名称" width="120"></el-table-column>
      </el-table-column>
      <el-table-column inline-template label="操作" width="180">
        <div>
          <el-button @click="edit($index)" type="default" icon="edit" size="mini">
          </el-button>
        </div>
      </el-table-column>
    </el-table>

    <div class="pagination">
      <el-pagination @current-change="navigate" :current-page="pagination.current_page" :page-size="pagination.per_page" layout="total, prev, pager, next, jumper" :total="pagination.total"></el-pagination>
    </div>

    <el-dialog title="编辑" v-model="isFormVisible" :close-on-click-modal="false" @close="close">
      <el-form :model="form" label-width="80px" :rules="formRules" ref="form">
        <el-form-item label="引物" prop="primer">
          <el-input v-model.number="form.primer" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="循环数" prop="cycle">
          <el-input v-model.number="form.cycle" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="浓度" prop="c">
          <el-input v-model.number="form.c" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="体积" prop="v">
          <el-input v-model.number="form.v" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="电泳结果/电泳图名称" prop="e_map">
          <el-input v-model.number="form.e_map" auto-complete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="close">取消</el-button>
        <el-button type="primary" @click.native.prevent="submit" :loading="formLoading">保存</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import { pick } from 'lodash'
  import { mapState, mapActions } from 'vuex'
  export default {
    data () {
      return {
        name: '',
        form: {
          primer: 0,
          cycle: 0,
          c: 0,
          v: 0,
          e_map: ''
        },
        checked: [],
        formId: 0,
        isFormVisible: false,
        formLoading: false,
        formRules: {},
        multipleSelection: []
      }
    },
    mounted () {
      this.fetch()
    },
    watch: {
      currentPage: 'fetch'
    },
    computed: {
      ...mapState({
        analysises: state => state.Experiments.analysises,
        pagination: state => state.Experiments.analysises_pagination,
        fetching: state => state.fetching
      }),
      currentPage () {
        return parseInt(this.$route.query.page, 10) || 1
      }
    },
    methods: {
      ...mapActions(['setFetching', 'analysisesSetData']),
      fetch () {
        this.setFetching({ fetching: true })
        this.$http.get(`experiments/analysises?page=${this.currentPage}`)
        .then(({ data }) => {
          this.analysisesSetData({
            analysises: data.data,
            analysises_pagination: data.meta.pagination
          })
          this.setFetching({ fetching: false })
        })
      },
      canConfirm (index) {
        let analysise = this.analysises[index]
        return analysise.status === 0 ? 'false' : 'true'
      },
      search () {
        console.log('search')
      },
      edit (index) {
        this.isFormVisible = true
        let analysise = this.analysises[index]
        this.formId = analysise.id
        console.log(typeof (analysise.quality))
        if (typeof (analysise.quality) === 'object') {
          this.form = {...analysise.quality}
        } else {
          let data = JSON.parse(analysise.quality)
          console.log(data)
          this.form = {...data}
        }
      },
      close () {
        this.formId = 0
        this.form.primer = 0
        this.form.cycle = 0
        this.form.c = 0
        this.form.v = 0
        this.form.e_map = ''
        this.isFormVisible = false
      },
      handleSelectionChange (val) {
        this.multipleSelection = val
      },
      askConfirm () {
        this.$confirm('确认完成实验吗', '提示', {
          trpe: 'warning'
        }).then(() => {
          for (var i = 0; i < this.multipleSelection.length; i++) {
            this.multipleSelection[i]
            let id = this.multipleSelection[i].id
            this.$http.patch(`experiments/${id}`, {'next': true})
            .then(() => {
              this.fetch()
            })
            .catch((error) => {
              this.$notify({
                title: '糟糕',
                message: error.response.data.messages[0],
                type: 'error'
              })
            })
          }
          this.$notify({
            title: '成功',
            message: '已经提交下一步处理',
            type: 'success'
          })
        })
      },
      submit () {
        this.$http.put(`experiments/${this.formId}`, pick(this.form, ['primer', 'cycle', 'c', 'v', 'e_map']))
        .then(() => {
          this.close()
          this.fetch()
          this.setFetching({
            fetching: false
          })
          this.$notify({
            title: '成功',
            message: '更新成功',
            type: 'success'
          })
        })
      },
      navigate (page) {
        this.$router.push({
          name: 'analysises.index',
          query: {
            page
          }
        })
      }
    }
  }
</script>
