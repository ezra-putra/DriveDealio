<?php

namespace App\Http\Controllers;

use App\Models\AuctionOrder;
use App\Models\Order;
use App\Models\ShippingStatus;
use App\Models\TowingStatus;
use App\Models\User;
use App\Notifications\ArrivedOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourierController extends Controller
{
    public function dashboard()
    {
        $shipping = DB::select(
            DB::raw("SELECT o.id as idorder, o.invoicenum, o.status, s.destination, s.origin, s.shipping_number, s.shipments_type, s.id as idshipping
            FROM drivedealio.orders as o INNER JOIN drivedealio.shippings as s on o.shippings_id = s.id
            WHERE s.shipping_number IS NOT NULL AND o.status != 'Arrived' ORDER BY s.created_at desc LIMIT 5;")
        );

        $towing = DB::select(
            DB::raw("SELECT ao.id as idorder, ao.status, ao.invoicenum, tw.destination, tw.origin, tw.trans_number, t.name, tw.id as idtowing
            FROM drivedealio.auction_orders as ao INNER JOIN drivedealio.towings as tw on ao.towings_id = tw.id
            INNER JOIN drivedealio.transporters as t on tw.transporters_id = t.id
            WHERE tw.trans_number IS NOT NULL AND ao.status != 'Arrived' ORDER BY tw.created_at desc LIMIT 5;")
        );

        return view('courier.dashboard', compact('shipping', 'towing'));
    }
    public function shippingList()
    {
        $shipping = DB::select(
            DB::raw("SELECT o.id as idorder, o.invoicenum, s.destination, s.origin, s.shipping_number, s.shipments_type, s.id as idshipping, s.total_weight, s.shipping_number,
            sh.name, sh.phonenumber, u.firstname, u.lastname, u.phonenumber as usernumber, u.email, o.status
            FROM drivedealio.orders as o INNER JOIN drivedealio.shippings as s on o.shippings_id = s.id
            INNER JOIN drivedealio.shops as sh on o.shops_id = sh.id
            INNER JOIN drivedealio.users as u on o.users_id = u.id WHERE o.status IN ('Arrived', 'On Delivery') ORDER BY s.created_at asc;")
        );

        return view('courier.listshipping', compact('shipping'));
    }

    public function towingList()
    {
        $towing = DB::select(
            DB::raw("SELECT ao.id as idorder, ao.invoicenum, tw.destination, tw.origin, tw.trans_number, t.name, tw.id as idtowing,
            u.firstname, u.lastname, u.phonenumber, u.email, ao.status
            FROM drivedealio.auction_orders as ao INNER JOIN drivedealio.towings as tw on ao.towings_id = tw.id
            INNER JOIN drivedealio.transporters as t on tw.transporters_id = t.id
            INNER JOIN drivedealio.auctionwinners as aw on ao.auctionwinners_id = aw.id
            INNER JOIN drivedealio.users as u on aw.users_id = u.id
            WHERE ao.status IN ('Arrived', 'On Delivery') ORDER BY tw.created_at asc;")
        );
        return view('courier.listtowing', compact('towing'));
    }

    public function shippingDetails($id)
    {
        $shipping = DB::select(
            DB::raw("SELECT o.id as idorder, o.invoicenum, s.destination, s.origin, s.shipping_number, s.shipments_type, s.id as idshipping, s.total_weight, s.shipping_number,
            sh.name, sh.phonenumber, u.firstname, u.lastname, u.phonenumber as usernumber, u.email
            FROM drivedealio.orders as o INNER JOIN drivedealio.shippings as s on o.shippings_id = s.id
            INNER JOIN drivedealio.shops as sh on o.shops_id = sh.id
            INNER JOIN drivedealio.users as u on o.users_id = u.id
            WHERE s.id = $id;")
        );

        $status = DB::select(
            DB::raw("SELECT ss.status, ss.created_at
            FROM drivedealio.shippings as s INNER JOIN drivedealio.shipping_statuses as ss on s.id = ss.shippings_id
            WHERE s.id = $id ORDER BY ss.created_at asc;")
        );

        $select_status = DB::select(
            DB::raw("SELECT ss.status, ss.created_at
            FROM drivedealio.shippings as s INNER JOIN drivedealio.shipping_statuses as ss on s.id = ss.shippings_id
            WHERE s.id = $id ORDER BY ss.created_at desc LIMIT 1;")
        );
        return view('courier.shippingdetails', compact('shipping', 'status', 'select_status'));
    }

    public function towingDetails($id)
    {
        $towing = DB::select(
            DB::raw("SELECT ao.id as idorder, ao.invoicenum, tw.destination, tw.origin, tw.trans_number, t.name, tw.id as idtowing,
            u.firstname, u.lastname, u.phonenumber, u.email
            FROM drivedealio.auction_orders as ao INNER JOIN drivedealio.towings as tw on ao.towings_id = tw.id
            INNER JOIN drivedealio.transporters as t on tw.transporters_id = t.id
            INNER JOIN drivedealio.auctionwinners as aw on ao.auctionwinners_id = aw.id
            INNER JOIN drivedealio.users as u on aw.users_id = u.id
            WHERE tw.id = $id")
        );

        $status = DB::select(
            DB::raw("SELECT ts.status, ts.created_at
            FROM drivedealio.towings as t INNER JOIN drivedealio.towing_statuses as ts on t.id = ts.towings_id
            WHERE t.id = $id ORDER BY ts.created_at asc;")
        );

        $select_status = DB::select(
            DB::raw("SELECT ts.status, ts.created_at
            FROM drivedealio.towings as t INNER JOIN drivedealio.towing_statuses as ts on t.id = ts.towings_id
            WHERE t.id = $id ORDER BY ts.created_at desc LIMIT 1;")
        );

        $vehicle = DB::select(
            DB::raw("SELECT ao.id as idorder, b.name, v.model, v.transmission, v.variant, v.colour, v.year,
            u.firstname, u.phonenumber, tw.origin
            FROM drivedealio.auction_orders as ao INNER JOIN drivedealio.towings as tw on ao.towings_id = tw.id
            INNER JOIN drivedealio.transporters as t on tw.transporters_id = t.id
            INNER JOIN drivedealio.vehicles as v on ao.vehicles_id = v.id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            INNER JOIN drivedealio.users as u on v.users_id = u.id
            WHERE tw.id = $id")
        );
        return view('courier.towingdetails', compact('towing', 'vehicle', 'status', 'select_status'));
    }

    public function updateShippingStatus(Request $request, $id)
    {
        $status = new ShippingStatus;
        $status->shippings_id = $id;
        $status->status = $request->input('status');
        $status->save();

        return redirect()->back()->with('success', 'Status Added!');
    }
    public function updateOrderStatus($id)
    {
        $order = Order::findOrFail($id);
        $order->status = "Arrived";
        $order->receivedate = Carbon::now();
        $order->save();

        return redirect()->back()->with('success', 'Package Arrived!');
    }

    public function updateTowingStatus(Request $request, $id)
    {
        $status = new TowingStatus;
        $status->towings_id = $id;
        $status->status = $request->input('status');
        $status->save();

        return redirect()->back()->with('success', 'Status Added!');
    }

    public function updateOrderTowing($id)
    {
        $order = AuctionOrder::findOrFail($id);
        $order->status = "Arrived";
        $order->save();

        $userInfo = DB::select(
            DB::raw("SELECT aw.users_id as iduser
            from drivedealio.auction_orders as ao INNER JOIN drivedealio.auctionwinners as aw on aw.id = ao.auctionwinners_id
            where ao.id = $id;")
        );
        $iduser = $userInfo[0]->iduser;

        $user = User::find($iduser);
        $title = 'Order Information';
        $message = 'Your Vehicle has Been Arrived!';
        $user->notify(new ArrivedOrder($title, $message));

        return redirect()->back()->with('success', 'Package Arrived!');
    }
}
