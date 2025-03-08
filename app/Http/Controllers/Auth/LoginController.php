<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    function index()
    {
        return redirect()->route('login');
    }
    function showLoginForm()
    {
        return view('auth.login');
    }

    function process(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'rewuired|min:6'
        ]);


        $user = User::where('email', $request->email)->first();
        // dd($user->status);

        // if ($user) {
        //     if ($user->status == 'Blocked' || $user->status == 'Suspended') {
        //         return response()->json(['status' => 'error', 'message' => 'Your account is BLOCKED or suspended, please contact the administrator for Activation!']);
        //     }
        // }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            Auth::login($user);
            if ($user->role == "user") {
                return redirect()->route('home');
            } //if employee
            elseif ($user->role == "admin") {
                return redirect()->route('admin');
            } //if applicant employee
            else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->back()->with('message', 'Username And Password Do not Match');
        }
    }
   

}
