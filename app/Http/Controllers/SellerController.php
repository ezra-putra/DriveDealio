<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Seller;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function sellerProfile($id)
    {
        $seller = DB::select(
            DB::raw("SELECT u.id as iduser, s.id as idseller, s.pics, s.name, s.province, s.city, sp.id as idsparepart, sp.partnumber, sp.unitprice, sp.partname,
            sp.vehiclemodel, sp.buildyear, sp.colour, sp.brand, (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.users as u INNER JOIN drivedealio.shops as s on u.id = s.users_id
            INNER JOIN drivedealio.spareparts as sp on s.id = sp.shops_id where sp.shops_id = $id;")
        );
        return view('seller.profileseller', compact('seller'));
    }

    public function dashboard()
    {
        $iduser = auth()->id();
        $shopname = DB::select(
            DB::raw("select name from drivedealio.shops where users_id = $iduser;")
        );
        $sparepart = DB::select(
            DB::raw("SELECT id, partnumber, partname, unitprice, stock, description, vehiclemodel, buildyear, colour, condition, shops_id
            FROM drivedealio.spareparts WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser) LIMIT 5;")
        );

        $orderlist = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, o.id as idorder, o.orderdate, o.shops_id, o.users_id, o.invoicenum, o.status, o.paymentmethod, o.paymentstatus
            from drivedealio.users as u INNER JOIN drivedealio.orders as o on u.id = o.users_id WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser) order by o.orderdate desc LIMIT 5;")
        );
        $ordercount = DB::select(
            DB::raw("SELECT count(id) as totalorder
            from drivedealio.orders WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser) AND orderdate = current_date;")
        );
        $totalorder =DB::select(
            DB::raw("SELECT count(id) as totalorder
            from drivedealio.orders WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser)")
        );
        $sparepartcount = DB::select(
            DB::raw("SELECT count(id) as totalitem
            FROM drivedealio.spareparts WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser);")
        );
        return view('/seller/dashboard', compact('sparepart', 'orderlist', 'ordercount', 'sparepartcount', 'shopname', 'totalorder'));
    }

    public function orderList()
    {
        $iduser = auth()->id();
        $orderlist = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, o.id as idorder, o.orderdate, o.shops_id, o.users_id, o.invoicenum, o.status, o.paymentmethod, o.paymentstatus, sp.id as idsparepart,
            (SELECT sum(od.unitprice) from drivedealio.orderdetails as od where od.orders_id = o.id ) as total_price
            from drivedealio.users as u INNER JOIN drivedealio.orders as o on u.id = o.users_id
            INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
            INNER JOIN drivedealio.spareparts as sp on od.spareparts_id = sp.id
            WHERE o.shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser) order by o.orderdate desc;")
        );


        return view('/seller/orderlist', compact('orderlist'));
    }

    public function listSparepart()
    {
        $iduser = auth()->id();
        $sparepart = DB::select(
            DB::raw("SELECT id, partnumber, partname, unitprice, stock, description, vehiclemodel, buildyear, colour, condition, shops_id
            FROM drivedealio.spareparts WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser);")
        );
        $cat = DB::select(
            DB::raw("SELECT * FROM drivedealio.sparepartcategories;")
        );
        return view('seller.sparepartlist', compact('sparepart', 'cat'));
    }

    public function sparepartEditForm($id)
    {
        $iduser = auth()->id();
        $sparepart = DB::select(
            DB::raw("SELECT s.id as idsparepart, s.partnumber, s.partname, s.unitprice, s.stock, s.description, s.vehiclemodel, s.buildyear, s.colour, s.condition, s.shops_id, s.brand, c.id as idcategories, c.categoriname, s.weight
            FROM drivedealio.spareparts as s INNER JOIN drivedealio.sparepartcategories as c on c.id = s.sparepartcategories_id
            WHERE s.shops_id = (select sp.id as idshop from drivedealio.shops as sp
            INNER JOIN drivedealio.users as u on sp.users_id = u.id where sp.users_id = $iduser) AND s.id = $id;")
        );
        return view('seller.updatesparepart', compact('sparepart'));
    }

    public function sparepartUpdate(Request $request, $id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->partnumber = $request->input('partnum');
        $sparepart->unitprice = $request->input('price');
        $sparepart->stock = $sparepart->stock + $request->input('addstock');
        $sparepart->description = $request->input('desc');
        $sparepart->partname = $request->input('partname');
        $sparepart->vehiclemodel = $request->input('model');
        $sparepart->buildyear = $request->input('year');
        $sparepart->colour = $request->input('colour');
        $sparepart->condition = $request->input('condition');
        $sparepart->brand = $request->input('brand');
        $sparepart->weight = $request->input('weight');
        $sparepart->save();

        return redirect()->route('seller.sparepartlist')->with('success', 'Sparepart updated successfully.');
    }

}
