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


    <el-table v-loading="fetching" :data="distributions" stripe border style="width: 100%;" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="55" @selectable="canConfirm($index)"> </el-table-column>
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="sample_id" label="样品编号">
      </el-table-column>
      <el-table-column prop="status" label="目前状态">
      </el-table-column>
      <el-table-column label="建库前">
        <el-table-column prop="quality.pre_v" label="体积
" width="120"></el-table-column>
        <el-table-column prop="quality.pre_c" label="浓度
" width="120"></el-table-column>
      </el-table-column>
      <el-table-column label="建库后">
        <el-table-column prop="quality.after_index" label="Index
" width="120"></el-table-column>
        <el-table-column prop="quality.after_v" label="体积
" width="120"></el-table-column>
        <el-table-column prop="quality.after_c" label="浓度" width="120"></el-table-column>
        <el-table-column prop="quality.after_e_map" label="电泳结果
" width="120"></el-table-column>
        <el-table-column prop="quality.after_library_size" label="文库片段大小
" width="120"></el-table-column>
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
        <h3>建库前</h3>
        <el-form-item label="体积" prop="pre_v">
          <el-input v-model.number="form.pre_v" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="浓度" prop="pre_c">
          <el-input v-model.number="form.pre_c" auto-complete="off"></el-input>
        </el-form-item>
        <h3>建库后</h3>
        <el-form-item label="Index" prop="after_index">
          <el-input v-model.number="form.after_index" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="体积" prop="after_v">
          <el-input v-model.number="form.after_v" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="浓度" prop="after_c">
          <el-input v-model.number="form.after_c" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="电泳结果" prop="after_e_map">
          <el-input v-model.number="form.after_e_map" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="文库片段大小" prop="after_library_size">
          <el-input v-model.number="form.after_library_size" auto-complete="off"></el-input>
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
          pre_v: 0,
          pre_c: 0,
          after_index: '',
          after_v: 0,
          after_c: 0,
          after_e_map: '',
          after_library_size: 0
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
        distributions: state => state.Experiments.distributions,
        pagination: state => state.Experiments.distributions_pagination,
        fetching: state => state.fetching
      }),
      currentPage () {
        return parseInt(this.$route.query.page, 10) || 1
      }
    },
    methods: {
      ...mapActions(['setFetching', 'distributionsSetData']),
      fetch () {
        this.setFetching({ fetching: true })
        this.$http.get(`experiments/distributions?page=${this.currentPage}`)
        .then(({ data }) => {
          this.distributionsSetData({
            distributions: data.data,
            distributions_pagination: data.meta.pagination
          })
          this.setFetching({ fetching: false })
        })
      },
      canConfirm (index) {
        let distribution = this.distributions[index]
        return distribution.status === 0 ? 'false' : 'true'
      },
      search () {
        console.log('search')
      },
      edit (index) {
        this.isFormVisible = true
        let distribution = this.distributions[index]
        this.formId = distribution.id
        console.log(typeof (distribution.quality))
        if (typeof (distribution.quality) === 'object') {
          this.form = {...distribution.quality}
        } else {
          let data = JSON.parse(distribution.quality)
          console.log(data)
          this.form = {...data}
        }
      },
      close () {
        this.formId = 0
        this.form.pre_v = 0
        this.form.pre_c = 0
        this.form.after_index = 0
        this.form.after_v = 0
        this.form.after_c = 0
        this.form.after_e_map = ''
        this.form.after_library_size = 0
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
        this.$http.put(`experiments/${this.formId}`, pick(this.form, ['pre_v', 'pre_c', 'after_index', 'after_v', 'after_c', 'after_e_map', 'after_library_size']))
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
          name: 'distributions.index',
          query: {
            page
          }
        })
      }
    }
  }
</script>
