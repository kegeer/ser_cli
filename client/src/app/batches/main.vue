<template>
<main>
  <div class="main-left">
    <el-menu default-active="/active" class="el-menu-vertical-demo" :router="true">
      <el-menu-item index="/active" :class="{'isActive': active}">批次管理</el-menu-item>
      <el-menu-item index="/manager" :class="{'isActive': !active}">样品管理</el-menu-item>
    </el-menu>
  </div>
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
        <el-button type="primary" @click="search" icon="search">搜索</el-button>
        <el-button type="default" @click="add">新增</el-button>
      </el-button-group>
    </div>
    <el-table v-loading="fetching" :data="batches" stripe border style="width: 100%;">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="py_num" label="谱元编号"></el-table-column>
      <el-table-column inline-template label="操作" width="180">
        <div>
          <el-button @click="samples($index)" type="default" icon="plus" size="mini">
          </el-button>
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
      <el-form :model="form" label-width="80px" :rules="formRules" ref="form">
        <el-form-item label="谱元编号" :label-width="formLabelWidth" prop="py_num">
          <el-input v-model="form.py_num" auto-complete="off"></el-input>
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
import {
  mapState,
  mapActions
} from 'vuex'
import { pick } from 'lodash'
export default {
  data () {
    return {
      name: '',
      startEndTime: '',
      active: true,
      formRules: {
        py_num: [{
          required: true,
          message: '请输入谱元编号',
          trigger: 'blur'
        }]
      },
      isFormVisible: false,
      formTitle: '编辑',
      formLabelWidth: '120px',
      fromButtonText: '保存',
      formLoading: false,
      form: {
        id: 0,
        py_num: ''
      }
    }
  },
  mounted () {
    this.fetch()
  },
  updated () {
    this.$bus.$on('close', () => this.close())
  },
  watch: {
    currentPage: 'fetch'
  },
  computed: {
    ...mapState({
      list: state => state.Batches.list,
      pagination: state => state.Batches.pagination,
      fetching: state => state.fetching
    }),
    batches () {
      return this.list
    },
    currentPage () {
      return parseInt(this.$route.query.page, 10) || 1
    },
    isEditing () {
      return this.form.id > 0
    }
  },
  methods: {
    ...mapActions(['setFetching', 'batchesSetData']),
    fetch () {
      this.setFetching({
        fetching: true
      })
      this.$http.get(`batches?page=${this.currentPage}`)
        .then(({
          data
        }) => {
          this.batchesSetData({
            list: data.data,
            pagination: data.meta.pagination
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
      let batch = this.batches[index]
      this.form = {...batch}
    },
    samples (index) {
      const { id } = this.batches[index]
      this.$router.push({
        name: 'samples.index',
        params: {
          id
        }
      })
    },
    askRemove (index) {
      const batch = this.batches[index]
      this.$confirm('确认删除记录吗？', '提示', {
        type: 'warning'
      }).then(() => {
        this.$http.delete(`batches/${batch.id}`)
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
            type: 'success'
          })
        }
      })
    },
    close () {
      this.form.id = 0
      this.form.py_num = ''
      this.isFormVisible = false
    },
    update () {
      this.$http.put(`batches/${this.form.id}`, this.form)
        .then(() => {
          this.close()
          this.fetch()
          this.setFetching({
            fetching: false
          })
          this.isFormVisible = false
          this.$notify({
            title: '成功',
            message: '更新成功',
            type: 'success'
          })
        })
    },
    save () {
      this.$http.post('batches', pick(this.form, ['py_num'])).then(() => {
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
        name: 'batches.index',
        query: {
          page
        }
      })
    }
  }
}
</script>
<style>
</style>
