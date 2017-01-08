<?php
namespace App\Utils;
class Procedures
{
	public static function all()
	{
		return [
		  '1' => '样品分装',
		  '2' => '核酸提取',
		  '3' => '模板稀释',
		  '4' => '样品分布',
		  '5' => '产物分析',
		  '6' => '产物Pooling',
		  '7' => '文库构建',
		  '8' => '上机测序'
		];
	}
}