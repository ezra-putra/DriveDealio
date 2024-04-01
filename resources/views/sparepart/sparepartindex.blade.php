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
                        @foreach ($sparepart as $s)
                            <div class="card ecommerce-card">
                                <div class="item-img mt-1" style="justify-content: center;">
                                    <a href="{{ route('sparepart.show', $s->idsparepart) }}">
                                        <img class="card-img-top" src="{{ asset('images/sparepart/'.$s->idsparepart.'/' .$s->url) }}" alt="Card image cap" style="height : 320px; width:auto; object-fit:fill;"/>
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
                                <div class="item-options text-center mb-1 w-100" style="justify-content: center;">
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
                                <!-- Brands starts -->
                                <div class="brands">
                                    <h6 class="filter-title">Categories</h6>
                                    <ul class="list-unstyled brand-list">
                                        @foreach ($categories as $c)
                                        <li>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="productBrand-{{ $c->id }}" />
                                                <label class="form-check-label" for="productBrand1">{{ $c->categoriname }}</label>
                                            </div>
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
@endsection
