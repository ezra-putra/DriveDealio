@extends('layout.main')
@section('content')
@if (count($vehicle) > 0 || count($sparepart) > 0)
<div class="col-md-12" style="padding: 3vh;">
        @foreach ($vehicle as $v)
        <div class="col-md-3">
            <div class="card ecommerce-card">
                <div class="item-img text-center">
                    <a href="{{ route('vehicle.show', $v->idvehicle) }}">
                        <img class="card-img-top img-fluid" src="{{ asset('/images/vehicle/'.$v->idvehicle.'/' . $v->url) }}" alt="Card image cap" style="height : 300px; width:auto; object-fit:fill;"/>
                    </a>
                </div>
                <div class="card-body">
                    <h5 class="item-name mb-1">
                        <a class="text-body" href="{{ route('vehicle.show', $v->idvehicle) }}">{{ $v->brand }} - {{ $v->model }}
                            {{ $v->variant }}</a>
                    </h5>
                    <div class="item-wrapper d-block">
                        <div class="item-cost mb-1">
                            <h6 class="item-price">@currency($v->price)</h6>
                        </div>
                        <p>Lot: #<strong style="color: blue;">{{ $v->lot_number }}</strong></p>
                        <p id="countdown_{{ $v->idauction }}">Time Remaining: {{ $vehicle[0]->duration }}</p>
                    </div>
                    <a href="{{ route('vehicle.show', $v->idvehicle) }}" class="btn btn-flat-info w-100">View Details</a>
                </div>
            </div>
        </div>

        @endforeach

        @foreach ($sparepart as $s)
        <div class="col-md-3">
            <div class="card ecommerce-card">
                <div class="item-img mt-1 text-center">
                    <a href="{{ route('sparepart.show', $s->idsparepart) }}">
                        <img class="card-img-top img-fluid" src="{{ asset('images/sparepart/'.$s->idsparepart.'/' .$s->url) }}" alt="Card image cap" style="height : 320px; width:auto; object-fit:fill;"/>
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
        </div>
        @endforeach
    @else
        <h3 class="mt-2 text-center">No Result Found</h3>
    @endif
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
