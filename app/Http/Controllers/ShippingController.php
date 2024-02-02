<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Models\Towing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{

    public function towingList()
    {
        $cat = DB::select(
            DB::raw("SELECT id, name from drivedealio.vehiclecategories;")
        );

        $towing = DB::select(
            DB::raw("SELECT t.name as packagename, t.origin, t.destination, t.price, t.eta, c.name
            from drivedealio.towings as t INNER JOIN drivedealio.vehiclecategories as c on t.vehiclecategories_id = c.id;")
        );

        return view('admin.listtowing', compact('cat', 'towing'));
    }

    public function createTowPackage(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $api_key = "U3iyOQmVBs4QcsdEdUvELHllqlXt7pbrL36Wo8aSfWA5AIVWswwPGNbSl4SVerHC";
        $url = "https://api.distancematrix.ai/maps/api/distancematrix/json?origins=". urlencode($origin) . "&destinations=" . urlencode($destination) . "&key=" . $api_key;
        //$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($origin) . "&destinations=" . urlencode($destination) . "&key=" . $api_key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        if ($data['status'] == 'OK')
        {
            $distance = $data['rows'][0]['elements'][0]['distance']['text'];
            //$distance = $data['rows'][0]['elements'][0]['distance']['value'];
            $tow = new Towing;
            $tow->name = $request->input('name');
            $tow->description = $request->input('desc');
            $tow->eta = $request->input('eta');
            $tow->origin = $origin;
            $tow->destination = $destination;
            $tow->distance = $distance;
            $tow->vehiclecategories_id = $request->input('categories');
            if($tow->vehiclecategories_id == 1)
            {
                if($tow->name == 'Carrier')
                {
                    $tow->price = (int)$distance * 4500;
                }
                if($tow->name == 'Towing')
                {
                    $tow->price = (int)$distance * 7000;
                }
                if($tow->name == 'Self Drive')
                {
                    $tow->price = (int)$distance * 3000;
                }

            }
            if($tow->vehiclecategories_id == 2)
            {
                if($tow->name == 'Bike')
                {
                    $tow->price = (int)$distance * 2000;
                }
                if($tow->name == 'Sport Bike')
                {
                    $tow->price = (int)$distance * 3000;
                }
                if($tow->name == 'Big Bike')
                {
                    $tow->price = (int)$distance * 4500;
                }
            }


            $tow->save();
            //dd($tow);
        }
        // dd($url);
        return redirect()->back()->with('success', 'Towings Package Added');
    }
}
