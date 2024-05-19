@extends('layout.main')
@section('content')
    <meta name="csrf_token" content="{{ csrf_token() }}"/>
    <h3>Sell My Vehicle</h3>
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <p style="color: red; margin-left: 5px; size: 10px;">*Enter the vehicle data as stated on the STNK and the correct vehicle specifications.</p>
                <form action="{{ route('vehicle.update', $vehicle[0]->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="bs-stepper-content row my-2">
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="form-label" for="vehiclename">Vehicle Name</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehiclename"
                                                placeholder="Vehicle Name" name="model" value="{{ $vehicle[0]->model }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="select-year">Vehicle Build Year</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="select-year"
                                                placeholder="Production Year" name="year" value="{{ $vehicle[0]->year }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="vehiclevariant">Vehicle Variants</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehiclevariant"
                                                placeholder="Vehicle Variants" name="variant" value="{{ $vehicle[0]->variant }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="enginecapacity">Vehicle Engine Capacity</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="enginecapacity"
                                                placeholder="Vehicle Engine Capacity" name="capacity" value="{{ $vehicle[0]->enginecapacity }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="cylinder">Engine Cylinder</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="number" class="form-control" id="cylinder"
                                                placeholder="Engine Cylinder" name="engcylinder" value="{{ $vehicle[0]->enginecylinders }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="select-fuel">Vehicle Fuel Type</label>
                                        <select class="select2 form-select" id="select-fuel" name="fuel">
                                            <option value="">--Choose Vehicle Fuel Type--</option>
                                            <option value="Gas">Gas</option>
                                            <option value="Solar">Diesel</option>
                                            <option value="Solar">Electric</option>
                                            <option value="Solar">Hybrid</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="select-transmission">Vehicle Transmission</label>
                                        <select class="select2 form-select" id="select-transmission" name="trans">
                                            <option value="">--Choose Vehicle Transmission--</option>
                                            <option value="AT">Automatic</option>
                                            <option value="MT">Manual</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="platenum">Plate Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="platenum"
                                                placeholder="Plate Number" name="plate" value="{{ $vehicle[0]->platenumber }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="select-color">Vehicle Colour</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="select-color"
                                                placeholder="Colour" name="color" value="{{ $vehicle[0]->colour }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="vehicleseats">Vehicle Seats Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehicleseats"
                                                placeholder="Vehicle Seats" name="seats" value="{{ $vehicle[0]->seatsnumber }}"/>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-12 mb-1">
                                <div class="col-md-12 mb-1">
                                    <label for="myDropzone" class="form-label">
                                        <h4>Upload Vehicle Image</h4>
                                    </label>
                                    <input type="file" class="form-control"  name="image[]" accept=".jpeg, .png, .jpg" multiple>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="fileStnk" class="form-label">Upload Scan STNK</label>
                                <input class="form-control" type="file" id="fileStnk" name="stnk" accept=".pdf" />
                                <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                    PDF file format is accepted.</p>
                            </div>

                            <div class="col-md-12">
                                <label for="fileInvoice" class="form-label">Upload Scan Invoice</label>
                                <input class="form-control" type="file" id="fileInvoice" name="invoice" accept=".pdf"/>
                                <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                    PDF file format is accepted.</p>
                            </div>

                            <div class="col-md-12">
                                <label for="fileBpkb" class="form-label">Upload Scan BPKB</label>
                                <input class="form-control" type="file" id="fileBpkb" name="bpkb" accept=".pdf" />
                                <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                    PDF file format is accepted.</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
