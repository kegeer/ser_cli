<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Protocol;
use App\Transformers\ProtocolTransformer;

class ProtocolsController extends ApiController
{
    public function index ()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$protocols = Protocol::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($protocols, new ProtocolTransformer);
    }
    public function store (Request $request)
    {
        // dd($request->all());
    	$protocol = Protocol::create([
            'procedure' => $request->get('procedure'),
            'name' => $request->get('name'),
    		'content' => $request->get('content')
    	]);
    	return $this->response->withCreated($protocol, new ProtocolTransformer);
    }
    public function show ($id)
    {
    	$protocol = $this->findOrNot($id);
    	return $this->response->item($protocol, new ProtocolTransformer);
    }
    public function update (Request $request, $id)
    {
    	$protocol = $this->findOrNot($id);
    	$protocol->fill([
    		'procedure' => $request->get('procedure'),
            'name' => $request->get('name'),
            'content' => $request->get('content')
    	])->save();
    	return $this->response->item($protocol, new ProtocolTransformer);
    }
    public function destroy ($id)
    {
    	$protocol = $this->findOrNot($id);
    	$protocol->delete();
    	return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $protocol = Protocol::find($id);
        if (!$protocol) {
            return $this->response->withNotFound('Protocol not found');
        }
        return $protocol;
    }
}
