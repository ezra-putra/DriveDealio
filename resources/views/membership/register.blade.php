@extends('layout.main')
@section('content')
<form action="{{ route('membership.store') }}" method="POST" enctype="multipart/form-data">
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Membership Register</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="bs-stepper-content row my-2">
                        @csrf
                        <div class="col-md-6">
                            @foreach ( $user as $u)
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="username">Name</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="username"
                                                placeholder="Enter Name" name="name" value="{{ $u->name }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="phonenum">Phone Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="phonenum"
                                                placeholder="Enter Phone Number" name="phone" value="{{ $u->phonenumber }}" readonly/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="fileKtp" class="form-label">Upload Scan KTP</label>
                                    <input class="form-control" type="file" id="fileKtp" />
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                        PDF file format is accepted.</p>
                                </div>

                                <div class="col-md-12">
                                    <label for="fileKtp" class="form-label">Upload Selfie with KTP</label>
                                    <input class="form-control" type="file" id="fileKtp" />
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                        PDF file format is accepted.</p>
                                </div>

                                <div class="col-md-12">
                                    <label for="fileNpwp" class="form-label">Upload Scan NPWP</label>
                                    <input class="form-control" type="file" id="fileNpwp" />
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                        PDF file format is accepted.</p>
                                </div>
                            </div>
                            @endforeach

                        </div>

                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="row custom-options-checkable g-1">
                                    @foreach ($membership as $m)
                                    <div class="col-md-6">
                                        <input class="custom-option-item-check" type="radio" name="member" value="{{ $m->id }}" id="rdomember-{{ $m->id }}" checked/>
                                        <label class="custom-option-item p-1" for="rdomember-{{ $m->id }}">
                                            <span class="d-flex justify-content-between flex-wrap mb-50">
                                                <span class="fw-bolder">{{ $m->membershiptype }}</span>
                                                <span class="fw-bolder">@currency($m->price)</span>
                                            </span>
                                            <small class="d-block">{{ $m->description }}</small>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <input type="submit" class="btn btn-primary btn-submit" value="Submit">
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</form>




    <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
@endsection
