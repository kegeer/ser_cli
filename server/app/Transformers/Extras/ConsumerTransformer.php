<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Client;
/**
* Transform client data
*/
class ConsumerTransformer extends TransformerAbstract
{
	public function transform(Client $client)
	{
		return [
			'id' => $client->id,
			'client_id' => $client->client_id,
			'name' => $client->name,
			'gender' => $client->gender,
			'age' => $client->age,
			'height' => $client->height,
			'weight' => $client->weight,
			'waistline' => $client->waistline,
			'phone' => $client->phone,
			'disease' => $client->disease,
			'disease_history' => $client->disease_history,
			'created_at' => $client->created_at->toIso8601String(),
            'updated_at' => $client->updated_at->toIso8601String(),
		];
	}
}