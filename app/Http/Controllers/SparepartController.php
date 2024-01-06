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
            DB::raw("SELECT p.id as idpics, p.url, sh.id as idshop, sh.name, sh.city, s.id as idsparepart, s.partnumber, s.partname, s.unitprice, s.stock, s.description,
            s.vehiclemodel, s.buildyear, s.colour, s.condition, s.shops_id
            FROM drivedealio.spareparts as s LEFT JOIN drivedealio.pics as p on s.id = p.spareparts_id
            INNER JOIN drivedealio.shops as sh on s.shops_id = sh.id;")
        );
        return view('sparepart.sparepartindex', compact('sparepart'));
    }

    public function show($id)
    {
        $sparepart = DB::select(
            DB::raw("SELECT p.id as idpics, p.url, sh.id as idshop, sh.name, sh.city, s.id as idsparepart, s.partnumber, s.partname, s.unitprice, s.stock, s.description,
            s.vehiclemodel, s.buildyear, s.colour, s.condition, s.shops_id, s.brand
            FROM drivedealio.spareparts as s LEFT JOIN drivedealio.pics as p on s.id = p.spareparts_id
            INNER JOIN drivedealio.shops as sh on s.shops_id = sh.id;")
        );
        return view('sparepart.details', compact('sparepart'));
    }

    public function listSparepart()
    {
        $iduser = auth()->id();
        $sparepart = DB::select(
            DB::raw("SELECT id, partnumber, partname, unitprice, stock, description, vehiclemodel, buildyear, colour, condition, shops_id
            FROM drivedealio.spareparts WHERE shops_id = (select s.id as idshop from drivedealio.shops as s
            INNER JOIN drivedealio.users as u on s.users_id = u.id where s.users_id = $iduser);")
        );
        return view('seller.sparepartlist', compact('sparepart'));
    }

    public function sparepartCategories()
    {
        $cat = DB::select(
            DB::raw("SELECT * FROM drivedealio.sparepartcategories;")
        );

        return view('seller.addsparepart', compact('cat'));
    }

    public function addSparepart(Request $request)
    {
        $iduser = auth()->id();
        $id = DB::select(
            DB::raw("SELECT s.id AS idshop FROM drivedealio.shops AS s
            INNER JOIN drivedealio.users AS u ON s.users_id = u.id WHERE s.users_id = $iduser;")
        )[0]->idshop;

        DB::insert("INSERT INTO drivedealio.spareparts(partnumber, unitprice, stock, description, partname, vehiclemodel, buildyear, colour, condition, sparepartcategories_id, shops_id, brand)
        VALUES(:partnumber, :unitprice, :stock, :description, :partname, :vehiclemodel, :buildyear, :colour, :condition, :sparepartcategories_id, :shops_id, :brand)",
        ['partnumber' => $request->input('partnum'), 'unitprice' => $request->input('price'), 'stock' => $request->input('stock'),
        'description' => $request->input('desc'), 'partname' => $request->input('partname'), 'vehiclemodel' => $request->input('model'),
        'buildyear' => $request->input('year'), 'colour' => $request->input('colour'), 'condition' => $request->input('condition'),
        'sparepartcategories_id' => $request->input('categories'), 'shops_id' => $id, 'brand' => $request->input('brand')]);

        return redirect('/seller/listsparepart');
    }

    public function destroy($id)
    {
        $sparepart = Sparepart::findOrFail($id);
        $sparepart->delete();
        // DB::delete('DELETE FROM drivedealio.spareparts where id = :id', ['id' => $sparepart]);

        return redirect('/seller/listsparepart');
    }
}
