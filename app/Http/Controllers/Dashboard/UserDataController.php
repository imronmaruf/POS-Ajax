<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserDataController extends Controller
{

    public function index()
    {
        $dataUser = User::all();
        return view('dashboard.data-user.index', compact('dataUser'));
    }
}
