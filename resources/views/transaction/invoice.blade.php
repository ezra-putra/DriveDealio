@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-9">
            @foreach ($order as $o)
            <div class="d-flex justify-content-between mt-1">
                <img src="{{ asset('/image/logo-drivedealio.png') }}" alt="Logo" width="170" height="40">
                <div class="row">
                    <div class="col">
                        <h5 style="text-align: right;">INVOICE</h5>
                        <p style="font-size: 12px;">{{ $o->invoicenum }}</p>
                    </div>
                </div>
            </div>
            <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
            <div class="row">
                <div class="d-flex justify-content-between mt-1">
                    <div class="d-flex flex-column me-5">
                        <h5>Seller Info</h5>
                        <p>Seller : <strong>{{ $o->sellername }}</strong></p>
                    </div>
                    <div class="d-flex flex-column me-5">
                        <h5>Buyer Info</h5>
                        <p>Buyer : {{ $o->firstname }} ({{ $o->phonenumber }})</p>
                        <p>Order Date : {{ \Carbon\Carbon::parse($o->orderdate)->isoFormat('D MMMM YYYY') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="table-responsive mb-1">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Product Info</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderdetails as $od)
                        @php
                            $subtotal = 0;
                            $totalprice = $od->quantityordered * $od->unitprice;
                            $subtotal += $totalprice;
                        @endphp
                        <tr>
                            <td>{{ $od->item_name }}</td>
                            <td>{{ $od->quantityordered }}</td>
                            <td>@currency($od->unitprice)</td>
                            <td>@currency($totalprice)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
            <div class="d-flex justify-content-between mt-1">
                <div class="d-flex flex-column me-5 mt-1">
                    @foreach ($shippings as $s)
                    <h6>Courier</h6>
                    <p class="mb-1">{{ $s->packagename }} Delivery Service</p>
                    @endforeach
                </div>
                <div class="d-flex flex-column me-5 mt-1">
                    <p style="text-align: left">Subtotal : @currency($subtotal)</p>
                    @foreach ($shippings as $s)
                    <p class="mb-1" style="text-align: left">Shipping Fee : @currency($s->shipping_fee)</p>
                    @endforeach
                    @foreach ($order as $o)
                    <h6 style="text-align: left">Total Price : @currency($o->total_price)</h6>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <a href="#" id="print-button" class="btn btn-info w-100">Print</a>
        </div>
    </div>
</div>

<script>
    document.getElementById('print-button').addEventListener('click', function() {
        var printContents = document.querySelector('.col-md-9').innerHTML;
        var printContainer = document.createElement('div');
        printContainer.innerHTML = printContents;

        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    });
</script>
@endsection
