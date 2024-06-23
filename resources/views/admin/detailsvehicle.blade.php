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
                                            <div class="col-md-12 mb-2">
                                                @foreach ($vehicle as $v)
                                                <input type="text" class="form-control" id="buildyear" disabled
                                                placeholder="Vehicle Build Year" name="year" value="{{ $v->year }}" />
                                                @endforeach
                                            </div>
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
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehicle-colour" disabled
                                                placeholder="colour" name="colour" value="{{ $v->colour }}" />
                                        </div>
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
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="select-fuel" disabled
                                                placeholder="fueltype" name="fuel"
                                                value="{{ $v->fueltype }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-1">
                                    @foreach ($vehicle as $v)
                                        <embed src="{{ asset('uploads/vehicle/'. $v->id.'/'. $v->stnk) }}" height="250" width="500">
                                    @endforeach
                                </div>

                                <div class="col-md-12">
                                    @foreach ($vehicle as $v)
                                        <embed src="{{ asset('uploads/vehicle/'. $v->id.'/'. $v->bpkb) }}" height="250" width="500">
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-12 mb-1">
                                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        @foreach ($image as $key => $i)
                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
                                        @endforeach
                                    </div>
                                    <div class="carousel-inner">
                                        @foreach ($image as $key => $i)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('/images/vehicle/'.$i->vehicles_id.'/' . $i->url) }}" class="d-block w-100" alt="Slide {{ $key + 1 }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>

                                <div class="col-md-12 mt-3">
                                    @foreach ($vehicle as $v)
                                        <embed src="{{ asset('uploads/vehicle/'. $v->id.'/'. $v->invoice) }}" height="250" width="500">
                                    @endforeach
                                </div>
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
                                <a href="{{ url('reject', $v->id) }}" class="btn btn-danger">
                                    <span>Reject</span>
                                </a>
                            </div>
                            @endforeach

                        </div>
                    </div>
            </div>
        </div>
    </div>
    </form>
@endsection
