@extends('layout.main')
@section('content')
<h3 class="mt-1">Vehicle Inspection</h3>
<div class="col-md-12 mx-auto" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12">
                    <H5>Vehicle Information</H5>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Vehicle Name</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                {{ $vehicle[0]->brand }} - {{ $vehicle[0]->model }} {{ $vehicle[0]->variant }} {{ $vehicle[0]->year }}, {{ $vehicle[0]->colour }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Plate Number</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                {{ $vehicle[0]->platenumber }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Fuel type</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                {{ $vehicle[0]->fueltype }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Engine</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                {{ $vehicle[0]->enginecapacity }} CC, {{ $vehicle[0]->enginecylinders }} Cylinders
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Transmission</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                {{ $vehicle[0]->transmission }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form method="POST" action="{{ route('inspector.inspections', $vehicle[0]->idvehicle) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body col-md-12">
                        <H5>Inspection</H5>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="Engine-number">Engine Number</label>
                                <div class="col-md-12 mb-2">
                                    <input type="text" class="form-control" id="engine-number"
                                        placeholder="Engine Number" name="engine" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="chassis-number">Chassis Number</label>
                                <div class="col-md-12 mb-2">
                                    <input type="text" class="form-control" id="chassis-number"
                                        placeholder="Chassis Number" name="chassis" />
                                </div>
                            </div>
                            <h5>Grading</h5>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="exteriorgrade">Exterior</label>
                                <div class="col-md-12 mb-2">
                                    <input type="text" class="form-control" id="exteriorgrade"
                                        placeholder="Exterior Grade" name="ext" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="interiorgrade">Interior</label>
                                <div class="col-md-12 mb-2">
                                    <input type="text" class="form-control" id="interiorgrade"
                                        placeholder="Interior Grade" name="int" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="enginegrade">Engine</label>
                                <div class="col-md-12 mb-2">
                                    <input type="text" class="form-control" id="enginegrade"
                                        placeholder="Engine Grade" name="engine" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="mechanismgrade">Mechanism</label>
                                <div class="col-md-12 mb-2">
                                    <input type="text" class="form-control" id="mechanismgrade"
                                        placeholder="Mechanism Grade" name="mech" />
                                </div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <label class="form-label" for="select-date">Appointment Date</label>
                                <select class="select2 form-select" id="select-date" name="dates" readonly>
                                    <option value="">--Choose Appointment Date--</option>
                                    @foreach ($appointment as $a)
                                        <option value="{{ $a->idappointment }}"
                                            {{ $a->idappointment == $a->appointments_id ? 'selected' : '' }}>{{ $a->name }} : {{ $a->appointmentdate }} - {{ $a->appointmenttime }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
