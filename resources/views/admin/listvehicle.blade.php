@extends('layout.main')
@section('content')
<div class="row" id="table-striped" style="padding: 3vh;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Vehicle List</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Vehicle Name</th>
                            <th scope="col">Plate Number</th>
                            <th scope="col">Input Date</th>

                            @if (auth()->user()->roles_id === 1)
                            <th scope="col">Owner</th>
                            @endif
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
                            <td>{{ $v->inputdate }}</td>
                            @if (auth()->user()->roles_id === 1)
                            <td>{{ $v->firstname }}</th>
                            @endif
                            <td>{{ $v->adstatus }}</td>
                            <td>
                                @if ($v->adstatus === 'Waiting for Approval')
                                    <a class="btn btn-icon btn-flat-info" href="{{ route('vehicle.adminEdit', $v->idvehicle) }}">
                                        <i data-feather="eye" class="me-50"></i>
                                        <span>Details</span>
                                    </a>
                                @endif
                                @if ($v->adstatus === 'Auction Request')
                                    <a class="btn btn-icon btn-flat-success" href="{{ route('vehicle.approveautions', $v->idvehicle) }}">
                                        <i data-feather="check" class="me-50"></i>
                                        <span>Approve Auctions</span>
                                    </a>
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
