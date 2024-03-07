@extends('layout.main')
@section('content')
<h3>Shipping Details</h3>
    <div class="col-md-12" style="padding: 3vh;">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <h5 class="mb-1">Sender Information</h5>
                            @foreach ($vehicle as $v)
                                <p>Name : {{ $v->firstname }}</p>
                                <p>Phone Number : {{ $v->phonenumber }}</p>
                                <p>Origin : {{ $v->origin }}</p>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1">Receiver Information</h5>
                            @foreach ($towing as $t)
                                <p>Name : {{ $t->firstname }} {{ $t->lastname }}</p>
                                <p>Phone Number : {{ $t->phonenumber }}</p>
                                <p>Destination : {{ $t->destination }}</p>
                            @endforeach
                        </div>
                    </div>
                    <hr style="height:2px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                                <h6 class="mb-1">Status Timeline</h6>
                            @foreach ($status as $s)
                                <p class="mb-1">{{ $s->status }} - {{ \Carbon\Carbon::parse($s->created_at)->isoFormat('DD MMMM YYYY, HH:mm') }}</p>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <h6>Add Delivery Status</h6>
                            @foreach ($towing as $t)
                            <form method="POST" action="{{ route('updateTowingStatus', $t->idtowing) }}" enctype="multipart/form-data">
                            @endforeach
                            @csrf
                                <label class="form-label" for="select-fuel">Delivery Status</label>
                                <select class="select2 form-select mb-1" id="select-status" name="status">
                                    <option value="">--Choose Status--</option>
                                    @foreach ($select_status as $s)
                                        @if ($s->status === 'Request to Pickup')
                                            <option value="Vehicle Picked Up">Package Picked Up</option>
                                        @elseif ($s->status === 'Vehicle Picked Up')
                                            <option value="Vehicle is on the Way">Package is on the Way</option>
                                        @elseif ($s->status === 'Vehicle is on the Way')
                                            <option value="Vehicle is Delivered to Receiver Address">Package is Delivered to Receiver Address</option>
                                        @elseif ($s->status === 'Vehicle is Delivered to Receiver Address')
                                            <option value="Vehicle Received by Receiver">Package Received by Receiver</option>
                                        @endif
                                    @endforeach
                                </select>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-info" type="submit">Add Status</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
