<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Vehicle;
use App\Models\Auction;
use App\Models\AuctionWinner;
use App\Models\Brand;
use App\Models\District;
use App\Models\Inspection;
use App\Models\Inspections;
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

class VehicleController extends Controller
{

    public function car()
    {
        $vehicle = DB::select(
            DB::raw("SELECT a.start_price as price, v.id as idvehicle, v.model, v.variant, vt.name as type, c.name, b.name as brand, a.lot_number, v.adstatus,
            (SELECT COALESCE(i.url, 'placeholder_url') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url, a.start_date, a.end_date, a.id as idauction
            from drivedealio.auctions as a INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            INNER JOIN drivedealio.vehicletypes as vt on vt.id = v.vehicletypes_id
            INNER JOIN drivedealio.vehiclecategories as c on c.id = vt.vehiclecategories_id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            WHERE c.name = 'Car' AND v.adstatus = 'Open to Bid';")
        );
        $type = DB::select(
            DB::raw("SELECT * FROM drivedealio.vehicletypes where vehiclecategories_id = 1;")
        );

        $brand = Brand::all();

        if(!empty($vehicle))
        {
            $startDateTime = Carbon::parse($vehicle[0]->start_date);
            $endDateTime = Carbon::parse($vehicle[0]->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $vehicle[0]->duration = $this->formatDuration($interval);
        }
        return view('vehicle.vehicleindex', compact('vehicle', 'type', 'brand'));
    }


    public function motorcycle()
    {
        $vehicle = DB::select(
            DB::raw("SELECT a.start_price as price, v.id as idvehicle, v.model, v.variant, vt.name as type, c.name, b.name as brand, a.lot_number, v.adstatus,
            (SELECT COALESCE(i.url, 'placeholder_url') FROM drivedealio.images as i WHERE i.vehicles_id = v.id LIMIT 1) as url, a.start_date, a.end_date, a.id as idauction
            from drivedealio.auctions as a INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            INNER JOIN drivedealio.vehicletypes as vt on vt.id = v.vehicletypes_id
            INNER JOIN drivedealio.vehiclecategories as c on c.id = vt.vehiclecategories_id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            WHERE c.name = 'Motorcycle' AND v.adstatus = 'Open to Bid';")
        );
        $type = DB::select(
            DB::raw("SELECT * FROM drivedealio.vehicletypes where vehiclecategories_id = 2;")
        );
        $brand = Brand::all();

        if(!empty($vehicle))
        {
            $startDateTime = Carbon::parse($vehicle[0]->start_date);
            $endDateTime = Carbon::parse($vehicle[0]->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $vehicle[0]->duration = $this->formatDuration($interval);
        }
        return view('vehicle.vehicleindex', compact('vehicle', 'type', 'brand'));
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
                v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname, v.appointments_id, a.id as idappointment, a.status, v.address, v.village, v.district, v.regency, v.province, u.phonenumber
                FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
                INNER JOIN drivedealio.users as u on v.users_id = u.id
                LEFT JOIN drivedealio.appointments as a on v.appointments_id = a.id
                where v.adstatus IN ('Inspection', 'Grading', 'Inspected') order by v.inputdate desc;")
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

        $bid = DB::select(
            DB::raw("SELECT u.id as iduser, um.id as idusermember, b.id as idbid, a.id as idauction, v.id as idvehicle,
            CONCAT(u.firstname, ' ', u.lastname) as name, b.bidamount, b.biddatetime
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on b.auctions_id = a.id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            WHERE v.id = $id ORDER BY b.bidamount DESC LIMIT 5;")
        );

        $iduser = auth()->id();

        if(!empty($iduser))
        {
            $mybid = DB::select(
                DB::raw("SELECT u.id as iduser, um.id as idusermember, b.id as idbid, a.id as idauction, v.id as idvehicle,
                CONCAT(u.firstname, ' ', u.lastname) as name, b.bidamount, b.biddatetime
                FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
                INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
                INNER JOIN drivedealio.auctions as a on b.auctions_id = a.id
                INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
                WHERE v.id = $id AND um.users_id = $iduser ORDER BY b.bidamount DESC LIMIT 5;")
            );
        }
        else
        {
            $mybid = [];
        }

        $winner = DB::select(
            DB::raw("SELECT b.*, a.id as idauction, a.current_price, u.id as iduser from drivedealio.bids as b INNER JOIN drivedealio.auctions as a on b.auctions_id = a.id
            INNER JOIN drivedealio.user_memberships as um on b.user_memberships_id = um.id
            INNER JOIN drivedealio.users as u on um.users_id = u.id
            WHERE a.vehicles_id = $id ORDER BY b.bidamount desc limit 1;")
        );

        $inspection = DB::select(
            DB::raw("SELECT exterior, interior, engine, mechanism, inputdate
            from drivedealio.inspections where vehicles_id = $id;")
        );

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
                foreach ($winner as $w) {
                    $existingWinner = AuctionWinner::where('auctions_id', $w->idauction)
                        ->where('users_id', $w->iduser)
                        ->exists();

                    if (!$existingWinner) {
                        $auctionWinner = new AuctionWinner();
                        $auctionWinner->windate = $endDateTime;
                        $auctionWinner->auctions_id = $w->idauction;
                        $auctionWinner->users_id = $w->iduser;

                        $user = User::find($w->iduser);
                        $title = 'Auction Information';
                        $message = 'You win the auction, please continue the process. Go to Auction Page!';
                        $user->notify(new NotificationsAuctionWinner($title, $message));

                        if ($w->bidamount === $w->current_price) {
                            $auctionWinner->is_winner = true;
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
        return view('vehicle.vehicledetails', compact('vehicle', 'bid', 'winner', 'inspection', 'mybid'));
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
            $name = $vehicle->inputdate->format('ymd'). "-$counter". "." .$image->getClientOriginalExtension();
            $image->move(public_path("images/vehicle/$vehicle->id"), $name);
            $data[] = [
                'url' => $name,
                'vehicles_id' => $vehicle->id,
            ];

            $counter++;
        }
        DB::table('drivedealio.images')->insert($data);

        return redirect('/vehicle/inspectionappointment/'. $vehicle->id)->with('status', 'Vehicle Data Saved!');
    }

    public function approve($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = 'Inspection';
        $vehicle->verificationdate = now();
        $vehicle->save();

        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!')->with('approvedVehicleId', $vehicle->id);
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
        $regencies = Regency::all();
        $districts = District::all();
        $villages = Village::all();

        return view('vehicle.inspectappointment', compact('appointment', 'vehicle' , 'provinces', 'regencies', 'districts', 'villages'));
    }

    public function appointmentDate(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = "Waiting for Approval";
        $vehicle->appointments_id = $request->input('inspectiondate');
        $vehicle->address = $request->input('address');
        $vehicle->province = Province::find($request->input('province'))->name;
        $vehicle->regency = Regency::find($request->input('regency'))->name;
        $vehicle->district = District::find($request->input('district'))->name;
        $vehicle->village = Village::find($request->input('village'))->name;
        $vehicle->odometer = $request->input('odo');
        // dd($vehicle);
        $vehicle->save();

        $appointment = Appointment::select('appointments.id as idappointment', 'vehicles.id as idvehicle', 'appointments.inspectors_id')
        ->join('vehicles', 'appointments.id', '=', 'vehicles.appointments_id')
        ->where('vehicles.id', $id)
        ->get();

        $idappointment = $appointment->idappointment;
        $appointment = Appointment::find($idappointment);
        $appointment->status = 'Booked';
        // dd($appointment);
        $appointment->save();

        $idinspector = $appointment->inspectors_id;
        $inspector = User::find($idinspector);
        $title = 'Inspection Information';
        $message ='New Inpsection Request from User!';
        $inspector->notify(new Inspector($title, $message));

        return redirect('/vehicle/myvehicle')->with('status', 'Your request has been processed!');
    }

    public function acceptAppointment($id)
    {
        $appointment = Appointment::find($id);
        $appointment->status = 'Accepted';
        $appointment->save();

        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!');
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
        $vehicle->adstatus = 'Inspected';
        $vehicle->chassis_number = $request->input('chassis');
        $vehicle->engine_number = $request->input('engine');
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
        // dd($inspection);
        $inspection->save();

        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!');
    }

    public function finishGrading($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = 'Setup Auction';
        $vehicle->save();

        $ownerVehicle = Vehicle::select('users_id as iduser')
        ->where('id', $id)
        ->first();

        $iduser = $ownerVehicle->iduser;

        $user = User::find($iduser);
        $title = 'Inspection Finish';
        $message = 'Inspection finish, check the result in MyVehicle Page!';
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
        // dd($auction);
        $auction->save();

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->adstatus = "Open to Bid";
        $vehicle->adreleasedate = Carbon::now();
        $vehicle->save();

        return redirect('/vehicle/myvehicle')->with('status', 'Your request has been processed!');
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

    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
