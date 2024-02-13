@extends('layout.main')
@section('content')
    <meta name="csrf_token" content="{{ csrf_token() }}"/>
    <h3>Sell My Vehicle</h3>
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <p style="color: red; margin-left: 5px; size: 10px;">*Enter the vehicle data as stated on the STNK and the correct vehicle specifications.</p>
                <form action="{{ route('vehicle.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="bs-stepper-content row my-2">
                        @csrf
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="select-cat">Vehicle Categories</label>
                                        <select class="form-select" id="select-cat" name="cat">
                                            <option value="">--Choose Vehicle Type--</option>
                                            @foreach ($cat as $c)
                                                <option value={{ $c->id }}>{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="select-type">Vehicle Type</label>
                                        <select class="form-select" id="select-type" name="type">
                                            <option value="">--Choose Vehicle Type--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-1">
                                    <label class="form-label" for="select-brand">Vehicle Brand</label>
                                    <select class="form-select" id="select-brand" name="brand">
                                        <option value="">--Choose Vehicle Brand--</option>
                                        @foreach ($brand as $b)
                                            <option value={{ $b->id }}>{{ $b->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="form-label" for="vehiclename">Vehicle Name</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehiclename"
                                                placeholder="Vehicle Name" name="model" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="select-year">Vehicle Build Year</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="select-year"
                                                placeholder="Production Year" name="year" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="vehiclevariant">Vehicle Variants</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehiclevariant"
                                                placeholder="Vehicle Variants" name="variant" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="enginecapacity">Vehicle Engine Capacity</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="enginecapacity"
                                                placeholder="Vehicle Engine Capacity" name="capacity" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="cylinder">Engine Cylinder</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="number" class="form-control" id="cylinder"
                                                placeholder="Engine Cylinder" name="engcylinder" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="select-fuel">Vehicle Fuel Type</label>
                                        <select class="select2 form-select" id="select-fuel" name="fuel">
                                            <option value="">--Choose Vehicle Fuel Type--</option>
                                            <option value="Petrol">Gas</option>
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
                                                placeholder="Plate Number" name="plate" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="select-color">Vehicle Colour</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="select-color"
                                                placeholder="Colour" name="color" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="vehicleseats">Vehicle Seats Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehicleseats"
                                                placeholder="Vehicle Seats" name="seats" required/>
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
                                    <input type="file" class="form-control"  name="image[]" accept=".jpeg/.png/.jpg" multiple>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label for="fileStnk" class="form-label">Upload Scan STNK</label>
                                <input class="form-control" type="file" id="fileStnk" name="stnk" accept=".pdf" required/>
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
                                <input class="form-control" type="file" id="fileBpkb" name="bpkb" accept=".pdf" required/>
                                <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                    PDF file format is accepted.</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-info btn-draft">
                                <i data-feather="file-text" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Save as Draft</span>
                            </button>
                            <input type="submit" class="btn btn-primary btn-submit"
                                value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(function () {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
            });

            $(function(){
                $('#select-cat').on('change', function() {
                    let cat_id = $('#select-cat').val();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('type') }}",
                        data: { vehiclecategories_id:cat_id },
                        cache: false,
                        success: function(data){
                            $('#select-type').html(data);
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });
                });
            });
        })
    </script>
@endsection
