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
                DB::raw("SELECT m.id as idmember, m.membershiptype, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser,
                hm.created_at, hm.updated_at , u.roles_id, hm.paymentmethod, hm.paymentstatus, hm.paymentduedate, hm.paymentdate, u.firstname
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id")
            );
        }else{
            $member = DB::select(
                DB::raw("SELECT m.id as idmember, m.membershiptype, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser,
                hm.created_at, hm.updated_at , u.roles_id, hm.paymentmethod, hm.paymentstatus, hm.paymentduedate, hm.paymentdate
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id where u.id = $iduser;")
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
        $endDateTime = Carbon::parse($member[0]->paymentduedate);
        $now = Carbon::now();
        $idhasmember = $member[0]->idhasmember;
        if ($now >= $endDateTime && $member[0]->paymentstatus == "Unpaid") {
            DB::table('drivedealio.user_memberships')
                ->where('id', $idhasmember)
                ->update(['status' => 'Cancelled', 'paymentstatus' => 'Unpaid']);
                $membership = DB::select(
                    DB::raw("SELECT hm.id as idhasmember, hm.memberships_id, m.id as idmember, m.membershiptype, m.price, hm.users_id as iduser, hm.paymentstatus
                    FROM drivedealio.user_memberships as hm INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id
                    WHERE hm.memberships_id = $idhasmember AND hm.users_id = $iduser;")
                );
                $user = User::find($membership[0]->iduser);
                $title = 'Membership expired';
                $message = 'Your membership has expired, please renew it.';
                $user->notify(new NotificationsMembership($title ,$message));
            }
        $interval = $startDateTime->diff($endDateTime);
        $member[0]->duration = $this->formatDuration($interval);

        return view('/membership/bilings', compact('member'));
    }

    public function approve_post($id)
    {
        $member = UserMemberships::findOrFail($id);
        $member->status = 'Active';
        $member->save();

        $user = auth()->id();
        $membership = DB::select(
            DB::raw("SELECT hm.id as idhasmember, hm.memberships_id, m.id as idmember, m.membershiptype, m.price, hm.users_id as iduser, hm.paymentstatus
            FROM drivedealio.user_memberships as hm INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id
            WHERE hm.memberships_id = $id AND hm.users_id = $user;")
        );
        $user = User::find($membership[0]->iduser);
        $title = 'Membership status';
        $message = 'Your membership is now active.';
        $user->notify(new NotificationsMembership($title, $message));

        return back()->with('status', 'Your request has been process!');
    }

    public function cancel_post($id)
    {
        $member = UserMemberships::findOrFail($id);
        if(auth()->user()->roles_id == 2){
            $member->status = 'Cancelled';
            $message = 'Your membership Cancelled.';
        }
        if(auth()->user()->roles_id == 1){
            $member->status = 'Rejected';

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
            $membership = DB::select(
                DB::raw("SELECT hm.id as idhasmember, hm.memberships_id, m.id as idmember, m.membershiptype, m.price, hm.users_id as iduser, hm.paymentstatus
                FROM drivedealio.user_memberships as hm INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id
                WHERE hm.memberships_id = $member->memberships_id AND hm.users_id = $member->users_id;")
            );
            $user = User::find($membership[0]->iduser);
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

    public function payment($id)
    {

    }

    protected function formatDuration($interval)
    {
        $formattedDuration = '';

        // Tambahkan jam jika lebih dari 0
        if ($interval->h > 0) {
            $formattedDuration .= $interval->h . 'H ';
        }

        // Tambahkan menit jika lebih dari 0
        if ($interval->i > 0) {
            $formattedDuration .= $interval->i . 'M ';
        }

        // Tambahkan detik jika lebih dari 0
        if ($interval->s > 0) {
            $formattedDuration .= $interval->s . 'S';
        }

        return trim($formattedDuration);
    }

    public function show(Membership $membership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function edit(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membership $membership)
    {
        //
    }
}
