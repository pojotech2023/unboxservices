<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OtherUtilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OtherUtilitiesController extends Controller
{
    public function index($id)
    {
        $utilities = OtherUtilities::with('site')
            ->where('site_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.menus.site_management.view_utilities', compact('utilities'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'site_id'     => 'required|exists:sites,id',
            'amount'      => 'required|string',
            'remarks'     => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        // Upload Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('other_utilities', 'public');
        }

        $vendor = OtherUtilities::create([
            'site_id' => $request->site_id,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'image' => $imagePath,
            'created_by'  => auth('admin')->id(),
        ]);

        return redirect()->back()->with('success', 'Others utility created successfully!');
    }
}
