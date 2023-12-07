@extends('layout.main')
@section('content')
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">


    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Appointments List</h4>>
                    <a href="/appointments/add-data" class="btn btn-icon btn-primary">
                        <i data-feather="plus" class="me-50"></i>
                        <span>Add Schedule</span></a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointment as $a)
                            <tr>
                                <td>{{ $a->idappointment }}</td>
                                <td>{{ $a->appointmentdate }}</td>
                                <td>{{ $a->appointmenttime }}</td>
                                <td>{{ $a->status }}</td>
                                <td>
                                @if ($a->status === 'Booked')
                                        <a class="btn btn-outline-primary" href="#"
                                            style="pointer-events: none;">Cancel</a>
                                @endif
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
