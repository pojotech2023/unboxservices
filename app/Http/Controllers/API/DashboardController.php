<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Site;

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
            $charts[] = [
                'site_name' => $site->site_name,
                'status' => $site->status,
                'data' => [
                    'pending' => (float) $site->pending_amnt,
                    'settled' => (float) $site->settled_amnt,
                    'total' => (float) $site->value,
                ],
            ];
        }

        return response()->json([
            'totalSites' => $totalSites,
            'newSites' => $newSites,
            'ongoingSites' => $ongoingSites,
            'completedSites' => $completedSites,
            'charts' => $charts,
        ]);
    }
}
