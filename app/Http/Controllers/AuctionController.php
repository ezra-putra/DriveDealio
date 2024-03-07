<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionOrder;
use App\Models\AuctionWinner;
use App\Models\Bid;
use App\Models\District;
use App\Models\Loan;
use App\Models\LoanPayment;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Towing;
use App\Models\TowingStatus;
use App\Models\Village;
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
            a.id as idauction, a.current_price, a.lot_number, v.id as idvehicle, v.model, v.adstatus, a.start_price, a.start_date, a.end_date, v.transmission, br.name as brand, v.colour, v.year, v.variant,
            (SELECT COALESCE(i.url, 'placeholder_url') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.member_orders as mo on um.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on a.id = b.auctions_id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            INNER JOIN drivedealio.brands as br on v.brands_id = br.id
            where u.id = $iduser;")
        );
        if(!empty($list)){
            $idvehicle = $list[0]->idvehicle;
            $idauction = $list[0]->idauction;
            $winner = DB::select(
                DB::raw("SELECT id as idwinner, auctions_id FROM drivedealio.auctionwinners where users_id = $iduser AND is_winner = true;")
            );
            // dd($winner);

            $order = DB::select(
                DB::raw("SELECT * FROM drivedealio.auction_orders where vehicles_id = $idvehicle;")
            );

            $startDateTime = Carbon::parse($list[0]->start_date);
            $endDateTime = Carbon::parse($list[0]->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $list[0]->duration = $this->formatDuration($interval);

            return view('auction.listauction', compact('list', 'winner', 'order'));
        }

        return view('auction.listauction', compact('list'));

    }

    public function placeBid(Request $request, $id)
    {
        $iduser = auth()->id();
        $userMember = DB::select(
            DB::raw("SELECT um.id as idusermember, um.status, m.membership_type from drivedealio.user_memberships as um
            INNER JOIN drivedealio.users as u on um.users_id = u.id
            INNER JOIN drivedealio.member_orders as mo on um.id = mo.user_membership_id
            INNER JOIN drivedealio.memberships as m on mo.memberships_id = m.id
            where um.users_id = $iduser AND um.status = 'Active';")
        );

        $categories = DB::select(
            DB::raw("SELECT c.id, c.name from drivedealio.vehiclecategories as c
            INNER JOIN drivedealio.vehicletypes as vt on c.id = vt.vehiclecategories_id
            INNER JOIN drivedealio.vehicles as v on vt.id = v.vehicletypes_id where v.id = $id")
        );

        $auction = DB::table('drivedealio.auctions as a')
        ->join('vehicles as v', 'a.vehicles_id', '=', 'v.id')
        ->select('a.start_price', 'a.current_price')
        ->where('a.id', $id)
        ->first();

        $startprice = $auction->start_price;
        $currentprice = $auction->current_price;

        $bidamount = preg_replace('/[^\d]/', '', $request->input('amount'));
        $amount = (int)$bidamount;

        if(!empty($userMember))
        {
            $allowedBids = 0;
            if ($userMember[0]->status === 'Active') {
                if ($userMember[0]->membership_type === 'Bronze') {
                    if ($categories[0]->id === 1) {
                        $allowedBids = 2;
                    }
                } elseif ($userMember[0]->membership_type === 'Silver') {
                    if ($categories[0]->id === 2) {
                        $allowedBids = 2;
                    } elseif ($categories[0]->id === 1) {
                        $allowedBids = 1;
                    }
                } elseif ($userMember[0]->membership_type === 'Gold') {
                    if ($categories[0]->id === 2) {
                        $allowedBids = 2;
                    } elseif ($categories[0]->id === 1) {
                        $allowedBids = 2;
                    }
                } elseif ($userMember[0]->membership_type === 'Platinum') {
                    if ($categories[0]->id === 2) {
                        $allowedBids = 4;
                    } elseif ($categories[0]->id === 2) {
                        $allowedBids = 3;
                    }
                }
            }

            if ($allowedBids > 0 && $amount > $currentprice && $currentprice != 0) {
                $existingBidsCount = Bid::where('user_memberships_id', $userMember[0]->idusermember)
                    ->where('auctions_id', $id)
                    ->count();

                if ($existingBidsCount < $allowedBids) {
                    // Proses penawaran
                    if ($amount >= $startprice && $currentprice == 0) {
                        // Bid pertama
                        $bidnew = new Bid;
                        $bidnew->bidamount = $amount;
                        $bidnew->user_memberships_id = $userMember[0]->idusermember;
                        $bidnew->auctions_id = $id;
                        $bidnew->biddatetime = Carbon::now();
                        $bidnew->save();

                        $auction = Auction::findOrFail($id);
                        $auction->current_price = $amount;
                        $auction->save();

                        return redirect()->back()->with(['success' => 'Bid placed successfully']);
                    } elseif ($amount > $currentprice && $currentprice != 0) {
                        $isBidExist = DB::select("SELECT 1 FROM drivedealio.bids WHERE user_memberships_id = :user_memberships_id AND auctions_id = :id",
                        ['user_memberships_id' => $userMember[0]->idusermember, 'id' => $id]);

                        if (!empty($isBidExist))
                        {
                            $bidupdate = Bid::where('user_memberships_id', $userMember[0]->idusermember)
                                ->where('auctions_id', $id)
                                ->firstOrFail();
                            $bidupdate->bidamount = $amount;
                            $bidupdate->biddatetime = Carbon::now();
                            // dd($bidupdate);
                            $bidupdate->save();

                            $auction = Auction::findOrFail($id);
                            $auction->current_price = $amount;
                            $auction->save();

                            return redirect()->back()->with(['success' => 'Bid amount updated successfully']);
                        }

                        $bidnew = new Bid;
                        $bidnew->bidamount = $amount;
                        $bidnew->user_memberships_id = $userMember[0]->idusermember;
                        $bidnew->auctions_id = $id;
                        $bidnew->biddatetime = Carbon::now();
                        // dd($bidnew);
                        $bidnew->save();

                        $auction = Auction::findOrFail($id);
                        $auction->current_price = $amount;
                        // dd($auction);
                        $auction->save();

                        return redirect()->back()->with(['success' => 'Bid placed successfully']);
                    }
                    elseif ($amount <= $currentprice && $currentprice != 0)
                    {
                        return redirect()->back()->with(['error' => 'Bid amount must be greater than the current price']);
                    }
                    else
                    {
                        return redirect()->back()->with(['error' => 'Bid amount must be greater than the starting price']);
                    }
                }
                else
                {
                    return redirect()->back()->with(['error' => 'You have reached the maximum number of bids allowed for your membership type in this category']);
                }
            }
            else
            {
                return redirect()->back()->with(['error' => 'Your membership type does not allow bidding in this category']);
            }
        }
        else
        {
            return redirect("/membership/register")->with('error', 'You must be registered as member before place bid!');
        }
    }


    public function auctionCheckout($id)
    {
        $iduser = auth()->id();
        $vehicle = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, um.id as idusermember, m.id as idmembership, m.membershiptype, b.id as idbid, b.bidamount,
            a.id as idauction, a.current_price, a.lot_number, v.id as idvehicle, v.model, v.variant, v.transmission, v.colour, v.year, v.adstatus, br.name as brand, a.start_price, v.province, v.village, v.district, v.regency,
            (SELECT COALESCE(i.url, 'placeholder_url') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.member_orders as mo on um.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on a.id = b.auctions_id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            INNER JOIN drivedealio.brands as br on v.brands_id = br.id
            where v.id = $id AND u.id = $iduser;")
        );

        $categories = DB::select(
            DB::raw("SELECT c.id, c.name from drivedealio.vehiclecategories as c
            INNER JOIN drivedealio.vehicletypes as vt on c.id = vt.vehiclecategories_id
            INNER JOIN drivedealio.vehicles as v on vt.id = v.vehicletypes_id where v.id = $id")
        );

        $address = DB::select(
            DB::raw("SELECT id as idaddress, name, address, district,
            city, province, village, zipcode, is_primaryadd FROM drivedealio.addresses where users_id = $iduser AND is_primaryadd = true order by is_primaryadd desc")
        );

        $provinces = Province::all();
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();

        $profile = DB::select(
            DB::raw("SELECT u.id as iduser, u.email, u.profilepicture, u.firstname, u.lastname, u.birthdate, u.phonenumber, a.id as idaddress, a.name, a.address, a.district,
            a.city, a.province, a.zipcode, a.is_primaryadd
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser order by a.is_primaryadd desc;")
        );

        $userinfo = DB::select(
            DB::raw("SELECT id, firstname, lastname, phonenumber from drivedealio.users where id = $iduser")
        )[0];

        $transporters = DB::select(
            DB::raw("SELECT id, name, details from drivedealio.transporters;")
        );

        if (empty($address)) {
            return redirect('/profile')->with('error', 'Add Your Address First!');
        }

        $order = DB::select(
            DB::raw("SELECT * FROM drivedealio.auction_orders where vehicles_id = $id")
        );

        $origin = $vehicle[0]->district. ", " .$vehicle[0]->regency. ", " .$vehicle[0]->province;
        $destination = $address[0]->district. ", " .$address[0]->city. ", " .$address[0]->province;
        // dd($destination);

        $api_key = "U3iyOQmVBs4QcsdEdUvELHllqlXt7pbrL36Wo8aSfWA5AIVWswwPGNbSl4SVerHC";
        $url = "https://api.distancematrix.ai/maps/api/distancematrix/json?origins=". urlencode($origin) . "&destinations=" . urlencode($destination) . "&key=" . $api_key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        if ($data['status'] == 'OK')
        {
            $distance = $data['rows'][0]['elements'][0]['distance']['text'];

            $distanceValue = (float)preg_replace('/[^0-9.]/', '', $distance);
        }
        return view('auction.checkoutauction', compact('vehicle', 'address', 'userinfo', 'provinces', 'regencies', 'districts', 'villages', 'profile', 'distanceValue', 'transporters', 'categories', 'order'));
    }

    public function auctionOrders(Request $request, $id)
    {
        $iduser = auth()->id();
        $vehicle = DB::select(
            DB::raw("SELECT u.id as iduser, u.firstname, um.id as idusermember, m.id as idmembership, m.membershiptype, b.id as idbid, b.bidamount,
            a.id as idauction, a.current_price, a.lot_number, v.id as idvehicle, v.model, v.adstatus, a.start_price, v.province, v.village, v.district, v.regency
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.member_orders as mo on um.id = mo.user_memberships_id
            INNER JOIN drivedealio.memberships as m on m.id = mo.memberships_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on a.id = b.auctions_id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id where u.id = $iduser AND v.id = $id;")
        );
        $idauction = $vehicle[0]->idauction;
        $date = DB::select(
            DB::raw("SELECT count(orderdate) from drivedealio.auction_orders where DATE(orderdate) = CURRENT_DATE;")
        );
        $address = DB::select(
            DB::raw("SELECT u.id as iduser, a.id as idaddress, a.name, a.address, a.district, a.city, a.zipcode, a.province
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser AND is_primaryadd = true;")
        );
        $winner = DB::select(
            DB::raw("SELECT aw.id as idwinner, a.id as idauction, aw.windate, auctions_id, users_id
            FROM drivedealio.auctions as a INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id where aw.users_id = $iduser AND a.id = $idauction;")
        );

        if(!empty($address))
        {
            $origin = $vehicle[0]->district. ", " .$vehicle[0]->regency. ", " .$vehicle[0]->province;
            $destination = $address[0]->district. ", " .$address[0]->city. ", " .$address[0]->province;

            $order = new AuctionOrder;
            $counter = $date[0]->count + 1;
            $idvehicle = $vehicle[0]->idvehicle;
            $idwinner = $winner[0]->idwinner;
            // dd($idvehicle);
            $order->invoicenum = "INV/AUC/" .date("Y/m/d"). "/$counter". "/$idvehicle";
            $order->status = 'Waiting for Payment';
            $order->orderdate = Carbon::now();
            $order->total_price = $request->input('totalPrice');
            $order->paymentstatus = 'Unpaid';
            $order->auctionwinners_id = $idwinner;
            $order->vehicles_id = $idvehicle;

            // dd($order);

            $towings = new Towing;
            $towings->origin = $origin;
            $towings->destination = $destination;
            $towings->transporters_id = $request->input('shipId');
            $towings->price = $request->input('towFee');
            $towings->save();

            // $order =  AuctionOrder::findOrFail($order->id);
            $order->towings_id = $towings->id;
            $order->save();

            return redirect()->back()->with('success', 'Order Create');
        }
    }

    public function paymentIndex($id)
    {
        $iduser = auth()->id();
        $order = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate,
            ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id
            INNER JOIN drivedealio.auction_orders as ao on aw.id = ao.auctionwinners_id
            INNER JOIN drivedealio.users as u on aw.users_id = u.id
            WHERE ao.id = $id AND u.id = $iduser;")
        );
        $idorder = $order[0]->idorder;
        // dd($idorder);
        $orderdate = date('Y-m-d H:i:s O', strtotime($order[0]->orderdate));


        \Midtrans\Config::$serverKey = 'SB-Mid-server-AOdoK40xyUyq11-i9Cc9ysHM';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order[0]->invoicenum,
                'gross_amount' => $order[0]->total_price,
            ),
            'customer_details' => array(
                'first_name' => $order[0]->firstname,
                'last_name' => $order[0]->lastname,
                'email' => $order[0]->email,
                'phone' => $order[0]->phonenumber,
            ),
            'expiry' => array(
                'start_time' => $orderdate,
                'unit' => 'days',
                'duration' => 5
            ),
            'enabled_payments' => [
                "permata_va",
                "bca_va",
                "bni_va",
                "bri_va",
            ]
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $order = AuctionOrder::findOrFail($id);
        if(empty($order->snap_token)){
            $order->paymentmethod = "Virtual Account";
            $order->snap_token = $snapToken;
            $order->save();
        }
        $snap_token = DB::select(
            DB::raw("SELECT snap_token from drivedealio.auction_orders where id = $id")
        )[0]->snap_token;

        return view('auction.payment', compact('order', 'snap_token', 'idorder'));
    }

    public function paymentPaid($id)
    {
        $order = AuctionOrder::findOrFail($id);
        $order->status = "Waiting for Confirmation";
        $order->paymentstatus = "Paid";
        $order->paymentdate = Carbon::now();
        $order->save();

        return redirect('/orderhistory')->with('success', 'Transaction Success');
    }

    public function approveOrder($id)
    {
        $order = AuctionOrder::findOrFail($id);
        $order->status = "On Process";
        $order->save();
        return redirect()->back()->with('success', 'Order Status Changed!');
    }

    public function onDelivery($id)
    {
        $towing = DB::select(
            DB::raw("SELECT t.id as idtowing, ao.orderdate
            from drivedealio.auction_orders as ao INNER JOIN drivedealio.towings as t on ao.towings_id = t.id
            where ao.id = $id;")
        );

        if (empty($towing)) {
            return redirect()->back()->with('error', 'No delivery data found');
        }
        else
        {
            $idtowing = $towing[0]->idtowing;
            $towing = Towing::findOrFail($idtowing);
            $towing->trans_number = "DDA".date("ymd").$idtowing;
            $towing->save();

            $status = new TowingStatus;
            $status->towings_id = $idtowing;
            $status->status = "Request to Pickup";
            $status->save();

            $order = AuctionOrder::findOrFail($id);
            $order->status = "On Delivery";
            $order->save();
            // dd($order);

            return redirect()->back()->with('success', 'Delivery Arranged');
        }
    }

    public function loan($id)
    {
        $iduser = auth()->id();
        $order = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate,
            ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id
            INNER JOIN drivedealio.auction_orders as ao on aw.id = ao.auctionwinners_id
            INNER JOIN drivedealio.users as u on aw.users_id = u.id
            WHERE ao.id = $id AND u.id = $iduser;")
        );

        return view('auction.loan', compact('order'));
    }

    public function applyLoan(Request $request, $id)
    {
        $iduser = auth()->id();
        $order = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate,
            ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id
            INNER JOIN drivedealio.auction_orders as ao on aw.id = ao.auctionwinners_id
            INNER JOIN drivedealio.users as u on aw.users_id = u.id
            WHERE ao.id = $id AND u.id = $iduser;")
        );

        $price = $order[0]->total_price;
        $idorder = $order[0]->idorder;

        $loan = new Loan;
        $loan->monthlypayment = $request->input('cicilanPerbulan');
        $loan->downpayment = $request->input('dpRupiah');
        $loan->interest = $request->input('bunga');
        $loan->loantenor = $request->input('jangkaWaktuInput');
        $loan->status = "Waiting for Approval";
        $loan->users_id = $iduser;
        $loan->unitprice = $price;
        $loan->auction_orders_id = $idorder;
        // dd($loan);
        $loan->save();

        $auctionorder = AuctionOrder::findOrFail($id);
        $auctionorder->paymentmethod = "DriveDealio Loan";
        $auctionorder->status = "Waiting for Loan Approval";
        $auctionorder->save();

        return redirect('/auction')->with('success', 'Loan Applied, waiting for confirmation from system!');
    }

    public function payDownPayment($id)
    {
        $loan = DB::select(
            DB::raw("SELECT l.id as idloan, l.monthlypayment, l.downpayment, u.firstname, u.lastname, u.email, u.phonenumber, l.auction_orders_id
            FROM drivedealio.users as u INNER JOIN drivedealio.loans as l on u.id = l.users_id WHERE l.auction_orders_id = $id;")
        );

        $date = DB::select(
            DB::raw("SELECT count(created_at) as count from drivedealio.loan_payments where DATE(created_at) = CURRENT_DATE;;")
        );

        $idloan = $loan[0]->idloan;
        $downpayment = $loan[0]->downpayment;
        // dd($idorder);

        $counter = $date[0]->count + 1;
        $loanpay = new LoanPayment;
        $loanpay->invoicenum = "INV/DP/" .date("Y/m/d"). "/$idloan" ."/$counter";
        $loanpay->loans_id = $idloan;
        $loanpay->total_bill = $downpayment;
        $loanpay->status = "Unpaid";
        $loanpay->type = "Down Payment";
        $loanpay->paymentcount = 0;
        // dd($loanpay);
        $loanpay->save();

        $orderdate = date('Y-m-d H:i:s O', strtotime($loanpay->created_at));

        \Midtrans\Config::$serverKey = 'SB-Mid-server-AOdoK40xyUyq11-i9Cc9ysHM';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $loanpay->invoicenum,
                'gross_amount' => $loanpay->total_bill,
            ),
            'customer_details' => array(
                'first_name' => $loan[0]->firstname,
                'last_name' => $loan[0]->lastname,
                'email' => $loan[0]->email,
                'phone' => $loan[0]->phonenumber,
            ),
            'expiry' => array(
                'start_time' => $orderdate,
                'unit' => 'days',
                'duration' => 2
            ),
            'enabled_payments' => [
                "permata_va",
                "bca_va",
                "bni_va",
                "bri_va",
            ]
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        if(empty($loanpay->snap_token)){
            $loanpay->snap_token = $snapToken;
            $loanpay->save();
        }
        $idpayloan = $loanpay->id;

        $snap_token = DB::select(
            DB::raw("SELECT snap_token from drivedealio.loan_payments where id = $loanpay->id")
        )[0]->snap_token;

        return view('auction.loanpayment', compact('loan', 'snap_token' , 'idloan'));
    }

    public function downPaymentPaid($id)
    {
        $downpayment = LoanPayment::where('loans_id', $id)->firstOrFail();
        $downpayment->paymentdatetime = Carbon::now();
        $downpayment->status = "Paid";
        $downpayment->save();

        $auctionOrderId = Loan::where('id', $id)->value('auction_orders_id');

        if ($auctionOrderId) {
            $order = AuctionOrder::find($auctionOrderId);
            if ($order) {
                $order->paymentdate = Carbon::now();
                $order->paymentstatus = "Paid";
                $order->status = "Waiting for Confirmation";
                $order->save();
            } else {
                return redirect('/orderhistory')->with('error', 'Auction Order not found');
            }
        } else {
            return redirect('/orderhistory')->with('error', 'Auction Order ID not found');
        }
        return redirect('/orderhistory')->with('success', 'Payment Success');
    }

    public function myLoan($id)
    {
        $iduser = auth()->id();
        $loan = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.transmission, ' ', v.colour, ', ', v.year) as vehiclename,
            ao.invoicenum, l.loantenor, l.monthlypayment
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.auction_orders as ao on v.id = ao.vehicles_id
            INNER JOIN drivedealio.loans as l on ao.id = l.auction_orders_id
            WHERE l.id = $id;")
        );

        $payableloan = DB::select(
            DB::raw("SELECT lp.id as idloanpay, lp.total_bill, lp.paymentcount, lp.status, lp.invoicenum, l.loantenor, lp.created_at, lp.type
            FROM drivedealio.loan_payments as lp INNER JOIN drivedealio.loans as l on lp.loans_id = l.id
            WHERE lp.type = 'Monthly Payment' AND l.users_id = $iduser AND lp.status = 'Unpaid';")
        );

        $paidloan = DB::select(
            DB::raw("SELECT lp.id as idloanpay, lp.total_bill, lp.paymentcount, lp.status, lp.invoicenum, l.loantenor, lp.type, lp.created_at, lp.paymentdatetime
            FROM drivedealio.loan_payments as lp INNER JOIN drivedealio.loans as l on lp.loans_id = l.id
            WHERE lp.type = 'Monthly Payment' AND l.users_id = $iduser AND lp.status = 'Paid';")
        );

        return view('auction.myloan', compact('loan', 'payableloan', 'paidloan'));
    }

    public function monthlyPayment($id)
    {
        $iduser = auth()->id();
        $payableloan = DB::select(
            DB::raw("SELECT lp.id as idloanpay, lp.total_bill, lp.paymentcount, lp.status, lp.invoicenum, l.loantenor, lp.created_at, lp.type,
            u.firstname, u.lastname, u.email, u.phonenumber, lp.snap_token
            FROM drivedealio.loan_payments as lp INNER JOIN drivedealio.loans as l on lp.loans_id = l.id
            INNER JOIN drivedealio.users as u on l.users_id = u.id
            WHERE lp.type = 'Monthly Payment' AND l.users_id = $iduser AND lp.status = 'Unpaid' AND lp.id = $id;")
        );
        \Midtrans\Config::$serverKey = 'SB-Mid-server-AOdoK40xyUyq11-i9Cc9ysHM';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $payableloan[0]->invoicenum,
                'gross_amount' => $payableloan[0]->total_bill,
            ),
            'customer_details' => array(
                'first_name' => $payableloan[0]->firstname,
                'last_name' => $payableloan[0]->lastname,
                'email' => $payableloan[0]->email,
                'phone' => $payableloan[0]->phonenumber,
            ),
            'enabled_payments' => [
                "permata_va",
                "bca_va",
                "bni_va",
                "bri_va",
            ]
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        if(empty($payableloan[0]->snap_token)){
            $loanpay = LoanPayment::findOrFail($id);
            $loanpay->snap_token = $snapToken;
            $loanpay->save();
        }

        $snap_token = DB::select(
            DB::raw("SELECT snap_token from drivedealio.loan_payments where id = $id")
        )[0]->snap_token;

        return view('auction.monthlypayment', compact('snap_token', 'payableloan'));
    }

    public function monthlyPaymentPaid($id)
    {
        $downpayment = LoanPayment::findOrFail($id);
        $downpayment->paymentdatetime = Carbon::now();
        $downpayment->status = "Paid";
        $downpayment->save();

        return redirect('/orderhistory')->with('success', 'Payment Success');
    }

    public function orderDetails(Request $request)
    {
        $id = ($request->get('id'));
        $data = AuctionOrder::find($id);
        $order = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate, b.name,
            ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder, a.current_price, ao.status,
            (SELECT COALESCE(i.url, 'placeholder_url') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url,
            ad.name as addressname, ad.address, ad.province, ad.city, ad.district, ad.village, ad.zipcode
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id
            INNER JOIN drivedealio.auction_orders as ao on aw.id = ao.auctionwinners_id
            INNER JOIN drivedealio.users as u on aw.users_id = u.id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            INNER JOIN drivedealio.addresses as ad on ao.addresses_id = ad.id
            WHERE ao.id = $id;")
        );

        $towing = DB::select(
            DB::raw("SELECT tp.name, tw.price, tw.trans_number
            FROM drivedealio.transporters as tp INNER JOIN drivedealio.towings as tw on tp.id = tw.transporters_id
            INNER JOIN drivedealio.auction_orders as ao on tw.id = ao.towings_id
            WHERE ao.id = $id;")
        );
        $status = DB::select(
            DB::raw("SELECT ts.status, ts.created_at
            FROM drivedealio.auction_orders as ao INNER JOIN drivedealio.towings as t on ao.towings_id = t.id
            INNER JOIN drivedealio.towing_statuses as ts on t.id = ts.towings_id
            WHERE ao.id = $id ORDER BY ts.created_at asc;")
        );

        return response()->json(array(
            'msg'=> view('auction.orderdetails',compact('data', 'order', 'towing', 'status'))->render()
        ),200);
    }

    public function invoice($id)
    {
        $order = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate,
            ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder, a.current_price, ao.paymentmethod
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id
            INNER JOIN drivedealio.auction_orders as ao on aw.id = ao.auctionwinners_id
            INNER JOIN drivedealio.users as u on aw.users_id = u.id
            WHERE ao.id = $id;")
        );

        $towing = DB::select(
            DB::raw("SELECT tp.name, tw.price, tw.trans_number
            FROM drivedealio.transporters as tp INNER JOIN drivedealio.towings as tw on tp.id = tw.transporters_id
            INNER JOIN drivedealio.auction_orders as ao on tw.id = ao.towings_id
            WHERE ao.id = $id;")
        );

        return view('auction.invoice', compact('order', 'towing'));
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
