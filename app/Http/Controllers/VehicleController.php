<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Vehicle;
use App\Models\Brand;
use App\Models\User;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VehicleController extends Controller
{
    public function car()
    {
        $vehicle = DB::select(
            DB::raw("SELECT a.start_price as price, i.url, v.id as idvehicle, v.model, v.variant, vt.name as type, c.name, b.name as brand, v.location
            from drivedealio.auctions as a INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            LEFT JOIN drivedealio.images as i on v.id = i.vehicles_id
            INNER JOIN drivedealio.vehicletypes as vt on vt.id = v.vehicletypes_id
            INNER JOIN drivedealio.vehiclecategories as c on c.id = vt.vehiclecategories_id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            WHERE c.name = 'Car' AND v.adstatus = 'Open to Bid';")
        );
        // dd($vehicle);
        return view('vehicle.vehicleindex', compact('vehicle'));
    }


    public function motorcycle()
    {
        $vehicle = DB::select(
            DB::raw("SELECT a.start_price as price, i.url, v.id as idvehicle, v.model, v.variant, vt.name as type, c.name, b.name as brand, v.location
            from drivedealio.auctions as a INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            LEFT JOIN drivedealio.images as i on v.id = i.vehicles_id
            INNER JOIN drivedealio.vehicletypes as vt on vt.id = v.vehicletypes_id
            INNER JOIN drivedealio.vehiclecategories as c on c.id = vt.vehiclecategories_id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            WHERE c.name = 'Motorcycle' AND v.adstatus = 'Open to Bid';")
        );
        // dd($vehicle);
        return view('vehicle.vehicleindex', compact('vehicle'));
    }

    public function myvehicle()
    {
        $iduser = auth()->id();

        if (auth()->user()->roles_id === 1) {
            $vehicle = DB::select(
                DB::raw("SELECT v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber, v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname
                FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
                INNER JOIN drivedealio.users as u on v.users_id = u.id order by v.inputdate asc ;")
            );
            return view('/admin/listvehicle', compact('vehicle'));
        }
        if(auth()->user()->roles_id === 3){
            $vehicle = DB::select(
                DB::raw("SELECT v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber,
                v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname, u.address, v.appointments_id, a.id as idappointment, a.status
                FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
                INNER JOIN drivedealio.users as u on v.users_id = u.id
                LEFT JOIN drivedealio.appointments as a on v.appointments_id = a.id
                where v.adstatus IN ('Inspection', 'Grading', 'Graded') order by v.inputdate asc;")
            );
            return view('/inspector/listvehicle', compact('vehicle'));
        }else{
            $vehicle = DB::select(
                DB::raw("SELECT v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber, v.adstatus, v.inputdate, b.name as brand, u.id as iduser, a.id as idauction, a.start_date, a.end_date
                FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
                INNER JOIN drivedealio.users as u on v.users_id = u.id LEFT JOIN drivedealio.auctions as a on v.id = a.vehicles_id
                where u.id = $iduser order by v.inputdate asc ;")
            );



            $startDateTime = Carbon::parse($vehicle[0]->start_date);
            $endDateTime = Carbon::parse($vehicle[0]->end_date);
            $interval = $startDateTime->diff($endDateTime);
            $vehicle[0]->duration = $this->formatDuration($interval);
            return view('/vehicle/myvehicle', compact('vehicle'));
        }
    }

    public function show($id)
    {
        $vehicle = DB::select(
            DB::raw("SELECT i.url as image, v.id as idvehicle, v.model, v.enginecapacity, v. enginecylinders, v.fueltype, v.transmission, vt.id as idtype, vt.name as type, v.platenumber,
            b.id as idbrand, b.name as brand, a.id as idauction, a.start_price as price, a.current_price, a.lot_number as lotnumber, v.location, u.id as iduser, u.firstname as fname, u.lastname as lname, v.variant, a.start_date, a.end_date, v.users_id
            FROM drivedealio.vehicles as v LEFT JOIN drivedealio.images as i on v.id = i.vehicles_id
            LEFT JOIN drivedealio.auctions as a on v.id = a.vehicles_id
            INNER JOIN drivedealio.users as u on v.users_id = u.id
            INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            INNER JOIN drivedealio.vehicletypes as vt on v.vehicletypes_id = vt.id where v.id = $id;")
        );

        $bid = DB::select(
            DB::raw("SELECT u.id as iduser, um.id as idusermember, b.id as idbid, a.id as idauction, v.id as idvehicle,
            CONCAT(u.firstname, ' ', u.lastname) as name, b.bidamount, TO_TIMESTAMP(b.date || ' ' || b.time, 'YYYY-MM-DD HH24:MI:SS') as  datetime
            FROM drivedealio.users as u INNER JOIN drivedealio.user_memberships as um on u.id = um.users_id
            INNER JOIN drivedealio.bids as b on um.id = b.user_memberships_id
            INNER JOIN drivedealio.auctions as a on b.auctions_id = a.id
            INNER JOIN drivedealio.vehicles as v on a.vehicles_id = v.id
            WHERE v.id = $id ORDER BY b.bidamount DESC LIMIT 5;")
        );

        $startDateTime = Carbon::parse($vehicle[0]->start_date);
        $endDateTime = Carbon::parse($vehicle[0]->end_date);
        $now = Carbon::now();

        if ($now >= $endDateTime) {

            DB::table('drivedealio.vehicles')
                ->where('id', $id)
                ->update(['adstatus' => 'Auction Ended']);
        }

        $interval = $startDateTime->diff($endDateTime);
        $vehicle[0]->duration = $this->formatDuration($interval);

        return view('vehicle.vehicledetails', compact('vehicle', 'bid'));
    }

    public function categorized()
    {
        $brand = DB::select(
            DB::raw('select id, name from drivedealio.brands;')
        );
        $type = DB::select(
            DB::raw('select id, name from drivedealio.vehicletypes; ')
        );
        $year = DB::select(
            DB::raw('select * from drivedealio.productionyears;')
        );
        $color = DB::select(
            DB::raw('select id, name from drivedealio.colours;')
        );
        $date = DB::select(
            DB::raw('select id, appointmentdate, appointmenttime from drivedealio.appointments;')
        );


        return view('vehicle.addvehicledata', compact('brand', 'type', 'year', 'color', 'date'));
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
        $vehicle->location = $request->input('loc');
        $vehicle->transmission = $request->input('trans');
        $vehicle->enginecapacity = $request->input('capacity');
        $vehicle->enginecylinders = $request->input('engcylinder');
        $vehicle->variant = $request->input('variant');
        $vehicle->users_id = auth()->id();

        //another table
        $vehicle->brands_id = $request->input('brand');
        $vehicle->vehicletypes_id = $request->input('type');
        $vehicle->productionyears_id = $request->input('year');
        $vehicle->colours_id = $request->input('color');

        $vehicle->adstatus = "Pending";

        $vehicle->inputdate = now();


        $vehicle->save();
        return view('/vehicle/myvehicle')->with('status', 'Vehicle Data Saved!');
    }

    public function uploadImage(Request $request)
    {

    }


    public function adminEdit($id)
    {
        $vhc = Vehicle::findOrFail($id);
        $brand = DB::select(
            DB::raw('select id, name from drivedealio.brands;')
        );
        $type = DB::select(
            DB::raw('select * from drivedealio.vehicletypes; ')
        );
        $year = DB::select(
            DB::raw('select * from drivedealio.productionyears;')
        );
        $color = DB::select(
            DB::raw('select id, name from drivedealio.colours;')
        );
        $date = DB::select(
            DB::raw('select id, appointmentdate, appointmenttime from drivedealio.appointments;')
        );
        $vehicle = DB::select(
            DB::raw("select id, model, enginecapacity, enginecylinders, fueltype, transmission, location, adstatus,
            vehicletypes_id, brands_id, colours_id, productionyears_id, platenumber, variant
            from drivedealio.vehicles where id = $id;")
        );


        return view('admin.detailsvehicle', compact('vehicle', 'vhc', 'brand', 'type', 'year', 'color', 'date'));
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

        return view('vehicle.inspectappointment', compact('appointment', 'vehicle'));
    }

    public function appointmentDate(Request $request, $id)
    {
        DB::update(
            'UPDATE drivedealio.vehicles SET adstatus = :adstatus, appointments_id = :appointments_id WHERE id = :id',
            ['adstatus' => 'Waiting for Approval', 'appointments_id' => $request->input('inspectiondate'), 'id' => $id]
        );
        $appointment = Appointments::find($id);
        DB::update("UPDATE drivedealio.appointments SET status = :status WHERE id = :id",
        ['status' => 'Booked', 'id' => $appointment->id]);
        return redirect('/vehicle/myvehicle')->with('status', 'Your request has been processed!');
    }

    public function acceptAppointment($id)
    {
        $appointment = Appointments::find($id);
        $appointment->status = 'Accepted';
        $appointment->save();

        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!');
    }

    public function inspections($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle = DB::select(
            DB::raw("select id as idvehicle from drivedealio.vehicles where id = $id")
        );
        return view('inspector.inspections', compact('vehicle'));
    }

    public function inspectionsUpdate(Request $request, $id)
    {
        DB::update(
            'UPDATE drivedealio.vehicles SET adstatus = :adstatus, chassis_number = :chassis_number,
            engine_number = :engine_number WHERE id = :id',
            ['adstatus' => 'Grading', 'chassis_number' => $request->input('chassis'), 'engine_number' => $request->input('engine'), 'id' => $id]
        );
        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!');
    }

    public function grading($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle = DB::select(
            DB::raw("select id as idvehicle from drivedealio.vehicles where id = $id")
        );

        $appointment = DB::select(
            DB::raw("SELECT a.id as idappointment, a.appointmentdate, a.appointmenttime, a.status, a.inspectors_id, u.id as idinspector, CONCAT(u.firstname, '', u.lastname) as name, v.id as idvehicle, v.appointments_id
            from drivedealio.appointments as a INNER JOIN drivedealio.users as u on a.inspectors_id = u.id
            INNER JOIN drivedealio.vehicles as v on a.id = v.appointments_id
            where a.id = v.appointments_id and v.id = $id;")
        );

        return view('inspector.grading', compact('vehicle', 'appointment'));
    }

    public function inspectionsGrade(Request $request, $id)
    {
        DB::update(
            'UPDATE drivedealio.vehicles SET adstatus = :adstatus WHERE id = :id', ['adstatus' => 'Graded', 'id' => $id]
        );
        DB::insert(
            'INSERT INTO drivedealio.inspections(exterior, interior, engine, mechanism, inputdate, vehicles_id, appointments_id)
            VALUES (:exterior, :interior, :engine, :mechanism, :inputdate, :vehicles_id, :appointments_id)',
            ['exterior' => $request->input('ext'), 'interior' => $request->input('int'),
            'engine' => $request->input('engine'), 'mechanism' => $request->input('mech'), 'inputdate' => 'now()',
            'vehicles_id' => $id, 'appointments_id' => $request->input('dates')]
        );

        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!');
    }

    public function finishGrading($id)
    {
        DB::update(
            'UPDATE drivedealio.vehicles SET adstatus = :adstatus WHERE id = :id', ['adstatus' => 'Setup Auction', 'id' => $id]
        );

        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!');
    }

    public function auctionSetupBtn($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle = DB::select(
            DB::raw("select id as idvehicle from drivedealio.vehicles where id = $id")
        );
        return view('vehicle.auctionsetup', compact('vehicle'));
    }

    public function auctionSetup(Request $request, $id)
    {
        $lotNumber = 'DDA-' . mt_rand(1000, 9999);
        while (Auction::where('lot_number', $lotNumber)->exists()){
            $lotNumber = 'DDA-' . mt_rand(1000, 9999);
        }
        DB::update(
            'UPDATE drivedealio.vehicles SET adstatus = :adstatus WHERE id = :id', ['adstatus' => 'Auction Request', 'id' => $id]
        );
        DB::insert(
            'INSERT INTO drivedealio.auctions(start_price, vehicles_id, lot_number, start_date, end_date)
            VALUES(:start_price, :vehicles_id, :lot_number, :start_date, :end_date)',
            ['start_price' => $request->input('price'), 'vehicles_id' => $id, 'lot_number' => $lotNumber,
            'start_date' => $request->input('startdate'), 'end_date' => $request->input('enddate')]
        );

        return redirect('/vehicle/myvehicle')->with('status', 'Your request has been processed!');
    }


    public function approveAuction($id)
    {
        DB::update(
            'UPDATE drivedealio.vehicles SET adstatus = :adstatus WHERE id = :id', ['adstatus' => 'Open to Bid', 'id' => $id]
        );
        return redirect('/admin/listvehicle')->with('status', 'Your request has been processed!');
    }

    public function auctionEndStatus($id)
    {
        $vehicle = Vehicle::find($id);

        if ($vehicle) {
            // Periksa apakah waktu lelang telah berakhir
            $now = Carbon::now();
            $endDate = Carbon::parse($vehicle->end_date);

            if ($now >= $endDate) {
                // Waktu lelang telah berakhir, ubah status
                $vehicle->adstatus = 'Auction Ended';
                $vehicle->save();

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Auction is still active']);
    }


    protected function formatDuration($interval)
    {
        $formattedDuration = '';

        // Tambahkan hari jika lebih dari 0
        if ($interval->days > 0) {
            $formattedDuration .= $interval->days . 'D ';
        }

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

    public function updateAdStatus(Request $request)
    {
        $auctionId = $request->input('auctionId');

        DB::table('auctions')
        ->where('id', $auctionId)
            ->update(['status' => 'Time Expired']);

        return response()->json(['message' => 'Ad status updated successfully']);
    }

    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
