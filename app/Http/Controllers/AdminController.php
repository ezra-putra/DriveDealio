<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function listSeller()
    {
        $seller = DB::select(
            DB::raw("SELECT s.id as idshop, s.name as shopname, CONCAT(s.address, ' ', s.city, ', ', s.province) as address, s.phonenumber,
            s.status, u.id as iduser, u.firstname, u.sellerstatus
            FROM drivedealio.shops as s INNER JOIN drivedealio.users as u
            ON s.users_id = u.id WHERE u.sellerstatus IS true")
        );

        return view('admin.listseller', compact('seller'));
    }

    public function approveSeller($id)
    {
        DB::update("UPDATE drivedealio.shops SET status = :status where id = :id" ,
        ['status' => 'Approve', 'id' => $id]);

        return view('/admin/listseller');
    }

    public function suspendSeller($id)
    {
        DB::update("UPDATE drivedealio.shops SET status = :status WHERE id = :id",
        ['status' => 'Suspend', 'id' => $id]);

        return view('/admin/listseller');

        // buat timestamp kalo misal toko ke suspen maka day+30 toko akan dihapus, jika toko dihapus maka user tidak akan bisa membuat toko lagi
    }

    public function dashboard()
    {
        $vehicle = DB::select(
            DB::raw("select v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber, v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            INNER JOIN drivedealio.users as u on v.users_id = u.id order by v.inputdate asc LIMIT 5;")
        );

        $user = DB::select(
            DB::raw("select u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name, um.id as idmemberships, m.membershiptype
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            LEFT JOIN drivedealio.user_memberships as um on u.id = um.users_id
            LEFT JOIN drivedealio.memberships as m on um.memberships_id = m.id
            where r.name != 'Admin' AND (um.status = 'Approved' OR um.status IS NULL) order by u.id asc LIMIT 5;")
        );
        return view('/admin/dashboard' , compact('vehicle', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
