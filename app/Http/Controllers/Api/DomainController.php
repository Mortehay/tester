<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain;
use App\Http\Resources\Domain as ResourceDomain;

class DomainController extends Controller
{
    public function getAll()
    {
        $domains = Domain::orderBy('created_at','desc')->paginate(5);
        // returnn collection of domains as a resource
        return  ResourceDomain::collection($domains);
    }
}
