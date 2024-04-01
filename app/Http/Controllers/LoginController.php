<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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

            $user = auth()->user();
            if ($user instanceof \Illuminate\Database\Eloquent\Model) {
                $user->last_login = now();
                $user->save();
            }
            if(auth()->user()->roles_id == 2){
                return redirect()->route('welcome');
            }
            if(auth()->user()->roles_id == 1){
                return redirect()->route('admindashboard');
            }
            if(auth()->user()->roles_id == 3){
                return redirect()->route('inspectordashboard');
            }
            if(auth()->user()->roles_id == 4){
                return redirect()->route('courierdashboard');
            }
        }

        return redirect()->back()->withInput()->withErrors([
            'email' => 'Incorrect Password or Email.',
        ]);
    }
}
