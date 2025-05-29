<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('site')
            ->where('is_inactive', 0)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'response code' => 200,
            'data' => $customers,
            'status' => true,
            'message' => 'Customer fetched successfully!',
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'site_id'       => 'required|exists:sites,id',
            'name'          => 'required|string',
            'mobile_no'     => 'required|numeric|digits:10',
            'email'         => 'required|email',
            'dob'           => 'required',
            'marriage_date' => 'required',
            'address'       => 'required|string'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }

        $customer = Customer::findOrFail($id);

        $dob = Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d');
        $marriage_date = Carbon::createFromFormat('d-m-Y', $request->marriage_date)->format('Y-m-d');


        $customer->update([
            'site_id' => $request->site_id,
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'dob' => $dob,
            'marriage_date' => $marriage_date,
            'address' => $request->address
        ]);

        return response()->json([
            'response code' => 200,
            'data' => $customer,
            'status' => true,
            'message' => 'Customer updated successfully!',
        ]);
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update(['is_inactive' => 1]);

        return response()->json([
            'response code' => 200,
            'data' => $customer,
            'status' => true,
            'message' => 'Customer deleted successfully!!',
        ]);
    }
}
