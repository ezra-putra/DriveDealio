@extends('layout.main')
@section('content')
<meta name="csrf_token" content="{{ csrf_token() }}"/>
<h3>Become a Seller</h3>
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <form action="{{ route('seller.register') }}" method="POST" enctype="multipart/form-data">
                    <div class="bs-stepper-content row my-2">
                        @csrf
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="col-md-12 mb-1">
                                    <label class="form-label" for="shop-pic">Shop Picture</label>
                                    <input type="file" class="form-control" id="shop-pic" accept=".jpeg, .jpg, .png" required name="pic" />
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Only JPEG, JPG, PNG file format is accepted.</p>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-6">
                                        <label class="form-label" for="shop-name">Shop Name</label>
                                        <input type="text" class="form-control" id="shop-name" placeholder="Name"
                                                name="shopname" />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="shop-phone">Phone Number</label>
                                        <input type="text" class="form-control" id="shop-phone"
                                                placeholder="Phonenumber" name="shopphone" />
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="shop-address">Shop Address</label>
                                    <input type="text" class="form-control" id="shop-address" placeholder="Address"
                                            name="shopaddress" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12 mb-1">
                                <label class="form-label" for="select-province">Province</label>
                                <select class="form-select" id="select-province" name="province">
                                    <option value="">--Choose Province--</option>
                                    @foreach ($provinces as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="select-regencies">Regencies</label>
                                    <select class="form-select" id="select-regencies" name="regency">
                                        <option value="">--Choose Regencies--</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="select-district">District</label>
                                        <select class="form-select" id="select-district" name="district">
                                            <option value="">--Choose District--</option>
                                        </select>
                                    </div>
                                </div>
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
        })
    </script>
@endsection
