import * as TYPES from '../../store/types'

const state = {
  pipelines: [],
  pipelines_pagination: {},
  protocols: [],
  protocols_pagination: {}
}

const mutations = {
  [TYPES.PIPELINES_SET_DATA] (state, obj) {
    state.pipelines = obj.pipelines
    state.pipelines_pagination = obj.pipelines_pagination
  },
  [TYPES.PROTOCOLS_SET_DATA] (state, obj) {
    state.protocols = obj.protocols
    state.protocols_pagination = obj.protocols_pagination
  }
}

const actions = {
  pipelinesSetData ({ commit }, obj) {
    commit(TYPES.PIPELINES_SET_DATA, obj)
  },
  protocolsSetData ({ commit }, obj) {
    commit(TYPES.PROTOCOLS_SET_DATA, obj)
  }
}

const module = {
  state,
  mutations,
  actions
}
export default { module }
