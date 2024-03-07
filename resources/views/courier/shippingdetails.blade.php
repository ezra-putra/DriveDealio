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
                            @foreach ($shipping as $s)
                                <p>Name : {{ $s->name }}</p>
                                <p>Phone Number : {{ $s->phonenumber }}</p>
                                <p>Origin : {{ $s->origin }}</p>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-1">Receiver Information</h5>
                            @foreach ($shipping as $s)
                                <p>Name : {{ $s->firstname }} {{ $s->lastname }}</p>
                                <p>Phone Number : {{ $s->usernumber }}</p>
                                <p>Destination : {{ $s->destination }}</p>
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
                            @foreach ($shipping as $s)
                            <form method="POST" action="{{ route('updateShippingStatus', $s->idshipping) }}" enctype="multipart/form-data">
                            @endforeach
                            @csrf
                                <label class="form-label" for="select-fuel">Delivery Status</label>
                                <select class="select2 form-select mb-1" id="select-status" name="status">
                                    <option value="">--Choose Status--</option>
                                    @foreach ($select_status as $s)
                                        @if ($s->status === 'Request to Pickup')
                                            <option value="Package Picked Up">Package Picked Up</option>
                                        @elseif ($s->status === 'Package Picked Up')
                                            <option value="Package is on the Way">Package is on the Way</option>
                                        @elseif ($s->status === 'Package is on the Way')
                                            <option value="Package is Delivered to Receiver Address">Package is Delivered to Receiver Address</option>
                                        @elseif ($s->status === 'Package is Delivered to Receiver Address')
                                            <option value="Package Received by Receiver">Package Received by Receiver</option>
                                        @endif
                                    @endforeach
                                </select>

                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-info me-1" type="submit">Add Status</button>
                                    </form>
                                    @foreach ($select_status as $s)
                                        @if ($s->status === 'Package Received by Receiver')
                                            @foreach ($shipping as $ss)
                                                <a href="{{ route('update.order', $ss->idorder) }}" class="btn btn-info">Arrived</a>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
