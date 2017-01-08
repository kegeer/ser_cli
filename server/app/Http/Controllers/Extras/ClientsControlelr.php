<?php

namespace App\Http\Controllers\Extras;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\Client;
use App\Transformers\ClientTransformer;

class ClientsControlelr extends ApiController
{
    public function index()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$clients = Client::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($clients, new ClientTransformer);
    }
    public function store(Request $request)
    {
    	// dd($request->all());
    	$client = Client::create([
    		'name' => $request->get('name'),
    		'contacts' => $request->get('contacts'),
    		'location' => $request->get('location'),
    		'phone' => $request->get('phone'),
    		'email' => $request->get('email')
		]);
		return $this->response->withCreated($client, new ClientTransformer);
    }
    public function show($id)
    {
    	$client = $this->findOrNot($id);
    	return $this->response->item($client, new ClientTransformer);

    }

    public function update(Request $request, $id)
    {
    	$client = $this->findOrNot($id);
    	$client->fill([
    		'name' => $request->get('name'),
    		'contacts' => $request->get('contacts'),
    		'location' => $request->get('location'),
    		'phone' => $request->get('phone'),
    		'email' => $request->get('email')
    	])->save();
        return $this->response->item($client, new ClientTransformer);
    }
    public function destroy($id)
    {
        $client = $this->findOrNot($id);
        $client->delete();
        return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $client = Client::find($id);
        if (!$client) {
            return $this->response->withNotFound('client not found');
        }
        return $client;
    }
}
