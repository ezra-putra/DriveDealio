<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Seller;
use App\Models\User;
use App\Models\Village;
use App\Notifications\Admin;
use App\Notifications\Seller as NotificationsSeller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $iduser = auth()->id();
        $profile = DB::select(
            DB::raw("SELECT id as iduser, email, profilepicture, firstname, lastname, birthdate, phonenumber
            from drivedealio.users where id = $iduser;")
        );
        $address = DB::select(
            DB::raw("SELECT id as idaddress, name, address, district,
            city, province, village, zipcode, is_primaryadd FROM drivedealio.addresses where users_id = $iduser order by is_primaryadd desc")
        );
        $document = DB::select(
            DB::raw("SELECT ktp, npwp from drivedealio.users where id = $iduser;")
        );
        // dd($document);

        $provinces = Province::all();
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();
        return view('authentication.profile', compact('profile', 'provinces', 'regencies', 'districts', 'villages', 'address', 'document'));
    }

    public function editProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->firstname =  $request->input('fname');
        $user->lastname =  $request->input('lname');
        $user->birthdate =  $request->input('birthdate');
        $user->email =  $request->input('email');
        $user->phonenumber =  $request->input('phone');
        $user->save();
        return redirect()->back()->with('status', 'Profile Edited!');
    }

    public function regency(Request $request)
    {
        $province_id = $request->province_id;
        $regencies = Regency::where('province_id', $province_id)->get();

        foreach($regencies as $r)
        {
            echo "<option value='$r->id'>$r->name</option>";
        }
    }

    public function district(Request $request)
    {
        $regency_id = $request->regency_id;
        $district = District::where('regency_id', $regency_id)->get();

        foreach($district as $d)
        {
            echo "<option value='$d->id'>$d->name</option>";
        }
    }

    public function village(Request $request)
    {
        $district_id = $request->district_id;
        $village = Village::where('district_id', $district_id)->get();

        foreach($village as $v)
        {
            echo "<option value='$v->id'>$v->name</option>";
        }
    }


    public function addAddress(Request $request)
    {
        $iduser = auth()->id();
        $address = new Address;
        $address->users_id = $iduser;
        $address->name = $request->input('name');
        $address->address = $request->input('address');
        $address->province = Province::find($request->input('province'))->name;
        $address->city = Regency::find($request->input('regency'))->name;
        $address->district = District::find($request->input('district'))->name;
        $address->village = Village::find($request->input('village'))->name;
        $address->zipcode = $request->input('zip');
        // dd($address);

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
        return redirect()->back()->with('success', 'Address Added!');
    }

    public function toSellerRegister()
    {
        $provinces = Province::all();
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();

        return view('seller.sellerregister', compact('provinces', 'regencies', 'districts', 'villages'));
    }

    public function becomeSeller(Request $request)
    {
        $id = auth()->id();
        $seller = new Seller;
        $seller->name = $request->input('shopname');
        $seller->address = $request->input('shopaddress');
        $seller->phonenumber = $request->input('shopphone');
        $seller->city = Regency::find($request->input('regency'))->name;
        $seller->district = District::find($request->input('district'))->name;
        $seller->province = Province::find($request->input('province'))->name;
        $seller->zipcode = $request->input('shopzip');
        $seller->status = 'Pending';
        $seller->users_id = $id;
        if($request->hasFile('pic')){
            $image = $request->file('pic');
            $name = $id.'-'.Carbon::now()->format('ymd').'.'.$image->getClientOriginalExtension();
            $image->move(public_path("uploads/img/seller/$id"), $name);
            $seller->pics = $name;
        }
        $seller->save();
        // dd($seller);

        $user = User::findOrfail($id);
        $user->sellerstatus = 1;
        $user->save();

        $userSeller = User::find($id);
        $title = 'Seller Registration';
        $message = 'Registration Complete, Please wait for System Approval!';
        $userSeller->notify(new NotificationsSeller($title, $message));

        $adminData = DB::select(
            DB::raw("SELECT u.id from drivedealio.users as u INNER JOIN drivedealio.roles as r where r.id = 1;")
        );
        $idadmin = $adminData[0]->id;
        $admin = User::find($idadmin);
        $title = 'Seller Registration';
        $message = 'New Seller has been Registered, Waiting for Approval!';
        $admin->notify(new Admin($title, $message));

        return redirect('/')->with('success', 'Registration Success!');
    }

    public function setPrimaryAddress($id)
    {
        $iduser = auth()->id();
        $profile = DB::select(
            DB::raw("SELECT u.id as iduser, u.email, u.profilepicture, u.firstname, u.lastname, u.birthdate, u.phonenumber, a.id as idaddress, a.name, a.address, a.district,
            a.city, a.province, a.zipcode, a.is_primaryadd
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser;")
        );

        if (count($profile) > 0) {
            $primaryAddress = collect($profile)->where('is_primaryadd', true)->first();

            if ($primaryAddress) {
                DB::update("UPDATE drivedealio.addresses SET is_primaryadd = :is_primaryadd WHERE id = :id",
                    ['is_primaryadd' => false, 'id' => $primaryAddress->idaddress]
                );
            }

            DB::update("UPDATE drivedealio.addresses SET is_primaryadd = :is_primaryadd WHERE id = :id",
                ['is_primaryadd' => true, 'id' => $id]
            );

            return redirect()->back()->with('success', 'Primary address updated successfully');
        } else {
            return redirect()->back()->with('error', 'Unable to fetch user profile');
        }

        return redirect()->back()->with('success', 'Primary address updated successfully');
    }
}
