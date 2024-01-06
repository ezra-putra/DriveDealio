@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">
    <h3>Cart</h3>
    <div class="row">
        <div class="col-md-8">
            @if(count($cart) > 0)
                @foreach ($cart as $c)
                <div class="card ecommerce-card">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="item-img">
                                <a href="#">
                                    <img src="../../../app-assets/images/pages/eCommerce/1.png" alt="img-placeholder" />
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card-body">
                                <div class="item-name mb-1">
                                    <h5 class="mb-0"><a href="#" class="text-body">{{ $c->partnumber }} - {{ $c->partname }} {{ $c->vehiclemodel }}</a></h5>
                                    <span class="item-company">By <a href="#" class="company-name">{{ $c->sellername }}</a></span>
                                </div>
                                @if ($c->stock > 3)
                                    <span class="text-success mb-1">In Stock: {{ $c->stock }}</span>
                                @else
                                    <span class="text-danger mb-1">In Stock: {{ $c->stock }}</span>
                                @endif

                                <div class="item-quantity mt-1">
                                    <span class="quantity-title">Quantity:</span>
                                    <br>
                                    <button class="btn btn-icon btn-flat-danger" type="button" id="decrement-btn">-</button>
                                    <input type="text" style="text-align: center; border:none;" name="quantity" class="quantity-counter" value="{{ $c->quantity }}" />
                                    @if ($c->quantity == $c->stock)
                                        <button class="btn btn-icon btn-flat-success" type="button" id="increment-btn" disabled>+</button>
                                    @else
                                        <button class="btn btn-icon btn-flat-success" type="button" id="increment-btn">+</button>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 text-center">
                            <div class="item-cost">
                                <h5 class="item-price">@currency($c->total_price)</h5>
                                <p class="card-text shipping">
                                    <span class="badge rounded-pill badge-light-success">Free Shipping</span>
                                </p>
                            </div>
                            <button type="button" class="btn btn-danger mt-1 remove-wishlist">
                                <i data-feather="x" class="align-middle me-25"></i>
                                <span>Remove</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-center">NO ITEMS IN CART</p>
            @endif
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h4>Order Summary</h4>
                    <hr style="height:2px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <p style="font-size: 14px;">Subtotal</p>
                        </label>
                        <div class="col-sm-3">
                            <p style="font-size: 14px;" class="mt-1" id="subTotal">@currency(0)</p>
                        </div>

                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <p style="font-size: 14px;">Discount Total</p>
                        </label>
                        <div class="col-sm-3">
                            <p style="font-size: 14px;" class="mt-1" id="discount">@currency(0)</p>
                        </div>
                    </div>
                    <hr style="height:2px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Total Price</p>
                        </label>
                        <div class="col-sm-3">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1" id="totalPrice">@currency(0)</p>
                        </div>
                    </div>
                    <a href="/checkout" class="btn btn-primary w-100">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('increment-btn').addEventListener('click', function () {
        incrementQuantity();
    });

    document.getElementById('decrement-btn').addEventListener('click', function () {
        decrementQuantity();
    });

    function incrementQuantity() {
        var quantityInput = document.querySelector('input[name="quantity"]');
        quantityInput.value = parseInt(quantityInput.value) + 1;
    }

    function decrementQuantity() {
        var quantityInput = document.querySelector('input[name="quantity"]');
        var newQuantity = parseInt(quantityInput.value) - 1;
        quantityInput.value = newQuantity > 0 ? newQuantity : 1;
    }
</script>
@endsection
