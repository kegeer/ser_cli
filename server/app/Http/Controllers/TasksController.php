<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Transformers\TaskTransformer;

class TasksController extends ApiController
{
    public function projectTasks($id) 
    {
        $data = Project::findOrFail($id)->tasks;
        $tasks = $this->paginateCollection($data, 10);
        return $this->response->collection($tasks, new TaskTransformer);
    }
    public function index()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$tasks = Task::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($tasks, new TaskTransformer);
    }
    public function store(Request $request)
    {
    	// dd($request->all());
    	$task = Task::create([
    		'project_id' => $request->get('project_id'),
    		'pipeline_id' => $request->get('pipeline_id'),
    		'name' => $request->get('name'),
    		'start_time' => $request->get('start_time'),
    		'end_time' => $request->get('end_time')
		]);
		return $this->response->withCreated($task, new TaskTransformer);
    }
    public function show($id)
    {
    	$task = $this->findOrNot($id);
    	return $this->response->item($task, new TaskTransformer);

    }

    public function update(Request $request, $id)
    {
    	$task = $this->findOrNot($id);
    	$task->fill([
    		'pipeline_id' => $request->get('pipeline_id'),
    		'name' => $request->get('name'),
    		'start_time' => $request->get('start_time'),
    		'end_time' => $request->get('end_time')
    	])->save();
        return $this->response->item($task, new TaskTransformer);
    }
    public function destroy($id)
    {
        $task = $this->findOrNot($id);
        $task->delete();
        return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->response->withNotFound('Task not found');
        }
        return $task;
    }
}
