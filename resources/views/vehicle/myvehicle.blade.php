@extends('layout.main')
@section('content')
<h3>MyVehicle List</h3>
    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">MyVehicle</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Vehicle Name</th>
                                <th scope="col">Plate Number</th>
                                <th scope="col">Input Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Auction Time Remaining</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($vehicle as $v)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $v->brand }} {{ $v->name }} {{ $v->transmission }}</td>
                                    <td>{{ $v->platenumber }}</td>
                                    <td>{{ $v->inputdate }}</td>
                                    @if (auth()->user()->roles_id === 1)
                                        <td>{{ $v->firstname }}</th>
                                    @endif
                                    <td>{{ $v->adstatus }}</td>

                                    @if (empty($v->duration))
                                        <td>AUCTION NOT SET</td>
                                    @else
                                        <td id="countdown">{{ $v->duration }}</td>
                                    @endif
                                    <td>
                                        @if ($v->adstatus === 'Setup Auction')
                                            <a class="btn btn-icon btn-flat-info"
                                                href="{{ route('auctionSetupBtn', $v->idvehicle) }}">
                                                <i data-feather="edit" class="me-50"></i>
                                                <span>Setup Auction</span>
                                            </a>
                                        @endif
                                        @if ($v->adstatus === 'Pending')
                                            <a class="btn btn-icon btn-flat-info"
                                                href="{{ route('vehicle.appointment', $v->idvehicle) }}">
                                                <i data-feather="calendar" class="me-50"></i>
                                                <span>Inspection Date</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (empty($vehicle))
                    <p class="text-center mt-1">No Vehicle Data</p>
                    <div class="text-center">
                        <a class="btn btn-outline-info mb-1 w-25" href="/vehicle/adddata">Sell My Vehicle</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Vehicle Order List</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Vehicle Name</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1
                            @endphp
                            @foreach ($order as $o)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $o->invoicenum }}</td>
                                    <td>{{ $o->brand }} {{ $o->vehiclename }} {{ $o->transmission }}</td>
                                    <td>{{ $o->orderdate }}</td>
                                    <td>{{ $o->status }}</td>
                                    <td>
                                        @if ($o->status === 'Waiting for Confirmation')
                                            <a class="btn btn-icon btn-flat-success"
                                                href="{{ route('approveauction.post', $o->idorder) }}">
                                                <i data-feather="check" class="me-50"></i>
                                                <span>Confirm Order</span>
                                            </a>
                                        @endif
                                        @if ($o->status === 'On Process')
                                            <a class="btn btn-icon btn-flat-success"
                                                href="{{ route('deliveryauction.post', $o->idorder) }}">
                                                <i data-feather="truck" class="me-50"></i>
                                                <span>Arrange Delivery</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (empty($vehicle))
                    <p class="text-center mt-1">No Vehicle Data</p>
                    <div class="text-center">
                        <a class="btn btn-outline-info mb-1 w-25" href="/vehicle/adddata">Sell My Vehicle</a>
                    </div>
                @endif
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        @if(!empty($vehicle))
            var startDate = new Date("{{ $vehicle[0]->start_date }}").getTime();
            var endDate = new Date("{{ $vehicle[0]->end_date }}").getTime();
            function startTimer(status) {
                if ("{{ $vehicle[0]->adstatus }}" === "Open to Bid") {
                    var endDate = new Date().getTime();
                    var x = setInterval(function() {
                        var now = new Date().getTime();
                        var distance = endDate - now;
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        $("#countdown").html(days + "D " + hours + "H " + minutes + "M " + seconds + "S ");

                        if (distance < 0) {
                            clearInterval(x);
                            $("#countdown").html("Auction Ended");
                        }
                    }, 1000);
                } else {
                    $("#countdown").html("Waiting for approval");
                }
            }
        @endif
    </script>
@endsection
