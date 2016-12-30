import { routes as dashboard } from './dashboard'
import { routes as batches } from './batches'
import { routes as projects } from './projects'
import { routes as pipelines } from './pipelines'
import { routes as experiments } from './experiments'
import { routes as qcs } from './qcs'
import { routes as results } from './results'

export default [...pipelines, ...results, ...qcs, ...experiments, ...projects, ...batches, ...dashboard]
