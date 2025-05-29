<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('site')
            ->where('is_inactive', 0)
            ->orderBy('id', 'desc')->get();
        return view('admin.menus.customer.customer_managment', compact('customers'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.menus.customer.customer_update', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'site_id'       => 'required|exists:sites,id',
            'name'          => 'required|string',
            'mobile_no'     => 'required|numeric|digits:10',
            'email'         => 'required|email|unique:customers,email,' . $id,
            'dob'           => 'required',
            'marriage_date' => 'required',
            'address'       => 'required|string'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $customer = Customer::findOrFail($id);

        $customer->update([
            'site_id' => $request->site_id,
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'dob' => $request->dob,
            'marriage_date' => $request->marriage_date,
            'address' => $request->address
        ]);

        return redirect()->back()->with('success', 'Customer updated successfully!');
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update(['is_inactive' => 1]);
        return back()->with('success', 'Customer deleted successfully !');
    }
}
