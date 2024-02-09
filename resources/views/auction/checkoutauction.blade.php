@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">
    <h3>Checkout Auction</h3>
    <div class="row">
        <div class="col-md-8">
            <div class="card ecommerce-card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h5>Address</h5>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <p style="font-weight: 800">{{ $userinfo->firstname }} {{ $userinfo->lastname }}</p>
                    <p>{{ $userinfo->phonenumber }}</p>
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
                    <h6>Seller name</h6>
                    <p>City</p>

                    <div class="row">
                        @php
                            $subTotal = 0;
                            $totalPrice = 0;
                            $shippingCost = 1700000;
                        @endphp
                        @foreach ($vehicle as $v)
                        <div class="col-md-2">
                            <div class="item-img">
                                <a href="#">
                                    <img src="" alt="img-placeholder" style="width: 150px; height: auto;"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <div class="col-md-6">
                                    <div class="item-name mb-1">
                                        <h5 class="mb-0"><a href="#" class="text-body">{{ $v->model }}</a></h5>
                                        @php
                                            $subTotal = $v->current_price;
                                            $totalPrice += $subTotal;
                                            $finalPrice = $totalPrice + $shippingCost
                                        @endphp
                                        <p style="font-size: 14px;" class="mt-1 mb-0">@currency($v->current_price)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="col-md-4">
                            <p class="mb-0">Shipping Duration</p>
                            <a href="#modalShipping" data-bs-toggle="modal" class="btn btn-info w-100 btn-ship">Select Shipping</a>
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
                    <hr style="height:5px;border-width:0;color:gray;background-color:lightgray">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h5>Order Summary</h5>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
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
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="subTotal">@currency($shippingCost)</p>
                        </div>
                    </div>
                    <hr style="height:5px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <h4>Total Price</h4>
                        </label>
                        <div class="col-sm-4">
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="subTotal">@currency($finalPrice)</p>
                        </div>
                    </div>
                    <a href="#modalPayment" data-bs-toggle="modal" class="btn btn-info w-100">Select Payment Method</a>
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

{{-- Modal Select Address --}}
<div class="modal fade" id="modalSelAddress" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="addNewCardTitle">Select Address</h1>
                <!-- form -->
                <form action="#" method="POST"
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

{{-- Modal Select Payment --}}
<div class="modal fade" id="modalPayment" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="addNewCardTitle">Select Payment Method</h1>
                <!-- form -->
                <form action="{{ route('auctionorder.post', $vehicle[0]->idvehicle) }}" method="POST"
                    enctype="multipart/form-data" class="row gy-1 gx-2 mt-75" id="bidForm">
                    @csrf
                    <div class="col-12">
                        <label class="form-label" for="select-pay">Payment Method</label>
                            <select class="select2 form-select" id="select-pay" name="payment">
                                <option value="">--Choose Payment Method--</option>
                                <option value="M-Banking">M-Banking</option>
                            </select>
                    </div>
                    <div class="col-12 text-center">
                        <input type="submit" id="submitBid" class="btn btn-primary me-1 mt-1" value="Create Order">
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
<input type="hidden" name="selectedShipping" id="selectedShipping" value="">
<script>
    function selectShipping() {
        var selectedShipping = document.getElementById('shippingOption').value;
        document.getElementById('selectedShipping').value = selectedShipping;
        $('#shippingModal').modal('hide');
    }
</script>


@endsection
