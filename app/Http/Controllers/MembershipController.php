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
use Illuminate\Support\Facades\Crypt;

class MembershipController extends Controller
{
    public function register()
    {
        $iduser = auth()->id();
        $user = DB::select(
            DB::raw("SELECT id, CONCAT(firstname, ' ', lastname) as name, phonenumber
            from drivedealio.users where id = $iduser;")
        );
        $membership = DB::select(
            DB::raw("SELECT id, membershiptype, price, description FROM drivedealio.memberships;")
        );
        $document = DB::select(
            DB::raw("SELECT ktp, npwp, npwpktpcheck from drivedealio.users where id = $iduser;")
        );
        return view('membership.register', compact('membership', 'user', 'document'));
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
                hm.created_at, hm.updated_at , u.roles_id, hm.paymentstatus, hm.paymentdate, u.firstname, hm.id as idorder, hm.invoicenum
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.memberships as m on m.id = hm.memberships_id order by hm.created_at desc;")
            );
        }else{
            $member = DB::select(
                DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, u.firstname, u.lastname, u.email, u.phonenumber,
                hm.created_at, hm.updated_at , u.roles_id, hm.paymentstatus, hm.paymentdate, hm.id as idorder, hm.price, hm.snap_token, hm.invoicenum
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.memberships as m on m.id = hm.memberships_id where u.id = $iduser order by hm.created_at desc;")
            );
            if (!empty($member)) {
                $endDateTime = Carbon::parse($member[0]->end);
                $now = Carbon::now();

                if ($now >= $endDateTime) {
                    $membership = UserMemberships::where('users_id', $iduser)->first();
                    if ($membership) {
                        $membership->status = "Not Active";
                        $membership->save();
                    }
                }
            }
        }
        return view('/membership/bilings', compact('member'));
    }

    public function cancel_post($id)
    {
        $member = UserMemberships::findOrFail($id);
        $member->status = 'Not Active';
        $member->save();

        $iduser = auth()->id();
        $user = User::find($iduser);
        $title = 'Membership Cancelled';
        $message = 'Your membership Cancelled.';
        $user->notify(new NotificationsMembership($title, $message));

        return back()->with('status', 'Your request has been process!');
    }

    public function store(Request $request)
    {
        $iduser = auth()->id();
        $user = User::find($iduser);

        $member = DB::select(
            DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, u.firstname, u.lastname, u.email, u.phonenumber,
            hm.created_at, hm.updated_at , u.roles_id, hm.paymentstatus, hm.paymentdate, hm.id as idorder, hm.price, hm.snap_token
            from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
            INNER JOIN drivedealio.memberships as m on m.id = hm.memberships_id where u.id = $iduser AND hm.status = 'Active';")
        );

        $date = DB::select(
            DB::raw("SELECT count(created_at) from drivedealio.user_memberships where DATE(created_at) = CURRENT_DATE;")
        );
        if(empty($member))
        {
            if ($request->hasFile('ktp')) {
                $file = $request->file('ktp');
                $fileName = "KTP"."-$iduser". "." .$file->getClientOriginalExtension();
                $file->move(public_path("uploads/doc/user-$iduser"), $fileName);

                $user = User::findOrFail($iduser);
                $user->ktp = encrypt($fileName);
                $user->save();

            }
            if ($request->hasFile('npwp')){
                $file = $request->file('npwp');
                $fileName = "NPWP"."-$iduser". "." .$file->getClientOriginalExtension();
                $file->move(public_path("uploads/doc/user-$iduser"), $fileName);

                $user = User::findOrFail($iduser);
                $user->npwp = encrypt($fileName);
                $user->npwpktpcheck = true;
                $user->save();
            }

            $counter = $date[0]->count + 1;
            $usermember = new UserMemberships;
            $usermember->users_id = auth()->id();
            $usermember->status = 'Pending';
            $usermember->invoicenum = "INV/MB/" .date("Y/m/d"). "/$counter";
            $usermember->memberships_id = $request->input('member');
            $usermember->paymentstatus = 'Unpaid';
            $usermember->price = $request->input('totalprice');
            $usermember->save();

            \Midtrans\Config::$serverKey = 'SB-Mid-server-AOdoK40xyUyq11-i9Cc9ysHM';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $usermember->invoicenum,
                    'gross_amount' => $usermember->price,
                ),
                'customer_details' => array(
                    'first_name' => $user->firstname,
                    'last_name' => $user->lastname,
                    'email' => $user->email,
                    'phone' => $user->phonenumber,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $orderMember = UserMemberships::findOrFail($usermember->id);
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
        $usermember = UserMemberships::findOrFail($id);
        $usermember->paymentstatus = "Paid";
        $usermember->paymentdate = Carbon::now();
        $usermember->save();

        $membership = DB::select(
            DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, u.firstname, u.lastname, u.email, u.phonenumber,
            hm.created_at, hm.updated_at , u.roles_id, hm.paymentstatus, hm.paymentdate, hm.id as idorder, hm.price, hm.snap_token
            from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
            INNER JOIN drivedealio.memberships as m on m.id = hm.memberships_id where hm.id = $id")
        );
        $idhasmember = $membership[0]->idhasmember;
        $type = $membership[0]->name;
        // dd($type);

        $member = UserMemberships::findOrFail($idhasmember);
        $member->status = "Active";
        $member->start = Carbon::now();
        if ($type == 'Gold' || $type == 'Platinum') {
            $member->end = $member->start->copy()->addMonths(3);
        } else {
            $member->end = $member->start->copy()->addMonth();
        }
        // dd($member);
        $member->save();

        $iduser = auth()->id();
        $user = User::find($iduser);
        $title = 'Membership Paid';
        $message = 'Payment received, your membership is active.';
        $user->notify(new NotificationsMembership($title, $message));

        return redirect('/membership/bilings')->with('success', 'Payment Success');
    }

    public function invoice($id)
    {
        $orderMember = DB::select(
            DB::raw("SELECT u.firstname, u.phonenumber, um.invoicenum, um.price as total_price, um.created_at, m.membershiptype, m.price
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.memberships as m on m.id = um.memberships_id
            WHERE um.id = $id;")
        );
        return view('membership.invoice', compact('orderMember'));
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
