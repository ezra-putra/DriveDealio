<?php

namespace App\Http\Controllers;

use App\Models\Inspector;
use App\Models\Appointments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class InspectorController extends Controller
{
    public function dashboardIndex(){
        $iduser = auth()->id();
        $appointment = DB::select(
            DB::raw("SELECT a.id as idappointment, a.appointmentdate, a.appointmenttime, a.inspectors_id, a.status, u.id as iduser, u.firstname
            from drivedealio.appointments as a INNER JOIN drivedealio.users as u on a.inspectors_id = u.id
            where a.inspectors_id = $iduser  order by a.appointmentdate asc LIMIT 5")
        );

        $vehicle = DB::select(
            DB::raw("select v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber,
            v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname, u.address, v.appointments_id, a.id as idappointment, a.status
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            INNER JOIN drivedealio.users as u on v.users_id = u.id
            LEFT JOIN drivedealio.appointments as a on v.appointments_id = a.id
            where v.adstatus IN ('Inspections', 'Grading', 'Graded') order by v.inputdate asc;")
        );

        return view('/inspector/dashboard' , compact('appointment', 'vehicle'));
    }

    public function appointmentList(){
        $iduser = auth()->id();
        $appointment = DB::select(
            DB::raw("SELECT a.id as idappointment, a.appointmentdate, a.appointmenttime, a.inspectors_id, a.status, u.id as iduser, u.firstname
            from drivedealio.appointments as a INNER JOIN drivedealio.users as u on a.inspectors_id = u.id
            where a.inspectors_id = $iduser")
        );

        return view('inspector.appointmentlist' , compact('appointment'));
    }

    public function appointmentCreate(Request $request){
        $idInspector = auth()->user()->id;
        DB::insert(
            "INSERT INTO drivedealio.appointments(appointmentdate, appointmenttime, status, inspectors_id)
            VALUES(:appointmentdate, :appointmenttime, :status, :inspectors_id)",
            ['appointmentdate' => $request->input('appointmentdate'), 'appointmenttime' =>  $request->input('appointmenttime'), 'status' => "Available", 'inspectors_id' => $idInspector]
        );
        return redirect()->route('appointmentlist');
    }
}
