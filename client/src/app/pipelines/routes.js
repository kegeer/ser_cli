const Pipelines = r => require.ensure([], () => r(require('./main.vue')), 'batches-bundle')
const Protocols = r => require.ensure([], () => r(require('./protocols.vue')), 'batches-bundle')

export default [
  {
    path: '/pipelines',
    name: 'pipelines.index',
    component: Pipelines
  },
  {
    path: '/protocols',
    name: 'protocols.index',
    component: Protocols
  }
]
