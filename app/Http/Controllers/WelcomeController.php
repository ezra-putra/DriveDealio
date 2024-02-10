<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $membership = DB::select(
            DB::raw("SELECT * FROM drivedealio.memberships;")
        );
        $memberships = Session('membership');
        return view('welcome', compact('membership'));
    }


}
