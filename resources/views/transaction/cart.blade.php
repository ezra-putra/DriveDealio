@extends('layout.main')
@section('content')
    <div class="col-md-12" style="padding: 3vh;">
        <h3>Cart</h3>
        <div class="row">
            <div class="col-md-8">
                <div class="card ecommerce-card">
                    @if (count($cartItems) > 0)
                        @foreach ($cartItems as $c)
                            <div class="card-body col-md-12" style="position: sticky; top: 0;">
                                <div class="d-flex align-items-center ">
                                    <div class="row">
                                        <div class="col-md-2 mx-0.5">
                                            <div class="item-img">
                                                <a href="#">
                                                    <img src="{{ asset('/images/' . $c->url) }}" alt="img-placeholder"
                                                        style="width: 150px; height: auto;" />
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="card-body">
                                                <div class="item-name mb-1">
                                                    <h5 class="mb-0"><a href="#"
                                                            class="text-body">{{ $c->partnumber }}
                                                            - {{ $c->partname }}
                                                            {{ $c->vehiclemodel }}</a></h5>
                                                    <span class="item-company">By <a href="#"
                                                            class="company-name">{{ $c->sellername }}</a></span>
                                                </div>
                                                @if ($c->stock > 3)
                                                    <span class="text-success">In Stock: {{ $c->stock }}</span>
                                                @else
                                                    <span class="text-danger">In Stock: {{ $c->stock }}</span>
                                                @endif
                                                <div class="d-flex align-items-center">
                                                    <span class="quantity-title me-2">Quantity:</span>

                                                    <form action="{{ route('decrement.quantity', $c->idsparepart) }}" method="POST" class="me-2">
                                                        @csrf
                                                        <button type="submit" class="btn btn-icon btn-flat-danger" id="decrement-btn">-</button>
                                                    </form>

                                                    <input type="number" style="text-align: center; border:none; width:20px;" name="quantity" class="quantity-counter me-2" value="{{ $c->quantity }}">

                                                    <form action="{{ route('increment.quantity', $c->idsparepart) }}" method="POST" class="me-2">
                                                        @csrf
                                                        <button type="submit" class="btn btn-icon btn-flat-success" id="increment-btn">+</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-2 text-center">
                                            <div class="row">
                                                <div class="item-cost">
                                                    <h5 class="item-price">@currency($c->total_price)</h5>
                                                    <p class="card-text shipping">
                                                        <span class="badge rounded-pill badge-light-success">Free
                                                            Shipping</span>
                                                    </p>
                                                </div>
                                                <form action="{{ route('cart.destroy', $c->idcart) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger mt-1 remove-wishlist">
                                                        <i data-feather="x" class="align-middle me-25"></i>
                                                        <span>Remove</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center mt-1">NO ITEMS IN CART</p>
                    @endif
                </div>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body col-md-12" style="position: sticky; top: 0;">
                        <h4>Order Summary</h4>
                        <hr style="height:2px;border-width:0;color:gray;background-color:lightgray">
                        <div class="row">
                            <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                <p style="font-size: 14px;">Subtotal</p>
                            </label>
                            <div class="col-sm-5">
                                @php
                                    $subTotal = 0;
                                    $totalPrice = 0;
                                @endphp
                                @foreach ($cartItems as $c)
                                    @php
                                        $subTotal = $c->unitprice * $c->quantity;
                                        $totalPrice += $subTotal;
                                    @endphp
                                    <p style="font-size: 14px;" class="mt-1" id="subTotal">@currency($subTotal)</p>
                                @endforeach
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:lightgray">
                        <div class="row">
                            <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                <p style="font-size: 14px; font-weight: bold">Total Price</p>
                            </label>
                            <div class="col-sm-5">
                                <p style="font-size: 14px; font-weight: bold" class="mt-1" id="totalPrice">
                                    @currency($totalPrice)</p>
                            </div>
                        </div>
                        <a href="/checkout" class="btn btn-primary w-100">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('increment-btn').addEventListener('click', function() {
            incrementQuantity();
        });

        document.getElementById('decrement-btn').addEventListener('click', function() {
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
