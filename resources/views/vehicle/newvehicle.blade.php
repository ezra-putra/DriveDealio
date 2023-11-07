@extends('layout.main')
@section('content')
<h2>Sell Vehicle</h2>
    <div class="col-md-6" style="padding: 3vh;">

        <div class="card">
            <div class="card-body">
                <div class="col-md-12 mb-1">
                    <label class="form-label" for="select2-basic">Vehicle Type</label>
                    <select class="select2 form-select" id="select2-basic">
                        <option value="">--Choose Vehicle Type--</option>
                        @foreach ($types as $t)
                            <option value={{ $t->id }}> <img src="{{ $t->image }}">{{ $t->brandname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-1">
                    <label class="form-label" for="select2-basic">Vehicle Brand</label>
                    <select class="select2 form-select" id="select2-basic">
                        <option value="">--Choose Vehicle Brand--</option>
                        @foreach ($brands as $b)
                            <option value={{ $b->id }}><img src="{{ $b->image }}">{{ $b->brandname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label" for="select2-basic">Vehicle Name</label>
                        <select class="select2 form-select" id="select2-basic">
                            <option value="">--Choose Vehicle Name--</option>
                            {{-- @foreach ($collection as $item) --}}

                            {{-- @endforeach --}}

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="select2-basic">Vehicle Build Year</label>
                        <select class="select2 form-select" id="select2-basic">
                            <option value="">--Choose Vehicle Build Year--</option>
                            {{-- @foreach ($collection as $item) --}}

                            {{-- @endforeach --}}

                        </select>
                    </div>
                </div>
                <br>
                <div class="col-md-12 mb-1">
                    <label class="form-label" for="select2-basic">Vehicle Variants</label>
                    <select class="select2 form-select" id="select2-basic">
                        <option value="">--Choose Vehicle Variants--</option>
                        {{-- @foreach ($collection as $item) --}}

                        {{-- @endforeach --}}
                    </select>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label" for="basic-default-password">Plate Number</label>
                        <div class="col-md-12 mb-2">
                            <input type="text" class="form-control" id="basicInput" placeholder="Plate Number" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="select2-basic">Vehicle Colour</label>
                        <select class="select2 form-select" id="select2-basic">
                            <option value="">--Choose Vehicle Colour--</option>
                            {{-- @foreach ($collection as $item) --}}

                            {{-- @endforeach --}}

                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
