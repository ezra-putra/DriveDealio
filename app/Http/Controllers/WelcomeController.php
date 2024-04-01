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
        $sparepart = DB::select(
            DB::raw("SELECT sh.id as idshop, sh.name, sh.city, s.id as idsparepart, s.partnumber, s.partname, s.unitprice, s.stock, s.description,
            s.vehiclemodel, s.buildyear, s.colour, s.condition, s.shops_id, s.weight,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = s.id LIMIT 1) as url
                FROM drivedealio.spareparts as s
                INNER JOIN drivedealio.shops as sh on s.shops_id = sh.id
                WHERE s.stock > 0 ORDER BY s.created_at DESC LIMIT 8;")
        );
        return view('welcome', compact('membership', 'sparepart'));
    }


}
