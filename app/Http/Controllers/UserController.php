<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $user = DB::select(
            DB::raw("select u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name, um.id as idmemberships, m.membershiptype
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            LEFT JOIN drivedealio.user_memberships as um on u.id = um.users_id
            LEFT JOIN drivedealio.memberships as m on um.memberships_id = m.id
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
