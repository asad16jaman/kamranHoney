<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $orderCount = Order::count();
        return view('admin.pages.dashboard', compact('orderCount'));
    }
}
