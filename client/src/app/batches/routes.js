const Batches = r => require.ensure([], () => r(require('./main.vue')), 'batches-bundle')
const Samples = r => require.ensure([], () => r(require('./components/samples.vue')), 'batches-bundle')
const AllSamples = r => require.ensure([], () => r(require('./components/allSamples.vue')), 'batches-bundle')
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
  },
  {
    path: '/samples',
    name: 'allSamples.index',
    component: AllSamples
  }
]
