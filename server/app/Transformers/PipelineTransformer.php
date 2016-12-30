<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Pipeline;
/**
* Transform Batch data
*/
class PipelineTransformer extends TransformerAbstract
{
	public function transform(Pipeline $pipeline)
	{
		return [
			'id' => $pipeline->id,
			'name' => $pipeline->name,
			'steps' => $pipeline->steps,
			'created_at' => $pipeline->created_at->toIso8601String(),
            'updated_at' => $pipeline->updated_at->toIso8601String(),
		];
	}
}