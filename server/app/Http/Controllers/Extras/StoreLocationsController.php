<?php

namespace App\Http\Controllers\Extras;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\StoreLocation;
use App\Transformers\StoreLocationTransformer;

class StoreLocationsController extends ApiController
{
    public function index()
    {
    	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$storelocations = StoreLocation::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($storelocations, new StoreLocationTransformer);
    }
    public function store(Request $request)
    {
    	// dd($request->all());
    	$storelocation = StoreLocation::create([
    		'location' => $request->get('location')
		]);
		return $this->response->withCreated($storelocation, new StoreLocationTransformer);
    }
    public function show($id)
    {
    	$storelocation = $this->findOrNot($id);
    	return $this->response->item($storelocation, new StoreLocationTransformer);

    }

    public function update(Request $request, $id)
    {
    	$storelocation = $this->findOrNot($id);
    	$storelocation->fill([
    		'location' => $request->get('location')
    	])->save();
        return $this->response->item($storelocation, new StoreLocationTransformer);
    }
    public function destroy($id)
    {
        $storelocation = $this->findOrNot($id);
        $storelocation->delete();
        return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $storelocation = StoreLocation::find($id);
        if (!$storelocation) {
            return $this->response->withNotFound('storelocation not found');
        }
        return $storelocation;
    }
}
