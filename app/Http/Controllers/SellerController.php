<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{


    public function dashboard()
    {
        $iduser = auth()->id();
        $sparepart = DB::select(
            DB::raw("SELECT id, partnumber, partname, unitprice, stock, description, vehiclemodel, buildyear, colour, condition, shops_id
            FROM drivedealio.spareparts WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser);")
        );

        // $orders = DB::select(
        //     DB::raw()
        // );
        return view('/seller/dashboard', compact('sparepart'));
    }

    public function orderList()
    {

    }
}
