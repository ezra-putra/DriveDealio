@foreach ($order as $o)
<h1 class="text-center mb-1" id="addNewCardTitle">Order Details</h1>
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h4>{{ $o->status }}</h4>
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        <button class="btn btn-outline-secondary" id="track">Track</button>
    </div>
</div>
<div id="myDiv" class="row mx-1" style="display:none;">
    <div class="col-md-12 mt-1">
        <h6 class="mb-1">Status Timeline</h6>
        @foreach ($status as $s)
            <p class="mb-1">{{ $s->status }} - {{ \Carbon\Carbon::parse($s->created_at)->isoFormat('DD MMMM YYYY, HH:mm') }}</p>
        @endforeach
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
</div>
<div class="card ecommerce-card border border-2 mx-2 mt-1">
    <div class="card-body col-md-12 d-flex flex-column" style="position: sticky; top: 0;">
        <div class="row">
            <div class="col-md-3">
                <div class="item-img text-center">
                    <a href="#">
                        <img src="{{ asset('/images/' . $o->url) }}" class="img-fluid" alt="img-placeholder" width="150" height="150"/>
                    </a>
                </div>
            </div>
            <div class="col-md-5 mx-auto my-auto">
                <h6 class="my-1">{{ $o->name }} - {{ $o->vehiclename }}</h6>
                <p class="my-1">1 Items x @currency($o->current_price)</p>
            </div>
            <div class="col-md-4 mx-auto my-auto text-center justify-content-end">
                <p class="my-1">Total Price</p>
                <p class="my-1">@currency($o->total_price)</p>
            </div>
        </div>
    </div>
</div>
@endforeach

<hr style="height:4px;border-width:0;color:gray;background-color:lightgray">
<div class="col-md-6 mt-1 mx-2">
    <h5>Delivery Information</h5>
</div>
@foreach ($towing as $t)
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Delivery Package</h5>
    </div>
    <div class="col-md-6 mt-1">
        <p>{{ $t->name }} - @currency($t->price)</p>
    </div>
</div>
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Shipping Number</h5>
    </div>
    <div class="col-md-6 mt-1">
        @if (!empty($t->trans_number))
            <p>{{ $t->trans_number }}</p>
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
@foreach ($order as $o)
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Total Price(1 Product)</h5>
    </div>
    <div class="col-md-6 mt-1">
        <p>@currency($o->total_price)</p>
    </div>
</div>
@endforeach

@foreach ($towing as $t)
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Delivery Fee</h5>
    </div>
    <div class="col-md-6 mt-1">
        <p>@currency($t->price)</p>
    </div>
</div>
@endforeach

<hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
<div class="row align-items-center mx-1">
    <div class="col-md-6 mt-1">
        <h5>Total Shopping</h5>
    </div>
    <div class="col-md-6 mt-1">
        @foreach ($order as $o)
        <h5>@currency($o->total_price)</h5>
        @endforeach
    </div>
</div>

<script>
    document.getElementById('track').addEventListener('click', function() {
        var div = document.getElementById('myDiv');
        if (div.style.display === 'none') {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
        }
    });
</script>

