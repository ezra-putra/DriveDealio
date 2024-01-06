<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\UserMemberships;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MembershipController extends Controller
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

    public function register()
    {
        $iduser = auth()->id();
        $user = DB::select(
            DB::raw("select id, CONCAT(firstname, ' ', lastname) as name, phonenumber, address
            from drivedealio.users where id=$iduser;")
        );
        $membership = DB::select(
            DB::raw("select id, membershiptype, price, description FROM drivedealio.memberships;")
        );
        return view('membership.register', compact('membership', 'user'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('membership.register');
    }

    public function myBilings(){
        $iduser = auth()->id();

        if(auth()->user()->roles_id === 1){
            $member = DB::select(
                DB::raw("select m.id as idmember, m.membershiptype, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, hm.created_at, hm.updated_at , u.roles_id,
                CONCAT(u.firstname, ' ', u.lastname) as name
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id")
            );
        }else{
            $member = DB::select(
                DB::raw("select m.id as idmember, m.membershiptype, hm.id as idhasmember, hm.status, hm.start, hm.end, u.id as iduser, hm.created_at, hm.updated_at , u.roles_id
                from drivedealio.user_memberships as hm INNER JOIN drivedealio.users as u on hm.users_id = u.id
                INNER JOIN drivedealio.memberships as m on hm.memberships_id = m.id where u.id = $iduser;")
            );
        }

        return view('/membership/bilings', compact('member'));
    }

    public function approve_post($id)
    {
        $member = UserMemberships::findOrFail($id);
        $member->status = 'Actived';

        $member->save();
        return back()->with('status', 'Your request has been process!');
    }

    public function expired_post()
    {
        $member = DB::select(
            DB::raw("SELECT * from drivedealio.user_memberships WHERE status IS 'Active'")
        );

        foreach ($member as $m) {
            $expiryDate = Carbon::parse($m->end);

            if (now()->gt($expiryDate)) {
                $m->update(['status' => 'Expired']);
            }
        }
        return back()->with('status', 'Your request has been process!');
    }

    public function cancel_post($id)
    {
        $member = UserMemberships::findOrFail($id);
        if(auth()->user()->roles_id == 2){
            $member->status = 'Cancelled';
        }
        if(auth()->user()->roles_id == 1){
            $member->status = 'Rejected';
        }

        $member->save();
        return back()->with('status', 'Your request has been process!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $member = new UserMemberships;
        $member->users_id = auth()->id();
        $member->memberships_id = $request->input('member');
        $member->status = 'Pending';

        $member->start = now();
        $member->end = $member->start->copy()->addMonth();


        $member->save();

        return redirect('/membership/bilings')->with('status', 'Your request has been process!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
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
