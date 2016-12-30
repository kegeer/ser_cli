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
			'start_time' => $task->start_time,
			'end_time' => $task->end_time,
			'created_at' => $task->created_at->toIso8601String(),
            'updated_at' => $task->updated_at->toIso8601String()
		];
	}
}