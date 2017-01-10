<?php
namespace App\Utils;
class Procedures
{
	public static function all()
	{
		return [
			[
				'id' => 1,
				'name' => '样品分装'
			],
			[
				'id' => 2,
				'name' => '核酸提取'
			],
			[
				'id' => 3,
				'name' => '模板稀释'
			],
			[
				'id' => 4,
				'name' => '样品分布'
			],
			[
				'id' => 5,
				'name' => '产物分析'
			],
			[
				'id' => 6,
				'name' => '产物Pooling'
			],
			[
				'id' => 7,
				'name' => '文库构建'
			],
			[
				'id' => 8,
				'name' => '上机测序'
			]
		];
	}
}