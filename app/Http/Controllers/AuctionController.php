<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    public function auctionlist()
    {
        //
    }

    public function placeBid(Request $request, $id)
    {
        $iduser = auth()->id();
        $userMember = DB::select(
            DB::raw("SELECT um.id as idusermember from drivedealio.user_memberships as um
            INNER JOIN drivedealio.users as u on um.users_id = u.id where um.users_id = $iduser")
        )[0]->idusermember;

        // $startprice = DB::select(
        //     DB::raw("SELECT a.start_price FROM drivedealio.auctions as a
        //     INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id where a.id = $id;")
        // );

        // $currentprice = DB::select(
        //     DB::raw("SELECT a.current_price FROM drivedealio.auctions as a
        //     INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id where a.id = $id;")
        // );

        $auction = DB::table('drivedealio.auctions as a')
        ->join('vehicles as v', 'a.vehicles_id', '=', 'v.id')
        ->select('a.start_price', 'a.current_price')
        ->where('a.id', $id)
        ->first();

        $startprice = $auction->start_price;
        $currentprice = $auction->current_price;

        $amount = $request->input('amount');

        // dd($currentprice);

        if($amount > $startprice && $currentprice == 0)
        {
            DB::insert("INSERT INTO drivedealio.bids(bidamount, user_memberships_id, auctions_id) VALUES(:bidamount, :user_memberships_id, :auctions_id)",
            ['bidamount' => $amount, 'user_memberships_id' => $userMember, 'auctions_id' => $id ]);

            DB::update("UPDATE drivedealio.auctions SET current_price = :current WHERE id = :id;" ,
            ['current' => $amount, 'id' => $id]);

            return redirect()->back()->with(['success' => 'Bid placed successfully']);
        }
        if($amount > $currentprice && $currentprice != 0)
        {
            DB::insert("INSERT INTO drivedealio.bids(bidamount, user_memberships_id, auctions_id) VALUES(:bidamount, :user_memberships_id, :auctions_id)",
            ['bidamount' => $amount, 'user_memberships_id' => $userMember, 'auctions_id' => $id ]);

            DB::update("UPDATE drivedealio.auctions SET current_price = :current WHERE id = :id;" ,
            ['current' => $amount, 'id' => $id]);

            return redirect()->back()->with(['success' => 'Bid placed successfully']);
        }
        else
        {
            return redirect()->back()->with(['error' => 'Bid amount must be greater than the starting price or the current price']);
        }

    }

    public function auctionTable()
    {
        //
    }

    public function auctionOrders()
    {
        //
    }
}
