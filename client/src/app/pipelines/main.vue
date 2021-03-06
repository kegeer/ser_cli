<template>
<main>
  <div class="main-left">
    <el-menu default-active="/pipelines" class="el-menu-vertical-demo" :router="true">
      <el-menu-item index="/pipelines">技术路线管理</el-menu-item>
      <el-menu-item index="/protocols">实验方法管理</el-menu-item>
    </el-menu>
  </div>

  <div class="main-right">
    <breadcrumb></breadcrumb>
    <div class="filters">
      <el-button-group style="display: inline-block;">
        <el-button type="default" @click="add">新增</el-button>
      </el-button-group>
    </div>

    <el-table v-loading="fetching" :data="pipelines" stripe border style="width: 100%;">
      <el-table-column prop="id" label="ID" width="80"></el-table-column>
      <el-table-column prop="name" label="名称"></el-table-column>
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
      <el-form :model="form" label-width="80px" :rules="formRules" ref="form">
        <el-form-item label="名称" ref="firstInput" prop="name">
          <el-input v-model="form.name" auto-complete="off"></el-input>
        </el-form-item>
        <table style="width: 100%">
          <thead>
            <tr>
              <th>Step</th>
              <th>Procedure</th>
              <th>Protocol</th>
              <th>Time</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="step in form.steps">
              <td>
                <el-badge class="mark" :value="step.step" />
              </td>
              <td>
                <el-select v-model="step.procedure" placeholder="please select your zone">
                  <el-option v-for="p in procedures" :label="p.label" :value="p.id"></el-option>
                </el-select>
              </td>
              <td>
                <el-select v-model="step.protocol" placeholder="please select your zone">
                  <el-option label="Zone one" value="1"></el-option>
                  <el-option label="Zone two" value="2"></el-option>
                </el-select>
              </td>
              <td>
                <el-input v-model="step.time" auto-complete="off"></el-input>
              </td>
              <td>
                <el-button type="danger" icon="delete" @click.prevent="removeLine(step)"></el-button>
              </td>
            </tr>
            <tr>
              <td colspan="5">
                <el-button type="primary" icon="plus" @click.prevent="addNewLine"></el-button>
              </td>
            </tr>
          </tbody>
        </table>
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
        name: '',
        steps: [
          {
            step: 1,
            procedure: 0,
            protocol: 0,
            time: 0
          }
        ]
      },
      isFormVisible: false,
      formTitle: '编辑',
      fromButtonText: '保存',
      formLoading: false,
      formRules: {
        name: [
          {required: true, message: '请输入名称', trigger: 'blure'}
        ]
      }
    }
  },
  mounted () {
    this.fetch()
  },
  computed: {
    ...mapState({
      pipelines: state => state.Pipelines.pipelines,
      pagination: state => state.Pipelines.pipelines_pagination,
      fetching: state => state.fetching,
      procedures: state => state.procedures
    }),
    currentPage () {
      return parseInt(this.$route.query.page, 10) || 1
    },
    isEditing () {
      return this.form.id > 0
    }
  },
  watch: {
    currentPage: 'fetch'
  },
  methods: {
    ...mapActions(['setFetching', 'pipelinesSetData']),
    fetch () {
      this.setFetching({
        fetching: true
      })
      this.$http.get(`pipelines?page=${this.currentPage}`)
        .then(({
          data
        }) => {
          this.pipelinesSetData({
            pipelines: data.data,
            pipelines_pagination: data.meta.pagination
          })
          this.setFetching({
            fetching: false
          })
        })
    },
    add () {
      this.isFormVisible = true
      this.formTitle = '新增'
      this.fromButtonText = '创建'
    },
    removeLine (step) {
      let index = this.form.steps.indexOf(step)
      this.form.steps.splice(index, 1)
    },
    addNewLine () {
      this.form.steps.push({
        step: this.form.steps.length + 1,
        procedure: 0,
        protocol: 0,
        time: 0
      })
    },
    tasks (index) {
      const { id } = this.pipelines[index]
      this.$router.push({
        name: 'tasks.index',
        params: {
          id
        }
      })
    },
    edit (index) {
      this.isFormVisible = true
      this.formTitle = '编辑'
      this.fromButtonText = '更新'
      const pipeline = this.pipelines[index]
      console.log(pipeline)
      this.form.name = pipeline.name
      if (typeof (pipeline.steps) === 'object') {
        this.form.steps = {...pipeline.steps}
      } else {
        let data = JSON.parse(pipeline.steps)
        console.log(data)
        this.form.steps = {...data}
      }
    },
    askRemove (index) {
      const pipeline = this.pipelines[index]
      this.$confirm('确认删除记录吗？', '提示', {
        type: 'warning'
      }).then(() => {
        this.$http.delete(`pipelines/${pipeline.id}`)
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
      this.form.name = ''
      this.form.steps = [
        {
          step: 1,
          procedure: 0,
          protocol: 0,
          time: 0
        }
      ]
      this.isFormVisible = false
    },
    update () {
      this.$http.put(`pipelines/${this.form.id}`, this.form)
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
      this.$http.post('pipelines', pick(this.form, ['name', 'steps'])).then(() => {
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
        name: 'pipelines.index',
        query: {
          page
        }
      })
    }
  }
}
</script>
