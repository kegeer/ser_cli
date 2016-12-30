const Experiments = r => require.ensure([], () => r(require('./main.vue')), 'experiments-bundle')
// const Analysis = r => require.ensure([], () => r(require('./components/analysis.vue')), 'experiments-bundle')
const Dilutions = r => require.ensure([], () => r(require('./components/dilution.vue')), 'experiments-bundle')
const Extractions = r => require.ensure([], () => r(require('./components/extraction.vue')), 'experiments-bundle')
const Splits = r => require.ensure([], () => r(require('./components/split.vue')), 'experiments-bundle')
// const Distribution = r => require.ensure([], () => r(require('./components/ditribution.vue')), 'experiments-bundle')

export default [
  {
    path: '/experiments',
    name: 'experiments.index',
    component: Experiments,
    children: [
      {
        path: 'splits',
        name: 'splits.index',
        component: Splits
      },
      {
        path: 'extractions',
        name: 'extractions.index',
        component: Extractions
      },
      {
        path: 'dilutions',
        name: 'dilutions.index',
        component: Dilutions
      }
    ]
  }
]
