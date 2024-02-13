<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Inspector;
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
            DB::raw("SELECT v.id as idvehicle, CONCAT(v.model,' ', v.variant) as name, v.transmission, v.platenumber,
            v.adstatus, v.inputdate, b.name as brand, u.id, u.firstname, v.appointments_id, a.id as idappointment, a.status
            FROM drivedealio.vehicles as v INNER JOIN drivedealio.brands as b on v.brands_id = b.id
            INNER JOIN drivedealio.users as u on v.users_id = u.id
            LEFT JOIN drivedealio.appointments as a on v.appointments_id = a.id
            where v.adstatus IN ('Inspection', 'Grading', 'Graded') order by v.inputdate asc;")
        );
        if ($appointment[0]->status == 'Available')
        {
            $this->appointmentExpired($appointment[0]->idappointment);
        }


        return view('/inspector/dashboard' , compact('appointment', 'vehicle'));
    }

    public function appointmentList()
    {
        $iduser = auth()->id();
        $appointment = DB::select(
            DB::raw("SELECT a.id as idappointment, a.appointmentdate, a.appointmenttime, a.inspectors_id, a.status, u.id as iduser, u.firstname
            from drivedealio.appointments as a INNER JOIN drivedealio.users as u on a.inspectors_id = u.id
            where a.inspectors_id = $iduser order by a.appointmentdate, a.appointmenttime desc")
        );
        if ($appointment[0]->status == 'Available')
        {
            $this->appointmentExpired($appointment[0]->idappointment);
        }

        return view('inspector.appointmentlist' , compact('appointment'));
    }

    public function appointmentExpired($id)
    {
        $iduser = auth()->id();
        $appointment = DB::select(
            DB::raw("SELECT a.id as idappointment, a.appointmentdate, a.appointmenttime, a.inspectors_id, a.status, u.id as iduser, u.firstname
            from drivedealio.appointments as a INNER JOIN drivedealio.users as u on a.inspectors_id = u.id
            where a.inspectors_id = $iduser AND a.status = 'Available';")
        );
        $now = Carbon::now();
        if($now >= $appointment[0]->appointmentdate || $now >= $appointment[0]->appointmenttime)
        {
            DB::table('drivedealio.appointments')
                ->where('id', $id)
                ->update(['status' => 'Expired']);

        }
    }

    public function appointmentCreate(Request $request){
        $idInspector = auth()->user()->id;
        $appointment = new Appointment;
        $appointment->appointmentdate = $request->input('appointmentdate');
        $appointment->appointmenttime = $request->input('appointmenttime');
        $appointment->status = "Available";
        $appointment->inspectors_id = $idInspector;
        $appointment->save();
        return redirect()->route('appointmentlist')->with('success', 'Appointment Added');
    }
}
