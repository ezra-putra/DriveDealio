@extends('layout.main')
@section('content')
<h3>Details</h3>
<div class="col-md-12 mx-auto" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-4">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    @foreach($sparepart as $s => $image)
                        <div class="carousel-item {{ $s == 0 ? 'active' : '' }}">
                            <img src="{{ asset('/images/' . $image->url) }}" class="d-block w-100" alt="Slide {{ $s + 1 }}">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body col-md-12">
                    <h3>{{ $sparepart[0]->partnumber }} - {{ $sparepart[0]->partname }} {{ $sparepart[0]->model }}</h3>
                    <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 py-auto">
                        <p style="font-size: 14px; font-weight: 900;">Item Sold 0</p>
                    </div>
                    <h1 class="mb-2">@currency($sparepart[0]->unitprice)</h1>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <h5 class="mb-1">Description</h5>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <p>
                        {{ $sparepart[0]->description }}
                    </p>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('seller.profile', $sparepart[0]->idshop) }}" aria-expanded="false" class="d-flex align-items-center text-decoration-none">
                            <span class="avatar me-1">
                                <img src="../../../app-assets/images/portrait/small/avatar-s-3.jpg" class="round" height="40" width="40" style="object-fit: cover">
                            </span>
                            <div class="user-info">
                                <div class="user-nav d-flex d-sm-inline-flex">
                                    <span class="user-name fw-bolder" style="font-size: 16px">{{ $sparepart[0]->name }}</span>
                                </div>
                                <div class="user-location">
                                    <span class="user-name" style="font-size: 12px">{{ $sparepart[0]->province }}, {{ $sparepart[0]->city }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <h4>Shipping</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border border-2">
                <div class="card-body col-md-12">
                    <h3>Set quantity</h3>
                    @if ($sparepart[0]->stock >= 5)
                            <span class="text-success">In Stock: {{ $sparepart[0]->stock }}</span>
                        @else
                            <span class="text-danger">In Stock: {{ $sparepart[0]->stock }}</span>
                        @endif

                    <div class="d-flex align-items-center mt-1">

                        <span class="quantity-title me-2">Quantity:</span>

                        <button class="btn btn-icon btn-flat-danger me-2" id="decrement-btn">-</button>

                        <input type="number" id="quantity" style="text-align: center; border: none; width: 20px;" name="quantity" class="quantity-counter me-2" value="1" max="{{ $sparepart[0]->stock }}"
                        oninput="updateQuantityLimit(this)">

                        <button class="btn btn-icon btn-flat-success me-2" id="increment-btn">+</button>

                    </div>
                    <div class="row mt-2">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Total Price</p>
                        </label>
                        <div class="col-sm-5">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1" id="totalPrice">
                                @currency($sparepart[0]->unitprice)</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('details.addcart', $sparepart[0]->idsparepart) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="quantity" id="finalQuantity" value="1">
                        <button type="submit" class="btn btn-info w-100 my-1">Add to Cart</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <h4 class="mb-2">User Review</h4>
                <h1 class="mb-1" style="font-size: 40px">4/5.0</h1>
            </div>
        </div>
        <div class="col-md-5">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                    <div>
                        <h5 class="mb-0">Review</h5>
                        <p class="mb-0">Displaying 10 of 192 reviews</p>
                    </div>
                    <div class="dropdown mt-2 mt-sm-0">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            Order By
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="#">Newest</a></li>
                            <li><a class="dropdown-item" href="#">Highest Rating</a></li>
                            <li><a class="dropdown-item" href="#">Lowest Rating</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-1">
                    <h4>Rating</h4>
                    <div class="d-flex align-items-center my-1">
                        <a href="#" aria-expanded="false" class="d-flex align-items-center text-decoration-none">
                            <span class="avatar me-2">
                                <img src="" alt="" class="round" alt="avatar" height="40" width="40" style="object-fit: cover">
                            </span>
                            <div class="user-nav d-flex d-sm-inline-flex ms-1">
                                <span class="user-name fw-bolder">Nama Reviewer</span>
                            </div>
                        </a>
                    </div>
                    <p>Mantabbb</p>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                </div>
            </div>
        </div>
    </div>
    <hr style="height:3px;border-width:0;color:gray;background-color:lightgray">
    <div class="card-body">
        <div class="mt-4 mb-2 text-center">
            <h4>Related Products</h4>
            <p class="card-text">People also search for this items</p>
        </div>
        <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="#">
                        <div class="item-heading">
                            <h5 class="text-truncate mb-0">Apple Watch Series 6</h5>
                            <small class="text-body">by Apple</small>
                        </div>
                        <div class="img-container w-50 mx-auto py-75">
                            <img src="../../../app-assets/images/elements/apple-watch.png"
                                class="img-fluid" alt="image" />
                        </div>
                        <div class="item-meta">
                            <ul class="unstyled-list list-inline mb-25">
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="unfilled-star"></i></li>
                            </ul>
                            <p class="card-text text-primary mb-0">$399.98</p>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#">
                        <div class="item-heading">
                            <h5 class="text-truncate mb-0">Apple MacBook Pro - Silver</h5>
                            <small class="text-body">by Apple</small>
                        </div>
                        <div class="img-container w-50 mx-auto py-50">
                            <img src="../../../app-assets/images/elements/macbook-pro.png"
                                class="img-fluid" alt="image" />
                        </div>
                        <div class="item-meta">
                            <ul class="unstyled-list list-inline mb-25">
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="unfilled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="unfilled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="unfilled-star"></i></li>
                            </ul>
                            <p class="card-text text-primary mb-0">$2449.49</p>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#">
                        <div class="item-heading">
                            <h5 class="text-truncate mb-0">Apple HomePod (Space Grey)</h5>
                            <small class="text-body">by Apple</small>
                        </div>
                        <div class="img-container w-50 mx-auto py-75">
                            <img src="../../../app-assets/images/elements/homepod.png"
                                class="img-fluid" alt="image" />
                        </div>
                        <div class="item-meta">
                            <ul class="unstyled-list list-inline mb-25">
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="unfilled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="unfilled-star"></i></li>
                            </ul>
                            <p class="card-text text-primary mb-0">$229.29</p>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#">
                        <div class="item-heading">
                            <h5 class="text-truncate mb-0">Magic Mouse 2 - Black</h5>
                            <small class="text-body">by Apple</small>
                        </div>
                        <div class="img-container w-50 mx-auto py-75">
                            <img src="../../../app-assets/images/elements/magic-mouse.png"
                                class="img-fluid" alt="image" />
                        </div>
                        <div class="item-meta">
                            <ul class="unstyled-list list-inline mb-25">
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                            </ul>
                            <p class="card-text text-primary mb-0">$90.98</p>
                        </div>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#">
                        <div class="item-heading">
                            <h5 class="text-truncate mb-0">iPhone 12 Pro</h5>
                            <small class="text-body">by Apple</small>
                        </div>
                        <div class="img-container w-50 mx-auto py-75">
                            <img src="../../../app-assets/images/elements/iphone-x.png"
                                class="img-fluid" alt="image" />
                        </div>
                        <div class="item-meta">
                            <ul class="unstyled-list list-inline mb-25">
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="filled-star"></i></li>
                                <li class="ratings-list-item"><i data-feather="star"
                                        class="unfilled-star"></i></li>
                            </ul>
                            <p class="card-text text-primary mb-0">$1559.99</p>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

</div>

<div class="modal fade" id="alertMaxQuantity" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="body">
                <p>You have reach the maximum amount.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">Close</button>
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
        var quantityInput = document.getElementById('quantity');
        var stock = parseInt(quantityInput.getAttribute('max'));
        var newQuantity = parseInt(quantityInput.value)
        if(newQuantity >= stock)
        {
            var modalInfoCart = new bootstrap.Modal(document.getElementById('alertMaxQuantity'));
            modalInfoCart.show();
        }
        else{
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updateQuantity(quantityInput);
        }

    }

    function decrementQuantity() {
        var quantityInput = document.querySelector('input[name="quantity"]');
        var newQuantity = parseInt(quantityInput.value) - 1;
        quantityInput.value = newQuantity > 0 ? newQuantity : 1;
        updateQuantity(quantityInput);
    }

    function updateQuantityLimit(input)
    {
        var stock = parseInt(input.getAttribute('max'));
        var currentQuantity = parseInt(input.value);

        if (currentQuantity > stock) {
            input.value = stock;
        }
    }

    function updateQuantity(input) {
        var quantityValue = input.value;
        document.getElementById('finalQuantity').value = quantityValue;
    }
</script>
@endsection
