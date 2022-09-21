<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateAdminRequest;


class AdminController extends Controller
{
    public function ReturnAdminManagement() {
        return view('adminManagement')->with('admins', 
            DB::table('admins')
            ->where('deleted_at', '=', null)
            ->select('id', 'name', 'email')
            ->get()
            );
    }
}
