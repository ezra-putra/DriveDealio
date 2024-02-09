<?php

namespace App\Http\Controllers;

use App\Models\AuctionOrder;
use App\Models\AuctionWinner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    public function auctionlist()
    {
        $iduser = auth()->id();
        $list = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, um.id as idusermember, m.id as idmembership, m.membershiptype, b.id as idbid, b.bidamount,
            a.id as idauction, a.current_price, a.lot_number, v.id as idvehicle, v.model, v.adstatus, a.start_price
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.member_orders as mo on um.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on a.id = b.auctions_id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id where u.id = $iduser;")
        );

        $winner = DB::select(
            DB::raw("SELECT aw.id as idwinner, a.id as idauction, aw.windate, auctions_id, users_id
            FROM drivedealio.auctions as a INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id where aw.users_id = $iduser")
        );
        // $totalbids = DB::select(
        //     DB::raw("SELECT * FROM drivedealio.bids")
        // );

        return view('auction.listauction', compact('list', 'winner'));
    }

    public function placeBid(Request $request, $id)
    {
        $iduser = auth()->id();
        $userMember = DB::select(
            DB::raw("SELECT um.id as idusermember, um.status from drivedealio.user_memberships as um
            INNER JOIN drivedealio.users as u on um.users_id = u.id where um.users_id = $iduser AND um.status = 'Active';")
        );

        $auction = DB::table('drivedealio.auctions as a')
        ->join('vehicles as v', 'a.vehicles_id', '=', 'v.id')
        ->select('a.start_price', 'a.current_price')
        ->where('a.id', $id)
        ->first();

        $startprice = $auction->start_price;
        $currentprice = $auction->current_price;

        $amount = $request->input('amount');

        // dd($currentprice);
        if(!empty($userMember))
        {
            if($amount >= $startprice && $currentprice == 0)
            {
                DB::insert("INSERT INTO drivedealio.bids(bidamount, user_memberships_id, auctions_id) VALUES(:bidamount, :user_memberships_id, :auctions_id)",
                ['bidamount' => $amount, 'user_memberships_id' => $userMember[0]->idusermember, 'auctions_id' => $id ]);

                DB::update("UPDATE drivedealio.auctions SET current_price = :current WHERE id = :id;" ,
                ['current' => $amount, 'id' => $id]);

                return redirect()->back()->with(['success' => 'Bid placed successfully']);
            }
            if($amount > $currentprice && $currentprice != 0)
            {
                DB::insert("INSERT INTO drivedealio.bids(bidamount, user_memberships_id, auctions_id) VALUES(:bidamount, :user_memberships_id, :auctions_id)",
                ['bidamount' => $amount, 'user_memberships_id' => $userMember[0]->idusermember, 'auctions_id' => $id ]);

                DB::update("UPDATE drivedealio.auctions SET current_price = :current WHERE id = :id;" ,
                ['current' => $amount, 'id' => $id]);

                return redirect()->back()->with(['success' => 'Bid placed successfully']);
            }
            else
            {
                return redirect()->back()->with(['error' => 'Bid amount must be greater than the starting price or the current price']);
            }
        }
        else
        {
            return redirect("/membership/register");
        }
    }

    public function auctionCheckout($id)
    {
        $iduser = auth()->id();

        $vehicle = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, um.id as idusermember, m.id as idmembership, m.membershiptype, b.id as idbid, b.bidamount,
            a.id as idauction, a.current_price, a.lot_number, v.id as idvehicle, v.model, v.adstatus, a.start_price
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.memberships as m on m.id = um.memberships_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on a.id = b.auctions_id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id where u.id = $iduser AND v.id = $id;")
        );

        $address = DB::select(
            DB::raw("SELECT u.id as iduser, a.id as idaddress, a.name, a.address, a.district, a.city, a.zipcode, a.province, a.is_primaryadd
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser AND a.is_primaryadd = true;")
        );

        $userinfo = DB::select(
            DB::raw("SELECT id, firstname, lastname, phonenumber from drivedealio.users where id = $iduser")
        )[0];

        return view('auction.checkoutauction', compact('vehicle', 'address', 'userinfo'));
    }

    public function auctionOrders(Request $request, $id)
    {
        $iduser = auth()->id();
        $vehicle = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, um.id as idusermember, m.id as idmembership, m.membershiptype, b.id as idbid, b.bidamount,
            a.id as idauction, a.current_price, a.lot_number, v.id as idvehicle, v.model, v.adstatus, a.start_price
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.member_orders as mo on um.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on a.id = b.auctions_id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id where u.id = $iduser AND v.id = $id;")
        );
        $date = DB::select(
            DB::raw("SELECT count(orderdate) from drivedealio.auction_orders where DATE(orderdate) = CURRENT_DATE;")
        );
        $address = DB::select(
            DB::raw("SELECT u.id as iduser, a.id as idaddress, a.name, a.address, a.district, a.city, a.zipcode, a.province
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser;")
        );
        $winner = DB::select(
            DB::raw("SELECT aw.id as idwinner, a.id as idauction, aw.windate, auctions_id, users_id
            FROM drivedealio.auctions as a INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id where aw.users_id = $iduser")
        );

        if(!empty($address))
        {
            $order = new AuctionOrder;
            $counter = $date[0]->count + 1;
            $lotnumber = $vehicle[0]->lot_number;
            $order->invoicenum = "INV/" .date("Y/m/d"). "/$counter". "/$lotnumber";
            $order->status = 'Waiting for Payment';
            $order->orderdate = Carbon::now();
            $order->unitprice = $vehicle[0]->current_price;
            $order->paymentmethod = $request->input('payment');
            $order->paymentstatus = 'Unpaid';
            $order->towings_id = 1;
            $order->auctionwinners_id = $winner[0]->idwinner;
            $order->vehicles_id = $vehicle[0]->idvehicle;
            dd($order);
        }
    }

    public function loanSimulation($id)
    {
        $iduser = auth()->id();

        $vehicle = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, um.id as idusermember, m.id as idmembership, m.membershiptype, b.id as idbid, b.bidamount,
            a.id as idauction, a.current_price, a.lot_number, v.id as idvehicle, v.model, v.adstatus, a.start_price
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.member_orders as mo on um.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on a.id = b.auctions_id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id where u.id = $iduser AND v.id = $id;")
        );

        return view('auction.loan', compact('vehicle'));

    }

    public function addToWatchlist(Request $request, $id)
    {

    }



}
