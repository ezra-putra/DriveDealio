<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


        $user->sellerstatus = 0;
        $user->roles_id = 2;

        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
    catch(\Exception $e){
        dd($e->getMessage());
    }

  }

  public function addAddress(Request $request)
  {
    $iduser = auth()->id();
    $address = new Address;
    $address->users_id = $iduser;
    $address->name = $request->input('name');
    $address->address = $request->input('address');
    $address->province = $request->input('province');
    $address->city = $request->input('city');
    $address->district = $request->input('district');
    $address->zipcode = $request->input('zip');

    $user = DB::select(
        DB::raw("SELECT count(id) as count from drivedealio.addresses where id = $iduser")
    );
    if($user[0]->count = 0)
    {
        $address->is_primaryadd = true;
    }else{
        $address->is_primaryadd = false;
    }



    $address->save();
    return redirect()->back();
  }

}
