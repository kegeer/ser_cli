<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\Procedures;

class ProceduresController extends ApiController
{
    public function index ()
    {
    	$procedures = Procedures::all();
    	return $procedures;
    }
}
