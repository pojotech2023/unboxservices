<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherUtilitiesSub;
use Illuminate\Support\Facades\Validator;

class OtherUtilitiesSubController extends Controller
{
    public function index($id)
    {
        $utilities = OtherUtilitiesSub::with('site')
            ->where('site_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.menus.subcontractor.view_utilities', compact('utilities'));
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

        $utilities = OtherUtilitiesSub::create([
            'site_id' => $request->site_id,
            'amount' => $request->amount,
            'remarks' => $request->remarks,
            'image' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Others utility created successfully!');
    }
}
