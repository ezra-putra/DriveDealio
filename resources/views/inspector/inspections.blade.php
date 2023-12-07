@extends('layout.main')
@section('content')
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Vehicle Inspections</h3>
                @foreach ($vehicle as $v)
                <form method="POST" action="{{ route('inspectionsUpdate', $v->idvehicle) }}"
                    enctype="multipart/form-data">
                @endforeach

                    <div class="bs-stepper-content row my-2">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
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
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <input type="submit" class="btn btn-success" value="Approve">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
