@extends('layout.main')
@section('content')
<h3>Transaction List</h3>
<div class="col-md-12" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 py-auto">
                <p style="font-size: 14px; font-weight: 900;">Status :</p>
                <a href="#" class="btn btn-outline-secondary mx-1">All</a>
                <a href="#" class="btn btn-outline-secondary me-1">Ongoing</a>
                <a href="#" class="btn btn-outline-secondary me-1">Success</a>
                <a href="#" class="btn btn-outline-secondary me-1">Failed</a>
            </div>
            @foreach ($order as $o)
            <div class="card ecommerce-card mt-1">
                <div class="card-body col-md-12 d-flex flex-column" style="position: sticky; top: 0;">
                    <div class="d-flex align-items-center">
                        <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 align-items-center">
                            <p class="mx-1 mb-0">{{ \Carbon\Carbon::parse($o->orderdate)->format('j M Y') }}</p>
                            <div class="d-flex align-items-center mx-1 my-auto">
                                @if ($o->status === 'Cancelled')
                                    <span class="badge bg-light-danger text-danger">{{ $o->status }}</span>
                                @elseif ($o->status === 'Waiting for Payment' || $o->status === 'Waiting for Confirmation')
                                    <span class="badge bg-light-warning text-danger">{{ $o->status }}</span>
                                @else
                                    <span class="badge bg-light-success text-success">{{ $o->status }}</span>
                                @endif
                            </div>
                            <p class="mx-1 mb-0">{{ $o->invoicenum }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <p class="ms-1">{{ $o->name }}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="item-img text-center">
                                <a href="#">
                                    <img src="../../../app-assets/images/pages/eCommerce/2.png" class="img-fluid" alt="img-placeholder" width="120" height="120"/>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8 mx-auto my-auto">
                            {{-- <h5 class="my-1">{{ $o->item_name }}</h5>
                            <p class="my-1">{{ $o->quantityordered }} Items x @currency($o->price)</p> --}}
                        </div>
                        <div class="col-md-2 mx-auto my-auto text-center justify-content-end">
                            <p class="my-1">Total Price</p>
                            <p class="my-1">@currency($o->total_price)</p>
                         </div>
                    </div>
                    <div class="d-flex justify-content-end me-3">
                        <a href="{{ route('transaction.details', $o->idorder) }}" class="btn btn-flat-success mx-1">
                            Transaction Details
                        </a>
                        @if ($o->status === 'Waiting for Payment')
                            <a href="{{ route('payment_cancel', $o->idorder) }}" class="btn btn-danger">
                                Cancel
                            </a>
                        @elseif ($o->status === 'Finished')
                            <a href="#" class="btn btn-success">
                                Reorder
                            </a>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
