<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Task;
/**
* Transform task data
*/
class TaskTransformer extends TransformerAbstract
{
	public function transform(Task $task)
	{
		return [
			'id' => $task->id,
			'name' => $task->name,
			'project_id' => $task->project_id,
			'pipeline_id' => $task->pipeline_id,
			'exp_manager' => $task->exp_manager,
			'info_manager' => $task->info_manager,
			'datetime_range' => [
				0 => $task->start_time,
				1 => $task->end_time
			],
			'created_at' => $task->created_at->toIso8601String(),
            'updated_at' => $task->updated_at->toIso8601String()
		];
	}
}