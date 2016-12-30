import * as TYPES from '../../store/types'

const state = {
  qcs: [],
  qcs_pagination: {},
  qc: {}
}
const mutations = {
  [TYPES.QCS_SET_DATA] (state, obj) {
    state.qcs = obj.qcs
    state.qcs_pagination = obj.qcs_pagination
  },
  [TYPES.QC_SET_DATA] (state, obj) {
    state.qc = obj.qc
  }
}
const actions = {
  qcsSetData ({ commit }, obj) {
    commit(TYPES.QCS_SET_DATA, obj)
  },
  qcSetData ({ commit }, obj) {
    commit(TYPES.QC_SET_DATA, obj)
  }
}
const module = {
  state,
  mutations,
  actions
}
export default { module }
