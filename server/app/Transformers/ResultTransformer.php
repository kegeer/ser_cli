<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Result;
/**
* Transform result data
*/
class ResultTransformer extends TransformerAbstract
{
	public function transform(Result $result)
	{
		return [
			'id' => $result->id,
			'sample_id' => $result->sample_id,
			'product' => $result->product,
			'major' => $result->major,
			'sub' => $result->sub,
			'revision' => $result->revision,
			'result' => $result->result,
			'created_at' => $result->created_at->toIso8601String(),
            'updated_at' => $result->updated_at->toIso8601String(),
		];
	}
}