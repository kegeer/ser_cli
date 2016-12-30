<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Project;
/**
* Transform project data
*/
class ProjectTransformer extends TransformerAbstract
{
	public function transform(Project $project)
	{
		return [
			'id' => $project->id,
			'name' => $project->name,
			'manager' => $project->manager,
			'created_at' => $project->created_at->toIso8601String(),
            'updated_at' => $project->updated_at->toIso8601String(),
		];
	}
}