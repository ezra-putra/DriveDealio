@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">
    <h3>Checkout</h3>
    <div class="row">
        <div class="col-md-8">
            <div class="card ecommerce-card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h5>Address</h5>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <p style="font-weight: 800">{{ $userinfo->firstname }} {{ $userinfo->lastname }}</p>
                    <p>{{ $userinfo->phonenumber }}</p>
                    <p>{{ $userinfo->address }}</p>
                    <p>{{ $userinfo->district }}, {{ $userinfo->city }}, {{ $userinfo->zipcode }}</p>
                    <hr style="height:5px;border-width:0;color:gray;background-color:lightgray;">
                    <h6>Nama Toko</h6>
                    <p>Asal Kota Toko</p>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="item-img">
                                <a href="#">
                                    <img src="../../../app-assets/images/pages/eCommerce/1.png" alt="img-placeholder" style="width: 170px; height: auto;"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="item-name mb-1">
                                            <h5 class="mb-0"><a href="#" class="text-body">Nama barang</a></h5>
                                            <p class="mb-0">Jumlah Barang</p>
                                            <h6>@currency(0)</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <p class="mb-0">Shipping Duration</p>
                                        <a href="" class="btn btn-info w-100">Select Shipping</a>
                                    </div>
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
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="subTotal">@currency(0)</p>
                        </div>
                    </div>
                    <hr style="height:5px;border-width:0;color:gray;background-color:lightgray">
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <a href="#" class="btn btn-outline-secondary w-100">Discount Voucher</a>
                    <hr style="height:5px;border-width:0;color:gray;background-color:lightgray">
                    <h5>Order Summary</h5>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <p style="font-size: 14px;font-weight:700; ">Subtotal</p>
                        </label>
                        <div class="col-sm-4">
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="subTotal">@currency(0)</p>
                        </div>
                    </div>
                    <hr style="height:5px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <h4>Total Price</h4>
                        </label>
                        <div class="col-sm-4">
                            <p style="font-size: 14px; font-weight:700;" class="mt-1" id="subTotal">@currency(0)</p>
                        </div>
                    </div>
                    <a href="#" class="btn btn-info w-100">Select Payment Method</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
