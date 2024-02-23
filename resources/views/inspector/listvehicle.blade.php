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
                            <td>{{ $v->firstname }}, {{ $v->phonenumber }}</td>
                            <td>{{ $v->address }}, {{ $v->village }} {{ $v->regency }}</td>
                            <td>{{ $v->adstatus }}</td>
                            <td>
                                @if ($v->status === 'Booked' && $v->adstatus === 'Inspection')
                                    <a class="btn btn-icon btn-flat-info" href="{{ route('inspector.inspec', $v->idvehicle) }}">
                                        <i data-feather="eye" class="me-50"></i>
                                        <span>Inspections</span>
                                    </a>
                                @endif
                                @if ($v->adstatus === 'Inspected')

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
