<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return response()->json([
            'response code' => 200,
            'data' => $user,
            'status' => true,
            'message' => 'Auth User fetched successfully!',
        ]);
    }

    public function update(Request $request)
    {
        //dd($request->all());
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'name'  => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $request->user_id,
            'password' => 'nullable|min:8|confirmed',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $user = User::findOrFail($request->user_id);

        // Upload Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile', 'public');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'image' => $imagePath,
            'updated_by' => auth('api')->id(),
        ]);

        return response()->json([
            'response code' => 200,
            'data' => $user,
            'status' => true,
            'message' => 'Auth User updated successfully!',
        ]);
    }
}
