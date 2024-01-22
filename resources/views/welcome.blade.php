@extends('layout.main')
@section('content')
    {{-- Start Carousel --}}
        <section id="carousel-options">
            <div class="row match-height" style="padding: 2.5vh;">
                <!-- Interval Option starts -->
                <div id="carousel-interval" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carousel-interval" data-bs-slide-to="0" class="active"></li>
                        <li data-bs-target="#carousel-interval" data-bs-slide-to="1"></li>
                        <li data-bs-target="#carousel-interval" data-bs-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="img-fluid" src="../../../app-assets/images/slider/01.jpg" alt="First slide"
                                style="object-fit: cover; width:100%; height:55vh" />
                        </div>
                        <div class="carousel-item">
                            <img class="img-fluid" src="../../../app-assets/images/slider/03.jpg" alt="Second slide"
                                style="object-fit: cover; width:100%; height:55vh" />
                        </div>
                        <div class="carousel-item">
                            <img class="img-fluid" src="../../../app-assets/images/slider/02.jpg" alt="Third slide"
                                style="object-fit: cover; width:100%; height:55vh" />
                        </div>
                    </div>
                    <a class="carousel-control-prev" data-bs-target="#carousel-interval" role="button"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" data-bs-target="#carousel-interval" role="button"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
    {{-- End Carousel --}}

    {{-- Start Recommendation --}}
    <div class="card-body">
        <div class="mb-2 text-center">
            <h2>HOT ITEMS RIGHT NOW</h2>
            <p>People also bid this product</p>
        </div>
        <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
            <div class="swiper-wrapper">
                {{-- @foreach ( as ) --}}
                <div class="swiper-slide rounded swiper-shadow">
                    <div class="item-heading">
                        <p class="text-truncate mb-0">
                            Bowers Wilkins - CM10 S2 Triple 6-1/2" 3-Way Floorstanding Speaker (Each) - Gloss Black
                        </p>
                        <p>
                            <small>by</small>
                            <small>Bowers & Wilkins</small>
                        </p>
                    </div>
                    <div class="img-container w-50 mx-auto my-2 py-75">
                        <img src="../../../app-assets/images/elements/apple-watch.png" class="img-fluid" alt="image">
                    </div>
                    <div class="item-meta">
                        <div class="product-rating">
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-secondary"></i>
                        </div>
                        <p class="text-primary mb-0">$19.98</p>
                    </div>
                </div>
                {{-- @endforeach --}}

                <div class="swiper-slide rounded swiper-shadow">
                    <div class="item-heading">
                        <p class="text-truncate mb-0">
                            Alienware - 17.3" Laptop - Intel Core i7 - 16GB Memory - NVIDIA GeForce GTX 1070 - 1TB Hard
                            Drive +
                            128GB Solid State Drive - Silver
                        </p>
                        <p>
                            <small>by</small>
                            <small>Alienware</small>
                        </p>
                    </div>
                    <div class="img-container w-50 mx-auto my-2 py-75">
                        <img src="../../../app-assets/images/elements/beats-headphones.png" class="img-fluid"
                            alt="image">
                    </div>
                    <div class="item-meta">
                        <div class="product-rating">
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-secondary"></i>
                        </div>
                        <p class="text-primary mb-0">$35.98</p>
                    </div>
                </div>
                <div class="swiper-slide rounded swiper-shadow">
                    <div class="item-heading">
                        <p class="text-truncate mb-0">
                            Canon - EOS 5D Mark IV DSLR Camera with 24-70mm f/4L IS USM Lens
                        </p>
                        <p>
                            <small>by</small>
                            <small>Canon</small>
                        </p>
                    </div>
                    <div class="img-container w-50 mx-auto my-3 py-50">
                        <img src="../../../app-assets/images/elements/macbook-pro.png" class="img-fluid" alt="image">
                    </div>
                    <div class="item-meta">
                        <div class="product-rating">
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-secondary"></i>
                        </div>
                        <p class="text-primary mb-0">$49.98</p>
                    </div>
                </div>
                <div class="swiper-slide rounded swiper-shadow">
                    <div class="item-heading">
                        <p class="text-truncate mb-0">
                            Apple - 27" iMac with Retina 5K display - Intel Core i7 - 32GB Memory - 2TB Fusion Drive -
                            Silver
                        </p>
                        <p>
                            <small>by</small>
                            <small>Apple</small>
                        </p>
                    </div>
                    <div class="img-container w-50 mx-auto my-2 py-75">
                        <img src="../../../app-assets/images/elements/homepod.png" class="img-fluid" alt="image">
                    </div>
                    <div class="item-meta">
                        <div class="product-rating">
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-secondary"></i>
                        </div>
                        <p class="text-primary mb-0">$29.98</p>
                    </div>
                </div>
                <div class="swiper-slide rounded swiper-shadow">
                    <div class="item-heading">
                        <p class="text-truncate mb-0">
                            Bowers Wilkins - CM10 S2 Triple 6-1/2" 3-Way Floorstanding Speaker (Each) - Gloss Black
                        </p>
                        <p>
                            <small>by</small>
                            <small>Bowers & Wilkins</small>
                        </p>
                    </div>
                    <div class="img-container w-50 mx-auto my-2 py-75">
                        <img src="../../../app-assets/images/elements/magic-mouse.png" class="img-fluid" alt="image">
                    </div>
                    <div class="item-meta">
                        <div class="product-rating">
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-secondary"></i>
                        </div>
                        <p class="text-primary mb-0">$99.98</p>
                    </div>
                </div>
                <div class="swiper-slide rounded swiper-shadow">
                    <div class="item-heading">
                        <p class="text-truncate mb-0">
                            Garmin - fenix 3 Sapphire GPS Watch - Silver
                        </p>
                        <p>
                            <small>by</small>
                            <small>Garmin</small>
                        </p>
                    </div>
                    <div class="img-container w-50 mx-auto my-2 py-75">
                        <img src="../../../app-assets/images/elements/iphone-x.png" class="img-fluid" alt="image">
                    </div>
                    <div class="item-meta">
                        <div class="product-rating">
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-warning"></i>
                            <i class="feather icon-star text-secondary"></i>
                        </div>
                        <p class="text-primary mb-0">$59.98</p>
                    </div>
                </div>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    {{-- End Recommendation --}}

    {{-- Start Vehicle Recommendation --}}

    {{-- End Vehicle Recommendation --}}

    {{-- Start Memberships Card --}}
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section id="pricing-plan">
                <!-- title text and switch button -->
                <div class="text-center">
                    <h1 class="mt-5 mb-1">Memberships Pricing Plans</h1>
                    <p class="mb-3 pb-75">
                        As a DriveDealio Member, you'll be able to search our massive inventory for wholesale, used and
                        repairable Vehicles. Unlock additional features by upgrading to a Bronze to Platinum
                        Membership—you'll be able to jump right into the auction and start bidding in our live auctions!
                    </p>
                </div>
                <!--/ title text and switch button -->

                <!-- pricing plan cards -->
                <div class="row pricing-card">
                    <div class="col-12 col-sm-offset-2 col-sm-10 col-md-12 col-lg-offset-2 col-lg-10 mx-auto">
                        <div class="row">
                            <!-- basic plan -->
                            @foreach ($membership as $m)
                            <div class="col-12 col-md-6">
                                <div class="card basic-pricing text-center">
                                    <div class="card-body">
                                        <img src="../../../app-assets/images/illustration/Pot1.svg" class="mb-2 mt-5" alt="svg img" />
                                        <h3>{{ $m->membershiptype }}</h3>
                                        <p class="card-text">{{ $m->description }}</p>
                                        <div class="annual-plan">
                                            <div class="plan-price mt-2">
                                                <span class="pricing-basic-value fw-bolder text-primary">@currency($m->price)</span>
                                                <sub class="pricing-duration text-body font-medium-1 fw-bold">/month</sub>
                                            </div>
                                            <small class="annual-pricing d-none text-muted"></small>
                                        </div>
                                        <ul class="list-group list-group-circle text-start mb-1">
                                            <li class="list-group-item">{{ $m->benefit1 }}</li>
                                            <li class="list-group-item">{{ $m->benefit2 }}</li>
                                            <li class="list-group-item">{{ $m->benefit3 }}</li>
                                        </ul>
                                        <a class="btn w-100 btn-outline-success mt-2" href="/membership/register">More Details</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!--/ pricing plan cards -->

                <!-- pricing faq -->
                <div class="pricing-faq">
                    <h3 class="text-center">FAQ's</h3>
                    <p class="text-center">Let us help answer the most common questions.</p>
                    <div class="row my-2">
                        <div class="col-12 col-lg-10 col-lg-offset-2 mx-auto">
                            <!-- faq collapse -->
                            <div class="accordion accordion-margin" id="accordionExample">
                                <div class="card accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                            Does my subscription automatically renew?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Pastry pudding cookie toffee bonbon jujubes jujubes powder topping. Jelly beans gummi bears sweet roll
                                            bonbon muffin liquorice. Wafer lollipop sesame snaps. Brownie macaroon cookie muffin cupcake candy
                                            caramels tiramisu. Oat cake chocolate cake sweet jelly-o brownie biscuit marzipan. Jujubes donut
                                            marzipan chocolate bar. Jujubes sugar plum jelly beans tiramisu icing cheesecake.
                                        </div>
                                    </div>
                                </div>
                                <div class="card accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Can I store the item on an intranet so everyone has access?
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Tiramisu marshmallow dessert halvah bonbon cake gingerbread. Jelly beans chocolate pie powder. Dessert
                                            pudding chocolate cake bonbon bear claw cotton candy cheesecake. Biscuit fruitcake macaroon carrot cake.
                                            Chocolate cake bear claw muffin chupa chups pudding.
                                        </div>
                                    </div>
                                </div>
                                <div class="card accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" data-bs-toggle="collapse" role="button" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Am I allowed to modify the item that I purchased?
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Tart gummies dragée lollipop fruitcake pastry oat cake. Cookie jelly jelly macaroon icing jelly beans
                                            soufflé cake sweet. Macaroon sesame snaps cheesecake tart cake sugar plum. Dessert jelly-o sweet muffin
                                            chocolate candy pie tootsie roll marzipan. Carrot cake marshmallow pastry. Bonbon biscuit pastry topping
                                            toffee dessert gummies. Topping apple pie pie croissant cotton candy dessert tiramisu.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ pricing faq -->
            </section>

        </div>
    </div>
    {{-- End Memberships Card --}}
@endsection
