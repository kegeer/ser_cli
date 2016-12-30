<template>
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


    <el-table v-loading="fetching" :data="extractions" stripe border style="width: 100%;" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="55" @selectable="canConfirm($index)"> </el-table-column>
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="sample_id" label="样品编号">
      </el-table-column>
      <el-table-column prop="status" label="目前状态">
      </el-table-column>
      <el-table-column label="提取结果">
        <el-table-column prop="quality.density" label="浓度" width="120"></el-table-column>
        <el-table-column prop="quality.volume" label="体积" width="120"></el-table-column>
        <el-table-column prop="quality.total" label="总量" width="120"></el-table-column>
        <el-table-column prop="quality.result" label="电泳结果" width="120"></el-table-column>
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
        <el-form-item label="浓度" prop="density">
          <el-input v-model.number="form.density" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="体积" prop="volume">
          <el-input v-model.number="form.volume" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="总量" prop="total">
          <el-input v-model.number="form.total" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="电泳结果" prop="result">
          <el-input v-model.number="form.result" auto-complete="off"></el-input>
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
          density: 0,
          volume: 0,
          total: 0,
          result: 0
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
        extractions: state => state.Experiments.extractions,
        pagination: state => state.Experiments.extractions_pagination,
        fetching: state => state.fetching
      }),
      currentPage () {
        return parseInt(this.$route.query.page, 10) || 1
      }
    },
    methods: {
      ...mapActions(['setFetching', 'extractionsSetData']),
      fetch () {
        this.setFetching({ fetching: true })
        this.$http.get(`experiments/extractions?page=${this.currentPage}`)
        .then(({ data }) => {
          this.extractionsSetData({
            extractions: data.data,
            extractions_pagination: data.meta.pagination
          })
          this.setFetching({ fetching: false })
        })
      },
      canConfirm (index) {
        let extraction = this.extractions[index]
        return extraction.status === 0 ? 'false' : 'true'
      },
      search () {
        console.log('search')
      },
      edit (index) {
        this.isFormVisible = true
        let extraction = this.extractions[index]
        this.formId = extraction.id
        console.log(typeof (extraction.quality))
        if (typeof (extraction.quality) === 'object') {
          this.form = {...extraction.quality}
        } else {
          let data = JSON.parse(extraction.quality)
          console.log(data)
          this.form = {...data}
        }
      },
      close () {
        this.formId = 0
        this.form.density = 0
        this.form.volume = 0
        this.form.total = 0
        this.form.result = 0
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
        this.$http.put(`experiments/${this.formId}`, pick(this.form, ['density', 'volume', 'total', 'result']))
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
          name: 'extractions.index',
          query: {
            page
          }
        })
      }
    }
  }
</script>
