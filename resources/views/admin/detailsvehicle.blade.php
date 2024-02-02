@extends('layout.main')
@section('content')
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Review Vehicle Data</h3>
                <p>Status : @foreach ($vehicle as $v){{ $v->adstatus }}@endforeach</p>
                    <div class="bs-stepper-content row my-2">
                        @csrf
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="select-brand">Vehicle Brand</label>
                                        <select class="select2 form-select" id="select-brand" name="brand" disabled>
                                            <option value="">--Choose Vehicle Brand--</option>
                                            @foreach ($brand as $b)
                                                @foreach ($vehicle as $v)
                                                    <option value="{{ $b->id }}"
                                                        {{ $v->brands_id == $b->id ? 'selected' : '' }}>{{ $b->name }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="select-type">Vehicle Type</label>
                                        <select class="select2 form-select" id="select-type" name="type" disabled>
                                            <option value="">--Choose Vehicle Type--</option>
                                            @foreach ($type as $t)
                                                @foreach ($vehicle as $v)
                                                    <option value="{{ $t->id }}"
                                                        {{ $v->vehicletypes_id == $t->id ? 'selected' : '' }}>
                                                        {{ $t->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <label class="form-label" for="vehiclename">Vehicle Name</label>
                                        <div class="col-md-12 mb-2">
                                            @foreach ($vehicle as $v)
                                                <input type="text" class="form-control" id="vehiclename" disabled
                                                    placeholder="Vehicle Name" name="model" value="{{ $v->model }}" />
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label" for="select-year">Vehicle Build Year</label>
                                        <select class="select2 form-select" id="select-year" name="year" disabled>
                                            <option value="NULL">--Choose Vehicle Build Year--</option>
                                            @foreach ($year as $y)
                                                @foreach ($vehicle as $v)
                                                    <option value="{{ $y->id }}"
                                                        {{ $v->productionyears_id == $y->id ? 'selected' : '' }}>
                                                        {{ $y->year }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="vehiclevariant">Vehicle Variants</label>
                                        <div class="col-md-12 mb-2">
                                            @foreach ($vehicle as $v)
                                                <input type="text" class="form-control" id="vehiclevariant" disabled
                                                    placeholder="Vehicle Variants" name="variant"
                                                    value="{{ $v->variant }}" />
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="enginecapacity">Vehicle Engine Capacity</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="enginecapacity" disabled
                                                placeholder="Vehicle Engine Capacity" name="capacity"
                                                value="{{ $v->enginecapacity }}" />
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="platenum">Plate Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="platenum" disabled
                                                placeholder="Plate Number" name="plate" value="{{ $v->platenumber }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="select-color">Vehicle Colour</label>
                                        <select class="select2 form-select" id="select-color" name="color" disabled>
                                            <option value="">--Choose Vehicle Colour--</option>
                                            @foreach ($color as $c)
                                                @foreach ($vehicle as $v)
                                                    <option value="{{ $c->id }}"
                                                        {{ $v->colours_id == $c->id ? 'selected' : '' }}>
                                                        {{ $c->name }}</option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="cylinder">Engine Cylinder</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="number" class="form-control" id="cylinder" disabled
                                                placeholder="Engine Cylinder" name="engcylinder"
                                                value="{{ $v->enginecylinders }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="select-fuel">Vehicle Fuel Type</label>
                                        <select class="select2 form-select" id="select-fuel" name="fuel" disabled>
                                            <option value="">--Choose Vehicle Fuel Type--</option>
                                            <option value="petrol" {{ $v->fueltype == 'petrol' ? 'selected' : '' }}>Petrol
                                            </option>
                                            <option value="solar" {{ $v->fueltype == 'solar' ? 'selected' : '' }}>Solar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-12 mb-1">
                                <div class="col-md-12 mb-1">
                                    <label for="dpz-multiple-files" class="form-label">
                                        <h4>Upload Vehicle Image</h4>
                                    </label>
                                    <form action="#" class="dropzone dropzone-area" id="dpz-multiple-files">
                                        <div class="dz-message">Drop images here or click to upload.</div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="Location">Location</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="location" placeholder="Location"
                                            disabled name="loc" value="{{ $v->location }}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="select-transmission">Vehicle Transmission</label>
                                    <select class="select2 form-select" id="select-transmission" name="trans" disabled>
                                        <option value="">--Choose Vehicle Transmission--</option>
                                        <option value="AT" {{ $v->transmission == 'AT' ? 'selected' : '' }}>Automatic
                                        </option>
                                        <option value="Manual" {{ $v->transmission == 'Manual' ? 'selected' : '' }}>Manual
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="fileStnk" class="form-label">Upload Scan STNK</label>
                                <input class="form-control" type="file" id="fileStnk" />
                                <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                    PDF file format is accepted.</p>
                            </div>

                            <div class="col-md-12">
                                <label for="fileInvoice" class="form-label">Upload Scan Invoice</label>
                                <input class="form-control" type="file" id="fileInvoice" />
                                <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                    PDF file format is accepted.</p>
                            </div>

                            <div class="col-md-12">
                                <label for="fileBpkb" class="form-label">Upload Scan BPKB</label>
                                <input class="form-control" type="file" id="fileBpkb" />
                                <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                    PDF file format is accepted.</p>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            @foreach ($vehicle as $v)
                            <div class="col-auto">
                                <a href="{{ url('approve', $v->id) }}" class="btn btn-success">
                                    <span>Approve Data</span>
                                </a>
                            </div>
                            <div class="col-auto">
                                <input type="submit" class="btn btn-danger btn-submit"
                                    value="Reject">
                            </div>
                            @endforeach

                        </div>
                    </div>
            </div>
        </div>
    </div>
    </form>
@endsection
