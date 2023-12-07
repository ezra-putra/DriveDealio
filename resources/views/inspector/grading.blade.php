@extends('layout.main')
@section('content')
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Vehicle Grading</h3>
                @foreach ($vehicle as $v)
                <form method="POST" action="{{ route('inspectionsGrade', $v->idvehicle) }}"
                    enctype="multipart/form-data">
                @endforeach

                    <div class="bs-stepper-content row my-2">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
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
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
