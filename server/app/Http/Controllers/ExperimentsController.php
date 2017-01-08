<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experiment;
use App\Transformers\ExperimentTransformer;

class ExperimentsController extends ApiController
{
    public function splits () {
    	return $this->stepData(1);
    }

    public function extractions () {
    	return $this->stepData(2);
    }
    public function dilutions () {
    	return $this->stepData(3);
    }

    public function distributions () {
    	return $this->stepData(4);
    }

    public function analysises () {
    	return $this->stepData(5);
    }

    public function poolings () {
    	return $this->stepData(6);
    }

    public function libraries () {
    	return $this->stepData(7);
    }

    public function sequences () {
    	return $this->stepData(8);
    }

	public function update (Request $request, $id)
    {
    	$exp = Experiment::findOrFail($id);
    	if ($request->get('next')) {
    		$this->moveToNext($exp)->save();
    	} else {
    		$data = $request->except(['_url']);
	    	$exp->quality = $data;
	    	$exp->save();
    	}
		return $this->response->item($exp, new ExperimentTransformer);
    }
    public function stepData ($id)
    {
    	$data = $this->paginateCollection(Experiment::where('current_step_id', $id)->get(), 10);
    	return $this->response->collection($data, new ExperimentTransformer);
    }
    protected function findOrNot($id)
    {
        $experiment = Experiment::find($id);
        if (!$experiment) {
            return $this->response->withNotFound('experiment not found');
        }
        return $experiment;
    }
    protected function moveToNext ($exp)
    {
    	// $pipeline = Task::where('sample_id', $exp->sample_id)->get()->pipeline;
    	// TODO: here is the task sample experiment connection
    	$exp->current_step += 1;
    	$exp->current_step_id += 1;
    	// $exp->current_step_id = $pipeline[$exp->current_step]['procedure_id'];
    	return $exp;
    }
}
