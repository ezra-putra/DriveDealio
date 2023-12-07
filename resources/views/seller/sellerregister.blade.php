@extends('layout.main')
@section('content')
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Become a Seller</h3>
                <form action="{{ route('seller.register') }}" method="POST" enctype="multipart/form-data">
                    <div class="bs-stepper-content row my-2">
                        @csrf
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="shop-name">Shop Name</label>
                                        <div class="col-md-12 mb-1">
                                            <input type="text" class="form-control" id="shop-name" placeholder="Name"
                                                name="shopname" />
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-1">
                                        <label class="form-label" for="shop-phone">Phone Number</label>
                                        <div class="col-md-12 mb-1">
                                            <input type="text" class="form-control" id="shop-phone"
                                                placeholder="Phonenumber" name="shopphone" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <label class="form-label" for="shop-address">Shop Address</label>
                                    <div class="col-md-12 mb-1">
                                        <input type="text" class="form-control" id="shop-address" placeholder="Address"
                                            name="shopaddress" />
                                    </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="shop-city">City</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="shop-city" placeholder="City"
                                            name="shopcity" />
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="shop-province">Shop Province</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="shop-province" placeholder="province"
                                            name="shopprovince" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="shop-district">Shop District</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="shop-district" placeholder="District"
                                            name="shopdistrict" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="shop-zip">Shop Zipcode</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="shop-zip" placeholder="Zip Code"
                                            name="shopzip" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <input type="submit" class="btn btn-primary btn-submit"
                                value="Register">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
