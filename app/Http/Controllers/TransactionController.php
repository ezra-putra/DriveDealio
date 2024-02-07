<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
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
            DB::raw("SELECT sp.id as idsparepart, sp.partnumber, sp.partname, sp.vehiclemodel, sp.stock, sp.unitprice, c.quantity, (sp.stock - c.quantity) as temp_stock, (sp.unitprice * c.quantity) as total_price, c.spareparts_id, c.users_id,
            u.id as iduser, u.firstname, s.id as idseller, s.name as sellername, s.city as sellercity,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.spareparts as sp INNER JOIN drivedealio.carts as c on sp.id = c.spareparts_id
            INNER JOIN drivedealio.users as u on c.users_id = u.id
            INNER JOIN drivedealio.shops as s on sp.shops_id = s.id WHERE u.id =  $iduser ;")
        );

        $address = DB::select(
            DB::raw("SELECT id as idaddress, name, address, district,
            city, province, village, zipcode, is_primaryadd FROM drivedealio.addresses where users_id = $iduser order by is_primaryadd desc")
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


        return view('transaction.checkout', compact('checkout', 'userinfo', 'address', 'profile', 'provinces', 'regencies', 'districts', 'villages'));
    }

    public function createOrderSparepart(Request $request)
    {
        $iduser = auth()->id();
        $checkout = DB::select(
            DB::raw("SELECT sp.id as idsparepart, sp.partnumber, sp.partname, sp.vehiclemodel, sp.stock, sp.unitprice, c.id as idcart, c.quantity, (sp.stock - c.quantity) as temp_stock, (sp.unitprice * c.quantity) as total_price, c.spareparts_id, c.users_id,
            u.id as iduser, u.firstname, s.id as idseller, s.name as sellername, s.city as sellercity
            FROM drivedealio.spareparts as sp INNER JOIN drivedealio.carts as c on sp.id = c.spareparts_id
            INNER JOIN drivedealio.users as u on c.users_id = u.id
            INNER JOIN drivedealio.shops as s on sp.shops_id = s.id WHERE u.id = $iduser; ")
        );
        $date = DB::select(
            DB::raw("SELECT count(orderdate) from drivedealio.orders where DATE(orderdate) = CURRENT_DATE;")
        );
        $address = DB::select(
            DB::raw("SELECT u.id as iduser, a.id as idaddress, a.name, a.address, a.district, a.city, a.zipcode, a.province
            from drivedealio.users as u INNER JOIN drivedealio.addresses as a on u.id = a.users_id where u.id = $iduser;")
        );

        if(!empty($address))
        {
            $order = new Order;
            $counter = $date[0]->count + 1;
            $order->invoicenum = "INV/" .date("Y/m/d"). "/$counter";
            $order->status = "Waiting for Payment";
            $order->paymentstatus = "Unpaid";
            $order->users_id = $iduser;
            $order->shops_id = $checkout[0]->idseller;
            // dd($order);
            $order->save();
            $shipping = 20000;

            foreach($checkout as $c)
            {
                $subTotal = $c->unitprice * $c->quantity;

                DB::insert("INSERT INTO drivedealio.orderdetails(orders_id, spareparts_id, quantityordered, unitprice, created_at, updated_at)
                    VALUES(:orders_id, :spareparts_id, :quantityordered, :unitprice, :created_at, :updated_at)",
                    ['orders_id' => $order->id, 'spareparts_id' => $c->idsparepart, 'quantityordered' => $c->quantity, 'unitprice' => $subTotal, 'created_at' => now(), 'updated_at' => now()]);

                DB::delete("DELETE FROM drivedealio.carts WHERE id = :id", ['id' => $c->idcart]);
            }
            $total = DB::select(
                DB::raw("SELECT sum(unitprice) as price from drivedealio.orderdetails where orders_id = $order->id")
            );
            $totalprice = $total[0]->price + $shipping;

            DB::update("UPDATE drivedealio.orders SET total_price = :totalprice where id = :id",
            ['totalprice' => $totalprice, 'id' => $order->id]);

            return redirect('/payment/'. $order->id)->with('success', 'Order Create');
        }
        else{
            return redirect()->back()->with('error', 'Add Your Address First');
        }
    }

    public function transactionList()
    {
        $iduser = auth()->id();
        $order = DB::select(
            DB::raw("SELECT o.id as idorder, u.id as iduser, o.invoicenum, o.orderdate, o.shops_id, o.users_id, o.status, o.paymentstatus, s.name, o.total_price
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.shops as s on o.shops_id = s.id
            where u.id = $iduser order by o.orderdate desc;")
        );


        return view('transaction.order', compact('order'));
    }

    public function transactionDetails($id)
    {
        $iduser = auth()->id();
        $order = DB::select(
            DB::raw("SELECT o.id as idorder, u.id as iduser, o.invoicenum, o.orderdate, o.shops_id, o.users_id, o.status, o.paymentstatus, s.name, o.total_price, s.id as idshop
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.shops as s on o.shops_id = s.id
            where u.id = $iduser AND o.id = $id;")
        );
        $orderdetails = DB::select(
            DB::raw("SELECT od.quantityordered, od.unitprice, CONCAT(sp.partnumber, ' ', sp.partname, ' ', sp.vehiclemodel) as item_name
            FROM drivedealio.orders as o INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
			INNER JOIN drivedealio.spareparts as sp on od.spareparts_id = sp.id where o.users_id = $iduser AND o.id = $id;")
        );
        //dd($orderdetails);

        return view('transaction.orderdetails', compact('orderdetails' ,'order'));
    }

    public function paymentIndex($id)
    {
        $iduser = auth()->id();
        $product = DB::select(
            DB::raw("SELECT o.id as idorder, o.invoicenum, o.orderdate, u.id as iduser, o.status, o.paymentstatus, od.quantityordered, s.stock, s.id as idsparepart,
            total_price, u.email, u.firstname, u.lastname, u.phonenumber, o.invoicenum
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

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $order = Order::findOrFail($id);
        $order->snap_token = $snapToken;
        $order->save();

        return view('transaction.payment', compact('product', 'snapToken'));
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
        DB::table('drivedealio.orders')
        ->where('id', $id)
        ->update(['status' => 'Cancelled', 'paymentstatus' => 'Unpaid']);

        return redirect('/orderhistory')->with('error', 'Transaction Cancelled');
    }

    public function approveOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->status = "On Process";
        $order->save();

        $iduser = auth()->id();
        $product = DB::select(
            DB::raw("SELECT o.id as idorder, o.invoicenum, o.orderdate, u.id as iduser, o.status, o.paymentstatus, od.quantityordered, s.stock, s.id as idsparepart,
            (SELECT sum(od.unitprice) from drivedealio.orderdetails as od where od.orders_id = o.id ) as total_price
            from drivedealio.orders as o INNER JOIN drivedealio.users as u on o.users_id = u.id
            INNER JOIN drivedealio.orderdetails as od on o.id = od.orders_id
            INNER JOIN drivedealio.spareparts as s on od.spareparts_id = s.id
            WHERE o.users_id = $iduser AND o.id = $id;")
        );

        foreach($product as $p)
        {
            $quantityordered = $p->stock - $p->quantity;
            DB::update("UPDATE drivedealio.spareparts SET stock = :stock, updated_at = :updated_at WHERE id = :id",
            ['stock' => $quantityordered, 'updated_at' => now(), 'id' => $p->idsparepart]);
        }

        return redirect()->back()->with('success', 'Status Changed');
    }

    public function onDelivered($id)
    {

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
