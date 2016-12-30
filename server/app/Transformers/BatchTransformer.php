<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Batch;
/**
* Transform Batch data
*/
class BatchTransformer extends TransformerAbstract
{
	public function transform(Batch $batch)
	{
		return [
			'id' => $batch->id,
			'py_num' => $batch->py_num,
			'ori_num' => $batch->ori_num,
			'created_at' => $batch->created_at->toIso8601String(),
            'updated_at' => $batch->updated_at->toIso8601String(),
		];
	}
}