<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Carbon\Carbon;
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

        $query = DB::table('auctions as a')
                ->select('a.start_price as price', 'v.id as idvehicle', 'v.model', 'v.variant', 'vt.name as type', 'c.name', 'b.name as brand', 'a.lot_number', 'v.adstatus', 'v.transmission',
                        DB::raw('(SELECT COALESCE(i.url, \'placeholder_url\') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url'), 'a.start_date', 'a.end_date', 'a.id as idauction')
                ->join('vehicles as v', 'a.vehicles_id', '=', 'v.id')
                ->join('vehicletypes as vt', 'vt.id', '=', 'v.vehicletypes_id')
                ->join('vehiclecategories as c', 'c.id', '=', 'vt.vehiclecategories_id')
                ->join('brands as b', 'v.brands_id', '=', 'b.id')
                ->where('v.adstatus', 'Open to Bid');

        $vehicle = $query->get();

        foreach ($vehicle as $v) {
            $startDateTime = Carbon::parse($v->start_date);
            $endDateTime = Carbon::parse($v->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $v->duration = $this->formatDuration($interval);
        }
        return view('welcome', compact('membership', 'sparepart', 'vehicle'));
    }

    protected function formatDuration($interval)
    {
        $formattedDuration = '';

        if ($interval->days > 0) {
            $formattedDuration .= $interval->days . 'D ';
        }

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
