<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Protocol;
/**
* Transform Batch data
*/
class ProtocolTransformer extends TransformerAbstract
{
	public function transform(Protocol $protocol)
	{
		return [
			'id' => $protocol->id,
			'procedure' => $protocol->procedure,
			'name' => $protocol->name,
			'content' => $protocol->content,
			'created_at' => $protocol->created_at->toIso8601String(),
            'updated_at' => $protocol->updated_at->toIso8601String(),
		];
	}
}