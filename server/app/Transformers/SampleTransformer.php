<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Sample;
/**
* Transform sample data
*/
class SampleTransformer extends TransformerAbstract
{
	public function transform(Sample $sample)
	{
		return [
			'id' => $sample->id,
			'batch_id' => $sample->batch_id,
			'ori_num' => $sample->ori_num,
			'py_num' => $sample->py_num,
			'sample_amount_type' => $sample->sample_amount_type,
			'sample_amount' => $sample->sample_amount,
			'sample_status' => $sample->sample_status,
			'created_at' => $sample->created_at->toIso8601String(),
            'updated_at' => $sample->updated_at->toIso8601String(),
		];
	}
}