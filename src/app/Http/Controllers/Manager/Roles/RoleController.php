<?php

namespace App\Http\Controllers\Manager\Roles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function list()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}