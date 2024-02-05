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
            DB::raw("SELECT m.*, b.* FROM drivedealio.memberships as m
            INNER JOIN drivedealio.benefits as b on m.benefits_id = b.id;")
        );
        $memberships = Session('membership');
        return view('welcome', compact('membership'));
    }

    
}
