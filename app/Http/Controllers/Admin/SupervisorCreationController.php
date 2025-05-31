<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoleMapping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SupervisorCreationController extends Controller
{
    public function index()
    {
        $supervisors = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'Supervisor');
        })->get();

        return view('admin.menus.supervisor.user_create', compact('supervisors'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'name'          => 'required|string',
            'mobile_no'     => 'required|numeric|digits:10',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6|confirmed'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $supervisor = User::create([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'password' => Crypt::encryptString($request->password),
            'created_by'  => auth('admin')->id(),
        ]);

        $supervisorId = $supervisor->id;

        $role_mapping = RoleMapping::create([
            'user_id' => $supervisorId,
            'role_id' => 2
        ]);

        return redirect()->back()->with('success', 'Supervisor created successfully!');
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id'       => 'required|exists:users,id',
            'name'          => 'required|string',
            'mobile_no'     => 'required|numeric|digits:10',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'password'      => 'required|min:6|confirmed'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $supervisor = User::findOrFail($request->user_id);

        $supervisor->update([
            'name'  => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'updated_by'  => auth('admin')->id(),
        ]);

        return redirect()->back()->with('success', 'Supervisor updated successfully!');
    }

    public function delete($id)
    {
        $supervisor = User::findOrFail($id);
        $supervisor->delete();
        return back()->with('success', 'Supervisor Deleted Successfully!');
    }
}
