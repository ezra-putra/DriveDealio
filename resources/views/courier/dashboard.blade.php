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
                                    <h1 class="mb-1 text-white">Welcome {{ auth()->user()->firstname }},</h1>
                                    <p class="card-text m-auto w-75">
                                        You have done <strong>57.6%</strong> more sales today. Check your new badge in your
                                        profile.
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
                                        <i data-feather="users" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder mt-1">92.6k</h2>
                                <p class="card-text">Subscribers Gained</p>
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
                                        <i data-feather="package" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bolder mt-1">38.4K</h2>
                                <p class="card-text">Orders Received</p>
                            </div>
                            <div id="order-chart"></div>
                        </div>
                    </div>
                    <!-- Orders Chart Card ends -->
                </div>
                <div class="row match-height">
                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <h4 class="card-title">Sparepart Shipping List</h4>
                                <div class="justify-items-end">
                                    <a class="btn btn-flat-primary p-50" href="/inspector/listvehicle">See All</a>
                                </div>
                            </div>
                            <div class="table-responsive mb-1">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Service Type</th>
                                            <th scope="col">Origin</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1
                                        @endphp
                                        @foreach ($shipping as $s)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $s->packagename }}</td>
                                            <td>{{ $s->origin }}</td>
                                            <td>{{ $s->destination }}</td>
                                            <td>
                                                <a href="{{ url('/shipping-details', $s->idshipping) }}" class="btn btn-flat-info">
                                                    <span>Details</span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                </table>
                            </div>
                            @if(empty($shipping))
                                <p class="text-center">NO DATA</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <h4 class="card-title">Vehicle Towing List</h4>
                                <div class="justify-items-end">
                                    <a class="btn btn-flat-primary p-50" href="/inspector/listvehicle">See All</a>
                                </div>
                            </div>
                            <div class="table-responsive mb-1">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Service Type</th>
                                            <th scope="col">Origin</th>
                                            <th scope="col">Destination</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1
                                        @endphp
                                        @foreach ($towing as $t)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $t->name }}</td>
                                            <td>{{ $t->origin }}</td>
                                            <td>{{ $t->destination }}</td>
                                            <td>
                                                <a href="{{ url('/towing-details', $t->idtowing) }}" class="btn btn-flat-info">
                                                    <span>Details</span>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                </table>
                            </div>
                            @if(empty($towing))
                                <p class="text-center">NO DATA</p>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
