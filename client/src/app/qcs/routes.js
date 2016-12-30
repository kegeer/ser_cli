const Qcs = r => require.ensure([], () => r(require('./main')), 'qcs-bundles')
const Qc = r => require.ensure([], () => r(require('./qc')), 'qcs-bundles')

export default [
  {
    name: 'qcs.index',
    path: '/qcs',
    component: Qcs
  },
  {
    name: 'qcs.show',
    path: '/qcs/:id/qc',
    component: Qc
  }
]
