<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
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
            DB::raw("SELECT u.id as iduser, u.email, u.profilepicture, u.firstname, u.lastname, u.birthdate, u.phonenumber, a.id as idaddress, a.name, a.address, a.district,
            a.city, a.province, a.zipcode, a.is_primaryadd
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser order by a.is_primaryadd desc;")
        );

        return view('authentication.profile', compact('profile'));
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
