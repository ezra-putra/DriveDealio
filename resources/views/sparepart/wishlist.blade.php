@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">
    <h3>Wishlist</h3>
    <div class="row">
        @foreach ($wishlist as $w)
        <div class="col-md-3">
            <div class="card ecommerce-card">
                <div class="item-img text-center">
                    <a href="#">
                        <img class="card-img-top" src="{{ asset('/images/' . $w->url) }}" alt="Card image cap" style="height : 300px; width:auto;" alt="img-placeholder" />
                    </a>
                </div>
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <div class="row">
                        <h5 class="item-name">
                            <a class="text-body" href="#">{{ $w->partnumber }}-{{ $w->partname }} {{ $w->model }} </a>
                        </h5>
                        <div class="item-wrapper">
                            <div class="item-cost">
                                <h6 class="item-price">@currency($w->unitprice)</h6>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="item-options text-center w-100">
                    <form method="POST" action="{{ route('wishlist.destroy', $w->idwishlist) }}" enctype="multipart/form-data" style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger w-100">
                            <i data-feather='trash'></i>
                            <span class="add-to-cart">Wishlist</span>
                        </button>
                    </form>
                    <form method="POST" action="{{ route('sparepart.addcart', $w->idsparepart) }}" enctype="multipart/form-data" style="display: inline-block">
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
