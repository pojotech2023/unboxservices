<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;

class DashboardController extends Controller
{
    public function getDashboard(Request $request)
{
    $statusFilter = $request->query('status'); // 'All', 'New', 'Ongoing', 'Completed'

    // Filter sites based on status if provided
    $siteQuery = Site::query();

    if ($statusFilter && $statusFilter !== 'All') {
        $siteQuery->where('status', $statusFilter);
    }

    $sites = $siteQuery->latest()->get();

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

    return response()->json([
        'totalSites' => Site::count(),
        'newSites' => Site::where('status', 'New')->count(),
        'ongoingSites' => Site::where('status', 'Ongoing')->count(),
        'completedSites' => Site::where('status', 'Completed')->count(),
        'charts' => $charts,
    ]);
}

}
