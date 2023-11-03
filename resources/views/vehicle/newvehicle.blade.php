@extends('layout.main')
@section('content')
    <h2>Sell Your Vehicle</h2>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 mb-1">
                    <label class="form-label" for="select2-basic">Vehicle Brand</label>
                    <select class="select2 form-select" id="select2-basic">
                        {{-- @foreach ($collection as $item) --}}
                        <option value="">--Choose Vehicle Brand--</option>
                        {{-- @endforeach --}}
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label" for="select2-basic">Vehicle Name</label>
                        <select class="select2 form-select" id="select2-basic">
                            {{-- @foreach ($collection as $item) --}}
                            <option value="">--Choose Vehicle Name--</option>
                            {{-- @endforeach --}}

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="select2-basic">Vehicle Build Year</label>
                        <select class="select2 form-select" id="select2-basic">
                            {{-- @foreach ($collection as $item) --}}
                            <option value="">--Choose Vehicle Build Year--</option>
                            {{-- @endforeach --}}

                        </select>
                    </div>
                </div>
                <br>
                <div class="col-md-12 mb-1">
                    <label class="form-label" for="select2-basic">Vehicle Variants</label>
                    <select class="select2 form-select" id="select2-basic">
                        {{-- @foreach ($collection as $item) --}}
                        <option value="">--Choose Vehicle Variants--</option>
                        {{-- @endforeach --}}
                    </select>
                </div>

                <label class="form-label" for="basic-default-password">Plate Number</label>
                <div class="col-md-12 mb-2">
                    <input type="text" class="form-control" id="basicInput" placeholder="Plate Number" />
                </div>

            </div>
        </div>
    </div>
@endsection
