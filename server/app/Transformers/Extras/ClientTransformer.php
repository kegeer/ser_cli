<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Client;
/**
* Transform client data
*/
class ClientTransformer extends TransformerAbstract
{
	public function transform(Client $client)
	{
		return [
			'id' => $client->id,
			'name' => $client->name,
			'contacts' => $client->contacts,
			'location' => $client->location,
			'phone' => $client->phone,
			'email' => $client->email,
			'created_at' => $client->created_at->toIso8601String(),
            'updated_at' => $client->updated_at->toIso8601String(),
		];
	}
}