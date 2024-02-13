@extends('layout.main')
@section('content')
    <div class="ecommerce-application">
        <div class="content-wrapper container-xxl p-0">
            <div class="content-detached content-right">
                <div class="content-body">
                    <!-- E-commerce Content Section Starts -->
                    <section id="ecommerce-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="ecommerce-header-items">
                                    <div class="result-toggler">
                                        <button class="navbar-toggler shop-sidebar-toggler" type="button"
                                            data-bs-toggle="collapse">
                                            <span class="navbar-toggler-icon d-block d-lg-none"><i
                                                    data-feather="menu"></i></span>
                                        </button>
                                        <div class="search-results"> results found</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- E-commerce Content Section Starts -->

                    <!-- background Overlay when sidebar is shown  starts-->
                    <div class="body-content-overlay"></div>
                    <!-- background Overlay when sidebar is shown  ends-->


                    <!-- E-commerce Products Starts -->
                    <section id="ecommerce-products" class="grid-view">
                        @foreach ($vehicle as $v)
                            <div class="card ecommerce-card">
                                <div class="item-img" style="justify-content: center;">
                                    <a href="{{ route('vehicle.show', $v->idvehicle) }}">
                                        <img class="card-img-top" src="{{ asset('/images/vehicle/'.$v->idvehicle.'/' . $v->url) }}" alt="Card image cap" style="height : 300px; width:auto; object-fit:fill;"/>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h5 class="item-name mb-1">
                                        <a class="text-body" href="{{ route('vehicle.show', $v->idvehicle) }}">{{ $v->brand }} - {{ $v->model }}
                                            {{ $v->variant }}</a>
                                    </h5>
                                    <div class="item-wrapper d-block">
                                        <div class="item-cost mb-1">
                                            <h6 class="item-price">@currency($v->price)</h6>
                                        </div>
                                        <p>Lot: #<strong style="color: blue;">{{ $v->lot_number }}</strong></p>
                                        <p id="countdown_{{ $v->idauction }}">Time Remaining: {{ $vehicle[0]->duration }}</p>
                                    </div>
                                    <a href="{{ route('vehicle.show', $v->idvehicle) }}" class="btn btn-flat-info w-100">View Details</a>
                                </div>
                            </div>
                        @endforeach
                    </section>
                    <!-- E-commerce Products Ends -->

                    <!-- E-commerce Pagination Starts -->
                    <section id="ecommerce-pagination">
                        <div class="row">
                            <div class="col-sm-12">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center mt-2">
                                        <li class="page-item prev-item"><a class="page-link" href="#"></a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item" aria-current="page"><a class="page-link"
                                                href="#">4</a></li>
                                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item"><a class="page-link" href="#">7</a></li>
                                        <li class="page-item next-item"><a class="page-link" href="#"></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </section>
                    <!-- E-commerce Pagination Ends -->

                </div>
            </div>
            <div class="sidebar-detached sidebar-left">
                <div class="sidebar">
                    <!-- Ecommerce Sidebar Starts -->
                    <div class="sidebar-shop">
                        <div class="row">
                            <div class="col-sm-12">
                                <h6 class="filter-heading d-none d-lg-block">Filters</h6>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <!-- Price Filter starts -->
                                <div class="multi-range-price">
                                    <h6 class="filter-title mt-0">Multi Range</h6>
                                    <ul class="list-unstyled price-range" id="price-range">
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceAll" name="price-range"
                                                    class="form-check-input" checked />
                                                <label class="form-check-label" for="priceAll">All</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceRange1" name="price-range"
                                                    class="form-check-input" />
                                                <label class="form-check-label" for="priceRange1">&lt;=$10</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceRange2" name="price-range"
                                                    class="form-check-input" />
                                                <label class="form-check-label" for="priceRange2">$10 - $100</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceARange3" name="price-range"
                                                    class="form-check-input" />
                                                <label class="form-check-label" for="priceARange3">$100 - $500</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="priceRange4" name="price-range"
                                                    class="form-check-input" />
                                                <label class="form-check-label" for="priceRange4">&gt;= $500</label>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Price Filter ends -->

                                <!-- Price Slider starts -->
                                <div class="price-slider">
                                    <h6 class="filter-title">Price Range</h6>
                                    <div class="price-slider">
                                        <div class="range-slider mt-2" id="price-slider"></div>
                                    </div>
                                </div>
                                <!-- Price Range ends -->

                                <!-- Categories Starts -->
                                <div id="product-categories">
                                    <h6 class="filter-title">Vehicle Type</h6>
                                    <ul class="list-unstyled categories-list">
                                        @foreach ($type as $t)
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="category1" name="category-filter"
                                                    class="form-check-input" checked />
                                                <label class="form-check-label" for="category1">{{ $t->name }}</label>
                                            </div>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                                <!-- Categories Ends -->

                                <!-- Brands starts -->
                                <div class="brands">
                                    <h6 class="filter-title">Brands</h6>
                                    <ul class="list-unstyled brand-list">
                                        @foreach ($vehicle as $v)
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="productBrand1" />
                                                <label class="form-check-label" for="productBrand1">{{ $v->brand }}</label>
                                            </div>
                                            <span>746</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- Brand ends -->

                                <!-- Clear Filters Starts -->
                                <div id="clear-filters">
                                    <button type="button" class="btn w-100 btn-primary">Clear All Filters</button>
                                </div>
                                <!-- Clear Filters Ends -->
                            </div>
                        </div>
                    </div>
                    <!-- Ecommerce Sidebar Ends -->

                </div>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    @foreach($vehicle as $item)
        var startDate_{{ $item->idauction }} = new Date("{{ $item->start_date }}").getTime();
        var endDate_{{ $item->idauction }} = new Date("{{ $item->end_date }}").getTime();
    @endforeach

    var x = setInterval(function() {
        @foreach($vehicle as $item)
            var now_{{ $item->idauction }} = new Date().getTime();
            var distance_{{ $item->idauction }} = endDate_{{ $item->idauction }} - now_{{ $item->idauction }};
            var days_{{ $item->idauction }} = Math.floor(distance_{{ $item->idauction }} / (1000 * 60 * 60 * 24));
            var hours_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60 * 60)) / (1000 * 60));
            var seconds_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60)) / 1000);
            document.getElementById("countdown_{{ $item->idauction }}").innerHTML = "Time Remaining: "+ days_{{ $item->idauction }} + "d " + hours_{{ $item->idauction }} + "h "
            + minutes_{{ $item->idauction }} + "m " + seconds_{{ $item->idauction }} + "s ";
            if (distance_{{ $item->idauction }} < 0) {
                clearInterval(x);
                document.getElementById("countdown_{{ $item->idauction }}").innerHTML = "Auction Ended";
            }
        @endforeach
    }, 1000);

</script>
@endsection
