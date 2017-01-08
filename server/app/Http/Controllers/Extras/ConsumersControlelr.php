<?php

namespace App\Http\Controllers\Extras;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Consumer;
use App\Transformers\ConsumerTransformer;

class ConsumersControlelr extends ApiController
{
    public function index()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$consumers = Consumer::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($consumers, new ConsumerTransformer);
    }
    public function store(Request $request)
    {
    	// dd($request->all());
    	$consumer = Consumer::create([
    		'client_id' => $request->get('client_id'),
    		'name' => $request->get('name'),
    		'gender' => $request->get('gender'),
    		'age' => $request->get('age'),
    		'height' => $request->get('height'),
    		'weight' => $request->get('weight'),
    		'waistline' => $request->get('waistline'),
    		'phone' => $request->get('phone'),
    		'disease' => $request->get('disease'),
    		'disease_history' => $request->get('disease_history')
		]);
		return $this->response->withCreated($consumer, new ConsumerTransformer);
    }
    public function show($id)
    {
    	$consumer = $this->findOrNot($id);
    	return $this->response->item($consumer, new ConsumerTransformer);

    }

    public function update(Request $request, $id)
    {
    	$consumer = $this->findOrNot($id);
    	$consumer->fill([
    		'client_id' => $request->get('client_id'),
    		'name' => $request->get('name'),
    		'gender' => $request->get('gender'),
    		'age' => $request->get('age'),
    		'height' => $request->get('height'),
    		'weight' => $request->get('weight'),
    		'waistline' => $request->get('waistline'),
    		'phone' => $request->get('phone'),
    		'disease' => $request->get('disease'),
    		'disease_history' => $request->get('disease_history')
    	])->save();
        return $this->response->item($consumer, new ConsumerTransformer);
    }
    public function destroy($id)
    {
        $consumer = $this->findOrNot($id);
        $consumer->delete();
        return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $consumer = Consumer::find($id);
        if (!$consumer) {
            return $this->response->withNotFound('consumer not found');
        }
        return $consumer;
    }
}
