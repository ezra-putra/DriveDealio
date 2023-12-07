<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
  public function showRegistrationForm()
  {
    return view('authentication.register');
  }

  public function register(Request $request)
  {
    try{
        $user = new User;
        $user->firstname = $request->input('fname');
        $user->lastname = $request->input('lname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->profilepicture = "https://png.pngtree.com/png-clipart/20210129/ourmid/pngtree-default-male-avatar-png-image_2811083.jpg";
        $user->phonenumber = $request->input('number');
        $user->birthdate = $request->input('birth');
        $user->address = $request->input('address');
        $user->province = $request->input('province');
        $user->city = $request->input('city');
        $user->district = $request->input('district');
        $user->zipcode = $request->input('zip');
        $user->sellerstatus = 0;
        $user->roles_id = 2;

        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
    catch(\Exception $e){
        dd($e->getMessage());
    }

  }
}
