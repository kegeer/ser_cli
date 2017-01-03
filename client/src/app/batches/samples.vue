<template>
<main>
  <div class="main-left">
    <el-menu default-active="/batches" class="el-menu-vertical-demo" :router="true">
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

  <div class="main-right">
    <breadcrumb></breadcrumb>
    <div class="filters">
      <div class="filter">
        谱元编号：
        <el-input placeholder="请输入谱元编号" v-model="name"></el-input>
      </div>
      <el-button-group style="display: inline-block;">
        <el-button type="primary" @click="search" icon="search">搜索</el-button>
        <el-button type="default" @click="add">新增</el-button>
      </el-button-group>
    </div>

    <el-table v-loading="fetching" :data="samples" stripe border style="width: 100%;">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="py_num" label="谱元编号"></el-table-column>
      <el-table-column inline-template label="操作" width="180">
        <div>
          <el-button @click="edit($index)" type="default" icon="edit" size="mini">
          </el-button>
          <el-button @click="askRemove($index)" type="warning" icon="delete" size="mini">
          </el-button>
        </div>
      </el-table-column>
    </el-table>

    <div class="pagination">
      <el-pagination @current-change="navigate" :current-page="pagination.current_page" :page-size="pagination.per_page" layout="total, prev, pager, next, jumper" :total="pagination.total"></el-pagination>
    </div>

    <el-dialog :title="formTitle" v-model="isFormVisible" :close-on-click-modal="false" @close="close">
      <el-form :model="form" label-width="120px" :rules="formRules" ref="form">
        <el-form-item label="谱元编号" ref="firstInput" prop="py_num">
          <el-input v-model="form.py_num" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="原始编号" prop="ori_num">
          <el-input v-model="form.ori_num" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item prop="sample_amount_type" label="样品类型">
          <el-radio-group v-model="form.sample_amount_type">
            <el-radio :label="1">固态</el-radio>
            <el-radio :label="2">液态</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item prop="sample_amount" label="样品量">
          <el-input v-model="form.sample_amount" auto-complete="off" placeholder="g/ml"></el-input>
        </el-form-item>
       <el-form-item label="样品状态/特征">
        <el-input v-model="form.sample_status" auto-complete="off" placeholder="例如：液体脑脊液微黄"></el-input>
      </el-form-item>

      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="close">取消</el-button>
        <el-button type="primary" @click.native.prevent="submit" :loading="formLoading">{{ fromButtonText }}</el-button>
      </div>
    </el-dialog>
  </div>
</main>
</template>

<script>
import { pick } from 'lodash'
import { mapState, mapActions } from 'vuex'
export default {
  data () {
    return {
      name: '',
      active: false,
      form: {
        id: 0,
        batch_id: this.$route.params.id,
        ori_num: '',
        py_num: '',
        sample_amount_type: 0,
        sample_amount: 0,
        sample_status: ''
      },
      isFormVisible: false,
      formTitle: '编辑',
      fromButtonText: '保存',
      formLoading: false,
      formRules: {
        py_num: [
          {required: true, message: '请输入名称', trigger: 'blure'}
        ],
        ori_num: [
          {required: true, message: '请填写原始编号', trigger: 'blure'}
        ]
      }
    }
  },
  mounted () {
    this.fetch()
  },
  computed: {
    ...mapState({
      list: state => state.Batches.samples,
      pagination: state => state.Batches.samples_pagination,
      fetching: state => state.fetching
    }),
    samples () {
      return this.list
    },
    currentPage () {
      return parseInt(this.$route.query.page, 10) || 1
    },
    isEditing () {
      return this.form.id > 0
    }
  },
  watch: {
    currentPage: 'fetch',
    $route: 'fetch'
  },
  methods: {
    ...mapActions(['setFetching', 'samplesSetData']),
    fetch () {
      this.setFetching({
        fetching: true
      })
      this.$http.get(`batches/${this.form.batch_id}/samples?page=${this.currentPage}`)
        .then(({
          data
        }) => {
          this.samplesSetData({
            samples: data.data,
            samples_pagination: data.meta.pagination
          })
          this.setFetching({
            fetching: false
          })
        })
    },
    search () {
      console.log('search')
    },
    add () {
      this.isFormVisible = true
      this.formTitle = '新增'
      this.fromButtonText = '创建'
      this.form.id = 0
    },
    edit (index) {
      this.isFormVisible = true
      this.formTitle = '编辑'
      this.fromButtonText = '更新'
      let sample = this.samples[index]
      this.form = {...sample}
    },
    askRemove (index) {
      let sample = this.samples[index]
      this.$confirm('确认删除记录吗？', '提示', {
        type: 'warning'
      }).then(() => {
        this.$http.delete(`samples/${sample.id}`)
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
    submit () {
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.setFetching({
            fetching: true
          })
          if (this.isEditing) {
            this.update()
          } else {
            this.save()
          }
        } else {
          this.$notify({
            title: '错误',
            message: '表单有错误，请检查后再提交',
            type: 'error'
          })
        }
      })
    },
    close () {
      this.form.id = 0
      this.form.batch_id = this.$route.params.id
      this.form.py_num = ''
      this.form.ori_num = ''
      this.form.sample_amount_type = 0
      this.form.sample_amount = 0
      this.form.sample_status = ''
      this.isFormVisible = false
    },
    update () {
      this.$http.put(`samples/${this.form.id}`, this.form)
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
    save () {
      this.$http.post('samples', pick(this.form, ['batch_id', 'py_num', 'ori_num', 'sample_amount_type', 'sample_amount', 'sample_status'])).then(() => {
        this.close()
        this.fetch()
        this.setFetching({
          fetching: false
        })
        this.$notify({
          title: '成功',
          message: '创建成功',
          type: 'success'
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
