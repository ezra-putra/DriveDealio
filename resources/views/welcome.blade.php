@extends('layout.main')
@section('content')
<section id="carousel-options">
    <div class="row match-height mb-1" style="padding: 2.5vh;">
        <div id="carousel-interval" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
            <ol class="carousel-indicators">
                <li data-bs-target="#carousel-interval" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#carousel-interval" data-bs-slide-to="1"></li>
                <li data-bs-target="#carousel-interval" data-bs-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img class="img-fluid" src="{{ asset('images/vehicle/welcome/1.png') }}" alt="First slide"
                        style="object-fit: contain; width:100%; height:55vh" />
                </div>
                <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('images/vehicle/welcome/2.png') }}" alt="Second slide"
                        style="object-fit: contain; width:100%; height:55vh" />
                </div>
                <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('images/vehicle/welcome/3.png') }}" alt="Third slide"
                        style="object-fit: contain; width:100%; height:55vh" />
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

<div class="card-body">
    <div class="mb-2 text-center">
        <h2>HOT VEHICLE TO BID RIGHT NOW</h2>
        <p>People also bid this product</p>
    </div>
    <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
        <div class="swiper-wrapper">
            @if(!empty($vehicle))
                @foreach ($vehicle as $v)
                    <div class="swiper-slide rounded swiper-shadow">
                        <div class="item-heading">
                            <p class="text-truncate mb-0">
                                {{ $v->brand }} - {{ $v->model }} {{ $v->variant }} {{ $v->transmission }}
                            </p>
                            <p>
                                <small id="countdown_{{ $v->idauction }}">{{ $v->duration }}</small>
                            </p>
                        </div>
                        <div class="img-container w-50 mx-auto my-2 py-75">
                            <img src="{{ asset('/images/vehicle/'.$v->idvehicle.'/'.$v->url) }}" style="height: auto; width: auto;" class="img-fluid" alt="image">
                        </div>
                        <div class="item-meta">
                            <p class="mb-1" style="font-weight: 700">Start price: @currency($v->price)</p>
                            <a href="{{ route('vehicle.show', $v->idvehicle) }}" class="btn btn-info w-100">Details</a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="swiper-slide rounded swiper-shadow">
                    <p class="text-center">There is No Auction at this Moment!</p>
                </div>
            @endif
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
<div class="card-body">
    <div class="mb-2 text-center">
        <h2>HOT ITEMS RIGHT NOW</h2>
        <p>People also find this product</p>
    </div>
    <div class="swiper-responsive-breakpoints swiper-container px-4 py-2">
        <div class="swiper-wrapper">
            @if (!empty($sparepart))
                @foreach ($sparepart as $s)
                <div class="swiper-slide rounded swiper-shadow">
                    <div class="item-heading">
                        <p class="text-truncate mb-0">
                            {{ $s->partnumber }} - {{ $s->partname }} {{ $s->vehiclemodel }}
                        </p>
                        <p>
                            <small>{{ $s->name }}</small>, <small>{{ $s->city }}</small>
                        </p>
                    </div>
                    <div class="img-container w-50 mx-auto my-2 py-75">
                        <img src="{{ asset('images/sparepart/'.$s->idsparepart.'/' .$s->url) }}" class="img-fluid" alt="image">
                    </div>
                    <div class="item-meta">
                        <p class="mb-1" style="font-weight: 700">@currency($s->unitprice)</p>
                        <a href="{{ route('sparepart.show', $s->idsparepart) }}" class="btn btn-info w-100">Details</a>
                    </div>
                </div>
                @endforeach
            @else
                <p class="text-center">There is No Sparepart Available Right Now!</p>
            @endif
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
    </div>
    <div class="content-body">
        <section id="pricing-plan">
            <div class="text-center">
                <h1 class="mt-5 mb-1">Memberships Pricing Plans</h1>
                <p class="mb-3 pb-75">
                    As a DriveDealio Member, you'll be able to search our massive inventory for wholesale, used and
                    repairable Vehicles. Unlock additional features by upgrading to a Bronze to Platinum
                    Membership—you'll be able to jump right into the auction and start bidding in our live auctions!
                </p>
            </div>
            <div class="row pricing-card">
                <div class="col-12 col-sm-offset-2 col-sm-10 col-md-12 col-lg-offset-2 col-lg-10 mx-auto">
                    <div class="row">
                        @foreach ($membership as $m)
                        <div class="col-12 col-md-6">
                            <div class="card basic-pricing text-center">
                                <div class="card-body">
                                    <h3>{{ $m->membershiptype }}</h3>
                                    <p class="card-text">{{ $m->description }}</p>
                                    <div class="annual-plan">
                                        <div class="plan-price mt-2">
                                            <span class="pricing-basic-value fw-bolder text-primary">@currency($m->price)</span>
                                        </div>
                                        <small class="annual-pricing d-none text-muted"></small>
                                    </div>
                                    <a class="btn w-100 btn-outline-success mt-2" href="/membership/register">Register Now</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        @foreach($vehicle as $item)
            var startDate_{{ $item->idauction }} = new Date("{{ $item->start_date }}").getTime();
            var endDate_{{ $item->idauction }} = new Date("{{ $item->end_date }}").getTime();
        @endforeach

        var x = setInterval(function() {
            @foreach($vehicle as $item)
                var now_{{ $item->idauction }} = new Date().getTime();
                var distance_{{ $item->idauction }} = endDate_{{ $item->idauction }} - now_{{ $item->idauction }};
                var days_{{ $item->idauction }} = Math.floor(distance_{{ $item->idauction }} / (1000 * 60 * 60 * 24));
                var hours_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60 * 60)) / (1000 * 60));
                var seconds_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60)) / 1000);
                document.getElementById("countdown_{{ $item->idauction }}").innerHTML = "Time Remaining: "+ days_{{ $item->idauction }} + "d " + hours_{{ $item->idauction }} + "h "
                + minutes_{{ $item->idauction }} + "m " + seconds_{{ $item->idauction }} + "s ";
                if (distance_{{ $item->idauction }} < 0) {
                    clearInterval(x);
                    document.getElementById("countdown_{{ $item->idauction }}").innerHTML = "Auction Ended";
                }
            @endforeach
        }, 1000);
    </script>
@endsection
