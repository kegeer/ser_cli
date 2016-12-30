import * as TYPES from '../../store/types'

const state = {
  results: [],
  results_pagination: {},
  result: {}
}
const mutations = {
  [TYPES.RESULTS_SET_DATA] (state, obj) {
    state.results = obj.results
    state.results_pagination = obj.results_pagination
  },
  [TYPES.RESULT_SET_DATA] (state, obj) {
    state.result = obj
  }
}
const actions = {
  resultsSetData ({ commit }, obj) {
    commit(TYPES.RESULTS_SET_DATA, obj)
  },
  resultSetData ({ commit }, obj) {
    commit(TYPES.RESULT_SET_DATA, obj)
  }
}
const module = {
  state,
  mutations,
  actions
}
export default { module }
