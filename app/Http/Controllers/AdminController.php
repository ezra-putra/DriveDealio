<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AuctionOrder;
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
            DB::raw("SELECT u.id as iduser, u.email, u.firstname, u.lastname, u.phonenumber, r.name
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

        $role = DB::select(
            DB::raw("SELECT * from drivedealio.roles;")
        );

        // dd($user);
        return view('admin.listuser', compact('user', 'useradmin', 'userinspector', 'userbuyer', 'courier', 'role'));
    }

    public function roleModal(Request $request)
    {
        $id = ($request->get('id'));
        $data = User::find($id);
        $user = DB::select(
            DB::raw("SELECT u.id as iduser, u.email, u.firstname, u.lastname, u.phonenumber, r.name
            from drivedealio.users as u INNER JOIN drivedealio.roles as r on u.roles_id = r.id
            where u.id = $id;")
        );

        $role = DB::select(
            DB::raw("SELECT * from drivedealio.roles;")
        );

        return response()->json(array(
            'msg'=> view('admin.editrole',compact('data', 'user', 'role'))->render()
        ),200);
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

    public function listTransaction()
    {
        $sparepartOrder = DB::select(
            DB::raw("SELECT o.id as idorder, u.id as iduser, o.invoicenum, o.orderdate, o.shops_id, o.users_id, o.status, o.paymentstatus, s.name, u.firstname, o.total_price
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.shops as s on o.shops_id = s.id
            order by o.orderdate desc;")
        );

        $auctionOrder = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate, v.transmission,
            ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder, ao.paymentstatus, ao.status, v.id as idvehicle, b.name as brand
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id
            INNER JOIN drivedealio.auction_orders as ao on aw.id = ao.auctionwinners_id
            INNER JOIN drivedealio.users as u on aw.users_id = u.id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            ORDER BY ao.orderdate desc;")
        );

        $member = DB::select(
            DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, u.firstname, u.lastname, u.email, u.phonenumber,
            hm.created_at, hm.updated_at , u.roles_id, mo.paymentstatus, mo.paymentdate, mo.id as idorder, mo.price, mo.snap_token, mo.invoicenum
            from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
            INNER JOIN drivedealio.member_orders as mo on hm.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id order by hm.created_at desc;")
        );

        return view('admin.listtransaction', compact('sparepartOrder', 'auctionOrder', 'member'));
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

        $sparepartOrder = DB::select(
            DB::raw("SELECT o.id as idorder, u.id as iduser, o.invoicenum, o.orderdate, o.shops_id, o.users_id, o.status, o.paymentstatus, s.name, u.firstname, o.total_price
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.shops as s on o.shops_id = s.id
            order by o.orderdate asc LIMIT 3;")
        );

        $auctionOrder = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate, v.transmission,
            ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder, ao.paymentstatus, ao.status, v.id as idvehicle, b.name as brand
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id
            INNER JOIN drivedealio.auction_orders as ao on aw.id = ao.auctionwinners_id
            INNER JOIN drivedealio.user_memberships as um on aw.user_memberships_id = um.id
            INNER JOIN drivedealio.users as u on um.users_id = u.id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            ORDER BY ao.orderdate asc LIMIT 2;")
        );
        return view('/admin/dashboard' , compact('vehicle', 'user', 'seller', 'sparepartOrder', 'auctionOrder'));
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

        $auctionOrder = AuctionOrder::join('loans', 'auction_orders.id', '=', 'loans.auction_orders_id')
        ->where('loans.id', $id)
        ->select('auction_orders.*')
        ->first();
        // dd($auctionOrder);
        $auctionOrder->status = "Waiting for Confirmation";
        // dd($auctionOrder);
        $auctionOrder->save();

        $loanInfo = DB::select(
            DB::raw("SELECT users_id from drivedealio.loans where id = $id;")
        );

        $iduser = $loanInfo[0]->users_id;
        $user = User::find($iduser);
        $title = 'Loan Approved';
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
        $message = 'Loan Rejected, Use Virtual Account to complete your Auction payment!';
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
    public function approve($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = 'Inspection';
        $vehicle->verificationdate = now();
        $vehicle->save();

        return redirect('/admin/listvehicle')->with('success', 'Data Changed Successfully!')->with('approvedVehicleId', $vehicle->id);
    }
    public function reject($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = 'Rejected';
        $vehicle->save();

        return redirect('/admin/listvehicle')->with('error', 'Data Changed Successfully!');
    }
}
