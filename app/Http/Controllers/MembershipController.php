<?php

namespace App\Http\Controllers;

use App\Models\MemberOrder;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMemberships;
use App\Notifications\Membership as NotificationsMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class MembershipController extends Controller
{
    public function index()
    {
        //
    }

    public function register()
    {
        $iduser = auth()->id();
        $user = DB::select(
            DB::raw("select id, CONCAT(firstname, ' ', lastname) as name, phonenumber
            from drivedealio.users where id=$iduser;")
        );
        $membership = DB::select(
            DB::raw("select id, membershiptype, price, description FROM drivedealio.memberships;")
        );
        return view('membership.register', compact('membership', 'user'));
    }

    public function create()
    {
        return view('membership.register');
    }

    public function myBilings()
    {
        $iduser = auth()->id();

        if(auth()->user()->roles_id === 1){
            $member = DB::select(
                DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser,
                hm.created_at, hm.updated_at , u.roles_id, mo.paymentstatus, mo.paymentdate, u.firstname, mo.id as idorder
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.member_orders as mo on hm.id = mo.user_memberships_id
                INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id order by hm.created_at desc;")
            );
        }else{
            $member = DB::select(
                DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, u.firstname, u.lastname, u.email, u.phonenumber,
                hm.created_at, hm.updated_at , u.roles_id, mo.paymentstatus, mo.paymentdate, mo.id as idorder, mo.price, mo.snap_token
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.member_orders as mo on hm.id = mo.user_memberships_id
                INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id where u.id = $iduser order by hm.created_at desc;")
            );
        }
        return view('/membership/bilings', compact('member'));
    }

    public function cancel_post($id)
    {
        $member = UserMemberships::findOrFail($id);
        if(auth()->user()->roles_id == 2){
            $member->status = 'Not Active';
            $message = 'Your membership Cancelled.';
        }
        if(auth()->user()->roles_id == 1){
            $member->status = 'Not Active';

            $message = 'Your membership rejected by system.';
        }
        $member->save();

        $iduser = auth()->id();
        $user = User::find($iduser);
        $title = 'Membership rejected';
        $user->notify(new NotificationsMembership($title, $message));


        return back()->with('status', 'Your request has been process!');
    }

    public function store(Request $request)
    {
        $iduser = auth()->id();

        $user = DB::select(
            DB::raw("SELECT id, firstname, lastname, phonenumber, email
            from drivedealio.users where id=$iduser;")
        );

        $member = DB::select(
            DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, u.firstname, u.lastname, u.email, u.phonenumber,
            hm.created_at, hm.updated_at , u.roles_id, mo.paymentstatus, mo.paymentdate, mo.id as idorder, mo.price, mo.snap_token
            from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
            INNER JOIN drivedealio.member_orders as mo on hm.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id where u.id = $iduser AND hm.status = 'Active';")
        );

        $membership = DB::select(
            DB::raw("select id, membershiptype, price, description FROM drivedealio.memberships;")
        );

        $date = DB::select(
            DB::raw("SELECT count(created_at) from drivedealio.member_orders where DATE(created_at) = CURRENT_DATE;")
        );
        if(empty($member))
        {
            $usermember = new UserMemberships;
            $usermember->users_id = auth()->id();
            $usermember->status = 'Pending';
            $usermember->save();

            $memberorder = new MemberOrder;
            $counter = $date[0]->count + 1;
            $memberorder->invoicenum = "INV/" .date("Y/m/d"). "/$counter";
            $memberorder->user_memberships_id = $usermember->id;
            $memberorder->memberships_id = $request->input('member');
            $memberorder->paymentstatus = 'Unpaid';
            $adminprice = 2000;
            $memberorder->price = $membership[0]->price + $adminprice;
            $memberorder->save();

            \Midtrans\Config::$serverKey = 'SB-Mid-server-AOdoK40xyUyq11-i9Cc9ysHM';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $memberorder->invoicenum,
                    'gross_amount' => $memberorder->price,
                ),
                'customer_details' => array(
                    'first_name' => $user[0]->firstname,
                    'last_name' => $user[0]->lastname,
                    'email' => $user[0]->email,
                    'phone' => $user[0]->phonenumber,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $orderMember = MemberOrder::findOrFail($memberorder->id);
            $orderMember->snap_token = $snapToken;
            $orderMember->save();

            $user = User::find($iduser);
            $title = 'Payment reminder';
            $message = 'Please settle your membership payment.';
            $user->notify(new NotificationsMembership($title, $message));

            return redirect('/membership/bilings')->with('success', 'Your request has been process!');
        }
        else
        {
            return redirect('/membership/bilings')->with('error', 'You have active membership package!');
        }
    }

    public function paymentPaid($id)
    {
        $memberorder = MemberOrder::findOrFail($id);
        $memberorder->paymentstatus = "Paid";
        $memberorder->paymentdate = Carbon::now();
        $memberorder->save();

        $membership = DB::select(
            DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, u.firstname, u.lastname, u.email, u.phonenumber,
            hm.created_at, hm.updated_at , u.roles_id, mo.paymentstatus, mo.paymentdate, mo.id as idorder, mo.price, mo.snap_token
            from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
            INNER JOIN drivedealio.member_orders as mo on hm.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id where mo.id = $id")
        );

        $member = UserMemberships::findOrFail($membership[0]->idhasmember);
        $member->status = "Active";
        $member->start = Carbon::now();
        if ($member->memberships_id == 3 || $member->memberships_id == 4) {
            $member->end = $member->start->copy()->addMonths(3);
        } else {
            $member->end = $member->start->copy()->addMonth();
        }
        $member->save();

        $iduser = auth()->id();
        $user = User::find($iduser);
        $title = 'Membership Paid';
        $message = 'Payment received, wait for confirmation from system.';
        $user->notify(new NotificationsMembership($title, $message));

        return redirect('/membership/bilings')->with('success', 'Payment Success');
    }

    protected function formatDuration($interval)
    {
        $formattedDuration = '';

        if ($interval->h > 0) {
            $formattedDuration .= $interval->h . 'H ';
        }

        if ($interval->i > 0) {
            $formattedDuration .= $interval->i . 'M ';
        }

        if ($interval->s > 0) {
            $formattedDuration .= $interval->s . 'S';
        }
        return trim($formattedDuration);
    }

}
