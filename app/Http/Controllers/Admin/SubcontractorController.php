<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Subcontractor;
use App\Models\SubcontractorPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubcontractorController extends Controller
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
        return view('admin.menus.subcontractor.subcontractor_management', compact('site', 'subcontractors'));
    }

    //subcontractor management payment list
    public function subcontractorPayList($siteId, $type)
    {
        $subcontractors = Subcontractor::where('subcontractor_type', $type)
            ->where('site_id', $siteId)->get();

        $totalAmount = $subcontractors->sum('amount');

        return view('admin.menus.subcontractor.subcontractor_paydetail', compact('subcontractors', 'siteId', 'totalAmount', 'type'));
    }

    //subcontractor management add payment
    public function subcontractorAddPay(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'site_id'  => 'required|exists:sites,id',
            'subcontractor_type' => 'required',
            'name'  => 'required',
            'date'  => 'required',
            'amount' => 'required',
            'remarks' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $vendor = Subcontractor::create([
            'site_id' => $request->site_id,
            'subcontractor_type' => $request->subcontractor_type,
            'name' => $request->name,
            'date' => $request->date,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
        ]);

        return redirect()->back()->with('success', 'SubContractor payment added successfully!');
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

        return view('admin.menus.subcontractor.subcontractor_dashboard', compact('subcontractors'));
    }


    //subcontractor dashboard payment history
    public function paymentHistory($type)
    {
        $payments = SubcontractorPayment::where('subcontractor_type', $type)->orderBy('date', 'desc')->get();

        $paidAmount = $payments->sum('payment');

        return view('admin.menus.subcontractor.payment_history', compact('payments', 'type', 'paidAmount'));
    }

    //subcontractor dashboard add payment 
    public function addPayment(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'subcontractor_type' => 'required',
            'name' => 'required',
            'payment' => 'required|numeric',
            'date' => 'required|date',
            'payment_mode' => 'required'
        ]);

         if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $payment = SubcontractorPayment::create([
            'subcontractor_type' => $request->subcontractor_type,
            'name' => $request->name,
            'payment' => $request->payment,
            'date' => $request->date,
            'payment_mode' => $request->payment_mode
        ]);

        return redirect()->back()->with('success', 'SubContractor payment added successfully!');
    }
}
