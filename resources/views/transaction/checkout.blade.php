@extends('layout.main')
@section('content')
<meta name="csrf_token" content="{{ csrf_token() }}"/>
<h3>Checkout</h3>
<div class="col-md-12" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-8">
            <div class="card ecommerce-card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h5>Address</h5>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <p style="font-weight: 800">{{ $userinfo->firstname }} {{ $userinfo->lastname }} ({{ $userinfo->phonenumber }})</p>
                    <p></p>
                    @foreach ($address as $a)
                    <p style="font-weight: 500;">{{ $a->name }}</p>
                    <p>{{ $a->address }}</p>
                    <p>{{ $a->district }}, {{ $a->city }}, {{ $a->zipcode }}</p>
                    <p>{{ $a->province }}</p>
                    @endforeach
                    @if (auth()->user() && auth()->user()->roles_id === 2)
                        @if (empty($address))
                        <div class="row">
                            <div class="col-md-2">
                                <h5>
                                    No Address
                                </h5>
                            </div>
                        </div>
                        @endif
                    @endif
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray;">
                    <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1">
                        <a class="btn btn-outline-secondary" data-bs-toggle="modal" href="#modalAddress">Add New Address</a>
                        <a class="btn btn-outline-secondary mx-1" data-bs-toggle="modal" href="#modalSelAddress">Select Another Address</a>
                    </div>
                    <hr style="height:5px;border-width:0;color:gray;background-color:lightgray;">
                    <h6>{{ $checkout[0]->sellername }}</h6>
                    <p>{{ $checkout[0]->sellercity }}</p>

                    <div class="row">
                        @php
                            $subTotal = 0;
                            $totalPrice = 0;
                            $shippingCost = 25000;
                        @endphp
                        @foreach ($checkout as $c)
                        <div class="col-md-2">
                            <div class="item-img">
                                <a href="#">
                                    <img src="{{ asset('images/sparepart/'.$c->idsparepart.'/' .$c->url) }}" alt="img-placeholder" style="width: 150px; height: auto;"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <div class="col-md-6">
                                    <div class="item-name mb-1">
                                        <h5 class="mb-0"><a href="#" class="text-body">{{ $c->partnumber }} - {{ $c->partname }} {{ $c->vehiclemodel }}</a></h5>
                                        @php
                                            $subTotal = $c->unitprice * $c->quantity;
                                            $totalPrice += $subTotal;
                                        @endphp
                                        <p style="font-size: 14px;" class="mt-1 mb-0">{{ $c->quantity }} x @currency($c->unitprice) = @currency($subTotal)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="col-md-12 mt-1">
                            <p class="mb-0">Select Shipping</p>
                            <div class="card-body">
                                <div class="row custom-options-checkable g-1">
                                    @foreach ($shipping as $s)
                                    <div class="col-md-6">
                                        <input class="custom-option-item-check" type="radio" name="ship" value="{{ $s->id }}" id="rdoship-{{ $s->id }}" checked/>
                                        <label class="custom-option-item p-1" for="rdoship-{{ $s->id }}">
                                            <span class="d-flex justify-content-between flex-wrap mb-50">
                                                <span class="fw-bolder">{{ $s->name }}</span>
                                                @php
                                                    if ($distanceValue > 100.0)
                                                    {
                                                        if ($s->id === 1)
                                                        {
                                                            $price = ($distanceValue * 50) + ($weight * 4000);
                                                        }
                                                        elseif ($s->id === 2)
                                                        {
                                                            $price = ($distanceValue * 20) + ($weight * 4000);
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if ($s->id === 1)
                                                        {
                                                            $price = ($distanceValue * 800) + ($weight * 4000);
                                                        }
                                                        elseif ($s->id === 2)
                                                        {
                                                            $price = ($distanceValue * 500) + ($weight * 4000);
                                                        }

                                                    }
                                                @endphp
                                                <span class="fw-bolder">@currency($price)</span>
                                            </span>
                                            <small class="d-block">{{ $s->details }}</small>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <p style="font-size: 14px;font-weight:700; ">Subtotal</p>
                        </label>
                        <div class="col-sm-4">
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="subTotal">@currency($totalPrice)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h5>Order Summary</h5>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <p style="font-size: 14px;font-weight:700; ">Subtotal</p>
                        </label>
                        <div class="col-sm-4">
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="subTotal">@currency($totalPrice)</p>
                        </div>
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <p style="font-size: 14px;font-weight:700; ">Shipping Cost</p>
                        </label>
                        <div class="col-sm-4">
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="shipping">@currency($price)</p>
                        </div>
                    </div>
                    <hr style="height:5px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <h4>Total Price</h4>
                        </label>
                        <div class="col-sm-4">
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="finalPrice">@currency($totalPrice)</p>
                        </div>
                    </div>
                    <form action="{{ route('order.post') }}" method="POST" enctype="multipart/form-data" class="row gy-1 gx-2 mt-75" id="bidForm">
                    @csrf
                        <input type="hidden" name="shipId" id="selectedShipId" value="">
                        <input type="hidden" name="ongkirfee" value=>
                        <input type="hidden" name="weight" value={{ $weight }}>
                        <input type="hidden" name="totalPrice" value=>
                        <button type="submit" class="btn btn-info w-100">Create Order</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modal Add Address --}}
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
                                <select class="form-select" id="select-regencies" name="regency">
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

{{-- Modal Select Address --}}
<div class="modal fade" id="modalSelAddress" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-wide" style="max-width: 750px">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="addNewCardTitle">Select Address</h1>
                <!-- form -->
                @foreach ($profile as $p)
                    <div class="col-md-12 mt-1">
                        <div class="card border border-3">
                            <div class="card-body col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p style="font-weight: 600;">{{ $p->firstname }} {{ $p->lastname }}</p>
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            currencyDisplay: 'symbol'
        }).format(amount);
    }
    function updateShippingCost() {
        var selectedRadioButton = document.querySelector('input[name="ship"]:checked');
        if (selectedRadioButton) {
            var shippingOptionId = selectedRadioButton.value;
            var price;
            var distanceValue = {{ $distanceValue }};
            var selectedShipIdInput = document.getElementById('selectedShipId');
            var ongkirFeeInput = document.querySelector('input[name="ongkirfee"]');
            var finalPriceInput = document.querySelector('input[name="totalPrice"]');
            var totalPrice = {{ $totalPrice }};
            var formattedPrice = 0;

            if (distanceValue > 100.0) {
                if (shippingOptionId === "1") {
                    price = {{ ($distanceValue * 50) + ($weight * 4000) }};
                } else if (shippingOptionId === "2") {
                    price = {{ ($distanceValue * 20) + ($weight * 4000) }};
                }
            } else {
                if (shippingOptionId === "1") {
                    price = {{ ($distanceValue * 800) + ($weight * 4000) }};
                } else if (shippingOptionId === "2") {
                    price = {{ ($distanceValue * 500) + ($weight * 4000) }};
                }
            }

            price = parseFloat(price);
            var previousOngkir = parseFloat(ongkirFeeInput.value);
            var finalPrice = parseFloat(totalPrice) + price;

            ongkirFeeInput.value = price;
            selectedShipIdInput.value = shippingOptionId;
            finalPriceInput.value = finalPrice;

            formattedPrice = formatCurrency(price);
            document.getElementById("shipping").innerText = formattedPrice;

            finalPrice = parseFloat(finalPrice);
            var formattedFinalPrice = formatCurrency(finalPrice);
            document.getElementById("finalPrice").innerText = formattedFinalPrice;
        }
    }

    var radioButtons = document.querySelectorAll('input[name="ship"]');
    radioButtons.forEach(function(radioButton) {
        radioButton.addEventListener('change', updateShippingCost);
    });

    updateShippingCost();
</script>

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
