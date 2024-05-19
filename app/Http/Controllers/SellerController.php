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
        $profile = DB::select(
            DB::raw("SELECT u.id as iduser, s.id as idseller, s.pics, s.name, s.province, s.city
            FROM drivedealio.users as u INNER JOIN drivedealio.shops as s on u.id = s.users_id where s.id = $id")
        );
        $seller = DB::select(
            DB::raw("SELECT sp.id as idsparepart, sp.partnumber, sp.unitprice, sp.partname,
            sp.vehiclemodel, sp.buildyear, sp.colour, sp.brand,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.spareparts as sp where sp.shops_id = $id;")
        );
        $rating = DB::select(
            DB::raw("SELECT COALESCE(ROUND(AVG(r.rating), 2), 0.0) as avg_rating from drivedealio.reviews as r INNER JOIN drivedealio.spareparts as s on r.spareparts_id = s.id
            where s.shops_id = $id;")
        );

        return view('seller.profileseller', compact('seller', 'profile', 'rating'));
    }

    public function dashboard()
    {
        $iduser = auth()->id();
        $shopname = DB::select(
            DB::raw("SELECT id, name, pics, users_id from drivedealio.shops where users_id = $iduser;")
        );
        $sparepart = DB::select(
            DB::raw("SELECT id, partnumber, partname, unitprice, stock, description, vehiclemodel, buildyear, colour, condition, shops_id
            FROM drivedealio.spareparts WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser) LIMIT 5;")
        );

        $orderlist = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, o.id as idorder, o.orderdate, o.shops_id, o.users_id, o.invoicenum, o.status, o.paymentstatus
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
            DB::raw("SELECT o.id as idorder, u.id as iduser, o.invoicenum, o.orderdate, o.shops_id, o.users_id, o.status, o.paymentstatus, s.name, u.firstname, o.total_price
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.shops as s on o.shops_id = s.id
            WHERE s.users_id = $iduser order by o.orderdate desc;")
        );

        return view('/seller/orderlist', compact('orderlist'));
    }

    public function orderDetails(Request $request)
    {
        $id = ($request->get('id'));
        $data = Order::find($id);

        $order = DB::select(
            DB::raw("SELECT o.id as idorder, u.id as iduser, o.invoicenum, o.orderdate, o.shops_id, o.users_id, o.status, o.paymentstatus, s.name, o.total_price, s.id as idshop,
            a.name as addressname, a.address, a.province, a.city, a.district, a.village, a.zipcode
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.shops as s on o.shops_id = s.id
            LEFT JOIN drivedealio.addresses as a on a.id = o.addresses_id
            where o.id = $id AND o.addresses_id = a.id;")
        );

        $orderdetails = DB::select(
            DB::raw("SELECT od.quantityordered, od.unitprice, CONCAT(sp.partnumber, ' ', sp.partname, ' ', sp.vehiclemodel) as item_name, sp.id as idsparepart,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.orders as o INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
			INNER JOIN drivedealio.spareparts as sp on od.spareparts_id = sp.id where o.id = $id;")
        );

        $shippings = DB::select(
            DB::raw("SELECT shp.packagename, sh.shipping_number, sh.shipping_fee
            FROM drivedealio.shipments as shp INNER JOIN drivedealio.shippings as sh on shp.id = sh.shipments_id
            INNER JOIN drivedealio.orders as o on sh.id = o.shippings_id where o.id = $id;")
        );

        $status = DB::select(
            DB::raw("SELECT ss.status, ss.created_at
            FROM drivedealio.orders as o INNER JOIN drivedealio.shippings as s on o.shippings_id = s.id
            INNER JOIN drivedealio.shipping_statuses as ss on s.id = ss.shippings_id
            WHERE o.id = $id ORDER BY ss.created_at asc;")
        );

        $countItems = DB::select(
            DB::raw("SELECT count(quantityordered) as count from drivedealio.orderdetails where orders_id = $id;")
        );

        $totalshop = DB::select(
            DB::raw("SELECT sum(unitprice) as price from drivedealio.orderdetails where orders_id = $id;")
        );
        return response()->json(array(
            'msg'=> view('transaction.orderdetails',compact('data', 'order', 'orderdetails', 'shippings', 'countItems', 'totalshop', 'status'))->render()
        ),200);
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
