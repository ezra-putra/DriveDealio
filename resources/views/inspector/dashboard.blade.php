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
                    <div class="col-lg-12 col-md-12 col-sm-12">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row match-height">
                    <!-- Avg Sessions Chart Card starts -->
                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <h4 class="card-title">Vehicle List</h4>
                                <div class="justify-items-end">
                                    <a class="btn btn-flat-primary p-50" href="/inspector/listvehicle">See All</a>
                                </div>
                            </div>
                            <div class="table-responsive mb-1">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Vehicle Name</th>
                                            <th scope="col">Owner</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1
                                        @endphp
                                        @foreach ($vehicle as $v)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $v->name }}</td>
                                            <td>{{ $v->firstname }}</td>
                                            <td>{{ $v->adstatus }}</td>
                                        </tr>
                                        @endforeach

                                </table>
                            </div>
                            @if(empty($vehicle))
                                <p class="text-center">NO DATA</p>
                            @endif
                        </div>
                    </div>
                    <!-- Avg Sessions Chart Card ends -->

                    <!-- Support Tracker Chart Card starts -->
                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between pb-0">
                                <h4 class="card-title">Appointment Date</h4>
                                <div class="justify-items-end">
                                    <a class="btn btn-flat-primary p-50" href="/appointmentlist">See All</a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $counter = 1
                                        @endphp
                                        @foreach ($appointment as $a)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{ $a->appointmentdate }}</td>
                                            <td>{{ $a->appointmenttime }}</td>
                                            <td>{{ $a->status }}</td>
                                        </tr>
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Support Tracker Chart Card ends -->
                </div>
            </section>
            <!-- Dashboard Analytics end -->

        </div>
    </div>
@endsection
