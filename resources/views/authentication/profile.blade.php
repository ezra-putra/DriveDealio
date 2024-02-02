@extends('layout.main')
@section('content')
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
                            @foreach ($profile as $p)
                            <div class="col-md-12 mt-1">
                                <div class="card border border-3">
                                    <div class="card-body col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p style="font-weight: 600;">{{ $p->name }}</p>
                                                <p>{{ $p->address }}</p>
                                                <p>{{ $p->district }}, {{ $p->city }}, {{ $p->zipcode }}</p>
                                                <p>{{ $p->province }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-end">
                                                    @if ($p->is_primaryadd === true)
                                                        <span class="badge bg-light-success text-success">Main Address</span>
                                                    @else
                                                        <form action="{{ route('primary.address', $p->idaddress) }}" method="POST">
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
                            <div class="col-6 mb-1">
                                <label class="form-label" for="address">Address</label>
                                <input type="text" name="address" id="address"
                                    class="form-control" placeholder="Address" />
                            </div>

                            <div class="col-6 mb-1">
                                <label class="form-label" for="district">District</label>
                                <input type="text" name="district" id="district"
                                    class="form-control" placeholder="district" />
                            </div>
                            <div class="col-6 mb-1">
                                <label class="form-label" for="province">Province</label>
                                <input type="text" name="province" id="province"
                                    class="form-control" placeholder="Province" />
                            </div>

                            <div class="mb-1 col-md-6">
                                <label class="form-label" for="city">City</label>
                                <input type="text" name="city" id="city"
                                    class="form-control" placeholder="City" />
                            </div>
                            <div class="mb-1 col-md-12">
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
@endsection
