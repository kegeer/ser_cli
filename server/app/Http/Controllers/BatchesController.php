<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Transformers\BatchTransformer;
use Carbon\Carbon;
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
        // $time = $request->get('send_time');
        // // $dd = Carbon::createFromFormat('d/m/Y', $time);
        // // $dd = Carbon::parse($time)->format('d/m/Y');
        // $dd = Carbon::createFromFormat('d/m/Y', $time)->toDateString();
        // dd($dd);
    	$batch = Batch::create([
    		'client_id' => $request->get('client_id'),
            'sample_type' => $request->get('sample_type'),
            'sender' => $request->get('sender'),
            'sender_contact' => $request->get('sender_contact'),
            'send_time' => $request->get('send_time'),
            'arrive_status' => $request->get('arrive_status'),
            'store_location' => $request->get('store_location'),
            'arrive_time' => $request->get('arrive_time'),
            'recipient' => $request->get('recipient'),
            'express_num' => $request->get('express_num'),
            'note' => $request->get('note')
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
            'client_id' => $request->get('client_id'),
            'sample_type' => $request->get('sample_type'),
            'sender' => $request->get('sender'),
            'sender_contact' => $request->get('sender_contact'),
            'send_time' => $request->get('send_time'),
            'arrive_status' => $request->get('arrive_status'),
            'store_location' => $request->get('store_location'),
            'arrive_time' => $request->get('arrive_time'),
            'recipient' => $request->get('recipient'),
            'express_num' => $request->get('express_num'),
    		'note' => $request->get('note')
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
