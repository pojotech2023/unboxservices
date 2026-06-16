<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboard()
{
    return view('admin.menus.dashboard');
      
}

}
