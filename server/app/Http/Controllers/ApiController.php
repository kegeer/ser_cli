<?php

namespace App\Http\Controllers;

use App\Support\Response;
use Illuminate\Http\Request;
use App\Traits\QueryParameters;
use App\Traits\Paginator;

class ApiController extends Controller
{
    use QueryParameters, Paginator;
    protected $response;
    protected $request;
    function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
