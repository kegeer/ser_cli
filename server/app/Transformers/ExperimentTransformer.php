<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Experiment;
/**
* Transform Batch data
*/
class ExperimentTransformer extends TransformerAbstract
{
	public function transform(Experiment $experiment)
	{
		return [
			'id' => $experiment->id,
			'sample_id' => $experiment->sample_id,
			'current_step' => $experiment->current_step,
			'current_step_i' => $experiment->current_step_id,
			'status' => $experiment->status,
			'quality' => $experiment->quality,
			'created_at' => $experiment->created_at->toIso8601String(),
            'updated_at' => $experiment->updated_at->toIso8601String(),
		];
	}
}