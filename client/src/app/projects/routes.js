const Projects = r => require.ensure([], () => r(require('./main.vue')), 'batches-bundle')
const Tasks = r => require.ensure([], () => r(require('./components/tasks.vue')), 'batches-bundle')
const AllTasks = r => require.ensure([], () => r(require('./components/allTasks.vue')), 'batches-bundle')

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
  },
  {
    path: '/tasks',
    name: 'allTasks.index',
    component: AllTasks
  }
]
