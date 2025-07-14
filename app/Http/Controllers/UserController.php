<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $request): View 
    {
        return view('admin.users.index', compact('users'));
    }
}
