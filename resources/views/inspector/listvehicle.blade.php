@extends('layout.main')
@section('content')
<div class="row" id="table-striped" style="padding: 3vh;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Vehicle List</h4>
            </div>
            <div class="table-responsive mb-1">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Vehicle Name</th>
                            <th scope="col">Plate Number</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Address</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $vehicle as $v )
                        <tr>

                            <td>{{ $v->idvehicle }}</td>
                            <td>{{ $v->brand }} {{ $v->name }} {{ $v->transmission }}</td>
                            <td>{{ $v->platenumber }}</td>
                            <td>{{ $v->firstname }}</td>
                            <td>{{ $v->address }}</td>
                            @if (auth()->user()->roles_id === 1)
                            <td>{{ $v->firstname }}</th>
                            @endif
                            <td>{{ $v->adstatus }}</td>
                            <td>
                                @if ($v->status === 'Available')
                                    <a class="btn btn-icon btn-flat-success" href="{{ route('acceptAppointment', $v->idappointment) }}">
                                        <i data-feather="check" class="me-50"></i>
                                        <span>Accept</span>
                                    </a>
                                @endif
                                @if ($v->status === 'Booked' && $v->adstatus === 'Inspections')

                                    <a class="btn btn-icon btn-flat-info" href="{{ route('inspector.inspections', $v->idvehicle) }}">
                                        <i data-feather="eye" class="me-50"></i>
                                        <span>Inspections</span>
                                    </a>
                                @endif
                                @if ($v->adstatus === 'Grading')
                                    <a class="btn btn-icon btn-flat-info" href="{{ route('inspector.grading', $v->idvehicle) }}">
                                        <i data-feather="edit" class="me-50"></i>
                                        <span>Grade</span>
                                    </a>
                                @endif
                                @if ($v->adstatus === 'Graded')

                                    <a class="btn btn-icon btn-flat-success" href="{{ route('finishGrading', $v->idvehicle) }}">
                                        <i data-feather="check" class="me-50"></i>
                                        <span>Finish</span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
            @if(empty($vehicle))
                <p class="text-center">NO DATA</p>
            @endif
        </div>
    </div>
</div>
@endsection
