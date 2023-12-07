<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('authentication.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }

    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt($credential)){

            if(auth()->user()->roles_id == 2){
                return redirect()->route('welcome')->with('success', 'LOGIN SUCCESS');
            }
            if(auth()->user()->roles_id == 1){
                return redirect()->route('admindashboard')->with('success', 'LOGIN SUCCESS');
            }
            if(auth()->user()->roles_id == 3){
                return redirect()->route('inspectordashboard')->with('success', 'LOGIN SUCCESS');
            }
        }

        return redirect()->back()->withInput()->withErrors([
            'email' => 'Invalid Login Credentials.',
        ]);
    }
}
