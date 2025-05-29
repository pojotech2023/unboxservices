<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MaterialOrder;
use App\Models\MaterialPayment;
use App\Models\MaterialRequest;
use App\Models\Site;
use App\Models\VendorPayDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{

    public function getMaterial($siteId)
    {
        $site = Site::with('materialOrders')->findOrFail($siteId);

        // Group material orders by lowercase material_type
        $materials = $site->materialOrders->groupBy(function ($item) {
            return strtolower($item->material_type);
        })->mapWithKeys(function ($group, $type) {
            return [
                $type => [
                    'units' => $group->sum('quantity'),
                    'values' => $group->sum('price'),
                ]
            ];
        });

        return response()->json([
            'response code' => 200,
            'data' => $materials,
            'status' => true,
            'message' => 'Material Management fetched successfully.',
        ]);
    }

    public function materialData(Request $request, $siteId, $materialType)
    {
        $monthYear = $request->input('monthYear', now()->format('Y-m')); // default to current month
        $week = $request->input('week'); // optional: 1 to 4

        $startOfMonth = Carbon::createFromFormat('Y-m', $monthYear)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $monthYear)->endOfMonth();

        $query = MaterialOrder::with('vendor')
            ->where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereBetween('date', [$startOfMonth, $endOfMonth]);

        // Apply week filter if provided
        if ($week > 0 && $week <= 4) {
            $weekStart = $startOfMonth->copy()->addDays(($week - 1) * 7);
            $weekEnd = $weekStart->copy()->addDays(6)->min($endOfMonth);
            $query->whereBetween('date', [$weekStart, $weekEnd]);
        }

        $materials = $query->get();

        $totalUnits = $materials->sum('quantity');
        $totalAmount = $materials->sum('price');

        $paymentQuery = MaterialPayment::where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereBetween('date', [$startOfMonth, $endOfMonth]);

        if ($week > 0 && $week <= 4) {
            $paymentQuery->whereBetween('date', [$weekStart, $weekEnd]);
        }

        $settledAmount = $paymentQuery->sum('settled_amount');
        $pendingAmount = $paymentQuery->sum('pending_amount');

        $site = Site::find($siteId);
        $siteName = $site ? $site->site_name : 'Unknown Site';

        return response()->json([
            'siteName' => $siteName,
            'materials' => $materials,
            'totalUnits' => $totalUnits,
            'totalAmount' => $totalAmount,
            'settledAmount' => $settledAmount,
            'pendingAmount' => $pendingAmount,
        ]);
    }

    public function materialRequest(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'site_id'             => 'required|exists:sites,id',
            'vendor_id'           => 'required|exists:vendors,id',
            'material_type'       => 'required|string',
            'quantity'            => 'required',
            'delivery_needed_by'  => 'required',
            'amount'              => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }

        $materialRequest = MaterialRequest::create([
            'site_id'             => $request->site_id,
            'vendor_id'           => $request->vendor_id,
            'material_type'       => $request->material_type,
            'quantity'            => $request->quantity,
            'unit'                => $request->unit,
            'delivery_needed_by'  => $request->delivery_needed_by,
            'amount'              => $request->amount,
            'remarks'             => $request->remarks
        ]);

        return response()->json([
            'response code' => 200,
            'data' => $materialRequest,
            'status' => true,
            'message' => 'Request has been sent successfully.',
        ]);
    }

    public function materialOrder(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'site_id'  => 'required|exists:sites,id',
            'vendor_id' => 'required|exists:vendors,id',
            'material_type' => 'required|string',
            'date' => 'required',
            'quantity' => 'required',
            'price' => 'required'
        ]);

       if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }
        
        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        $materialOrder = MaterialOrder::create([
            'site_id' => $request->site_id,
            'vendor_id' => $request->vendor_id,
            'material_type' => $request->material_type,
            'date' => $date,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'price' => $request->price,
            'available_unit_count' => $request->available_unit_count
        ]);

        $paydetail = VendorPayDetail::where('vendor_id', $request->vendor_id)->first();
        if ($paydetail) {
            $newUnits =   $paydetail->total_units + $request->quantity;
            $newTotalUnitPrice =   $paydetail->total_unit_price + $request->price;
            $newBalanaceAmount =   $paydetail->balance_amount + $request->price;

            $paydetail->update([
                'total_units'  => $newUnits,
                'total_unit_price' => $newTotalUnitPrice,
                'balance_amount' => $newBalanaceAmount
            ]);
        }

        $site = Site::where('id', $request->site_id)->first();
        $oldExpense = $site->expense;

        $site->update([
            'expense' => $oldExpense + $request->price
        ]);

        return response()->json([
            'response code' => 200,
            'data' => $materialOrder,
            'status' => true,
            'message' => 'Order added successfully.',
        ]);
    }
}
