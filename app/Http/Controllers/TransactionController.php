<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function cartIndex()
    {
        $iduser = auth()->id();
        $cart = DB::select(
            DB::raw("SELECT sp.id as idsparepart, sp.partnumber, sp.partname, sp.vehiclemodel, sp.stock, sp.image, sp.unitprice, c.quantity, (sp.stock - c.quantity) as temp_stock, (sp.unitprice * c.quantity) as total_price, c.spareparts_id, c.users_id,
            u.id as iduser, u.firstname, s.id as idseller, s.name as sellername
            FROM drivedealio.spareparts as sp INNER JOIN drivedealio.carts as c on sp.id = c.spareparts_id
            INNER JOIN drivedealio.users as u on c.users_id = u.id
            INNER JOIN drivedealio.shops as s on sp.shops_id = s.id WHERE u.id =  $iduser;")
        );
        return view('transaction.cart', compact('cart'));
    }

    // Transaksi Sparepart START
    public function addToWishlist($id)
    {
        $iduser = auth()->id();
        DB::insert("INSERT INTO drivedealio.wishlist(users_id, spareparts_id) VALUES(:users_id, :spareparts_id)",
        ['users_id' => $iduser, 'spareparts_id' => $id]);
    }
    public function removeWishlist($id)
    {
        DB::delete("DELETE FROM drivedealio.wishlist WHERE spareparts_id = :spareparts_id",
        ['spareparts_id' => $id]);
    }

    public function calculateTotalPrice(Request $request)
    {
        $userId = auth()->id();

        // Mengambil harga dan kuantitas dari keranjang
        $cartData = DB::select(
            DB::raw("SELECT sp.unitprice as price, c.quantity
                FROM drivedealio.spareparts as sp
                INNER JOIN drivedealio.carts as c on sp.id = c.spareparts_id
                INNER JOIN drivedealio.users as u on c.users_id = u.id
                INNER JOIN drivedealio.shops as s on sp.shops_id = s.id WHERE u.id = $userId;")
        );

        // Memastikan data keranjang ditemukan
        if (empty($cartData)) {
            return view('sparepart.total_price')->with('totalPrice', 0); // Tampilkan total harga 0 jika keranjang kosong
        }

        $price = $cartData[0]->price ?? 0;
        $quantity = $cartData[0]->quantity ?? 0;

        // Mendapatkan diskon dari inputan user
        $userDiscount = $request->input('discount') ?? 0;

        // Mendapatkan diskon dari voucher yang tersedia (gantilah dengan logika yang sesuai)
        $voucherDiscount = 0.0;

        // Menghitung total diskon
        $discount = max($userDiscount, $voucherDiscount);

        // Menghitung subtotal dan total harga setelah diskon
        $subtotal = $price * $quantity;
        $totalPrice = max(0, $subtotal - $discount);

        // Menampilkan hasil di blade
        return view('transaction.cart', [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'totalPrice' => $totalPrice,
        ]);
    }

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

    public function removeFromCart($id)
    {

        $iduser = auth()->id();
        DB::update("UPDATE drivedealio.carts SET quantity = CASE WHEN quantity > 1 THEN quantity - 1 ELSE 0 END
        WHERE users_id = :users_id  AND spareparts_id = :spareparts_id", ['users_id' => $iduser, 'spareparts_id' =>$id]);


        return redirect()->back()->with('success', 'Product quantity updated successfully.');
    }

    public function checkout()
    {
        $iduser = auth()->id();
        $checkout = DB::select(
            DB::raw("SELECT sp.id as idsparepart, sp.partnumber, sp.partname, sp.vehiclemodel, sp.stock, sp.image, sp.unitprice, c.quantity, (sp.stock - c.quantity) as temp_stock, (sp.unitprice * c.quantity) as total_price, c.spareparts_id, c.users_id,
            u.id as iduser, u.firstname, s.id as idseller, s.name as sellername, u.address, u.city, u.province, u.zipcode, u.district
            FROM drivedealio.spareparts as sp INNER JOIN drivedealio.carts as c on sp.id = c.spareparts_id
            INNER JOIN drivedealio.users as u on c.users_id = u.id
            INNER JOIN drivedealio.shops as s on sp.shops_id = s.id WHERE u.id =  $iduser;")
        );

        $userinfo = DB::select(
            DB::raw("SELECT id, firstname, lastname, phonenumber, address, district, city, zipcode from drivedealio.users where id = $iduser")
        )[0];
        return view('transaction.checkout', compact('checkout', 'userinfo'));
    }


    // Transaksi Sparepart END

    // Transaksi Lelang Start
    public function addToWatchlist(Request $request, $id)
    {

    }

    // Transaksi Lelang END
}
