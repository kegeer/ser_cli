const Results = r => require.ensure([], () => r(require('./main')), 'results-bundles')
const Result = r => require.ensure([], () => r(require('./result')), 'results-bundles')

export default [
  {
    name: 'results.index',
    path: '/results',
    component: Results
  },
  {
    name: 'results.show',
    path: '/results/:id/result',
    component: Result
  }
]
