import * as TYPES from '../../store/types'

const state = {
  list: [],
  pagination: {},
  samples: [],
  samples_pagination: {}
}

const mutations = {
  [TYPES.BATCHES_SET_DATA] (state, obj) {
    state.list = obj.list
    state.pagination = obj.pagination
  },
  [TYPES.SAMPLES_SET_DATA] (state, obj) {
    state.samples = obj.samples
    state.samples_pagination = obj.samples_pagination
  }
}

const actions = {
  batchesSetData ({ commit }, obj) {
    commit(TYPES.BATCHES_SET_DATA, obj)
  },
  samplesSetData ({ commit }, obj) {
    commit(TYPES.SAMPLES_SET_DATA, obj)
  }
}

const module = {
  state,
  mutations,
  actions
}

export default { module }
