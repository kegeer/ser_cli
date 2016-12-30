const Dashboard = r => require.ensure([], () => r(require('./main')), 'dashboard-bundle')

export default [
  {
    name: 'dashboard.index',
    path: '/',
    component: Dashboard,
    meta: { requiresAuth: true }
  }, {
    name: 'catchall',
    path: '*',
    component: Dashboard,
    meta: { requiresAuth: true }
  }
]
