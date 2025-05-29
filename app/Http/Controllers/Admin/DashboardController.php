<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboard()
{
    $totalSites = Site::count();
    $newSites = Site::where('status', 'New')->count();
    $ongoingSites = Site::where('status', 'Ongoing')->count();
    $completedSites = Site::where('status', 'Completed')->count();

    $sites = Site::latest()->get();
    $charts = [];

    foreach ($sites as $site) {
        $pending = (float) $site->pending_amnt;
        $settled = (float) $site->settled_amnt;
        $total = (float) $site->value;

        $charts[] = [
            'site_name' => $site->site_name,
            'status' => $site->status,
            'data' => [$pending, $settled, $total],
        ];
    }

    return view('admin.menus.dashboard', compact(
        'totalSites',
        'newSites',
        'ongoingSites',
        'completedSites',
        'charts'
    ));
}

}
