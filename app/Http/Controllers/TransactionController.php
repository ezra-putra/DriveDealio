<?php

namespace App\Http\Controllers;

use App\Models\AuctionOrder;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Review;
use App\Models\Seller;
use App\Models\Shipping;
use App\Models\ShippingStatus;
use App\Models\User;
use App\Models\Village;
use App\Notifications\Seller as SellerNotifications;
use App\Notifications\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function cartIndex()
    {
        $iduser = auth()->id();
        $cartItems = DB::select(
            DB::raw("SELECT sp.id as idsparepart, sp.partnumber, sp.partname, sp.vehiclemodel, sp.stock, sp.unitprice, c.quantity, (sp.stock - c.quantity) as temp_stock, (sp.unitprice * c.quantity) as total_price, c.spareparts_id, c.users_id,
            u.id as iduser, u.firstname, s.id as idseller, s.name as sellername, c.id as idcart,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.spareparts as sp INNER JOIN drivedealio.carts as c on sp.id = c.spareparts_id
            INNER JOIN drivedealio.users as u on c.users_id = u.id
            INNER JOIN drivedealio.shops as s on sp.shops_id = s.id WHERE u.id =  $iduser;")
        );

        return view('transaction.cart', compact('cartItems'));
    }

    public function addNewCart(Request $request, $id)
    {
        $iduser = auth()->id();
        $cartItem = DB::select("SELECT * FROM drivedealio.carts
            WHERE users_id = :users_id AND spareparts_id = :spareparts_id", ['users_id' => $iduser, 'spareparts_id' =>$id]);

        if ($cartItem)
        {
            DB::update("UPDATE drivedealio.carts SET quantity = quantity + :quantity
                WHERE users_id = :users_id AND spareparts_id = :spareparts_id",
                ['users_id' => $iduser, 'spareparts_id' =>$id, 'quantity' => $request->input('quantity')]);
            return redirect()->back()->with('success', 'Product quantity updated successfully.');
        } else {
            DB::insert("INSERT INTO drivedealio.carts (users_id, spareparts_id, quantity)
                VALUES (:users_id, :spareparts_id, :quantity)",
                ['users_id' => $iduser, 'spareparts_id' =>$id, 'quantity' => $request->input('quantity')]);
            return redirect()->back()->with('success', 'Product added to cart successfully.');
        }
    }


    // Transaksi Sparepart START
    public function addToCart($id)
    {
        $iduser = auth()->id();

        $cartItem = DB::table('drivedealio.carts')
        ->where('users_id', $iduser)
        ->where('spareparts_id', $id)
        ->first();

        if ($cartItem) {

            DB::table('drivedealio.carts')
                ->where('users_id', $iduser)
                ->where('spareparts_id', $id)
                ->update(['quantity' => DB::raw('quantity + 1')]);
        } else {

            DB::table('drivedealio.carts')->insert([
                'users_id' => $iduser,
                'spareparts_id' => $id,
                'quantity' => 1,
            ]);
        }
            // Redirect
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function incrementProductQuantity($id)
    {
        $iduser = auth()->id();
        DB::update("UPDATE drivedealio.carts SET quantity = quantity + 1
        WHERE users_id = :users_id  AND spareparts_id = :spareparts_id", ['users_id' => $iduser, 'spareparts_id' =>$id]);
        return redirect()->back()->with('success', 'Product quantity updated successfully.');
    }

    public function decrementProductQuantity($id)
    {
        $iduser = auth()->id();
        DB::update("UPDATE drivedealio.carts SET quantity = quantity - 1
        WHERE users_id = :users_id  AND spareparts_id = :spareparts_id", ['users_id' => $iduser, 'spareparts_id' =>$id]);

        $affectedRows = DB::table('carts')
            ->where('users_id', $iduser)
            ->where('spareparts_id', $id)
            ->where('quantity', '=', 0)
            ->delete();

        if ($affectedRows > 0) {
            return redirect()->back()->with('success', 'Product removed from the cart.');
        } else {
            return redirect()->back()->with('success', 'Product quantity updated successfully.');
        }
    }


    public function deletefromCart($idcart)
    {
        DB::delete("DELETE FROM drivedealio.carts WHERE id = :id", ['id' => $idcart]);

        return redirect()->back()->with('error', 'Item Deleted from Cart');
    }

    public function checkout()
    {
        $iduser = auth()->id();
        $checkout = DB::select(
            DB::raw("SELECT sp.id as idsparepart, sp.partnumber, sp.partname, sp.vehiclemodel, sp.stock, sp.unitprice, c.quantity, (sp.stock - c.quantity) as temp_stock, (sp.unitprice * c.quantity) as total_price, c.spareparts_id, c.users_id, sp.weight,
            u.id as iduser, u.firstname, s.id as idseller, s.name as sellername, s.city as sellercity, s.district, s.province,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.spareparts as sp INNER JOIN drivedealio.carts as c on sp.id = c.spareparts_id
            INNER JOIN drivedealio.users as u on c.users_id = u.id
            INNER JOIN drivedealio.shops as s on sp.shops_id = s.id WHERE u.id =  $iduser;")
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

        $shipping = DB::select(
            DB::raw("SELECT id, details, packagename as name from drivedealio.shipments;")
        );

        if (empty($address)) {
            return redirect('/profile')->with('error', 'Add Your Address First!');
        }


        $origin = $checkout[0]->district. ", " .$checkout[0]->sellercity. ", ". $checkout[0]->province;
        $destination = $address[0]->district. ", " .$address[0]->city. ", " .$address[0]->province;

        $api_key = "U3iyOQmVBs4QcsdEdUvELHllqlXt7pbrL36Wo8aSfWA5AIVWswwPGNbSl4SVerHC";
        $url = "https://api.distancematrix.ai/maps/api/distancematrix/json?origins=". urlencode($origin) . "&destinations=" . urlencode($destination) . "&key=" . $api_key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        $weight = 0;
        foreach($checkout as $c)
        {
            $weight += $c->weight * $c->quantity;
        }

        if ($data['status'] == 'OK')
        {
            $distance = $data['rows'][0]['elements'][0]['distance']['text'];

            $distanceValue = (float)preg_replace('/[^0-9.]/', '', $distance);

        }
        return view('transaction.checkout', compact('checkout', 'userinfo', 'address', 'profile', 'provinces', 'regencies', 'districts', 'villages', 'shipping', 'weight', 'distanceValue'));
    }


    public function createOrderSparepart(Request $request)
    {
        $iduser = auth()->id();
        $checkout = DB::select(
            DB::raw("SELECT sp.id as idsparepart, sp.partnumber, sp.partname, sp.vehiclemodel, sp.stock, sp.unitprice, c.id as idcart, c.quantity, (sp.stock - c.quantity) as temp_stock, (sp.unitprice * c.quantity) as total_price, c.spareparts_id, c.users_id,
            u.id as iduser, u.firstname, s.id as idseller, s.name as sellername, s.city as sellercity, s.district, s.province, s.users_id as owner
            FROM drivedealio.spareparts as sp INNER JOIN drivedealio.carts as c on sp.id = c.spareparts_id
            INNER JOIN drivedealio.users as u on c.users_id = u.id
            INNER JOIN drivedealio.shops as s on sp.shops_id = s.id WHERE u.id = $iduser; ")
        );
        $date = DB::select(
            DB::raw("SELECT count(orderdate) from drivedealio.orders where DATE(orderdate) = CURRENT_DATE;")
        );
        $address = DB::select(
            DB::raw("SELECT u.id as iduser, a.id as idaddress, a.name, a.address, a.district, a.city, a.zipcode, a.province, a.village
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser;")
        );

        $addresses = DB::select(
            DB::raw("SELECT u.id as iduser, a.id as idaddress, a.name, a.address, a.district, a.city, a.zipcode, a.province, a.village
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser AND a.is_primaryadd = true;")
        );
        $sellerId = $checkout[0]->owner;
        //dd($sellerId);
        $shopaddress = DB::select(
            DB::raw("SELECT s.city as sellercity, s.district, s.province, s.id as idseller, s.users_id
            FROM drivedealio.shops as s INNER JOIN drivedealio.spareparts as sp on s.id = sp.shops_id
            WHERE s.users_id = $sellerId;")
        );

        if(!empty($address))
        {
            $origin = $shopaddress[0]->district. ", " .$shopaddress[0]->sellercity. ", ". $shopaddress[0]->province;
            $destination = $addresses[0]->district. ", " .$addresses[0]->city. ", " .$addresses[0]->province;

            $idseller = $shopaddress[0]->idseller;
            $idshopOwner = $shopaddress[0]->users_id;
            // dd($idseller);
            $order = new Order;
            $counter = $date[0]->count + 1;
            $order->invoicenum = "INV/SP/" .date("Y/m/d"). "/$counter";
            $order->status = "Waiting for Payment";
            $order->paymentstatus = "Unpaid";
            $order->users_id = $iduser;
            $order->shops_id = $idseller;
            $order->addresses_id = $addresses[0]->idaddress;
            // dd($shipping);
            $order->save();

            $shipping = new Shipping;
            $shipping->shipping_fee = $request->input('ongkirfee');
            $shipping->total_weight = $request->input('weight');
            $shipping->origin = $origin;
            $shipping->destination = $destination;
            $shipping->shipments_id = $request->input('shipId');
            // dd($shipping);
            $shipping->save();


            foreach($checkout as $c)
            {
                $subTotal = $c->unitprice * $c->quantity;

                DB::insert("INSERT INTO drivedealio.orderdetails(orders_id, spareparts_id, quantityordered, unitprice, created_at, updated_at)
                    VALUES(:orders_id, :spareparts_id, :quantityordered, :unitprice, :created_at, :updated_at)",
                    ['orders_id' => $order->id, 'spareparts_id' => $c->idsparepart, 'quantityordered' => $c->quantity, 'unitprice' => $subTotal, 'created_at' => now(), 'updated_at' => now()]);

                DB::delete("DELETE FROM drivedealio.carts WHERE id = :id", ['id' => $c->idcart]);
            }

            $order = Order::findOrFail($order->id);
            $order->total_price = $request->input('totalPrice');
            $order->shippings_id = $shipping->id;
            $order->save();

            $user = User::find($iduser);
            $title = 'Sparepart Transaction';
            $message = 'Order Has been Created for '.$order->invoicenum. '!';
            $user->notify(new Transaction($title, $message));

            //dd($idshopOwner);

            $seller = User::find($idshopOwner);
            $title = 'Order Information';
            $message = 'New Order Has Been Made. Invoice Number ' .$order->invoicenum. '!';
            $seller->notify(new SellerNotifications($title, $message));

            return redirect('/payment/'. $order->id)->with('success', 'Order Create');
        }
        else{
            return redirect()->back()->with('error', 'Add Your Address First');
        }
    }

    public function transactionList(Request $request)
    {
        $iduser = auth()->id();
        $order = Order::select('orders.id as idorder', 'users.id as iduser', 'orders.invoicenum', 'orders.orderdate', 'orders.shops_id', 'orders.users_id', 'orders.status', 'orders.paymentstatus', 'shops.name', 'orders.total_price', 'shops.id as idshop')
            ->join('users', 'orders.users_id', '=', 'users.id')
            ->join('shops', 'orders.shops_id', '=', 'shops.id')
            ->where('users.id', $iduser)
            ->orderBy('orders.orderdate', 'desc')
            ->get();

        $auctionorder = AuctionOrder::select(
                    DB::raw("CONCAT(vehicles.model, ' ', vehicles.variant, ' ', vehicles.transmission, ' ', vehicles.colour, ', ', vehicles.year) as vehiclename"),
                    'auctions.lot_number', 'auctionwinners.id as idwinner', 'auction_orders.orderdate',
                    'auction_orders.invoicenum', 'auction_orders.total_price', 'users.firstname', 'users.lastname',
                    'users.email', 'users.phonenumber', 'auction_orders.id as idorder', 'auction_orders.status',
                    'vehicles.id as idvehicle', 'auctions.current_price', 'auction_orders.paymentmethod', 'loans.status as loanstatus',
                    DB::raw("(SELECT COALESCE(images.url, 'placeholder_url') FROM images WHERE images.vehicles_id = vehicles.id LIMIT 1) as url"),
                    'brands.name as brand', 'auction_orders.paymentstatus', 'loans.id as idloan')
                ->join('auctionwinners', 'auction_orders.auctionwinners_id', '=', 'auctionwinners.id')
                ->join('auctions', 'auctionwinners.auctions_id', '=', 'auctions.id')
                ->join('users', 'auctionwinners.users_id', '=', 'users.id')
                ->join('vehicles', 'auctions.vehicles_id', '=', 'vehicles.id')
                ->join('brands', 'vehicles.brands_id', '=', 'brands.id')
                ->leftJoin('loans', 'auction_orders.id', '=', 'loans.auction_orders_id')
                ->where('users.id', $iduser)
                ->orderBy('auction_orders.orderdate', 'desc')
                ->get();

        $status = $request->query('btn-status');
        if($status)
        {
            if($status === 'Ongoing'){
                $order = $order->whereIn('status', ['On Process', 'On Delivery', 'Arrived', 'Waiting for Confirmation']);
                $auctionorder = $auctionorder->whereIn('status', ['On Process', 'On Delivery', 'Arrived', 'Waiting for Confirmation']);
            }
            else{
                $order = $order->where('status', $status);
                $auctionorder = $auctionorder->where('status', $status);
            }
        }

        return view('transaction.order', compact('order', 'auctionorder'));
    }

    public function transactionDetails(Request $request)
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

    public function invoice($id)
    {
        $order = DB::select(
            DB::raw("SELECT o.id as idorder, u.id as iduser, o.invoicenum, o.orderdate, o.shops_id, o.users_id, o.status, o.paymentstatus, s.name, o.total_price, s.id as idshop,
            a.name as addressname, a.address, a.province, a.city, a.district, a.village, a.zipcode, s.name as sellername, u.firstname, u.lastname, u.phonenumber
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.shops as s on o.shops_id = s.id
            LEFT JOIN drivedealio.addresses as a on a.id = o.addresses_id
            where o.id = $id AND o.addresses_id = a.id;")
        );

        $orderdetails = DB::select(
            DB::raw("SELECT od.quantityordered, od.unitprice, CONCAT(sp.partnumber, ' ', sp.partname, ' ', sp.vehiclemodel) as item_name,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.orders as o INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
			INNER JOIN drivedealio.spareparts as sp on od.spareparts_id = sp.id where o.id = $id;")
        );

        $shippings = DB::select(
            DB::raw("SELECT shp.packagename, sh.shipping_number, sh.shipping_fee
            FROM drivedealio.shipments as shp INNER JOIN drivedealio.shippings as sh on shp.id = sh.shipments_id
            INNER JOIN drivedealio.orders as o on sh.id = o.shippings_id where o.id = $id;")
        );

        return view('transaction.invoice', compact('order', 'orderdetails', 'shippings'));
    }

    public function paymentIndex($id)
    {
        $iduser = auth()->id();
        $product = DB::select(
            DB::raw("SELECT o.id as idorder, o.invoicenum, o.orderdate, u.id as iduser, o.status, o.paymentstatus, od.quantityordered, s.stock, s.id as idsparepart,
            total_price, u.email, u.firstname, u.lastname, u.phonenumber, o.invoicenum, od.unitprice,
            CONCAT(s.partnumber, '-', s.partname, ' ', s.vehiclemodel) as name
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
            INNER JOIN drivedealio.spareparts as s on od.spareparts_id = s.id
            WHERE o.users_id = $iduser AND o.id = $id;")
        );

        \Midtrans\Config::$serverKey = 'SB-Mid-server-AOdoK40xyUyq11-i9Cc9ysHM';
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $product[0]->invoicenum,
                'gross_amount' => $product[0]->total_price,
            ),
            'customer_details' => array(
                'first_name' => $product[0]->firstname,
                'last_name' => $product[0]->lastname,
                'email' => $product[0]->email,
                'phone' => $product[0]->phonenumber,
            ),
        );

        //dd($product[0]->snap_token);
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $order = Order::findOrFail($id);
        if(empty($order->snap_token)){
            $order->snap_token = $snapToken;
            $order->save();
        }
        $snap_token = DB::select(
            DB::raw("SELECT snap_token from drivedealio.orders where id = $id")
        )[0]->snap_token;

        return view('transaction.payment', compact('product', 'snap_token'));
    }

    public function paymentPaid($id)
    {
        $order = Order::findOrFail($id);
        $order->status = "Waiting for Confirmation";
        $order->paymentstatus = "Paid";
        $order->paymentdate = Carbon::now();
        $order->save();

        return redirect('/orderhistory')->with('success', 'Transaction Success');
    }

    public function paymentCancel($id)
    {
        $order = Order::findOrFail($id);
        $order->status = "Cancelled";
        $order->paymentstatus = "Unpaid";
        $order->save();

        return redirect('/orderhistory')->with('error', 'Transaction Cancelled');
    }

    public function approveOrder($id)
    {
        $payment = DB::select(
            DB::raw("SELECT o.paymentstatus from drivedealio.orders as o where o.id = $id")
        );
        if($payment[0]->paymentstatus === 'Paid')
        {
            $order = Order::findOrFail($id);
            $order->status = "On Process";
            $order->save();

            $product = DB::select(
                DB::raw("SELECT o.id as idorder, o.invoicenum, o.orderdate, u.id as iduser, o.status, o.paymentstatus, od.quantityordered, s.stock, s.id as idsparepart,
                (SELECT sum(od.unitprice) from drivedealio.orderdetails as od where od.orders_id = o.id ) as total_price
                from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
                INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
                INNER JOIN drivedealio.spareparts as s on od.spareparts_id = s.id
                WHERE o.id = $id;")
            );
            // dd($product);

            foreach($product as $p)
            {
                $quantityordered = $p->stock - $p->quantityordered;
                DB::update("UPDATE drivedealio.spareparts SET stock = :stock, updated_at = :updated_at WHERE id = :id",
                ['stock' => $quantityordered, 'updated_at' => now(), 'id' => $p->idsparepart]);
            }

            return redirect()->back()->with('success', 'Status Changed');
        }
        else{
            return redirect()->back()->with('error', 'The buyer has not made the payment.');
        }
    }

    public function onDelivery($id)
    {
        $shipping = DB::select(
            DB::raw("SELECT s.id as idshipping, o.orderdate  from drivedealio.orders as o
            INNER JOIN drivedealio.shippings as s on o.shippings_id = s.id where o.id = $id")
        );

        if (empty($shipping)) {
            return redirect()->back()->with('error', 'No delivery data found');
        }
        else
        {
            $idshipping = $shipping[0]->idshipping;
            $shipping = Shipping::findOrFail($idshipping);
            $shipping->shipping_number = "DDA".date("ymd").$idshipping;
            $shipping->save();

            $status = new ShippingStatus;
            $status->shippings_id = $idshipping;
            $status->status = "Request to Pickup";
            $status->save();

            $order = Order::findOrFail($id);
            $order->status = "On Delivery";
            $order->shippingdate = Carbon::now();
            $order->save();
            // dd($order);

            return redirect()->back()->with('success', 'Delivery Arranged');
        }
    }

    public function review($id)
    {
        $productToReview = DB::select(
            DB::raw("SELECT od.quantityordered, od.unitprice, CONCAT(sp.partnumber, ' ', sp.partname, ' ', sp.vehiclemodel) as item_name, sp.id as idsparepart, o.id as idorder,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.orders as o INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
			INNER JOIN drivedealio.spareparts as sp on od.spareparts_id = sp.id where o.id = $id AND o.status = 'Arrived';")
        );

        return view('transaction.review', compact('productToReview'));
    }

    public function addReview(Request $request, $id)
    {
        $productToReview = DB::select(
            DB::raw("SELECT od.quantityordered, od.unitprice, CONCAT(sp.partnumber, ' ', sp.partname, ' ', sp.vehiclemodel) as item_name, sp.id as idsparepart, o.id as idorder,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.orders as o INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
			INNER JOIN drivedealio.spareparts as sp on od.spareparts_id = sp.id where o.id = $id AND o.status = 'Arrived';")
        );
        $iduser = auth()->id();

        foreach($productToReview as $p)
        {
            $review = new Review;
            $review->rating = $request->input('rating_'.$p->idsparepart);
            $review->message = $request->input('comment_'.$p->idsparepart);
            $review->reviewdate = Carbon::now();
            $review->spareparts_id = $p->idsparepart;
            $review->users_id = $iduser;
            $review->orders_id = $p->idorder;
            $review->save();
            // dd($review);
        }

        $order = Order::findOrFail($id);
        $order->status = "Finished";
        $order->save();

        return redirect('/orderhistory')->with('success', 'Review Submited and Transaction Finished!');
    }

    public function finishAuctionOrder($id)
    {
        $order = AuctionOrder::findOrFail($id);
        $order->status = 'Finished';
        $order->save();

        return redirect()->back()->with('success', 'Order finish, see you on the next transaction!');
    }

    protected function formatDuration($interval)
    {
        $formattedDuration = '';

        // Tambahkan jam jika lebih dari 0
        if ($interval->h > 0) {
            $formattedDuration .= $interval->h . 'H ';
        }

        // Tambahkan menit jika lebih dari 0
        if ($interval->i > 0) {
            $formattedDuration .= $interval->i . 'M ';
        }

        // Tambahkan detik jika lebih dari 0
        if ($interval->s > 0) {
            $formattedDuration .= $interval->s . 'S';
        }

        return trim($formattedDuration);
    }

    // Transaksi Sparepart END
}
