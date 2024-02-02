@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">

    <div class="row">
        <div class="col-md-4">

            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h4>Auction Statistic</h4>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 12px; font-weight: bold">Total Bids</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 12px; font-weight: bold" class="mt-1" id="totalPrice">0</p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 12px; font-weight: bold">Total Auction Win</p>
                        </label>
                        <div class="col-sm-5">
                            <p style="font-size: 12px; font-weight: bold" class="mt-1" id="totalPrice" >ANNITAMAXWINN</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (!empty($list))
        <div class="col-md-8">
            <h3>Auction History</h3>
            <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 py-auto">
                <p style="font-size: 14px; font-weight: 900;">Status :</p>
                <a href="#" class="btn btn-outline-secondary mx-1">All</a>
                <a href="#" class="btn btn-outline-secondary me-1">Ongoing</a>
                <a href="#" class="btn btn-outline-secondary me-1">Success</a>
                <a href="#" class="btn btn-outline-secondary me-1">Failed</a>
            </div>
            @foreach ($list as $l)
            <div class="card ecommerce-card mt-1">
                <div class="card-body col-md-12 d-flex flex-column" style="position: sticky; top: 0;">
                    @foreach ($winner as $w)
                        @if ($w->auctions_id === $l->idauction)
                            <div class="col-md-8 w-100" style="background-color: lightgreen">
                                <h4 class="text-start ms-1 my-1">You win the auction</h4>
                                <p class="ms-1">*please click continue to continue the process</p>
                            </div>
                        @endif
                    @if ($l->bidamount === $l->current_price)
                        @if ($w->auctions_id === $l->idauction)
                            <div class="col-md-8 w-100" style="background-color: lightgreen; display:none;">
                                <h5 class="text-center my-1">Your bid lead this auction:)</h5>
                            </div>
                        @else
                        <div class="col-md-8 w-100" style="background-color: lightgreen;">
                            <h5 class="text-center my-1">Your bid lead this auction:)</h5>
                        </div>
                        @endif
                    @else
                        <div class="col-md-8 w-100" style="background-color: lightyellow">
                            <h5 class="text-center my-1 text-warning">You're bid is lose, place another bid:(</h5>
                        </div>
                    @endif
                    @endforeach
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 align-items-center">
                            <p class="mx-1 mb-0">Waktu</p>
                            <div class="d-flex align-items-center mx-1 my-auto">
                                @if ($l->adstatus === 'Auction Ended')
                                    <span class="badge bg-light-danger text-danger">{{ $l->adstatus }}</span>
                                @else
                                    <span class="badge bg-light-success text-success">{{ $l->adstatus }}</span>
                                @endif
                            </div>
                            <p class="mx-1 mb-0">#{{ $l->lot_number }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="item-img text-center">
                                <a href="#">
                                    <img src="../../../app-assets/images/pages/eCommerce/2.png" class="img-fluid" alt="img-placeholder" width="120" height="120"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="my-1">{{ $l->model }}</h5>
                            <p class="my-1">Start Price: @currency($l->start_price)</p>
                        </div>
                        <div class="col-md-2">
                            <p class="my-1">Current Price</p>
                            <p class="my-1">@currency($l->current_price)</p>
                         </div>
                    </div>
                    <div class="d-flex justify-content-end me-1">
                        <a href="{{ route('vehicle.show', $l->idvehicle) }}" class="btn btn-flat-success mx-1">
                            Vehicle Details
                        </a>
                        @foreach ($winner as $w)
                            @if ($w->auctions_id === $l->idauction)
                            <a href="{{ route('auction.checkout', $l->idvehicle) }}" class="btn btn-info">
                                Continue
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            @else
                <p class="text-center mt-1">NO BIDS</p>
        </div>
        @endif
    </div>
</div>
@endsection
