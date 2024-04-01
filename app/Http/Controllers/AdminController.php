<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Loan;
use App\Models\Seller;
use App\Models\User;
use App\Models\Vehicle;
use App\Notifications\Loan as NotificationsLoan;
use App\Notifications\Seller as NotificationsSeller;
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
        $courier = DB::select(
            DB::raw("SELECT u.id, u.email, u.firstname, u.lastname, u.phonenumber, r.name
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            WHERE r.name = 'Courier' order by u.id asc;")
        );

        // dd($user);
        return view('admin.listuser', compact('user', 'useradmin', 'userinspector', 'userbuyer', 'courier'));
    }

    public function editRoleUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->roles_id = $request->input('role');
        $user->save();

        return redirect()->back()->with('success', 'Role change succesfully');
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
        $seller = Seller::findOrFail($id);
        $seller->status = 'Active';
        $seller->save();

        $sellerInfo = DB::select(
            DB::raw("SELECT users_id from drivedealio.shops where id = $id;")
        );

        $idseller = $sellerInfo[0]->users_id;
        // dd($idseller);
        $notif = User::find($idseller);
        $title = 'Seller Activation Request';
        $message = 'Your Seller Account Has Been Approved to Operational by Admin!';
        $notif->notify(new NotificationsSeller($title, $message));

        return redirect()->back()->with('success', 'Seller Approved!');
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

        $loanInfo = DB::select(
            DB::raw("SELECT users_id from drivedealio.loans where id = $id;")
        );

        $iduser = $loanInfo[0]->users_id;
        $user = User::find($iduser);
        $title = 'Loan Request';
        $message = 'Loan Approved, Please Continue Your Transaction!';
        $user->notify(new NotificationsLoan($title, $message));

        return redirect()->back()->with('success', 'Loan Status Changed!');
    }

    public function rejectLoan($id)
    {
        $loan = Loan::findOrFail($id);
        $loan->status = "Reject";
        $loan->save();

        $loanInfo = DB::select(
            DB::raw("SELECT users_id from drivedealio.loans where id = $id;")
        );

        $iduser = $loanInfo[0]->users_id;
        $user = User::find($iduser);
        $title = 'Loan Request';
        $message = 'Loan Rejected, Please Select Another PaymentMethod!';
        $user->notify(new NotificationsLoan($title, $message));

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
}
