<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
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

        $provinces = Province::all();
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();
        return view('authentication.profile', compact('profile', 'provinces', 'regencies', 'districts', 'villages', 'address'));
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

    public function uploadUserInformation(Request $request)
    {
        $iduser = auth()->id();
        if ($request->hasFile('ktp')) {
            $file = $request->file('ktp');
            $fileName = "KTP"."-$iduser". "." .$file->getClientOriginalExtension();
            $file->move(public_path('uploads/id'), $fileName);

            DB::update("UPDATE drivedealio.users SET ktp = :ktp where id = :id",
            ['ktp'=> $fileName, 'id'=>$iduser]);
        }
        if ($request->hasFile('npwp')){
            $file = $request->file('npwp');
            $fileName = "NPWP"."-$iduser". "." .$file->getClientOriginalExtension();
            $file->move(public_path('uploads/id'), $fileName);

            DB::update("UPDATE drivedealio.users SET npwp = :npwp where id = :id",
            ['npwp'=> $fileName, 'id'=>$iduser]);
        }

        return redirect()->back()->with('success', 'Upload Success');
    }

    public function index()
    {
        $user = DB::select(
            DB::raw("SELECT u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name, um.id as idmemberships, m.membershiptype
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            LEFT JOIN drivedealio.user_memberships as um on u.id = um.users_id
            LEFT JOIN drivedealio.member_orders as mo on um.id = mo.user_memberships_id
            LEFT JOIN drivedealio.memberships as m on m.id = mo.memberships_id
            where r.name != 'Admin' AND (um.status = 'Approved' OR um.status IS NULL) order by u.id asc;")
        );
        // dd($user);
        return view('admin.listuser', ['users' => $user]);
    }

    public function becomeSeller(Request $request)
    {
        $id = auth()->id();

        DB::insert("INSERT INTO drivedealio.shops(name, address, phonenumber, city, province, district, zipcode, status, users_id)
        VALUES(:name, :address, :phonenumber, :city, :province, :district, :zipcode, :status, :id)",
        ['name' => $request->input('shopname'), 'address' => $request->input('shopaddress'),
        'phonenumber' => $request->input('shopphone'), 'city' => $request->input('shopcity'),
        'province' => $request->input('shopprovince'), 'district' => $request->input('shopdistrict'),
        'zipcode' => $request->input('shopzip'), 'status' => 'Pending', 'id' => $id]);

        DB::update("UPDATE drivedealio.users SET sellerstatus = :sellerstatus WHERE id = :id",
        ['sellerstatus' => 1, 'id' => $id]);

        return view('seller.dashboard');
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



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
