@foreach ($order as $o)
<h1 class="text-center mb-1" id="addNewCardTitle">Order Details</h1>
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>{{ $o->status }}</h5>
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        <a href="#" class="btn btn-outline-secondary">Track</a>
    </div>
</div>
<hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>No. Invoice</h5>
    </div>
    <div class="col-md-6 mt-1 d-flex justify-content-end">
        <p>{{ $o->invoicenum }}</p>
    </div>
</div>
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Order Date</h5>
    </div>
    <div class="col-md-6 mt-1 d-flex justify-content-end">
        <p>{{ \Carbon\Carbon::parse($o->orderdate)->isoFormat('DD MMMM YYYY, HH:mm') }}</p>
    </div>
</div>
<hr style="height:4px;border-width:0;color:gray;background-color:lightgray">
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Product Details</h5>
    </div>
    <div class="col-md-6 mt-1 d-flex justify-content-end">
        <a href="{{ route('seller.profile', $o->idshop) }}" aria-expanded="false" class="text-decoration-none">
            <span class="user-name" style="font-size: 14px">{{ $o->name }}</span>
            <i data-feather='chevron-right'></i>
        </a>
    </div>
</div>
@endforeach

@foreach ($orderdetails as $od)
<div class="card ecommerce-card border border-2 mx-2 mt-1">
    <div class="card-body col-md-12 d-flex flex-column" style="position: sticky; top: 0;">
        <div class="row">
            <div class="col-md-3">
                <div class="item-img text-center">
                    <a href="#">
                        <img src="{{ asset('/images/' . $od->url) }}" class="img-fluid" alt="img-placeholder" width="150" height="150"/>
                    </a>
                </div>
            </div>
            <div class="col-md-5 mx-auto my-auto">
                <h6 class="my-1">{{ $od->item_name }}</h6>
                <p class="my-1">{{ $od->quantityordered }} Items x @currency($od->unitprice)</p>
            </div>
            @php
                $subtotal = 0;

                $subtotal = $od->unitprice * $od->quantityordered;
            @endphp
            <div class="col-md-4 mx-auto my-auto text-center justify-content-end">
                <p class="my-1">Total Price</p>
                <p class="my-1">@currency($subtotal)</p>
            </div>
        </div>
        <div class="d-flex justify-content-end me-3">
            <a href="#" class="btn btn-info">Buy Again</a>
        </div>
    </div>
</div>
@endforeach

<hr style="height:4px;border-width:0;color:gray;background-color:lightgray">
<div class="col-md-6 mt-1 mx-2">
    <h5>Delivery Information</h5>
</div>
@foreach ($shippings as $s)
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Delivery Package</h5>
    </div>
    <div class="col-md-6 mt-1">
        <p>{{ $s->packagename }} - @currency($s->shipping_fee)</p>
    </div>
</div>
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Shipping Number</h5>
    </div>
    <div class="col-md-6 mt-1">
        @if (!empty($s->shipping_number))
            <p>{{ $s->shipping_number }}</p>
        @else
            <p>-</p>
        @endif
    </div>
</div>
@endforeach
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Address</h5>
    </div>
    @foreach ($order as $o)
    <div class="col-md-6 mt-1">
        <p class="mb-1">{{ $o->addressname }}</p>
        <p class="mb-1">{{ $o->address }}</p>
        <p class="mb-1">{{ $o->district }}, {{ $o->city }}</p>
        <p class="mb-1">{{ $o->province }} {{ $o->zipcode }}</p>
    </div>
    @endforeach
</div>
<hr style="height:4px;border-width:0;color:gray;background-color:lightgray">
<div class="col-md-6 mt-1 mx-2">
    <h5>Payment Details</h5>
</div>
@foreach ($countItems as $c)
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Total Price({{ $c->count }} Product)</h5>
    </div>
    <div class="col-md-6 mt-1">
        @foreach ($totalshop as $ts)
            <p>@currency($ts->price)</p>
        @endforeach
    </div>
</div>
@endforeach

@foreach ($shippings as $s)
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Delivery Fee</h5>
    </div>
    <div class="col-md-6 mt-1">
        <p>@currency($s->shipping_fee)</p>
    </div>
</div>
@endforeach

<hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Total Shopping</h5>
    </div>
    <div class="col-md-6 mt-1">
        <h5>@currency($order[0]->total_price)</h5>
    </div>
</div>

