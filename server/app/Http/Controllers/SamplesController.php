<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sample;
use App\Models\Batch;
use App\Transformers\SampleTransformer;
use Illuminate\Pagination\LengthAwarePaginator;

class SamplesController extends ApiController
{
    public function batchSamples($id) 
    {
        $data = Batch::findOrFail($id)->samples;
        $samples = $this->paginateCollection($data, 10);
        return $this->response->collection($samples, new SampleTransformer);
    }
    public function index()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$samples = Sample::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($samples, new SampleTransformer);
    }
    public function store(Request $request)
    {
    	// dd($request->all());
    	$sample = Sample::create([
    		'batch_id' => $request->get('batch_id'),
    		'py_num' => $request->get('py_num'),
    		'ori_num' => $request->get('ori_num'),
		]);
		return $this->response->withCreated($sample, new SampleTransformer);
    }
    public function show($id)
    {
    	$sample = $this->findOrNot($id);
    	return $this->response->item($sample, new SampleTransformer);

    }

    public function update(Request $request, $id)
    {
    	$sample = $this->findOrNot($id);
    	$sample->fill([
    		'py_num' => $request->get('py_num'),
    		'ori_num' => $request->get('ori_num')
    	])->save();
        return $this->response->item($sample, new SampleTransformer);
    }
    public function destroy($id)
    {
        $sample = $this->findOrNot($id);
        $sample->delete();
        return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $sample = Sample::find($id);
        if (!$sample) {
            return $this->response->withNotFound('Sample not found');
        }
        return $sample;
    }
}
