<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Transformers\ResultTransformer;

class ResultsController extends ApiController
{
    public function index ()
    {
	  	$sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$results = Result::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($results, new ResultTransformer);
    }

    public function store (Request $request)
    {
    	$result = Result::create([
    		'sample_id' => $request->get('sample_id'),
    		'product' => $request->get('product'),
    		'major' => $request->get('major'),
    		'sub' => $request->get('sub'),
    		'revision' => $request->get('revision'),
    		'result' => $request->get('result')
    	]);
    	return $this->response->withCreated($result, new ResultTransformer);
    }
    public function show($id)
    {
    	$result = $this->findOrNot($id);
    	return $this->response->item($result, new ResultTransformer);

    }
    public function destroy($id)
    {
        $result = $this->findOrNot($id);
        $result->delete();
        return $this->response->withNoContent();
    }
    protected function findOrNot($id)
    {
        $result = Result::find($id);
        if (!$result) {
            return $this->response->withNotFound('result not found');
        }
        return $result;
    }
}
