<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Qc;
/**
* Transform Batch data
*/
class QcTransformer extends TransformerAbstract
{
	public function transform(Qc $qc)
	{
		return [
			'id' => $qc->id,
			'run_id' => $qc->run_id,
			'summary' => $qc->summary,
			'index' => $qc->index,
			'cycle' => $qc->cycle,
			'hist' => $qc->hist,
			'created_at' => $qc->created_at->toIso8601String(),
            'updated_at' => $qc->updated_at->toIso8601String(),
		];
	}
}