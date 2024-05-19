@extends('layout.main')
@section('content')
<h3>Details</h3>
<div class="col-md-12 mx-auto" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-4">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach($vehicle as $v => $vehi)
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ intval($v) }}" class="{{ $v == 0 ? 'active' : '' }}" aria-label="Slide {{ intval($v) + 1 }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach($vehicle as $v => $vehi)
                        <div class="carousel-item {{ $v == 0 ? 'active' : '' }}">
                            <img src="{{ asset('/images/vehicle/'.$vehi->idvehicle.'/' . $vehi->image) }}" class="d-block w-100" alt="Slide {{ $v + 1 }}">
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
                    <h3>{{ $vehicle[0]->brand }} {{ $vehicle[0]->model }} - {{ $vehicle[0]->variant }}</h3>
                    <h1>@currency($vehicle[0]->price)</h1>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <button class="nav-link active" id="nav-detail-tab" data-bs-toggle="tab" data-bs-target="#nav-detail" type="button" role="tab" aria-controls="nav-detail" aria-selected="true">Vehicle Details</button>
                          <button class="nav-link" id="nav-inspection-tab" data-bs-toggle="tab" data-bs-target="#nav-inspection" type="button" role="tab" aria-controls="nav-inspection" aria-selected="false">Inspection</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Engine type</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->enginecapacity }}cc
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Fuel type</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->fueltype }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Transmission</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->transmission }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Build year</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->year }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Cylinders</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->enginecylinders }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Seats number</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->seatsnumber }} Seats
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Colour</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->colour }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-inspection" role="tabpanel" aria-labelledby="nav-inspection-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Chassis number</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->chassis_number }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Exterior</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $inspection[0]->exterior }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Engine</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $inspection[0]->engine }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Engine number</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $vehicle[0]->engine_number }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Interior</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $inspection[0]->interior }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <p style="font-size: 14px;">Mechanism</p>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                                {{ $inspection[0]->mechanism }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border border-2">
                <div class="card-body col-md-12">
                    <h4>Auction Details</h4>
                    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Time Remaining</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                {{ $vehicle[0]->duration }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Sale Status</p>
                        </label>
                        <div class="col-sm-6">
                            @if ($vehicle[0]->adstatus === 'Auction Ended')
                                    <span class="badge bg-light-danger text-danger mt-1">{{ $vehicle[0]->adstatus }}</span>
                                @else
                                    <span class="badge bg-light-success text-success mt-1">{{ $vehicle[0]->adstatus }}</span>
                                @endif
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Lot Number</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                #{{ $vehicle[0]->lotnumber }}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 14px; font-weight: bold">Current Price</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 14px; font-weight: bold" class="mt-1">
                                @currency($vehicle[0]->current_price)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
    <div class="row">
        <div class="col-md-4">
            <h3>Place Bid</h3>
            @if (auth()->user())
                @if ($vehicle[0]->users_id != auth()->user()->id && auth()->user()->roles_id != 1)
                    @if ($vehicle[0]->adstatus === 'Open to Bid')
                    <form action="{{ route('place_bid', $vehicle[0]->idvehicle) }}" method="POST" enctype="multipart/form-data"
                        class="row gy-1 gx-2 mt-75 mb-1" id="bidForm">
                        @csrf
                        <div class="col-8">
                            <label class="form-label visually-hidden" for="bid-amount">Bid Amount</label>
                            <div class="input-group input-group-merge">
                                <input name="amount" class="form-control" type="text" id="bid-amount" placeholder="Enter Bid Amount" />
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" id="submitBid" class="btn btn-primary me-1">Bid</button>
                        </div>
                    </form>
                    <h6 style="color: red">*Current Price: @currency($vehicle[0]->current_price)</h6>
                    @else
                    <form action="{{ route('place_bid', $vehicle[0]->idvehicle) }}" method="POST" enctype="multipart/form-data"
                        class="row gy-1 gx-2 mt-75 mb-1" id="bidForm" style="display: none;">
                        @csrf
                        <div class="col-8">
                            <label class="form-label visually-hidden" for="bid-amount">Bid Amount</label>
                            <div class="input-group input-group-merge">
                                <input name="amount" class="form-control" type="text" id="bid-amount" placeholder="Enter Bid Amount" />
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <button type="submit" id="submitBid" class="btn btn-primary me-1">Bid</button>
                        </div>
                    </form>
                    <h6 style="color: red">*Current Price: @currency($vehicle[0]->current_price)</h6>
                    @endif
                @endif
            @else
            <form action="{{ route('place_bid', $vehicle[0]->idvehicle) }}" method="POST" enctype="multipart/form-data"
                class="row gy-1 gx-2 mt-75 mb-1" id="bidForm">
                @csrf
                <div class="col-8">
                    <label class="form-label visually-hidden" for="bid-amount">Bid Amount</label>
                    <div class="input-group input-group-merge">
                        <input name="amount" class="form-control" id="bid-amount" type="text" placeholder="Enter Bid Amount" />
                    </div>
                </div>
                <div class="col-4 text-center">
                    <button type="submit" id="submitBid" class="btn btn-primary me-1">Bid</button>
                </div>
            </form>
            <h6 style="color: red">*Current Price: @currency($vehicle[0]->current_price)</h6>
            @endif
        </div>
        <div class="col-md-5">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                    <div>
                        <h5 class="mb-0">Bidding List</h5>
                        <p class="mb-0">10 Bid on this Vehicle</p>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Bid Ammount</th>
                                    <th scope="col">Bid Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 1
                                @endphp
                                @foreach ($bid as $b)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>@currency($b->bidamount)</td>
                                    <td>{{ $b->biddatetime }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(empty($bid))
                        <p class="text-center">NO BID, PLACE BID NOW</p>
                    @endif

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center">
                    <div>
                        <h5 class="mb-0">My Bid</h5>
                        <p class="mb-0">on this Vehicle</p>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Bid Ammount</th>
                                    <th scope="col">Bid Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mybid as $mb)
                                <tr>
                                    <td>@currency($mb->bidamount)</td>
                                    <td>{{ $mb->biddatetime }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(empty($mybid))
                        <p class="text-center">NO BID, PLACE BID NOW</p>
                    @endif

                </div>
            </div>
        </div>
        <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
    </div>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Ambil data start_date dan end_date dari PHP dan konversi ke UTC
        var startDate = new Date("{{ $vehicle[0]->start_date }}").getTime();
        var endDate = new Date("{{ $vehicle[0]->end_date }}").getTime();

        // Update durasi setiap detik
        var x = setInterval(function() {
            // Dapatkan waktu sekarang dalam UTC
            var now = new Date().getTime();

            // Hitung selisih waktu antara sekarang dan end_date
            var distance = endDate - now;

            // Hitung hari, jam, menit, dan detik
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Tampilkan durasi di elemen dengan id "countdown"
            $("#countdown").html(days + "D, " + hours + "H " + minutes + "M " + seconds + "S ");

            // Jika waktu sudah habis, tampilkan pesan atau lakukan aksi tertentu
            if (distance < 0) {
                clearInterval(distance);
                $("#countdown").html("Auction Ended");
                $("#submitBid").prop('disabled', true);
            }

        }, 1000);
    </script>

<script>
    var idr = document.getElementById("bid-amount");
    idr.addEventListener("keyup", function (e) {
        idr.value = formatRupiah(this.value, "Rp. ");
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
        return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
    }
</script>
@endsection
