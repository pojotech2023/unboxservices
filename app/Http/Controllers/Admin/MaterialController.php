<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialOrder;
use App\Models\MaterialPayment;
use App\Models\MaterialRequest;
use App\Models\Site;
use App\Models\VendorPayDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    //Material management
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

        return view('admin.menus.material.material_management', compact('site', 'materials'));
    }


    // Material details
    public function index($siteId, $materialType)
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $materials = MaterialOrder::with('vendor')
            ->where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get();

        $site = Site::find($siteId);
        $siteName = $site ? $site->site_name : 'Unknown Site';

        $totalUnits = MaterialOrder::where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('quantity');

        $totalAmount = MaterialOrder::where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('price');

        $settledAmount = MaterialPayment::where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('settled_amount');

        $pendingAmount = MaterialPayment::where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('pending_amount');

        return view('admin.menus.material.material_details', compact(
            'materials',
            'siteId',
            'siteName',
            'totalAmount',
            'settledAmount',
            'pendingAmount',
            'totalUnits',
            'materialType'
        ));
    }

    // Material details
    public function getMaterialData(Request $request, $siteId)
    {
        $monthYear = $request->input('monthYear'); // format: YYYY-MM
        $week = (int) $request->input('week'); // 1, 2, 3, 4
        $materialType = $request->input('material_type');

        $startOfMonth = Carbon::createFromFormat('Y-m', $monthYear)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('Y-m', $monthYear)->endOfMonth();

        // Default to full month
        $startDate = $startOfMonth->copy();
        $endDate = $endOfMonth->copy();

        // If specific week selected (1 to 4)
        if ($week >= 1 && $week <= 4) {
            $daysInMonth = $startOfMonth->daysInMonth;
            $weekLength = ceil($daysInMonth / 4); // usually 7 or 8 days

            $startDate = $startOfMonth->copy()->addDays(($week - 1) * $weekLength);
            $endDate = $startDate->copy()->addDays($weekLength - 1);

            // Limit to end of month
            if ($endDate->gt($endOfMonth)) {
                $endDate = $endOfMonth;
            }
        }

        $materials = MaterialOrder::with('vendor')
            ->where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalUnits = $materials->sum('quantity');
        $totalAmount = $materials->sum('price');

        $settledAmount = MaterialPayment::where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('settled_amount');

        $pendingAmount = MaterialPayment::where('site_id', $siteId)
            ->where('material_type', $materialType)
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('pending_amount');

        return response()->json([
            'bricks' => $materials,
            'totalUnits' => $totalUnits,
            'totalAmount' => $totalAmount,
            'settledAmount' => $settledAmount,
            'pendingAmount' => $pendingAmount,
        ]);
    }

    // Material get request form
    public function getRequestForm($siteId, $materialType)
    {
        return view('admin.menus.material.add_request', compact('siteId', 'materialType'));
    }

    // Material add request form
    public function materialRequest(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'site_id'             => 'required|exists:sites,id',
            'vendor_id'           => 'required|exists:vendors,id',
            'vendor_name'         => 'required',
            'vendor_mobile'       => 'required',
            'material_type'       => 'required|string',
            'quantity'            => 'required',
            'unit'                => 'required',
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
            'remarks'             => $request->remarks,
            'created_by'  => auth('admin')->id(),
        ]);

        $site = Site::find($request->site_id);

        // Save PDF
        // Storage::makeDirectory('public/whatsapp_pdfs');
        // $pdf = Pdf::loadView('admin.helper.pdf_request', [
        //     'type' => 'request',
        //     'request' => $materialRequest,
        //     'vendor_name' => $request->vendor_name,
        //     'vendor_address' => $request->vendor_address
        // ]);
        // $filename = 'material_request_' . Str::slug($request->vendor_name) . '_' . now()->format('Ymd_His') . '.pdf';
        // Storage::put("public/whatsapp_pdfs/$filename", $pdf->output());
        // $publicLink = asset("storage/whatsapp_pdfs/$filename");

        // $whatsappUrl = "https://wa.me/{$request->vendor_mobile}?text=" . urlencode("\n$publicLink\n\n");

        $message = "* ValliHomes *\n"
            . "Site Name: {$site->site_name} - Material Request\n"
            . "Vendor Name: {$request->vendor_name}\n"
            . "Mobile Number: {$request->vendor_mobile}\n"
            . "Material Type: {$request->material_type}\n"
            . "Quantity: {$request->quantity} {$request->unit}\n"
            . "Delivery By: {$request->delivery_needed_by}\n"
            . "Amount: ₹{$request->amount}\n"
            . (!empty($request->remarks) ? "Remarks: {$request->remarks}\n" : "");

        $whatsappUrl = "https://wa.me/{$request->vendor_mobile}?text=" . urlencode($message);

        return response()->json([
            'status' => 'success',
            'message' => 'Request has been sent successfully.',
            'whatsapp_url' => $whatsappUrl
        ]);
    }

    // Material get order form
    public function getOrderForm($siteId, $materialType)
    {
        return view('admin.menus.material.add_order', compact('siteId', 'materialType'));
    }

    // Material add order form
    public function materialOrder(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'site_id'  => 'required|exists:sites,id',
            'vendor_id' => 'required|exists:vendors,id',
            'vendor_name'         => 'required',
            'vendor_mobile'       => 'required',
            'vendor_address' => 'required',
            'material_type' => 'required|string',
            'date' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $material_order = MaterialOrder::create([
            'site_id' => $request->site_id,
            'vendor_id' => $request->vendor_id,
            'material_type' => $request->material_type,
            'date' => $request->date,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'price' => $request->price,
            'created_by'  => auth('admin')->id(),
            // 'available_unit_count' => $request->available_unit_count
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
        } else {
            VendorPayDetail::create([
                'vendor_id'         => $request->vendor_id,
                'total_units' => $request->quantity,
                'total_unit_price' => $request->price,
                'balance_amount'  => $request->price,
                'created_by'  => auth('admin')->id(),
            ]);
        }

        $site = Site::where('id', $request->site_id)->first();
        $oldExpense = $site->expense;

        $site->update([
            'expense' => $oldExpense + $request->price
        ]);

        $site = Site::find($request->site_id);

        // Save PDF
        // Storage::makeDirectory('public/whatsapp_pdfs');
        // $pdf = Pdf::loadView('admin.helper.pdf_order', [
        //     'type' => 'order',
        //     'request' => $material_order,
        //     'vendor_name' => $request->vendor_name,
        //     'vendor_address' => $request->vendor_address
        // ]);
        // $filename = 'material_order' . Str::slug($request->vendor_name) . '_' . now()->format('Ymd_His') . '.pdf';
        // Storage::put("public/whatsapp_pdfs/$filename", $pdf->output());
        // $publicLink = asset("storage/whatsapp_pdfs/$filename");

        // $whatsappUrl = "https://wa.me/{$request->vendor_mobile}?text=" . urlencode("\n$publicLink\n\n");

        $message = "* ValliHomes *\n"
            . "Site Name: {$site->site_name} - Material Order\n"
            . "Vendor Name: {$request->vendor_name}\n"
            . "Vendor Address: {$request->vendor_address}\n"
            . "Mobile Number: {$request->vendor_mobile}\n"
            . "Material Type: {$request->material_type}\n"
            . "Date: " . Carbon::parse($request->date)->format('d-m-Y') . "\n"
            . "Quantity: {$request->quantity}\n"
            . "Unit: {$request->unit}\n"
            . "Price: ₹{$request->price}\n";

        $whatsappUrl = "https://wa.me/{$request->vendor_mobile}?text=" . urlencode($message);

        return response()->json([
            'status' => 'success',
            'message' => 'Material order placed successfully.',
            'whatsapp_url' => $whatsappUrl
        ]);
    }

    public function materialPayment(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'site_id'  => 'required|exists:sites,id',
            'vendor_id' => 'required|exists:vendors,id',
            'material_type' => 'required|string',
            'quantity' => 'required',
            'date'  => 'required',
            'total_amount' => 'required',
            'settled_amount' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $materialPayment = MaterialPayment::create([
            'site_id' => $request->site_id,
            'vendor_id' => $request->vendor_id,
            'material_type' => $request->material_type,
            'date' => $request->date,
            'quantity' => $request->quantity,
            'total_amount' => $request->total_amount,
            'settled_amount' => $request->settled_amount,
            'pending_amount' => $request->pending_amount,
            'remarks' => $request->remarks,
            'created_by'  => auth('admin')->id(),
        ]);

        // Save PDF
        Storage::makeDirectory('public/whatsapp_pdfs');
        $pdf = Pdf::loadView('admin.helper.pdf_request', [
            'request' => $materialPayment,
            'vendor_name' => $request->vendor_name
        ]);
        $filename = 'material_request_' . Str::slug($request->vendor_name) . '_' . now()->format('Ymd_His') . '.pdf';
        Storage::put("public/whatsapp_pdfs/$filename", $pdf->output());
        $publicLink = asset("storage/whatsapp_pdfs/$filename");

        $whatsappUrl = "https://wa.me/{$request->vendor_mobile}?text=" . urlencode("\n$publicLink\n\n");

        return response()->json([
            'status' => 'success',
            'message' => 'Request has been sent successfully.',
            'whatsapp_url' => $whatsappUrl
        ]);
    }
}
