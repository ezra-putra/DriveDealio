<?php

namespace App\Http\Controllers;

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

    public function myBilings(){
        $iduser = auth()->id();

        if(auth()->user()->roles_id === 1){
            $member = DB::select(
                DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser,
                hm.created_at, hm.updated_at , u.roles_id, hm.paymentmethod, hm.paymentstatus, hm.paymentduedate, hm.paymentdate, u.firstname
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id order by hm.created_at desc;")
            );
        }else{
            $member = DB::select(
                DB::raw("SELECT m.id as idmember, m.membershiptype as name, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser,
                hm.created_at, hm.updated_at , u.roles_id, hm.paymentmethod, hm.paymentstatus, hm.paymentduedate, hm.paymentdate
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id where u.id = $iduser order by hm.created_at desc;")
            );

            $endDateTime = Carbon::parse($member[0]->end);
            $now = Carbon::now();
            if($now >= $endDateTime)
            {
                DB::update("UPDATE drivedealio.user_memberships SET status = :status WHERE id = :id",
                ['status' => "Not Active", 'id' => $member[0]->idhasmember]);
                return view('/membership/bilings', compact('member'));
            }
        }

        $startDateTime = Carbon::parse($member[0]->created_at);
        $endDateTime = Carbon::parse($member[0]->end);
        $now = Carbon::now();
        $idhasmember = $member[0]->idhasmember;
        if ($now >= $endDateTime) {
            DB::table('drivedealio.user_memberships')
                ->where('id', $idhasmember)
                ->update(['status' => 'Not Active']);

                $user = User::find($iduser);
                $title = 'Membership expired';
                $message = 'Your membership has expired, please renew it.';
                $user->notify(new NotificationsMembership($title ,$message));
            }
        $interval = $startDateTime->diff($endDateTime);
        $member[0]->duration = $this->formatDuration($interval);

        $expirationDate = strtotime($member[0]->end);
        $currentDate = strtotime(now());
        $daysRemaining = max(0, ceil(($expirationDate - $currentDate) / (60 * 60 * 24)));
        $progressPercentage = min(100, max(0, floor(($daysRemaining / 365) * 100)));

        return view('/membership/bilings', compact('member', 'daysRemaining', 'progressPercentage'));
    }

    public function approve_post($id)
    {
        $member = UserMemberships::findOrFail($id);
        $member->status = 'Active';
        $member->save();

        $iduser = auth()->id();
        $user = User::find($iduser);
        $title = 'Membership status';
        $message = 'Your membership is now active.';
        $user->notify(new NotificationsMembership($title, $message));

        return back()->with('status', 'Your request has been process!');
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
        $member = DB::select(
            DB::raw("select m.id as idmember, m.membershiptype, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, hm.created_at, hm.updated_at , u.roles_id
            from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
            INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id where u.id = $iduser AND hm.status = 'Active';")
        );
        if(empty($member))
        {
            $member = new UserMemberships;
            $member->users_id = auth()->id();
            $member->memberships_id = $request->input('member');
            $member->status = 'Pending';
            $member->paymentstatus = 'Unpaid';
            $member->paymentduedate = Carbon::now()->addDay();
            $member->start = now();
            if ($member->memberships_id == 3 || $member->memberships_id == 4) {

                $member->end = $member->start->copy()->addMonths(3);
            } else {

                $member->end = $member->start->copy()->addMonth();
            }
            $member->save();
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

    public function paymentPaid(Request $request, $id)
    {
        $member = UserMemberships::findOrFail($id);
        $member->status = "Pending";
        $member->paymentstatus = "Paid";
        $member->paymentmethod = $request->input('payment');
        $member->paymentdate = Carbon::now();
        $member->save();

        $iduser = auth()->id();
        $user = User::find($iduser);
        $title = 'Membership Paid';
        $message = 'Payment received, wait for confirmation from system.';
        $user->notify(new NotificationsMembership($title, $message));

        return redirect()->back()->with('success', 'Transaction Success');
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
