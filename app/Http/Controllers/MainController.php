<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function index()
    {
        $iduser = auth()->id();

        return view('layout.main');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $vehicle = DB::select(
            DB::raw("SELECT a.start_price as price, v.id as idvehicle, v.model, v.variant, vt.name as type, c.name, b.name as brand, a.lot_number, v.adstatus,
            (SELECT COALESCE(i.url, 'placeholder_url') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url, a.start_date, a.end_date, a.id as idauction
            from drivedealio.auctions as a INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            INNER JOIN drivedealio.vehicletypes as vt on vt.id = v.vehicletypes_id
            INNER JOIN drivedealio.vehiclecategories as c on c.id = vt.vehiclecategories_id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            WHERE v.model ILIKE '%$search%' OR b.name ILIKE '%$search%' AND v.adstatus = 'Open to Bid';")
        );
        if(!empty($vehicle))
        {
            $startDateTime = Carbon::parse($vehicle[0]->start_date);
            $endDateTime = Carbon::parse($vehicle[0]->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $vehicle[0]->duration = $this->formatDuration($interval);
        }

        $sparepart = DB::select(
            DB::raw("SELECT sh.id as idshop, sh.name, sh.city, s.id as idsparepart, s.partnumber, s.partname, s.unitprice, s.stock, s.description,
            s.vehiclemodel, s.buildyear, s.colour, s.condition, s.shops_id, s.weight,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = s.id LIMIT 1) as url
            FROM drivedealio.spareparts as s
            INNER JOIN drivedealio.shops as sh on s.shops_id = sh.id
            WHERE s.stock > 0 AND s.partname ILIKE '%$search%' OR s.partnumber ILIKE '%$search%';")
        );

        return view('layout.search', compact('vehicle', 'sparepart'));
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
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
