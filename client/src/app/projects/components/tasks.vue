<template>
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
        <el-button type="primary" @click="search" icon="search">搜索</el-button>
        <el-button type="default" @click="add">新增</el-button>
      </el-button-group>
    </div>

    <el-table v-loading="fetching" :data="tasks" stripe border style="width: 100%;">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="name" label="任务名称"></el-table-column>
      <el-table-column prop="pipeline_id" label="技术路线"></el-table-column>
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

    <el-dialog :title="formTitle" v-model="isFormVisible" :close-on-click-modal="false" @close="close" size="full">
      <el-form :model="form" label-width="120px" :rules="formRules" ref="form">
        <el-row>
          <el-col :span="12">
            <el-form-item label="名称" ref="firstInput" prop="name">
              <el-input v-model="form.name" auto-complete="off"></el-input>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="技术路线" ref="firstInput" prop="name">
              <el-select v-model="form.pipeline_id" placeholder="Select">
                <el-option
                  v-for="item in options"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>

        <el-row>
          <el-col :span="12">
            <el-form-item label="实验负责人" ref="firstInput" prop="name">
              <el-select v-model="form.exp_manager" placeholder="Select">
                <el-option
                  v-for="item in options"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="信息负责人" prop="manager">
              <el-select v-model="form.info_manager" placeholder="Select">
                <el-option
                  v-for="item in options"
                  :label="item.label"
                  :value="item.value">
                </el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-row>
        <el-form-item label="时间周期" prop="datetime_range">
          <el-date-picker v-model="form.datetime_range" type="datetimerange" placeholder="选择时间周期">
            </el-date-picker>
        </el-form-item>
        <h3>已选批次</h3>
        <el-table v-loading="fetching" :data="form.batchesSelection" stripe border style="width: 100%;margin-bottom: 60px;">
          <el-table-column inline-template width="55">
            <el-button type="danger" icon="delete" size="mini" @click="closeTag(index)"></el-button>
          </el-table-column>
          <el-table-column prop="id" label="ID" width="80"></el-table-column>
          <el-table-column prop="client_id" label="样品编号"></el-table-column>
          <el-table-column prop="send_time" label="寄送时间"></el-table-column>
          <el-table-column prop="arrive_time" label="到样时间"></el-table-column>
        </el-table>
        <h3>可选批次</h3>
        <el-table v-loading="fetching" :data="batches" stripe border style="width: 100%;" @selection-change="handleSelectionChange">
          <el-table-column type="selection" width="55"> </el-table-column>
          <el-table-column prop="id" label="ID" width="80"></el-table-column>
          <el-table-column prop="client_id" label="样品编号"></el-table-column>
          <el-table-column prop="send_time" label="寄送时间"></el-table-column>
          <el-table-column prop="arrive_time" label="到样时间"></el-table-column>
        </el-table>
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
import Sidebar from './sidebar'
export default {
  components: {
    Sidebar
  },
  data () {
    return {
      name: '',
      startEndTime: '',
      active: false,
      form: {
        id: 0,
        name: '',
        project_id: this.$route.params.id,
        pipeline_id: 0,
        exp_manager: 0,
        info_manager: 0,
        datetime_range: [],
        batchesSelection: []
      },
      options: [
        {
          value: 1,
          label: 'op1'
        },
        {
          value: 2,
          label: 'op2'
        }
      ],
      isFormVisible: false,
      formTitle: '编辑',
      fromButtonText: '保存',
      formLoading: false,
      formRules: {
      }
    }
  },
  mounted () {
    this.fetch()
  },
  computed: {
    ...mapState({
      list: state => state.Projects.tasks,
      pagination: state => state.Projects.tasks_pagination,
      fetching: state => state.fetching,
      batches: state => state.Batches.list
    }),
    tasks () {
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
    ...mapActions(['setFetching', 'tasksSetData', 'batchesSetData']),
    fetch () {
      this.setFetching({
        fetching: true
      })
      this.$http.get(`projects/${this.form.project_id}/tasks?page=${this.currentPage}`)
        .then(({
          data
        }) => {
          this.tasksSetData({
            tasks: data.data,
            tasks_pagination: data.meta.pagination
          })
          this.setFetching({
            fetching: false
          })
        })
      this.$http.get('batches/unsign').then(({ data }) => {
        this.batchesSetData({
          list: data.data
        })
      })
    },
    handleSelectionChange (val) {
      this.form.batchesSelection = val
    },
    closeTag (index) {
      this.form.batchesSelection.splice(index, 1)
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
      let task = this.tasks[index]
      this.form = {...task}
    },
    askRemove (index) {
      let sample = this.tasks[index]
      this.$confirm('确认删除记录吗？', '提示', {
        type: 'warning'
      }).then(() => {
        this.$http.delete(`tasks/${sample.id}`)
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
      this.form.project_id = this.$route.params.id
      this.form.pipeline_id = 0
      this.form.name = ''
      this.form.exp_manager = 0
      this.form.info_manager = 0
      this.form.datetime_range = []
      this.form.batchesSelection = []
      this.isFormVisible = false
    },
    update () {
      this.$http.put(`tasks/${this.form.id}`, this.form)
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
      this.$http.post('tasks', pick(this.form, ['project_id', 'pipeline_id', 'name', 'exp_manager', 'info_manager', 'datetime_range', 'batchesSelection'])).then(() => {
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
        name: 'tasks.index',
        query: {
          page
        }
      })
    }
  }
}
</script>
