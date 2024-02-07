@extends('layout.main')
@section('content')

<meta name="csrf_token" content="{{ csrf_token() }}"/>
<h3>Profile</h3>
<div class="col-md-12" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <span class="avatar me-1">
                        <img src="{{ $profile[0]->profilepicture }}" class="round" alt="avatar" height="40" width="40" style="object-fit: cover">
                    </span>
                    <div class="user-nav d-flex d-sm-inline-flex">
                        <span class="user-name fw-bolder">{{ $profile[0]->firstname }} {{ $profile[0]->lastname }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <h4>Data</h4>
            <div class="card">
                <div class="card-body col-md-12">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Profile</button>
                            <button class="nav-link" id="nav-address-tab" data-bs-toggle="tab" data-bs-target="#nav-address" type="button" role="tab" aria-controls="nav-address" aria-selected="false">Address</button>
                            <button class="nav-link" id="nav-idcard-tab" data-bs-toggle="tab" data-bs-target="#nav-idcard" type="button" role="tab" aria-controls="nav-idcard" aria-selected="false">User Information</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-md-4 border border-3">
                                    <div class="text-center">
                                        <img src="{{ $profile[0]->profilepicture }}" class="align-items-center mx-auto mt-1" alt="avatar" height="250" width="250" style="object-fit: cover">
                                    </div>
                                    <input class="form-control mt-1" type="file" name="profile" accept=".jpeg, .jpg, .png" required/>
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Only JPEG, JPG, PNG file format is accepted.</p>
                                </div>
                                <div class="col-md-8">
                                    <h5>Edit Profile</h5>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Name</p>
                                        </label>
                                        <div class="col-sm-3">
                                            <input name="fname" class="form-control" type="text" value="{{ $profile[0]->firstname }}"/>
                                        </div>
                                        <div class="col-sm-3">
                                            <input name="lname" class="form-control" type="text" value="{{ $profile[0]->lastname }}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Birthdate</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <input name="fname" class="form-control" type="text" value="{{ $profile[0]->birthdate }}"/>
                                        </div>
                                    </div>
                                    <h5>Edit Contact</h5>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Email</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <input name="fname" class="form-control" type="text" value="{{ $profile[0]->email }}"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Phone Number</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <input name="fname" class="form-control" type="text" value="{{ $profile[0]->phonenumber }}"/>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <a href="" class="btn btn-info">Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-address" role="tabpanel" aria-labelledby="nav-address-tab">
                            <a class="btn btn-outline-secondary" data-bs-toggle="modal" href="#modalAddress">Add New Address</a>
                            @if(!empty($address))
                            @foreach ($address as $a)
                            <div class="col-md-12 mt-1">
                                <div class="card border border-3">
                                    <div class="card-body col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p style="font-weight: 600;">{{ $a->name }}</p>
                                                <p>{{ $a->address }}</p>
                                                <p>{{ $a->district }}, {{ $a->city }}, {{ $a->zipcode }}</p>
                                                <p>{{ $a->province }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-end">
                                                    @if ($a->is_primaryadd === true)
                                                        <span class="badge bg-light-success text-success">Main Address</span>
                                                    @else
                                                        <form action="{{ route('primary.address', $a->idaddress) }}" method="POST">
                                                            @csrf
                                                            <button class="btn btn-info" type="submit">Set as Primary</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="tab-pane fade" id="nav-idcard" role="tabpanel" aria-labelledby="nav-idcard-tab">
                            <form action="{{ route('userinfo.post') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label for="fileKtp" class="form-label">Upload Scan KTP</label>
                                    <input class="form-control" type="file" id="fileKtp" name="ktp" accept=".pdf" required/>
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                        PDF file format is accepted.</p>
                                </div>
                                <div class="col-md-12">
                                    <label for="fileNpwp" class="form-label">Upload Scan NPWP</label>
                                    <input class="form-control" type="file" id="fileNpwp" name="npwp" accept=".pdf" required/>
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                        PDF file format is accepted.</p>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <input type="submit" class="btn btn-info" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddress" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="addNewCardTitle">Address Information</h1>
                <!-- form -->
                <form action="{{ route('address.post') }}" method="POST"
                    enctype="multipart/form-data" class="row gy-1 gx-2 mt-75" id="bidForm">
                    @csrf
                    <div class="col-12">
                        <div class="row">
                            <div class="mb-1 col-md-12">
                                <label class="form-label" for="name">Address Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control" placeholder="Address Name" />
                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label" for="address">Address</label>
                                <input type="text" name="address" id="address"
                                    class="form-control" placeholder="Address" />
                            </div>

                            <div class="col-12 mb-1">
                                <label class="form-label" for="select-province">Province</label>
                                <select class="form-select" id="select-province" name="province">
                                    <option value="">--Choose Province--</option>
                                    @foreach ($provinces as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6 mb-1">
                                <label class="form-label" for="select-regencies">Regencies</label>
                                <select class="form-select" id="select-regencies" name="regencies">
                                    <option value="">--Choose Regencies--</option>
                                </select>
                            </div>

                            <div class="col-6 mb-1">
                                <label class="form-label" for="select-district">District</label>
                                    <select class="form-select" id="select-district" name="district">
                                        <option value="">--Choose District--</option>
                                    </select>
                            </div>

                            <div class="col-6 mb-1">
                                <label class="form-label" for="select-village">Village</label>
                                    <select class="form-select" id="select-village" name="village">
                                        <option value="">--Choose Village--</option>
                                    </select>
                            </div>

                            <div class="mb-1 col-md-6">
                                <label class="form-label" for="zip">Zip Code</label>
                                <input type="text" name="zip" id="zip"
                                    class="form-control" placeholder="Zip Code" />
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <input type="submit" id="submitBid" class="btn btn-primary me-1 mt-1" value="Add Address">
                        <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                            aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
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
            $('#select-province').on('change', function() {
                let province_id = $('#select-province').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('regency') }}",
                    data: { province_id:province_id },
                    cache: false,

                    success: function(params){
                        $('#select-regencies').html(params);
                    },
                    error: function(data){
                        console.log(data);
                    }
                })
            })
        })

        $(function(){
            $('#select-regencies').on('change', function() {
                let regency_id = $('#select-regencies').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('district') }}",
                    data: { regency_id:regency_id },
                    cache: false,

                    success: function(params){
                        $('#select-district').html(params);
                    },
                    error: function(data){
                        console.log(data);
                    }
                })
            })
        })
        $(function(){
            $('#select-district').on('change', function() {
                let district_id = $('#select-district').val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('village') }}",
                    data: { district_id:district_id },
                    cache: false,

                    success: function(params){
                        $('#select-village').html(params);
                    },
                    error: function(data){
                        console.log(data);
                    }
                })
            })
        })
    })
</script>
@endsection
