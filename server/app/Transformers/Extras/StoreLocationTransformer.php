<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\StoreLocation;
/**
* Transform storelocation data
*/
class StoreLocationTransformer extends TransformerAbstract
{
	public function transform(StoreLocation $storelocation)
	{
		return [
			'id' => $storelocation->id,
			'location' => $storelocation->location,
			'created_at' => $storelocation->created_at->toIso8601String(),
            'updated_at' => $storelocation->updated_at->toIso8601String()
		];
	}
}