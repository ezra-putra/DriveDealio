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

                <div class="row match-height">
                    <!-- Timeline Card -->
                    <div class="col-lg-4 col-12">
                        <div class="card card-user-timeline">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <i data-feather="list" class="user-timeline-title-icon"></i>
                                    <h4 class="card-title">User Timeline</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="timeline ms-50">
                                    <li class="timeline-item">
                                        <span class="timeline-point timeline-point-indicator"></span>
                                        <div class="timeline-event">
                                            <h6>12 Invoices have been paid</h6>
                                            <p>Invoices are paid to the company</p>
                                            <div class="d-flex align-items-center">
                                                <img class="me-1" src="../../../app-assets/images/icons/json.png"
                                                    alt="data.json" height="23" />
                                                <h6 class="more-info mb-0">data.json</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span
                                            class="timeline-point timeline-point-warning timeline-point-indicator"></span>
                                        <div class="timeline-event">
                                            <h6>Client Meeting</h6>
                                            <p>Project meeting with Carl</p>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar me-50">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg"
                                                        alt="Avatar" width="38" height="38" />
                                                </div>
                                                <div class="more-info">
                                                    <h6 class="mb-0">Carl Roy (Client)</h6>
                                                    <p class="mb-0">CEO of Infibeam</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span class="timeline-point timeline-point-info timeline-point-indicator"></span>
                                        <div class="timeline-event">
                                            <h6>Create a new project</h6>
                                            <p>Add files to new design folder</p>
                                            <div class="avatar-group">
                                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="bottom" title="Billy Hopkins"
                                                    class="avatar pull-up">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg"
                                                        alt="Avatar" width="33" height="33" />
                                                </div>
                                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="bottom" title="Amy Carson" class="avatar pull-up">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg"
                                                        alt="Avatar" width="33" height="33" />
                                                </div>
                                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="bottom" title="Brandon Miles"
                                                    class="avatar pull-up">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg"
                                                        alt="Avatar" width="33" height="33" />
                                                </div>
                                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="bottom" title="Daisy Weber"
                                                    class="avatar pull-up">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg"
                                                        alt="Avatar" width="33" height="33" />
                                                </div>
                                                <div data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="bottom" title="Jenny Looper"
                                                    class="avatar pull-up">
                                                    <img src="../../../app-assets/images/portrait/small/avatar-s-20.jpg"
                                                        alt="Avatar" width="33" height="33" />
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="timeline-item">
                                        <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
                                        <div class="timeline-event">
                                            <h6>Update project for client</h6>
                                            <p class="mb-0">Update files as per new design</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--/ Timeline Card -->

                    <!-- Sales Stats Chart Card starts -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-start pb-1">
                                <div>
                                    <h4 class="card-title mb-25">Sales</h4>
                                    <p class="card-text">Last 6 months</p>
                                </div>
                                <div class="dropdown chart-dropdown">
                                    <i data-feather="more-vertical" class="font-medium-3 cursor-pointer"
                                        data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Last 28 Days</a>
                                        <a class="dropdown-item" href="#">Last Month</a>
                                        <a class="dropdown-item" href="#">Last Year</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-inline-block me-1">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="circle" class="font-small-3 text-primary me-50"></i>
                                        <h6 class="mb-0">Sales</h6>
                                    </div>
                                </div>
                                <div class="d-inline-block">
                                    <div class="d-flex align-items-center">
                                        <i data-feather="circle" class="font-small-3 text-info me-50"></i>
                                        <h6 class="mb-0">Visits</h6>
                                    </div>
                                </div>
                                <div id="sales-visit-chart" class="mt-50"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Sales Stats Chart Card ends -->

                    <!-- App Design Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-app-design">
                            <div class="card-body">
                                <span class="badge badge-light-primary">03 Sep, 20</span>
                                <h4 class="card-title mt-1 mb-75 pt-25">App design</h4>
                                <p class="card-text font-small-2 mb-2">
                                    You can Find Only Post and Quotes Related to IOS like ipad app design, iphone app design
                                </p>
                                <div class="design-group mb-2 pt-50">
                                    <h6 class="section-label">Team</h6>
                                    <span class="badge badge-light-warning me-1">Figma</span>
                                    <span class="badge badge-light-primary">Wireframe</span>
                                </div>
                                <div class="design-group pt-25">
                                    <h6 class="section-label">Members</h6>
                                    <div class="avatar">
                                        <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg" width="34"
                                            height="34" alt="Avatar" />
                                    </div>
                                    <div class="avatar bg-light-danger">
                                        <div class="avatar-content">PI</div>
                                    </div>
                                    <div class="avatar">
                                        <img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg"
                                            width="34" height="34" alt="Avatar" />
                                    </div>
                                    <div class="avatar">
                                        <img src="../../../app-assets/images/portrait/small/avatar-s-7.jpg" width="34"
                                            height="34" alt="Avatar" />
                                    </div>
                                    <div class="avatar bg-light-secondary">
                                        <div class="avatar-content">AL</div>
                                    </div>
                                </div>
                                <div class="design-planning-wrapper mb-2 py-75">
                                    <div class="design-planning">
                                        <p class="card-text mb-25">Due Date</p>
                                        <h6 class="mb-0">12 Apr, 21</h6>
                                    </div>
                                    <div class="design-planning">
                                        <p class="card-text mb-25">Budget</p>
                                        <h6 class="mb-0">$49251.91</h6>
                                    </div>
                                    <div class="design-planning">
                                        <p class="card-text mb-25">Cost</p>
                                        <h6 class="mb-0">$840.99</h6>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary w-100">Join Team</button>
                            </div>
                        </div>
                    </div>
                    <!--/ App Design Card -->
                </div>

                <!-- List DataTable -->
                <div class="row">
                    <div class="col-12">
                        <div class="card invoice-list-wrapper">
                            <div class="card-datatable table-responsive">
                                <table class="invoice-list-table table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>#</th>
                                            <th><i data-feather="trending-up"></i></th>
                                            <th>Client</th>
                                            <th>Total</th>
                                            <th class="text-truncate">Issued Date</th>
                                            <th>Balance</th>
                                            <th>Invoice Status</th>
                                            <th class="cell-fit">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ List DataTable -->
            </section>
            <!-- Dashboard Analytics end -->

        </div>
    </div>
@endsection
