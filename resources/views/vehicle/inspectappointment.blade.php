@extends('layout.main')
@section('content')
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Review Vehicle Data</h3>
                <div class="bs-stepper-content row my-2">
                    @foreach ($vehicle as $v)
                        <form method="POST" action="{{ route('appointmentDate', ['id' => $v->idvehicle]) }}">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <div class="col-lg-12 col-md-6 col-12">
                                    <div class="row">
                                        <div class="col-md-12 mb-1">
                                            <label class="form-label" for="select-date">Inspection Date</label>
                                            <select class="select2 form-select" id="select-date" name="inspectiondate">
                                                <option value="">--Choose Inspection Date--</option>
                                                @foreach ($appointment as $a)
                                                    <option value={{ $a->idappointment }}>{{ $a->name }} -
                                                        {{ $a->appointmentdate }} - {{ $a->appointmenttime }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <input type="submit" class="btn btn-success" value="Select">
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
