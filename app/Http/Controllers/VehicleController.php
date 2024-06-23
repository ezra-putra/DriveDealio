<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Vehicle;
use App\Models\Auction;
use App\Models\AuctionOrder;
use App\Models\AuctionWinner;
use App\Models\Bid;
use App\Models\Brand;
use App\Models\City;
use App\Models\District;
use App\Models\Inspection;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
use App\Notifications\AuctionWinner as NotificationsAuctionWinner;
use App\Notifications\Inspector;
use App\Notifications\Vehicle as NotificationsVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class VehicleController extends Controller
{

    public function car(Request $request)
    {
        $query = DB::table('auctions as a')
                ->select('a.start_price as price', 'v.id as idvehicle', 'v.model', 'v.variant', 'vt.name as type', 'c.name', 'b.name as brand', 'a.lot_number', 'v.adstatus',
                        DB::raw('(SELECT COALESCE(i.url, \'placeholder_url\') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url'), 'a.start_date', 'a.end_date', 'a.id as idauction')
                ->join('vehicles as v', 'a.vehicles_id', '=', 'v.id')
                ->join('vehicletypes as vt', 'vt.id', '=', 'v.vehicletypes_id')
                ->join('vehiclecategories as c', 'c.id', '=', 'vt.vehiclecategories_id')
                ->join('brands as b', 'v.brands_id', '=', 'b.id')
                ->where('c.name', 'Car')
                ->where('v.adstatus', 'Open to Bid');

        $selectedType = $request->query('type');
        $selectedBrand = $request->query('brand');

        if(!empty($selectedType)){
            $query->whereIn('v.vehicletypes_id', explode(',',$selectedType));
        }

        if(!empty($selectedBrand)){
            $query->whereIn('v.brands_id', explode(',',$selectedBrand));
        }

        $vehicle = $query->get();

        $type = DB::table('vehicletypes')->where('vehiclecategories_id', 1)->get();
        $brand = Brand::all();

        foreach ($vehicle as $v) {
            $startDateTime = Carbon::parse($v->start_date);
            $endDateTime = Carbon::parse($v->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $v->duration = $this->formatDuration($interval);
        }

        return view('vehicle.vehicleindex', compact('vehicle', 'type', 'brand', 'selectedType', 'selectedBrand'));
    }

    public function motorcycle(Request $request)
    {
        $query = DB::table('auctions as a')
                ->select('a.start_price as price', 'v.id as idvehicle', 'v.model', 'v.variant', 'vt.name as type', 'c.name', 'b.name as brand', 'a.lot_number', 'v.adstatus',
                        DB::raw('(SELECT COALESCE(i.url, \'placeholder_url\') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url'), 'a.start_date', 'a.end_date', 'a.id as idauction')
                ->join('vehicles as v', 'a.vehicles_id', '=', 'v.id')
                ->join('vehicletypes as vt', 'vt.id', '=', 'v.vehicletypes_id')
                ->join('vehiclecategories as c', 'c.id', '=', 'vt.vehiclecategories_id')
                ->join('brands as b', 'v.brands_id', '=', 'b.id')
                ->where('c.name', 'Motorcycle')
                ->where('v.adstatus', 'Open to Bid');


        $selectedType = $request->query('type');
        $selectedBrand = $request->query('brand');

        if(!empty($selectedType)){
            $query->whereIn('v.vehicletypes_id', explode(',',$selectedType));
        }

        if(!empty($selectedBrand)){
            $query->whereIn('v.brands_id', explode(',',$selectedBrand));
        }

        $vehicle = $query->get();

        $type = DB::table('vehicletypes')->where('vehiclecategories_id', 2)->get();
        $brand = Brand::all();

        foreach ($vehicle as $v) {
            $startDateTime = Carbon::parse($v->start_date);
            $endDateTime = Carbon::parse($v->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $v->duration = $this->formatDuration($interval);
        }

        return view('vehicle.vehicleindex', compact('vehicle', 'type', 'brand', 'selectedType', 'selectedBrand'));
    }


    public function myvehicle()
    {
        $iduser = auth()->id();

        if (auth()->user()->roles_id === 1) {
            $vehicle = DB::select(
                DB::raw("SELECT v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber, v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname
                FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
                INNER JOIN drivedealio.users as u on v.users_id = u.id order by v.inputdate desc ;")
            );
            return view('/admin/listvehicle', compact('vehicle'));
        }
        if(auth()->user()->roles_id === 3){
            $vehicle = DB::select(
                DB::raw("SELECT v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber,
                v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname, v.appointments_id, a.id as idappointment, a.status, v.address, v.city, v.province, u.phonenumber
                FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
                INNER JOIN drivedealio.users as u on v.users_id = u.id
                LEFT JOIN drivedealio.appointments as a on v.appointments_id = a.id
                where v.adstatus IN ('Waiting for Approval','Inspection', 'Grading', 'Inspected') order by v.inputdate desc;")
            );
            return view('/inspector/listvehicle', compact('vehicle'));
        }else{
            $vehicle = DB::select(
                DB::raw("SELECT v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber, v.adstatus, v.inputdate, b.name as brand, u.id as iduser, a.id as idauction, a.start_date, a.end_date,
                (SELECT i.url FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url
                FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
                INNER JOIN drivedealio.users as u on v.users_id = u.id LEFT JOIN drivedealio.auctions as a on v.id = a.vehicles_id
                where u.id = $iduser order by v.inputdate desc;")
            );
            if(!empty($vehicle))
            {
                $startDateTime = Carbon::parse($vehicle[0]->start_date);
                $endDateTime = Carbon::parse($vehicle[0]->end_date);
                $interval = $startDateTime->diff($endDateTime);
                $vehicle[0]->duration = $this->formatDuration($interval);
            }

            $order = DB::select(
                DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate, v.transmission,
                ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder, ao.paymentstatus, ao.status, v.id as idvehicle, b.name as brand
                FROM drivedealio.vehicles as v INNER JOIN drivedealio.auctions as a on v.id = a.vehicles_id
                INNER JOIN drivedealio.auctionwinners as aw on a.id = aw.auctions_id
                INNER JOIN drivedealio.auction_orders as ao on aw.id = ao.auctionwinners_id
                INNER JOIN drivedealio.users as u on aw.users_id = u.id
                INNER JOIN drivedealio.brands as b on v.brands_id = b.id
                WHERE v.users_id = $iduser;")
            );

            return view('/vehicle/myvehicle', compact('vehicle', 'order'));
        }
    }

    public function show($id)
    {
        $vehicle = DB::select(
            DB::raw("SELECT i.url as image, v.id as idvehicle, v.model, v.enginecapacity, v. enginecylinders, v.fueltype, v.transmission, vt.id as idtype, vt.name as type, v.platenumber, i.url, v.adstatus,
            b.id as idbrand, b.name as brand, a.id as idauction, a.start_price as price, a.current_price, a.lot_number as lotnumber, u.id as iduser, u.firstname as fname, u.lastname as lname,
            v.variant, a.start_date, a.end_date, v.users_id, v.seatsnumber, v.chassis_number, v.engine_number, v.colour, v.year
            FROM drivedealio.vehicles as v LEFT JOIN drivedealio.images as i on v.id = i.vehicles_id
            LEFT JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.users as u on v.users_id = u.id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            INNER JOIN drivedealio.vehicletypes as vt on v.vehicletypes_id = vt.id
            where v.id = $id;")
        );

        $winner = DB::select(
            DB::raw("SELECT b.*, a.id as idauction, a.current_price, u.id as iduser from drivedealio.bids as b INNER JOIN drivedealio.auctions as a on b.auctions_id = a.id
            INNER JOIN drivedealio.user_memberships as um on b.user_memberships_id = um.id
            INNER JOIN drivedealio.users as u on um.users_id = u.id
            WHERE a.vehicles_id = $id ORDER BY b.biddatetime desc limit 3;")
        );

        // dd($winner);

        $query = DB::table('auctions as a')
                ->select('a.start_price as price', 'v.id as idvehicle', 'v.model', 'v.variant', 'vt.name as type', 'c.name', 'b.name as brand', 'a.lot_number', 'v.adstatus', 'v.transmission',
                        DB::raw('(SELECT COALESCE(i.url, \'placeholder_url\') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url'), 'a.start_date', 'a.end_date', 'a.id as idauction')
                ->join('vehicles as v', 'a.vehicles_id', '=', 'v.id')
                ->join('vehicletypes as vt', 'vt.id', '=', 'v.vehicletypes_id')
                ->join('vehiclecategories as c', 'c.id', '=', 'vt.vehiclecategories_id')
                ->join('brands as b', 'v.brands_id', '=', 'b.id')
                ->where('v.adstatus', 'Open to Bid')->whereNot( 'v.id', $id);

        $vehiclerec = $query->get();
        foreach($vehiclerec as $v)
        {
            $startDateTime = Carbon::parse($v->start_date);
            $endDateTime = Carbon::parse($v->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $v->duration = $this->formatDuration($interval);
        }

        $vehiclename = $vehicle[0]->brand. '-'. $vehicle[0]->model. ' '. $vehicle[0]->variant;

        $startDateTime = Carbon::parse($vehicle[0]->start_date);
        $endDateTime = Carbon::parse($vehicle[0]->end_date);
        $interval = $startDateTime->diff($endDateTime);
        $vehicle[0]->duration = $this->formatDuration($interval);

        $now = Carbon::now();

        if ($now >= $endDateTime)
        {
            if (!empty($winner) && isset($winner[0]))
            {
                $auctionStatus = 'Auction Ended';
                foreach ($winner as $key => $w) {
                    $existingWinner = AuctionWinner::where('auctions_id', $w->idauction)
                        ->where('users_id', $w->iduser)
                        ->exists();

                    if (!$existingWinner) {
                        $auctionWinner = new AuctionWinner();
                        $auctionWinner->windate = $endDateTime;
                        $auctionWinner->auctions_id = $w->idauction;
                        $auctionWinner->users_id = $w->iduser;
                        $auctionWinner->is_checkout = false;

                        $user = User::find($w->iduser);
                        $title = 'Auction Information';
                        $message = 'You win the auction '. $vehiclename .', please continue the process. Go to Auction Page!';
                        $user->notify(new NotificationsAuctionWinner($title, $message));

                        if ($key === 0) {
                            $auctionWinner->is_winner = true;
                        }else{
                            $auctionWinner->is_winner = false;
                        }
                        $auctionWinner->save();

                    }
                }
            } else {
                $auctionStatus = 'Setup Auction';
            }
            DB::table('drivedealio.vehicles')
            ->where('id', $id)
            ->update(['adstatus' => $auctionStatus]);
        }

        $iduser = auth()->id();
        $bid = Bid::select('bids.*')
        ->join('auctions', 'bids.auctions_id', '=', 'auctions.id')
        ->where('auctions.vehicles_id', $id)
        ->orderBy('bids.biddatetime', 'desc')
        ->take(5)
        ->get();
        if(!empty($iduser))
        {
            $mybid = Bid::select('bids.*')
            ->join('auctions', 'bids.auctions_id', '=', 'auctions.id')
            ->join('user_memberships', 'bids.user_memberships_id', '=', 'user_memberships.id')
            ->where('auctions.vehicles_id', $id)
            ->where('user_memberships.users_id', $iduser)
            ->orderByDesc('bids.bidamount')
            ->take(5)
            ->get();
        }
        else
        {
            $mybid = [];
        }

        $inspection = DB::select(
            DB::raw("SELECT exterior, interior, engine, mechanism, inputdate
            from drivedealio.inspections where vehicles_id = $id;")
        );


        // dd($decryptBidAmount);
        return view('vehicle.vehicledetails', compact('vehicle', 'bid', 'winner', 'inspection', 'mybid', 'vehiclerec'));
    }

    public function toFormAddVehicle()
    {
        $iduser = auth()->id();
        $vehicleUpload = DB::select(
            DB::raw("SELECT count(id) as vehicle_upload from drivedealio.vehicles where users_id = $iduser;")
        );

        $brand = DB::select(
            DB::raw('SELECT id, name from drivedealio.brands;')
        );

        $date = DB::select(
            DB::raw('SELECT id, appointmentdate, appointmenttime from drivedealio.appointments;')
        );
        $cat = DB::select(
            DB::raw("SELECT id, name from drivedealio.vehiclecategories")
        );

        return view('vehicle.addvehicledata', compact('brand', 'date', 'cat'));

    }
    public function type(Request $request)
    {
        $cat_id = $request->vehiclecategories_id;
        $type = DB::select(
            DB::raw("SELECT id, name, vehiclecategories_id from drivedealio.vehicletypes where vehiclecategories_id = $cat_id;")
        );

        foreach($type as $t)
        {
            echo "<option value='$t->id'>$t->name</option>";
        }
    }

    public function create()
    {
        return view('vehicle.addvehicledata');
    }

    public function store(Request $request)
    {
        $vehicle = new Vehicle;
        $vehicle->model = $request->input('model');
        $vehicle->platenumber = $request->input('plate');
        $vehicle->fueltype = $request->input('fuel');
        $vehicle->transmission = $request->input('trans');
        $vehicle->enginecapacity = $request->input('capacity');
        $vehicle->enginecylinders = $request->input('engcylinder');
        $vehicle->variant = $request->input('variant');
        $vehicle->seatsnumber = $request->input('seats');
        $vehicle->users_id = auth()->id();
        $vehicle->brands_id = $request->input('brand');
        $vehicle->vehicletypes_id = $request->input('type');
        $vehicle->year = $request->input('year');
        $vehicle->colour = $request->input('color');
        $vehicle->adstatus = $request->input('action') === 'submit' ? 'Pending' : 'Draft';
        $vehicle->inputdate = now();
        $vehicle->save();

        if ($request->hasFile('stnk')) {
            $file = $request->file('stnk');
            $fileName = "STNK"."-$vehicle->id". "." .$file->getClientOriginalExtension();
            $file->move(public_path("uploads/vehicle/$vehicle->id"), $fileName);

            DB::update("UPDATE drivedealio.vehicles SET stnk = :stnk where id = :id",
            ['stnk'=> $fileName, 'id'=>$vehicle->id]);
        }
        if ($request->hasFile('bpkb')){
            $file = $request->file('bpkb');
            $fileName = "BPKB"."-$vehicle->id". "." .$file->getClientOriginalExtension();
            $file->move(public_path("uploads/vehicle/$vehicle->id"), $fileName);

            DB::update("UPDATE drivedealio.vehicles SET bpkb = :bpkb where id = :id",
            ['bpkb'=> $fileName, 'id'=>$vehicle->id]);
        }
        if ($request->hasFile('invoice')){
            $file = $request->file('invoice');
            $fileName = "INV"."-$vehicle->id". "." .$file->getClientOriginalExtension();
            $file->move(public_path("uploads/vehicle/$vehicle->id"), $fileName);

            DB::update("UPDATE drivedealio.vehicles SET invoice = :invoice where id = :id",
            ['invoice'=> $fileName, 'id'=>$vehicle->id]);
        }

        $date = DB::select(
            DB::raw("SELECT count(inputdate) from drivedealio.vehicles where DATE(inputdate) = CURRENT_DATE;")
        );

        $data = [];
        $counter = $date[0]->count + 1;
        if ($request->hasFile('image')) {
            $data = [];
            $counter = $date[0]->count + 1;
            foreach($request->file('image') as $image) {
                $name = $vehicle->inputdate->format('ymd'). "-$counter". "$vehicle->id" ."." .$image->getClientOriginalExtension();
                $image->move(public_path("images/vehicle/$vehicle->id"), $name);
                $data[] = [
                    'url' => $name,
                    'vehicles_id' => $vehicle->id,
                ];
                $counter++;
            }
            DB::table('drivedealio.images')->insert($data);
        }
        if ($request->input('action') === 'submit') {
            return redirect('/vehicle/inspectionappointment/' . $vehicle->id)
                ->with('success', 'Vehicle Data Saved!');
        } else {
            return redirect('/vehicle/myvehicle')
                ->with('success', 'Vehicle data saved as draft!');
        }
    }

    public function editVehicle($id)
    {
        $iduser = auth()->id();
        $vehicle = DB::select(
            DB::raw("SELECT * FROM drivedealio.vehicles where id = $id AND users_id = $iduser;")
        );

        return view('vehicle.updatevehicledata', compact('vehicle'));
    }

    public function updateDataVehicle(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->model = $request->input('model');
        $vehicle->platenumber = $request->input('plate');
        $vehicle->fueltype = $request->input('fuel');
        $vehicle->transmission = $request->input('trans');
        $vehicle->enginecapacity = $request->input('capacity');
        $vehicle->enginecylinders = $request->input('engcylinder');
        $vehicle->variant = $request->input('variant');
        $vehicle->seatsnumber = $request->input('seats');
        $vehicle->users_id = auth()->id();
        $vehicle->brands_id = $request->input('brand');
        $vehicle->vehicletypes_id = $request->input('type');
        $vehicle->year = $request->input('year');
        $vehicle->colour = $request->input('color');
        $vehicle->adstatus = "Pending";
        $vehicle->inputdate = now();
        $vehicle->save();

        if ($request->hasFile('stnk')) {
            $file = $request->file('stnk');
            $fileName = "STNK"."-$vehicle->id". "." .$file->getClientOriginalExtension();
            $file->move(public_path("uploads/vehicle/$vehicle->id"), $fileName);

            DB::update("UPDATE drivedealio.vehicles SET stnk = :stnk where id = :id",
            ['stnk'=> $fileName, 'id'=>$vehicle->id]);
        }
        if ($request->hasFile('bpkb')){
            $file = $request->file('bpkb');
            $fileName = "BPKB"."-$vehicle->id". "." .$file->getClientOriginalExtension();
            $file->move(public_path("uploads/vehicle/$vehicle->id"), $fileName);

            DB::update("UPDATE drivedealio.vehicles SET bpkb = :bpkb where id = :id",
            ['bpkb'=> $fileName, 'id'=>$vehicle->id]);
        }
        if ($request->hasFile('invoice')){
            $file = $request->file('invoice');
            $fileName = "INV"."-$vehicle->id". "." .$file->getClientOriginalExtension();
            $file->move(public_path("uploads/vehicle/$vehicle->id"), $fileName);

            DB::update("UPDATE drivedealio.vehicles SET invoice = :invoice where id = :id",
            ['invoice'=> $fileName, 'id'=>$vehicle->id]);
        }

        $date = DB::select(
            DB::raw("SELECT count(inputdate) from drivedealio.vehicles where DATE(inputdate) = CURRENT_DATE;")
        );

        $data = [];
        $counter = $date[0]->count + 1;
        foreach($request->file('image') as $image)
        {
            $name = $vehicle->inputdate->format('ymd'). "-$counter". "$vehicle->id" . "." .$image->getClientOriginalExtension();
            $image->move(public_path("images/vehicle/$vehicle->id"), $name);
            $data[] = [
                'url' => $name,
                'vehicles_id' => $vehicle->id,
            ];

            $counter++;
        }
        DB::table('drivedealio.images')->insert($data);

        return redirect('/vehicle/inspectionappointment/'. $vehicle->id)->with('success', 'Vehicle Data Saved!');
    }

    public function appointment($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle = DB::select(
            DB::raw("select id as idvehicle from drivedealio.vehicles where id = $id")
        );
        $appointment = DB::select(
            DB::raw("select a.id as idappointment, a.appointmentdate, a.appointmenttime, a.status, a.inspectors_id, u.id as idinspector, CONCAT(u.firstname, '', u.lastname) as name
            from drivedealio.appointments as a INNER JOIN drivedealio.users as u on a.inspectors_id = u.id where a.status = 'Available';")
        );

        $provinces = Province::all();
        $cities = City::all();

        return view('vehicle.inspectappointment', compact('appointment', 'vehicle' , 'provinces', 'cities'));
    }

    public function appointmentDate(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = "Waiting for Approval";
        $vehicle->appointments_id = $request->input('inspectiondate');
        $vehicle->address = $request->input('address');
        $vehicle->province = Province::find($request->input('province'))->province_name;
        $vehicle->city = City::find($request->input('city'))->city_name;
        $vehicle->odometer = $request->input('odo');
        $vehicle->save();

        $appointment = Appointment::select('appointments.id as idappointment', 'vehicles.id as idvehicle', 'appointments.inspectors_id')
        ->join('vehicles', 'appointments.id', '=', 'vehicles.appointments_id')
        ->where('vehicles.id', $id)
        ->get();

        $idappointment = $appointment[0]->idappointment;
        $appointment = Appointment::find($idappointment);
        $appointment->status = 'Booked';
        $appointment->save();

        $idinspector = $appointment->inspectors_id;
        $inspector = User::find($idinspector);
        $title = 'Inspection Information';
        $message ='New Inpsection Request from User!';
        $inspector->notify(new Inspector($title, $message));

        return redirect('/vehicle/myvehicle')->with('success', 'Your request has been processed!');
    }

    public function acceptAppointment($id)
    {
        $appointment = Appointment::find($id);
        $appointment->status = 'Accepted';
        $appointment->save();

        return redirect('/admin/listvehicle')->with('success', 'Your request has been processed!');
    }

    public function inspec($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle = DB::select(
            DB::raw("SELECT v.id as idvehicle, v.model, v.variant, v.fueltype, v.enginecapacity, v.enginecylinders,
            v.fueltype, v.transmission, v.platenumber, b.name as brand, v.colour, v.year
            from drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            where v.id = $id")
        );
        $appointment = DB::select(
            DB::raw("SELECT a.id as idappointment, a.appointmentdate, a.appointmenttime, a.status, a.inspectors_id, u.id as idinspector, CONCAT(u.firstname, '', u.lastname) as name, v.id as idvehicle, v.appointments_id
            from drivedealio.appointments as a INNER JOIN drivedealio.users as u on a.inspectors_id = u.id
            INNER JOIN drivedealio.vehicles as v on a.id = v.appointments_id
            where a.id = v.appointments_id and v.id = $id;")
        );
        return view('inspector.inspections', compact('vehicle', 'appointment'));
    }

    public function inspections(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = 'Setup Auction';
        $vehicle->chassis_number = $request->input('chassis');
        $vehicle->engine_number = $request->input('engine-num');
        $vehicle->save();

        $inspection = new Inspection;
        $inspection->exterior = $request->input('ext');
        $inspection->interior = $request->input('int');
        $inspection->mechanism = $request->input('mech');
        $inspection->engine = $request->input('engine');
        $inspection->inputdate = Carbon::now();
        $inspection->vehicles_id = $id;
        $inspection->appointments_id = $request->input('dates');
        $recprice = preg_replace('/[^\d]/', '', $request->input('recprice'));
        $inspection->recprice = (int)$recprice;
        $inspection->save();

        $ownerVehicle = Vehicle::select('users_id as iduser', 'model')
        ->where('id', $id)
        ->first();

        $iduser = $ownerVehicle->iduser;
        $vehicleName = $ownerVehicle->model;

        $user = User::find($iduser);
        $title = 'Inspection Finish';
        $message = 'Inspection finish for '. $vehicleName .', check the result in MyVehicle Page !';
        $user->notify(new NotificationsVehicle($title, $message));


        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!');
    }


    public function auctionSetupBtn($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle = DB::select(
            DB::raw("SELECT id as idvehicle from drivedealio.vehicles where id = $id;")
        );
        $inspection = DB::select(
            DB::raw("SELECT i.exterior, i.interior, i.mechanism, i.engine, i.inputdate, i.recprice, CONCAT(a.appointmentdate, '-', a.appointmenttime) as inspectiondatetime
            from drivedealio.inspections as i INNER JOIN drivedealio.appointments as a on i.appointments_id = a.id
            where i.vehicles_id = $id;")
        );
        return view('vehicle.auctionsetup', compact('vehicle', 'inspection'));
    }

    public function auctionSetup(Request $request, $id)
    {
        $date = DB::select(
            DB::raw("SELECT count(inputdate) from drivedealio.vehicles where DATE(inputdate) = CURRENT_DATE;")
        );

        $counter = $date[0]->count + 1;
        $lotNumber = 'DDA-' .date('dmy'). $counter;

        $auction = new Auction;
        $start_price = preg_replace('/[^\d]/', '', $request->input('price'));
        $auction->start_price = (int)$start_price;
        $auction->vehicles_id = $id;
        $auction->lot_number = $lotNumber;
        $auction->start_date = $request->input('startdate');
        $auction->end_date = $request->input('enddate');
        $auction->save();

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = "Open to Bid";
        $vehicle->adreleasedate = Carbon::now();
        $vehicle->save();

        return redirect('/vehicle/myvehicle')->with('status', 'Your request has been processed!');
    }

    public function orderDetails(Request $request)
    {
        $id = ($request->get('id'));
        $data = AuctionOrder::find($id);
        $order = DB::select(
            DB::raw("SELECT CONCAT(v.model, ' ', v.variant, ' ', v.colour, ', ', v.year) as vehiclename, a.lot_number, aw.id as idwinner, ao.orderdate, b.name,
            ao.invoicenum, ao.total_price, u.firstname, u.lastname, u.email, u.phonenumber, ao.id as idorder, a.current_price, ao.status, v.id as idvehicle,
            (SELECT COALESCE(i.url, 'placeholder_url') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url,
            ad.name as addressname, ad.address, ad.province, ad.city
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
