<?php

namespace App\Http\Controllers;

use App\Services\Users\CreateUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request, CreateUser $service)
    {
        return $service->execute($request);
    }
}
