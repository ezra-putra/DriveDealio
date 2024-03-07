@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-9">
            @foreach ($orderMember as $o)
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
                        <p>Seller : <strong>DriveDealio</strong></p>
                    </div>
                    <div class="d-flex flex-column me-5">
                        <h5>Buyer Info</h5>
                        <p>Buyer : {{ $o->firstname }} ({{ $o->phonenumber }})</p>
                        <p>Order Date : {{ \Carbon\Carbon::parse($o->created_at)->isoFormat('D MMMM YYYY') }}</p>
                    </div>
                </div>
            </div>
            <div class="table-responsive mb-1">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Membership Info</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $subtotal = 0;
                            $adminfee = 5000;
                        @endphp
                        <td>{{ $o->membershiptype }} Membership</td>
                        <td>@currency($o->price)</td>
                    </tbody>
                </table>
            </div>
            <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
            <div class="d-flex justify-content-end mt-1">
                <div class="d-flex flex-column me-5 mt-1">
                    <p style="text-align: left">Subtotal : @currency($o->price)</p>
                    <p style="text-align: left">Admin : @currency($adminfee)</p>
                    <h6>Total Price : @currency($o->total_price)</h6>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-3">
            <a href="#" id="print-button" class="btn btn-info w-100">Print</a>
        </div>
    </div>
</div>
<script>
    document.getElementById('print-button').addEventListener('click', function() {
        var printContents = document.querySelector('.col-md-9').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    });
</script>
@endsection
