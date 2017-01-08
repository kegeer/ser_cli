<?php
namespace App\Traits;
use Illuminate\Pagination\LengthAwarePaginator;

trait Paginator 
{

	public function paginateCollection($collection, $perPage)
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $collection->slice(($currentPage - 1)*$perPage, $perPage);
        $paginator = new LengthAwarePaginator($currentPageItems, $collection->count(), $perPage);
        $queryString = request()->getQueryString() ? preg_replace('/&*page=[0-9]+/','',request()->getQueryString()) : '';
        $paginator->setPath(LengthAwarePaginator::resolveCurrentPath() . $queryString);
        return $paginator;
    }
}