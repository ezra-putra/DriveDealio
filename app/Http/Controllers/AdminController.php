<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Loan;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function listUser()
    {
        $user = DB::select(
            DB::raw("SELECT u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            order by u.id asc;")
        );
        $useradmin = DB::select(
            DB::raw("SELECT u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            WHERE r.name = 'Admin' order by u.id asc;")
        );
        $userinspector = DB::select(
            DB::raw("SELECT u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            WHERE r.name = 'Inspector' order by u.id asc;")
        );
        $userbuyer = DB::select(
            DB::raw("SELECT u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            WHERE r.name = 'Buyer' order by u.id asc;")
        );
        // dd($user);
        return view('admin.listuser', compact('user', 'useradmin', 'userinspector', 'userbuyer'));
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
        ['status' => 'Active', 'id' => $id]);

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
            DB::raw("SELECT v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber, v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            INNER JOIN drivedealio.users as u on v.users_id = u.id order by v.inputdate asc LIMIT 5;")
        );

        $user = DB::select(
            DB::raw("SELECT u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            order by u.id asc LIMIT 5;")
        );

        $seller = DB::select(
            DB::raw("SELECT s.id as idshop, s.name as shopname, CONCAT(s.address, ' ', s.city, ', ', s.province) as address, s.phonenumber,
            s.status, u.id as iduser, u.firstname, u.sellerstatus
            FROM drivedealio.shops as s INNER JOIN drivedealio.users as u
            ON s.users_id = u.id WHERE u.sellerstatus IS true")
        );
        return view('/admin/dashboard' , compact('vehicle', 'user', 'seller'));
    }

    public function loanList()
    {
        $loan = DB::select(
            DB::raw("SELECT ao.invoicenum, ao.total_price, l.monthlypayment, l.loantenor, l.downpayment, l.status, u.firstname, u.lastname, u.phonenumber, l.id as idloan
            FROM drivedealio.auction_orders as ao INNER JOIN drivedealio.loans as l on ao.id = l.auction_orders_id
            INNER JOIN drivedealio.users as u on l.users_id = u.id")
        );
        return view('admin.loanlist', compact('loan'));
    }

    public function approveLoan($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = "Approved";
        $loan->verificationdate = Carbon::now();
        $loan->save();
        return redirect()->back()->with('success', 'Loan Status Changed!');
    }

    public function rejectLoan($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = "Reject";
        $loan->save();
        return redirect()->back()->with('success', 'Loan Status Changed!');
    }

    public function adminEdit($id)
    {
        $vhc = Vehicle::findOrFail($id);
        $brand = DB::select(
            DB::raw('SELECT id, name from drivedealio.brands;')
        );
        $type = DB::select(
            DB::raw('SELECT * from drivedealio.vehicletypes; ')
        );
        $date = DB::select(
            DB::raw('SELECT id, appointmentdate, appointmenttime from drivedealio.appointments;')
        );
        $vehicle = DB::select(
            DB::raw("SELECT id, model, enginecapacity, enginecylinders, fueltype, transmission, adstatus,
            vehicletypes_id, brands_id, platenumber, variant, year, colour, stnk, bpkb, invoice
            from drivedealio.vehicles where id = $id;")
        );

        $image = DB::select(
            DB::raw("SELECT url, vehicles_id from drivedealio.images where vehicles_id = $id;")
        );

        return view('admin.detailsvehicle', compact('vehicle', 'vhc', 'brand', 'type', 'date', 'image'));
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
