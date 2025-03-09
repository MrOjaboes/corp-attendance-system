<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);
        return view('profile', compact('user'));
    }
    public function updateProfile(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        flash()->success('Success', 'You have successfully submited the attendance !');
        return back();
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        $user = User::find(auth()->user()->id);
        if (!Hash::check($request->current_password, $user->password)) {

            return redirect()->back()->with('error','Current password does not match record');
        }
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        flash()->success('Success', 'Password updated successfully !');
        return back();
    }
}
