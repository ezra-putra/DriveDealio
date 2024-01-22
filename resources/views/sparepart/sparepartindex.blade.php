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
                                    <div class="view-options d-flex">
                                        <div class="btn-group dropdown-sort">
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle me-1"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="active-sorting">Featured</span>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Featured</a>
                                                <a class="dropdown-item" href="#">Lowest</a>
                                                <a class="dropdown-item" href="#">Highest</a>
                                            </div>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="radio_options" id="radio_option1"
                                                autocomplete="off" checked />
                                            <label class="btn btn-icon btn-outline-primary view-btn grid-view-btn"
                                                for="radio_option1"><i data-feather="grid"
                                                    class="font-medium-3"></i></label>
                                            <input type="radio" class="btn-check" name="radio_options" id="radio_option2"
                                                autocomplete="off" />
                                            <label class="btn btn-icon btn-outline-primary view-btn list-view-btn"
                                                for="radio_option2"><i data-feather="list"
                                                    class="font-medium-3"></i></label>
                                        </div>
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
                        @foreach ($sparepart as $s)
                            <div class="card ecommerce-card">
                                <div class="item-img" style="justify-content: center;">
                                    <a href="{{ route('sparepart.show', $s->idsparepart) }}">
                                        <img class="card-img-top" src="{{ asset('/images/' . $s->url) }}" alt="Card image cap" style="height : 320px; width:auto; object-fit:fill;"/>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <h5 class="item-name">
                                            <a class="text-body" href="{{ route('sparepart.show', $s->idsparepart) }}">{{ $s->partnumber }} - {{ $s->partname }}
                                                {{ $s->vehiclemodel }}</a>
                                        </h5>
                                        <p></p>
                                        <div class="item-wrapper">
                                            <div class="item-cost">
                                                <h6 class="item-price">@currency($s->unitprice)</h6>
                                            </div>
                                        </div>
                                        <div class="item-wrapper">
                                            <p>{{ $s->city }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-options text-center" style="justify-content: center;">
                                    <form method="POST" action="{{ route('wishlist.post', $s->idsparepart) }}" enctype="multipart/form-data" style="display: inline-block">
                                        @csrf
                                        <button class="btn btn-light w-100">
                                            <i data-feather='heart'></i>
                                            <span class="add-to-cart">Wishlist</span>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('sparepart.addcart', $s->idsparepart) }}" enctype="multipart/form-data" style="display: inline-block">
                                        @csrf
                                        <button class="btn btn-primary w-100">
                                            <i class="fa fa-shopping-cart"></i>
                                            <span class="add-to-cart">Add to Cart</span>
                                        </button>
                                    </form>
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
                                        {{-- @foreach ($vehicle as $v)
                                        <li>
                                            <div class="form-check">
                                                <input type="radio" id="category1" name="category-filter"
                                                    class="form-check-input" checked />
                                                <label class="form-check-label" for="category1">{{ $v->type }}</label>
                                            </div>
                                        </li>
                                        @endforeach --}}

                                    </ul>
                                </div>
                                <!-- Categories Ends -->

                                <!-- Brands starts -->
                                <div class="brands">
                                    <h6 class="filter-title">Brands</h6>
                                    <ul class="list-unstyled brand-list">
                                        {{-- @foreach ($vehicle as $v)
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="productBrand1" />
                                                <label class="form-check-label" for="productBrand1">{{ $v->brand }}</label>
                                            </div>
                                            <span>746</span>
                                        </li>
                                        @endforeach --}}
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
@endsection
