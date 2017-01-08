<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Transformers\ProjectTransformer;

class ProjectsController extends ApiController
{
    public function index()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$projects = Project::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($projects, new ProjectTransformer);
    }
    public function store(Request $request)
    {
    	// dd($request->all());
    	$project = Project::create([
    		'name' => $request->get('name'),
    		'manager' => $request->get('manager')
		]);
		return $this->response->withCreated($project, new ProjectTransformer);
    }
    public function show($id)
    {
    	$project = $this->findOrNot($id);
    	return $this->response->item($project, new ProjectTransformer);

    }

    public function update(Request $request, $id)
    {
    	$project = $this->findOrNot($id);
    	$project->fill([
    		'name' => $request->get('name'),
    		'manager' => $request->get('manager')
    	])->save();
        return $this->response->item($project, new ProjectTransformer);
    }
    public function destroy($id)
    {
        $project = $this->findOrNot($id);
        $project->delete();
        return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return $this->response->withNotFound('Project not found');
        }
        return $project;
    }
}
