<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{


    public function dashboard()
    {
        $id = auth()->id();
        $sparepart = DB::select(
            DB::raw("SELECT id, partnumber, partname, unitprice, stock, description, vehiclemodel, buildyear, colour, shops_id
            FROM drivedealio.spareparts WHERE shops_id = $id")
        );
        return view('/seller/dashboard', compact('sparepart'));
    }

    public function orderList()
    {
        
    }
}
