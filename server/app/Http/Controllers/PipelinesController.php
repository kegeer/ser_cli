<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pipeline;
use App\Transformers\PipelineTransformer;

class PipelinesController extends ApiController
{
    public function index ()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$pipelines = Pipeline::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($pipelines, new PipelineTransformer);
    }
    public function store (Request $request)
    {
    	$pipeline = Pipeline::create([
    		'name' => $request->get('name'),
    		'steps' => $request->get('steps')
    	]);
    	return $this->response->withCreated($pipeline, new PipelineTransformer);
    }
    public function show ($id)
    {
    	$pipeline = $this->findOrNot($id);
    	return $this->response->item($pipeline, new PipelineTransformer);
    }
    public function update (Request $request, $id)
    {
    	$pipeline = $this->findOrNot($id);
    	$pipeline->fill([
    		'name' => $request->get('name'),
    		'steps' => $request->get('steps')
    	])->save();
    	return $this->response->item($pipeline, new PipelineTransformer);
    }
    public function destroy ($id)
    {
    	$pipeline = $this->findOrNot($id);
    	$pipeline->delete();
    	return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $pipeline = Pipeline::find($id);
        if (!$pipeline) {
            return $this->response->withNotFound('pipeline not found');
        }
        return $pipeline;
    }
}
