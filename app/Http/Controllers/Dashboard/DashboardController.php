<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Owner\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::where('role', '!=', 'owner')->count();
        $storeCount = Store::count();
        return view('dashboard.index', compact('userCount', 'storeCount'));
    }
}
