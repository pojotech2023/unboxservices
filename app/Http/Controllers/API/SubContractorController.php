<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Subcontractor;
use App\Models\SubcontractorPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubContractorController extends Controller
{
    //subcontractor management
    public function getSubcontractor($siteId)
    {
        $site = Site::with('subcontractor')->findOrFail($siteId);

        $subcontractors = $site->subcontractor->groupBy(function ($item) {
            return strtolower($item->subcontractor_type);
        })->mapWithKeys(function ($group, $type) {
            return [
                $type =>  [
                    'totalAmounts' => $group->sum('amount')
                ]
            ];
        });

        return response()->json([
            'response code' => 200,
            'data' => $subcontractors,
            'status' => true,
            'message' => 'SubContractor Management fetched successfully.',
        ]);
    }

    //subcontractor management payment list
    public function subcontractorPayList($siteId, $type)
    {
        $subcontractors = Subcontractor::where('subcontractor_type', $type)
            ->where('site_id', $siteId)->get();

        $totalAmount = $subcontractors->sum('amount');

        return response()->json([
            'response code' => 200,
            'data' => [
                'subcontractors' => $subcontractors,
                'total_amount' => $totalAmount
            ],
            'status' => true,
            'message' => 'SubContractor Paylist fetched successfully.',
        ]);
    }

    //subcontractor management add payment
    public function subcontractorAddPay(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'site_id'  => 'required|exists:sites,id',
            'subcontractor_type' => 'required',
            'name'  => 'required',
            'date'  => 'required',
            'amount' => 'required',
            'remarks' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }

        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        $subcontractor = Subcontractor::create([
            'site_id' => $request->site_id,
            'subcontractor_type' => $request->subcontractor_type,
            'name' => $request->name,
            'date' => $date,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'created_by' => auth('api')->id(),
        ]);

        return response()->json([
            'response code' => 200,
            'data' => $subcontractor,
            'status' => true,
            'message' => 'SubContractor payment added successfully!.',
        ]);
    }

    //subcontractor Dashboard
    public function dashboard()
    {
        $types = Subcontractor::select('subcontractor_type')->distinct()->pluck('subcontractor_type');

        $subcontractors = [];

        foreach ($types as $type) {
            $totalAmount = Subcontractor::where('subcontractor_type', $type)->sum('amount');
            $paidAmount = SubcontractorPayment::where('subcontractor_type', $type)->sum('payment');
            $pendingAmount = $totalAmount - $paidAmount;

            $subcontractors[] = [
                'type' => $type,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'pending_amount' => $pendingAmount,
            ];
        }

        return response()->json([
            'response code' => 200,
            'data' => $subcontractors,
            'status' => true,
            'message' => 'SubContractor Dashboard Feteched Successfully!.'
        ]);
    }

    //subcontractor dashboard payment history
    public function paymentHistory($type)
    {
        $payments = SubcontractorPayment::where('subcontractor_type', $type)->orderBy('date', 'desc')->get();

        $paidAmount = $payments->sum('payment');

        return response()->json([
            'response code' => 200,
            'status' => true,
            'data' => [
                'payment_historyList' => $payments,
                'total_paidAmount' => $paidAmount
            ],
            'message' => 'SubContractor payment history fetched successfully!.'
        ]);
    }

    //subcontractor dashboard add payment 
    public function addPayment(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'subcontractor_type' => 'required',
            'name' => 'required',
            'payment' => 'required|numeric',
            'date' => 'required|date',
            'payment_mode' => 'required'
        ]);

         if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }

        $date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');

        $payment = SubcontractorPayment::create([
            'subcontractor_type' => $request->subcontractor_type,
            'name' => $request->name,
            'payment' => $request->payment,
            'date' => $date,
            'payment_mode' => $request->payment_mode,
            'created_by' => auth('api')->id(),
        ]);

         return response()->json([
            'response code' => 200,
            'status' => true,
            'data' => $payment,
            'message' => 'SubContractor payment added successfully!.'
        ]);
       
    }
}
