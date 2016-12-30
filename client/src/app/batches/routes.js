const Batches = r => require.ensure([], () => r(require('./main.vue')), 'batches-bundle')
const Samples = r => require.ensure([], () => r(require('./samples.vue')), 'batches-bundle')

export default [
  {
    path: '/batches',
    name: 'batches.index',
    component: Batches
  },
  {
    path: '/batches/:id/samples',
    name: 'samples.index',
    component: Samples
  }
]
