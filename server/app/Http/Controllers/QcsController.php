<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qc;
use App\Transformers\QcTransformer;

class QcsController extends ApiController
{
    public function index ()
    {
		  $sort = $this->getSort();
    	$order = $this->getOrder();
    	$limit = $this->getLimit();
    	$qcs = Qc::orderBy($sort, $order)->paginate($limit);
    	return $this->response->collection($qcs, new QcTransformer);
    }
    public function store (Request $request)
    {
    	$project = Qc::create([
    		'run_id' => $request->get('run_id'),
    		'summary' => $request->get('summary'),
    		'index' => $request->get('index'),
    		'cycle' => $request->get('cycle'),
    		'hist' => $request->get('hist'),
  		]);
  		return $this->response->withCreated($qc, new QcTransformer);
    }
    public function show ($id)
    {
        $qc = Qc::findOrFail($id);
        return $this->response->item($qc, new QcTransformer);
    }
}
