@extends('layout.main')
@section('content')
<h3>Shipping List</h3>
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
                                <th scope="col">Sender</th>
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
                            @foreach ( $shipping as $s )
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $s->packagename }}</td>
                                <td>{{ $s->name }}</td>
                                <td>{{ $s->origin }}</td>
                                <td>{{ $s->firstname }} {{ $s->lastname }}</td>
                                <td>{{ $s->destination }}</td>
                                <td>{{ $s->status }}</td>
                                <td>
                                    <a href="{{ url('/shipping-details', $s->idshipping) }}" class="btn btn-flat-info">
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
