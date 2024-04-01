@extends('layout.main')
@section('content')
<h3>Towing List</h3>
<div class="col-md-12 mx-auto" style="padding: 3vh;">
    <div class="row" id="table-striped">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="table1" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Service</th>
                                <th scope="col">Origin</th>
                                <th scope="col">Receiver</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ( $towing as $t )
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $t->name }}</td>
                                <td>{{ $t->origin }}</td>
                                <td>{{ $t->firstname }} {{ $t->lastname }}</td>
                                <td>{{ $t->destination }}</td>
                                <td>{{ $t->status }}</td>
                                <td>
                                    <a href="{{ url('/towing-details', $t->idtowing) }}" class="btn btn-flat-info">
                                        <span>Details</span>
                                    </a>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
