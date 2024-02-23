@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">

    <div class="row">

        <div class="col-md-12">
            <h3>Auction History</h3>
            <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 py-auto">
                <p style="font-size: 14px; font-weight: 900;">Status :</p>
                <a href="#" class="btn btn-outline-secondary mx-1">All</a>
                <a href="#" class="btn btn-outline-secondary me-1">Ongoing</a>
                <a href="#" class="btn btn-outline-secondary me-1">Success</a>
                <a href="#" class="btn btn-outline-secondary me-1">Failed</a>
            </div>
        @if (!empty($list))
            @foreach ($list as $l)
            <div class="card ecommerce-card mt-1 col-md-8 mx-auto">
                <div class="card-body col-md-12 d-flex flex-column" style="position: sticky; top: 0;">
                    @foreach ($winner as $w)
                        @if ($w->auctions_id === $l->idauction)
                        <div class="col-md-8 w-100" style="background-color: lightgreen">
                            <h4 class="text-center ms-1 my-1">You win the auction</h4>
                        </div>
                        @endif
                    @endforeach
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 align-items-center">
                            <p class="mx-1 mb-0" id="countdown_{{ $l->idauction }}">{{ $list[0]->duration }}</p>
                            <div class="d-flex align-items-center mx-1 my-auto">
                                @if ($l->adstatus === 'Auction Ended')
                                    <span class="badge bg-light-danger text-danger">{{ $l->adstatus }}</span>
                                @else
                                    <span class="badge bg-light-success text-success">{{ $l->adstatus }}</span>
                                @endif
                            </div>
                            <p class="mx-1 mb-0">#{{ $l->lot_number }}</p>
                            <p class="mx-1 mb-0">My Bid: @currency($l->bidamount)</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="item-img text-center">
                                <a href="{{ route('vehicle.show', $l->idvehicle) }}">
                                    <img src="{{ asset('/images/vehicle/'.$l->idvehicle.'/' . $l->url) }}" class="img-fluid" alt="img-placeholder" width="120" height="120"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="my-1">{{ $l->brand }} - {{ $l->model }} {{ $l->variant }} {{ $l->transmission }} {{ $l->colour }}, {{ $l->year }}</h5>
                            <p class="my-1">Start Price: @currency($l->start_price)</p>
                        </div>
                        <div class="col-md-2">
                            <p class="my-1">Current Bid</p>
                            <p class="my-1">@currency($l->current_price)</p>
                         </div>
                    </div>
                    <div class="d-flex justify-content-end me-1">
                        <a href="{{ route('vehicle.show', $l->idvehicle) }}" class="btn btn-flat-success">
                            Vehicle Details
                        </a>
                        @if (empty($order))
                        @foreach ($winner as $w)
                            @if ($w->auctions_id === $l->idauction)
                            <a href="{{ route('auction.checkout', $l->idvehicle) }}" class="btn btn-info">
                                Checkout
                            </a>
                            @endif
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <p class="text-center mt-1">It's quite up here:( Start bid now!</p>
        @endif
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    @if(!empty($list))
        @foreach($list as $item)
            var startDate_{{ $item->idauction }} = new Date("{{ $item->start_date }}").getTime();
            var endDate_{{ $item->idauction }} = new Date("{{ $item->end_date }}").getTime();
        @endforeach

        var x = setInterval(function() {
            @foreach($list as $item)
                var now_{{ $item->idauction }} = new Date().getTime();
                var distance_{{ $item->idauction }} = endDate_{{ $item->idauction }} - now_{{ $item->idauction }};
                var days_{{ $item->idauction }} = Math.floor(distance_{{ $item->idauction }} / (1000 * 60 * 60 * 24));
                var hours_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60 * 60)) / (1000 * 60));
                var seconds_{{ $item->idauction }} = Math.floor((distance_{{ $item->idauction }} % (1000 * 60)) / 1000);
                document.getElementById("countdown_{{ $item->idauction }}").innerHTML = days_{{ $item->idauction }} + "d " + hours_{{ $item->idauction }} + "h "
                + minutes_{{ $item->idauction }} + "m " + seconds_{{ $item->idauction }} + "s ";
                if (distance_{{ $item->idauction }} < 0) {
                    clearInterval(x);
                    document.getElementById("countdown_{{ $item->idauction }}").innerHTML = "Auction Ended";
                }
            @endforeach
        }, 1000);
    @endif
</script>
@endsection
