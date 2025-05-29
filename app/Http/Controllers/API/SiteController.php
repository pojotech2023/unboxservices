<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    //site management list
    public function index()
    {
        $sites = Site::with('customer')
            ->where('is_inactive', 0)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'response code' => 200,
            'data' => $sites,
            'status' => true,
            'message' => 'Sites Feteched Successfully!.'
        ]);
    }

    //site details
    public function siteDetail($id)
    {
        $site = Site::with('materialOrders')->where('id', $id)->first();

        // Group material orders by material_type and format each item
        $materials = $site->materialOrders->groupBy('material_type')->map(function ($group, $type) {
            return [
                'material_type' => $type,
                $type . ' units' => $group->sum('quantity'),
                $type . ' total units values' => $group->sum('price'),
            ];
        })->values();

        return response()->json([
            'response code' => 200,
            'data' => $materials,
            'status' => true,
            'message' => 'Site fetched successfully!',
        ]);
    }
}
