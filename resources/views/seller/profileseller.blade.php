@extends('layout.main')
@section('content')
<div class="col-md-12 mx-auto" style="padding: 3vh;">
    <div class="card">
        <div class="card-body col-md-12 d-flex flex-column my-auto">
            <div class="row">
                <div class="col-md-6 d-flex align-items-center">
                    @foreach ($profile as $p)
                    <span class="avatar me-1">
                        <img src="{{ asset("/uploads/img/seller/$p->iduser/" . $p->pics) }}" class="round" height="150" width="150" style="object-fit: cover">
                    </span>
                    <div class="user-info">
                        <div class="user-nav d-flex d-sm-inline-flex">
                            <span class="user-name fw-bolder" style="font-size: 22px">{{ $p->name }}</span>
                        </div>
                        <div class="user-location">
                            <span class="user-name" style="font-size: 12px">{{ $p->province }}, {{ $p->city }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <div class="col-md-4">
                        @foreach ($rating as $r)
                        <h2 class="text-center">{{ $r->avg_rating }}/5.0</h2>
                        @endforeach
                        <p class="text-center">Seller Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h3>Product list</h3>
    <div class="row mt-1">
        @foreach ($seller as $s)
        <div class="col-md-3">
            <div class="card ecommerce-card">
                <div class="item-img text-center mt-1">
                    <a href="{{ route('sparepart.show', $s->idsparepart) }}">
                        <img class="card-img-top" src="{{ asset('images/sparepart/'.$s->idsparepart.'/' .$s->url) }}" alt="Card image cap" style="height : 300px; width:auto;" alt="img-placeholder" />
                    </a>
                </div>
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <div class="row">
                        <h5 class="item-name">
                            <a class="text-body" href="{{ route('sparepart.show', $s->idsparepart) }}">{{ $s->partnumber }} - {{ $s->partname }} {{ $s->vehiclemodel }}</a>
                        </h5>
                        <div class="item-wrapper mt-1">
                            <div class="item-cost">
                                <h6 class="item-price">@currency($s->unitprice)</h6>
                            </div>
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
    </div>
</div>

@endsection
