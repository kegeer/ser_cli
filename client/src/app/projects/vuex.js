import * as TYPES from '../../store/types'

const state = {
  list: [],
  pagination: {},
  tasks: [],
  tasks_pagination: {}
}

const mutations = {
  [TYPES.PROJECTS_SET_DATA] (state, obj) {
    state.list = obj.list
    state.pagination = obj.pagination
  },
  [TYPES.TASKS_SET_DATA] (state, obj) {
    state.tasks = obj.tasks
    state.tasks_pagination = obj.tasks_pagination
  }
}

const actions = {
  projectsSetData ({ commit }, obj) {
    commit(TYPES.PROJECTS_SET_DATA, obj)
  },
  tasksSetData ({ commit }, obj) {
    commit(TYPES.TASKS_SET_DATA, obj)
  }
}

const module = {
  state,
  mutations,
  actions
}

export default { module }
