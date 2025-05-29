<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class GenerateQuotationController extends Controller
{

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
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }

         $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        $quotation = Quotation::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'date' => $date,
            'mobile_no' => $request->mobile_no,
        ]);

        $totalAmount = 0;

        foreach ($request->particular as $index => $particular) {
            $rate = $request->rate[$index];
            $sqFt = $request->sqFt[$index];
            $total = $rate * $sqFt;
            $totalAmount += $total;

            $quotation_details = QuotationDetail::create([
                'quotation_id' => $quotation->id,
                'particular' => $particular,
                'rate' => $rate,
                'sqFt' => $sqFt,
                'total_cost' => $total,
            ]);
        }

        // Update the total amount in the quotation
        $quotation->total_amount = $totalAmount;
        $quotation->save();

        return response()->json([
            'response code' => 200,
            'data' => [
                'quotation' => $quotation,
                'quotation_details' => $quotation_details
            ],
            'status' => true,
            'message' => 'Generate Quotation created successfully.',
        ]);
    }
}
