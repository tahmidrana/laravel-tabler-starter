<?php

namespace App\Http\Controllers\Admin\AdminConsole;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::query()
            ->orderBy('id')
            ->get();

        return view('admin.admin-console.permissions.index', compact('permissions'));
    }
}
