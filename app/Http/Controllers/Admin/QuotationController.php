<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;

class QuotationController extends Controller
{
    public function getForm()
    {
        return view('admin.menus.quotation.quotation_add');
    }


   public function store(Request $request)
{
    $validate = Validator::make($request->all(), [
        'name' => 'required',
        'subject' => 'required',
        'date' => 'required|date',
        'mobile_no' => 'required',
        'particular' => 'required|array',
        'rate' => 'required|array',
        'sqFt' => 'required|array',
    ]);

    if ($validate->fails()) {
        return response()->json(['errors' => $validate->errors()], 422);
    }

    $quotation = Quotation::create([
        'name' => $request->name,
        'subject' => $request->subject,
        'date' => $request->date,
        'mobile_no' => $request->mobile_no,
    ]);

    $totalAmount = 0;
    $particulars = [];

    foreach ($request->particular as $index => $part) {
        $rate = $request->rate[$index];
        $sqFt = $request->sqFt[$index];
        $total = $rate * $sqFt;
        $totalAmount += $total;

         // Save each detail
        QuotationDetail::create([
            'quotation_id' => $quotation->id,
            'particular' => $part,
            'rate' => $rate,
            'sqFt' => $sqFt,
            'total_cost' => $total,
        ]);

         // Add to data array for PDF
        $particulars[] = [
            'particular' => $part,
            'rate' => $rate,
            'sqFt' => $sqFt,
            'total_cost' => $total
        ];
    }

    // Update total amount
    $quotation->update(['total_amount' => $totalAmount]);

    // Add data to $quotation object for PDF use
    $quotation->particular = array_column($particulars, 'particular');
    $quotation->rate = array_column($particulars, 'rate');
    $quotation->sqFt = array_column($particulars, 'sqFt');
    $quotation->total_cost = array_column($particulars, 'total_cost');
    $quotation->total_amount = $totalAmount;

    // Generate PDF
    $pdf = Pdf::loadView('admin.helper.pdf_quotation', ['data' => $quotation]);

    // Save PDF
    $pdfPath = 'quotations/quotation_' . $quotation->id . '.pdf';
    Storage::disk('public')->put($pdfPath, $pdf->output());

    // WhatsApp message
    $pdfUrl = asset('storage/' . $pdfPath);
    $message = urlencode("Hi {$quotation->name}, your quotation is ready. Download here: $pdfUrl");
    $whatsappLink = "https://wa.me/91{$quotation->mobile_no}?text=$message";

    return response()->json([
        'status' => 'success',
        'whatsapp_url' => $whatsappLink
    ]);
}

}
