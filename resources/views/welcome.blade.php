@extends('layout.main')
@section('content')
    {{-- Start Carousel --}}
    <div class="app-content content ">
        <section id="carousel-options">
            <div class="row match-height" style="padding: 2.5vh">
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
    <div class="card-body" style="padding: 5vh">
        <div class="mt-4 mb-2 text-center">
            <h2>HOT ITEMS RIGHT NOW</h2>
            <p>People also bid this product</p>
        </div>
        <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
            <div class="swiper-wrapper">
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
    </div>
    {{-- End Recommendation --}}

    {{-- Start Vehicle Recommendation --}}

    {{-- End Vehicle Recommendation --}}
@endsection
