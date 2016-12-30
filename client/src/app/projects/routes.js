const Projects = r => require.ensure([], () => r(require('./main.vue')), 'batches-bundle')
const Tasks = r => require.ensure([], () => r(require('./tasks.vue')), 'batches-bundle')

export default [
  {
    path: '/projects',
    name: 'projects.index',
    component: Projects
  },
  {
    path: '/projects/:id/tasks',
    name: 'tasks.index',
    component: Tasks
  }
]
