<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MaterialOrder;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $sites = Site::with('customer')
            ->where('is_inactive', 0)
            ->when($status && $status !== 'All', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.menus.site_management.site_management', compact('sites', 'status'));
    }


    public function getForm()
    {
        return view('admin.menus.site_management.site_create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'site_name'     => 'required|string',
            'site_img'      => 'required|image|mimes:jpg,jpeg,png,webp',
            'location'      => 'required|string',
            'value'         => 'required',
            'duration'      => 'required',
            'settled_amnt'  => 'required',
            'pending_amnt'  => 'required',
            'name'          => 'required|string',
            'mobile_no'     => 'required|numeric|digits:10',
            'email'         => 'required|email|unique:customers,email',
            'dob'           => 'required',
            'marriage_date' => 'required',
            'address'       => 'required|string'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $site_img = null;
        if ($request->hasFile('site_img')) {
            $site_img = $request->file('site_img')->store('Site', 'public');
        }

        $site = Site::create([
            'site_name' => $request->site_name,
            'site_img'  => $site_img,
            'location'  => $request->location,
            'value'  => $request->value,
            'duration'  => $request->duration,
            'settled_amnt'  => $request->settled_amnt,
            'pending_amnt'  => $request->pending_amnt,
            'created_by'  => auth('admin')->id(),
        ]);

        $siteID = $site->id;

        $customer = Customer::create([
            'site_id' => $siteID,
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'dob' => $request->dob,
            'marriage_date' => $request->marriage_date,
            'address' => $request->address,
            'created_by'  => auth('admin')->id(),
        ]);

        return redirect()->back()->with('success', 'Site Created and Customer Added successfully.');
    }

    public function edit($id)
    {
        $site = Site::findOrFail($id);

        return view('admin.menus.site_management.site_update', compact('site'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'site_name'     => 'nullable|string',
            'site_img'      => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'location'      => 'nullable|string',
            'value'         => 'nullable',
            'duration'      => 'nullable',
            'settled_amnt'  => 'nullable',
            'pending_amnt'  => 'nullable',
            'status'        => 'nullable'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $site = Site::findOrFail($id);

        $site_img = $site->site_img;
        if ($request->hasFile('site_img')) {
            if (!empty($site->site_img)) {
                Storage::disk('public')->delete($site->site_img);
            }
            $site_img = $request->file('site_img')->store('Site', 'public');
        }

        $site->update([
            'site_name' => $request->site_name,
            'site_img'  => $site_img,
            'location'  => $request->location,
            'value'  => $request->value,
            'duration'  => $request->duration,
            'settled_amnt'  => $request->settled_amnt,
            'pending_amnt'  => $request->pending_amnt,
            'updated_by'  => auth('admin')->id(),
        ]);

        //Status update
        if ($request->filled('status')) {
            $site->update([
                'status' => $request->status
            ]);
        }

        return redirect()->back()->with('success', 'Site updated successfully!');
    }

    public function delete($id) //softdelete , change 1 to is_inactive
    {
        $site = Site::find($id);
        $site->update(['is_inactive' => 1]);
        return back()->with('success', 'Site deleted successfully !');
    }

    //Site Detail
    public function siteDetail($id)
    {
        $site = Site::with('materialOrders')
            ->where('id', $id)->first();

        $totalUnits = $site->materialOrders->sum('quantity');
        $totalValues = $site->materialOrders->sum('price');
        return view('admin.menus.site_management.site_detail', compact('site', 'totalUnits', 'totalValues'));
    }
}
