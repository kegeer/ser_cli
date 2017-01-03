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
			'client_id' => $batch->client_id,
			'sample_type' => $batch->sample_type,
			'sender' => $batch->sender,
			'sender_contact' => $batch->sender_contact,
			'send_time' => $batch->send_time,
			'arrive_status' => $batch->arrive_status,
			'store_location' => $batch->store_location,
			'arrive_time' => $batch->arrive_time,
			'recipient' => $batch->recipient,
			'express_num' => $batch->express_num,
			'note' => $batch->note,
			'created_at' => $batch->created_at->toIso8601String(),
            'updated_at' => $batch->updated_at->toIso8601String(),
		];
	}
}