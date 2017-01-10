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
        $res = [];
        $samples = $request->all();
        foreach ($samples as $sample) {
            $res = Sample::create([
            'batch_id' => $sample['batch_id'],
            'ori_num' => $sample['ori_num'],
            'py_num' => $sample['py_num'],
            'sample_amount_type' => $sample['sample_amount_type'],
            'sample_amount' => $sample['sample_amount'],
            'sample_status' => $sample['sample_status']
            ]);
        }
		return $this->response->withCreated($res, new SampleTransformer);
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
            'batch_id' => $request->get('batch_id'),
            'ori_num' => $request->get('ori_num'),
            'py_num' => $request->get('py_num'),
            'sample_amount_type' => $request->get('sample_amount_type'),
            'sample_amount' => $request->get('sample_amount'),
            'sample_status' => $request->get('sample_status')
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
