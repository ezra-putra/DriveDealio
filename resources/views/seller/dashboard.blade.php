@extends('layout/main')
@section('content')
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                <div class="row match-height">
                    <!-- Greetings Card starts -->
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="card card-congratulations">
                            <div class="card-body text-center">
                                <img src="../../../app-assets/images/elements/decore-left.png"
                                    class="congratulations-img-left" alt="card-img-left" />
                                <img src="../../../app-assets/images/elements/decore-right.png"
                                    class="congratulations-img-right" alt="card-img-right" />
                                <div class="avatar avatar-xl bg-primary shadow">
                                    <div class="avatar-content">
                                        <i data-feather="award" class="font-large-1"></i>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h1 class="mb-1 text-white">Welcome
                                        <a href="{{ route('seller.profile', $shopname[0]->id) }}" aria-expanded="false" class="text-decoration-none text-white">
                                            <span class="user-name">{{ $shopname[0]->name }}</span>
                                        </a>
                                    </h1>
                                    <p class="card-text m-auto w-75">
                                        You have <strong>{{ $ordercount[0]->totalorder }}</strong> total order today.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Greetings Card ends -->
                    <!-- Subscribers Chart Card starts -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header flex-column align-items-start pb-0">
                                <div class="avatar bg-light-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <i data-feather="package" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder mt-1">{{ $sparepartcount[0]->totalitem }}</h2>
                                <p class="card-text">Total Product</p>
                            </div>
                            <div id="gained-chart"></div>
                        </div>
                    </div>
                    <!-- Subscribers Chart Card ends -->

                    <!-- Orders Chart Card starts -->
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header flex-column align-items-start pb-0">
                                <div class="avatar bg-light-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <i data-feather="file-text" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder mt-1">{{ $totalorder[0]->totalorder }}</h2>
                                <p class="card-text">Orders Received</p>
                            </div>
                            <div id="order-chart"></div>
                        </div>
                    </div>
                    <!-- Orders Chart Card ends -->
                </div>
                <a href="{{ route('seller.profile', $shopname[0]->id) }}" class="btn btn-outline-secondary d-flex justify-content-between align-items-center w-100 mb-1">
                    <span class="text-start">To Seller Profile</span>
                    <i data-feather="chevron-right"></i>
                </a>
                <div class="row match-height">
                    <div class="col-lg-7 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between pb-0 mb-1">
                                <h4 class="card-title">Order Lists</h4>
                                <div class="justify-items-end">
                                    <a class="btn btn-flat-primary p-50" href="/orderlist">See All</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Invoice</th>
                                            <th scope="col">Buyer Name</th>
                                            <th scope="col">Order Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1
                                        @endphp
                                        @foreach ($orderlist as $ol)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $ol->invoicenum }}</td>
                                            <td>{{ $ol->firstname }}</td>
                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s.u', $ol->orderdate)->format('d M Y') }}</td>
                                            <td>{{ $ol->status }}</td>
                                        </tr>
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between pb-0 mb-1">
                                <h4 class="card-title">Sparepart List</h4>
                                <div class="justify-items-end">
                                    <a class="btn btn-flat-primary p-50" href="/seller/listsparepart">See All</a>
                                </div>
                            </div>
                            <div class="table-responsive mb-1">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Part Name</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1
                                        @endphp
                                        @foreach ($sparepart as $s)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $s->partnumber }} - {{ $s->partname }} {{ $s->vehiclemodel }} {{ $s->buildyear }}, {{ $s->colour }}</td>
                                            <td>{{ $s->stock }}</td>
                                            <td>@currency($s->unitprice)</td>
                                        </tr>
                                        @endforeach

                                </table>
                            </div>
                            @if(empty($sparepart))
                                <p class="text-center">NO DATA</p>
                            @endif
                        </div>
                    </div>

                </div>
            </section>
            <!-- Dashboard Analytics end -->
        </div>
    </div>
@endsection
