<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Transformers\BatchTransformer;

class BatchesController extends ApiController
{
    public function index()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$batches = Batch::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($batches, new BatchTransformer);
    }
    public function store(Request $request)
    {
    	// dd($request->all());
    	$batch = Batch::create([
    		'py_num' => $request->get('py_num'),
    		'ori_num' => $request->get('ori_num'),
		]);
		return $this->response->withCreated($batch, new BatchTransformer);
    }
    public function show($id)
    {
    	$batch = $this->findOrNot($id);
    	return $this->response->item($batch, new BatchTransformer);

    }

    public function update(Request $request, $id)
    {
    	$batch = $this->findOrNot($id);
    	$batch->fill([
    		'py_num' => $request->get('py_num'),
    		'ori_num' => $request->get('ori_num')
    	])->save();
        return $this->response->item($batch, new BatchTransformer);
    }
    public function destroy($id)
    {
        $batch = $this->findOrNot($id);
        $batch->delete();
        return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $batch = Batch::find($id);
        if (!$batch) {
            return $this->response->withNotFound('batch not found');
        }
        return $batch;
    }
}
