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


    <el-table v-loading="fetching" :data="dilutions" stripe border style="width: 100%;" @selection-change="handleSelectionChange">
      <el-table-column type="selection" width="55" @selectable="canConfirm($index)"> </el-table-column>
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="sample_id" label="样品编号">
      </el-table-column>
      <el-table-column prop="status" label="目前状态">
      </el-table-column>
      <el-table-column label="提取结果">
        <el-table-column prop="quality.ori_con" label="原浓度" width="120"></el-table-column>
        <el-table-column prop="quality.sample_vol" label="取样体积" width="120"></el-table-column>
        <el-table-column prop="quality.water" label="加水量" width="120"></el-table-column>
        <el-table-column prop="quality.last_con" label="终浓度" width="120"></el-table-column>
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
        <el-form-item label="原浓度" prop="ori_con">
          <el-input v-model.number="form.ori_con" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="取样体积" prop="sample_vol">
          <el-input v-model.number="form.sample_vol" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="加水量" prop="water">
          <el-input v-model.number="form.water" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="终浓度" prop="last_con">
          <el-input v-model.number="form.last_con" auto-complete="off"></el-input>
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
          ori_con: 0,
          sample_vol: 0,
          water: 0,
          last_con: 0
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
        dilutions: state => state.Experiments.dilutions,
        pagination: state => state.Experiments.dilutions_pagination,
        fetching: state => state.fetching
      }),
      currentPage () {
        return parseInt(this.$route.query.page, 10) || 1
      }
    },
    methods: {
      ...mapActions(['setFetching', 'dilutionsSetData']),
      fetch () {
        this.setFetching({ fetching: true })
        this.$http.get(`experiments/dilutions?page=${this.currentPage}`)
        .then(({ data }) => {
          this.dilutionsSetData({
            dilutions: data.data,
            dilutions_pagination: data.meta.pagination
          })
          this.setFetching({ fetching: false })
        })
      },
      canConfirm (index) {
        let dilution = this.dilutions[index]
        return dilution.status === 0 ? 'false' : 'true'
      },
      search () {
        console.log('search')
      },
      edit (index) {
        this.isFormVisible = true
        let dilution = this.dilutions[index]
        this.formId = dilution.id
        console.log(typeof (dilution.quality))
        if (typeof (dilution.quality) === 'object') {
          this.form = {...dilution.quality}
        } else {
          let data = JSON.parse(dilution.quality)
          console.log(data)
          this.form = {...data}
        }
      },
      close () {
        this.formId = 0
        this.form.ori_con = 0
        this.form.sample_vol = 0
        this.form.water = 0
        this.form.last_con = 0
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
        this.$http.put(`experiments/${this.formId}`, pick(this.form, ['ori_con', 'sample_vol', 'water', 'last_con']))
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
          name: 'dilutions.index',
          query: {
            page
          }
        })
      }
    }
  }
</script>
