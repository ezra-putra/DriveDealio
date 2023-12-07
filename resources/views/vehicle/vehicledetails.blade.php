@extends('layout.main')
@section('content')
    <div class="ecommerce-application">

        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Vehicle Details</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Car</a></li>
                                    <li class="breadcrumb-item active">Details</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-header-right text-md-end col-md-3 col-12 d-md-block d-none">
                    <div class="mb-1 breadcrumb-right">
                        <div class="dropdown">
                            <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                    data-feather="grid"></i></button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="app-todo.html"><i
                                        class="me-1" data-feather="check-square"></i><span
                                        class="align-middle">Todo</span></a><a class="dropdown-item" href="app-chat.html"><i
                                        class="me-1" data-feather="message-square"></i><span
                                        class="align-middle">Chat</span></a><a class="dropdown-item"
                                    href="app-email.html"><i class="me-1" data-feather="mail"></i><span
                                        class="align-middle">Email</span></a><a class="dropdown-item"
                                    href="app-calendar.html"><i class="me-1" data-feather="calendar"></i><span
                                        class="align-middle">Calendar</span></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- app e-commerce details start -->
                <section class="app-ecommerce-details">
                    <div class="card">
                        <!-- Product Details starts -->
                        <div class="card-body">
                            <div class="row my-2">
                                @foreach ($vehicle as $v)
                                    <div
                                        class="col-12 col-md-5 d-flex align-items-center justify-content-center mb-2 mb-md-0">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="{{ $v->image }}" class="img-fluid product-img"
                                                alt="product image" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <h2>{{ $v->brand }} {{ $v->model }} - {{ $v->variant }}</h2>
                                        <span class="card-text item-company">By <a href="#"
                                                class="company-name">{{ $v->fname }} {{ $v->lname }}</a>
                                        </span>
                                        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                                        <div class="tab-content">
                                            <div class="row">
                                                <label for="colFormLabelLg" class="col-sm-4 col-form-label-lg">
                                                    <h4>Remaining Bid Time</h4>
                                                </label>
                                                <div class="col-sm-6">
                                                    <h4 class="mt-1" id="countdown">{{ $v->duration }}</h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                                            <h5>Current Price</h5>
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <h5 class="mt-1">@currency($v->price)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                                            <h5>Plate Number</h5>
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <h5 class="mt-1">{{ $v->platenumber }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                                            <h5>Location</h5>
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <h5 class="mt-1">{{ $v->location }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                                            <h5>Lot Number</h5>
                                                        </label>
                                                        <div class="col-sm-6">
                                                            <h5 class="mt-1">#{{ $v->lotnumber }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Bid Ammount</th>
                                                        <th scope="col">Bid Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Ezra</td>
                                                        <td>Rp.170.000.000</td>
                                                        <td>17:52:01</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Theresia</td>
                                                        <td>Rp.167.500.000</td>
                                                        <td>17:50:80</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex flex-column flex-sm-row pt-1 mt-auto">
                                            <a href="#" class="btn btn-primary me-0 me-sm-1 mb-1 mb-sm-0">
                                                <i class="fa fa-gavel me-50" id="btnPlacebid"></i>
                                                <span>Place Bidding</span>
                                            </a>
                                            <a href="#"
                                                class="btn btn-outline-secondary btn-wishlist me-0 me-sm-1 mb-1 mb-sm-0">
                                                <i data-feather="eye" class="me-50" id="btnAddWatchlist"></i>
                                                <span>Watchlist</span>
                                            </a>
                                        </div>
                                @endforeach
                            </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray; text-align: center">
                        <!-- Product Details ends -->

                        <!-- Item features starts -->

                        <div class="item-features">
                            <h4>Specifications</h4>
                            <div class="row">
                                {{-- Right --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <h5>Transmission</h5>
                                        </label>
                                        <div class="col-sm-6">
                                            <p style="font-weight: bold; color: black;" class="mt-1">
                                                {{ $v->transmission }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <h5>Fuel Type</h5>
                                        </label>
                                        <div class="col-sm-6">
                                            <h5 class="mt-1">{{ $v->fueltype }}</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <h5>Vehicle Type</h5>
                                        </label>
                                        <div class="col-sm-6">
                                            <h5 class="mt-1">{{ $v->type }}</h5>
                                        </div>
                                    </div>
                                </div>
                                {{-- Left --}}
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <h5>Engine Capacity</h5>
                                        </label>
                                        <div class="col-sm-6">
                                            <h5 class="mt-1">{{ $v->enginecapacity }}L</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                            <h5>Engine Cylinders</h5>
                                        </label>
                                        <div class="col-sm-6">
                                            <h5 class="mt-1">{{ $v->enginecylinders }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Item features ends -->

                        <!-- Related Products starts -->
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
                        <!-- Related Products ends -->
                    </div>
                </section>
                <!-- app e-commerce details end -->

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
            $("#countdown").html(days + "D " + hours + "H " + minutes + "M " + seconds + "S ");

            // Jika waktu sudah habis, tampilkan pesan atau lakukan aksi tertentu
            if (distance < 0) {
                clearInterval(x);
                $("#countdown").html("Auction Ended");

                $("#btnPlacebid").prop('disabled', true);

                $("#btnAddWatchlist").prop('disabled', true);
            }
        }, 1000);

        function updateAdStatus() {
            $.ajax({
                type: 'POST',
                url: '/update-ad-status', // Sesuaikan dengan URL rute yang sesuai di Laravel
                data: {
                    auctionId: "{{ $vehicle[0]->idauction }}"
                },
                success: function(response) {
                    console.log(response); // Tampilkan respons dari server jika diperlukan
                },
                error: function(error) {
                    console.error(error); // Tampilkan pesan kesalahan jika terjadi
                }
            });
        }
    </script>
@endsection
