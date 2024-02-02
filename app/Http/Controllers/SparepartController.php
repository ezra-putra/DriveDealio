<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SparepartController extends Controller
{

    public function index()
    {
        $sparepart = DB::select(
            DB::raw("SELECT sh.id as idshop, sh.name, sh.city, s.id as idsparepart, s.partnumber, s.partname, s.unitprice, s.stock, s.description,
            s.vehiclemodel, s.buildyear, s.colour, s.condition, s.shops_id, s.weight,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = s.id LIMIT 1) as url
                FROM drivedealio.spareparts as s
                INNER JOIN drivedealio.shops as sh on s.shops_id = sh.id
                WHERE s.stock > 0;")
        );
        return view('sparepart.sparepartindex', compact('sparepart'));
    }

    public function show($id)
    {
        $sparepart = DB::select(
            DB::raw("SELECT p.url, sh.id as idshop, sh.name, sh.city, sh.province, s.id as idsparepart, s.partnumber, s.partname, s.unitprice, s.stock, s.description,
            s.vehiclemodel as model, s.buildyear, s.colour, s.condition, s.shops_id, s.brand, s.weight
            FROM drivedealio.spareparts as s LEFT JOIN drivedealio.pics as p on s.id = p.spareparts_id
            INNER JOIN drivedealio.shops as sh on s.shops_id = sh.id where s.id = $id;")
        );
        return view('sparepart.details', compact('sparepart'));
    }


    public function sparepartCategories()
    {

        return view('seller.addsparepart', compact('cat'));
    }

    public function addSparepart(Request $request)
    {
        $iduser = auth()->id();
        $id = DB::select(
            DB::raw("SELECT s.id AS idshop FROM drivedealio.shops AS s
            INNER JOIN drivedealio.users AS u ON s.users_id = u.id WHERE s.users_id = $iduser;")
        )[0]->idshop;

        $sparepart = new Sparepart();
        $sparepart->partnumber = $request->input('partnum');
        $sparepart->unitprice = $request->input('price');
        $sparepart->stock = $request->input('stock');
        $sparepart->description = $request->input('desc');
        $sparepart->partname = $request->input('partname');
        $sparepart->vehiclemodel = $request->input('model');
        $sparepart->buildyear = $request->input('year');
        $sparepart->colour = $request->input('colour');
        $sparepart->condition = $request->input('condition');
        $sparepart->brand = $request->input('brand');
        $sparepart->sparepartcategories_id = $request->input('categories');
        $sparepart->weight = $request->input('weight');
        $sparepart->shops_id = $id;
        $sparepart->save();

        $date = DB::select(
            DB::raw("SELECT count(created_at) from drivedealio.spareparts where DATE(created_at) = CURRENT_DATE;")
        );

        $data = [];
        $counter = $date[0]->count + 1;
        foreach($request->file('image') as $image)
        {
            $name = $sparepart->created_at->format('ymd'). "-$counter". ".". $image->getClientOriginalExtension();
            $image->move(public_path('images'), $name);
            $data[] = [
                'url' => $name,
                'spareparts_id' => $sparepart->id,
            ];

            $counter++;
        }
        DB::table('drivedealio.pics')->insert($data);

        return redirect('/seller/listsparepart');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();

        return redirect('/seller/listsparepart');
    }

    public function wishlistIndex()
    {
        $iduser = auth()->id();
        $wishlist = DB::select(
            DB::raw("SELECT s.id as idseller, s.name, sp.id as idsparepart, sp.partnumber, sp.partname,
            sp.vehiclemodel as model, sp.unitprice, sp.stock, w.id as idwishlist, w.users_id, w.spareparts_id, u.id as iduser,
            (SELECT p.url FROM drivedealio.pics as p WHERE p.spareparts_id = sp.id LIMIT 1) as url
            FROM drivedealio.shops as s INNER JOIN drivedealio.spareparts as sp on s.id = sp.shops_id
            INNER JOIN drivedealio.wishlists as w on sp.id = w.spareparts_id
            INNER JOIN drivedealio.users as u on u.id = w.users_id WHERE w.users_id = $iduser;")
        );

        return view('sparepart.wishlist', compact('wishlist'));
    }

    public function addToWishlist($id)
    {
        $iduser = auth()->id();
        DB::insert("INSERT INTO drivedealio.wishlists(users_id, spareparts_id) VALUES(:users_id, :spareparts_id)",
        ['users_id' => $iduser, 'spareparts_id' => $id]);
        return redirect()->back()->with(['success' => 'Added to Wishlist']);
    }

    public function removeWishlist($id)
    {
        DB::delete("DELETE FROM drivedealio.wishlists WHERE id = :id",
        ['id' => $id]);
        return redirect()->back()->with(['error' => 'Removed from Wishlist']);
    }
}
