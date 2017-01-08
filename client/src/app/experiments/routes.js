const Experiments = r => require.ensure([], () => r(require('./main.vue')), 'experiments-bundle')
const Analysises = r => require.ensure([], () => r(require('./components/analysis.vue')), 'experiments-bundle')
const Dilutions = r => require.ensure([], () => r(require('./components/dilution.vue')), 'experiments-bundle')
const Extractions = r => require.ensure([], () => r(require('./components/extraction.vue')), 'experiments-bundle')
const Splits = r => require.ensure([], () => r(require('./components/split.vue')), 'experiments-bundle')
const Distribution = r => require.ensure([], () => r(require('./components/distribution.vue')), 'experiments-bundle')
const Poolings = r => require.ensure([], () => r(require('./components/pooling.vue')), 'experiments-bundle')
const Libraries = r => require.ensure([], () => r(require('./components/library.vue')), 'experiments-bundle')
const Sequences = r => require.ensure([], () => r(require('./components/sequence.vue')), 'experiments-bundle')

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
      },
      {
        path: 'distributions',
        name: 'distributions.index',
        component: Distribution
      },
      {
        path: 'analysises',
        name: 'analysises.index',
        component: Analysises
      },
      {
        path: 'poolings',
        name: 'poolings.index',
        component: Poolings
      },
      {
        path: 'libraries',
        name: 'libraries.index',
        component: Libraries
      },
      {
        path: 'sequences',
        name: 'sequences.index',
        component: Sequences
      }
    ]
  }
]
