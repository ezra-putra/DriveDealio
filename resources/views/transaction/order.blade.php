@extends('layout.main')
@section('content')
<h3>Transaction List</h3>
<div class="col-md-12" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h4 class="mb-1">Transaction Type</h4>
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-tabs me-3 w-100" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-sparepart-tab" data-bs-toggle="pill" data-bs-target="#v-pills-sparepart" role="tab" aria-controls="v-pills-sparepart" aria-selected="true">Sparepart</button>
                            <button class="nav-link" id="v-pills-auction-tab" data-bs-toggle="pill" data-bs-target="#v-pills-auction" role="tab" aria-controls="v-pills-auction" aria-selected="false">Auction</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 py-auto">
                <p style="font-size: 14px; font-weight: 900;">Status :</p>
                <a href="#" class="btn btn-outline-secondary mx-1">All</a>
                <a href="#" class="btn btn-outline-secondary me-1">Ongoing</a>
                <a href="#" class="btn btn-outline-secondary me-1">Success</a>
                <a href="#" class="btn btn-outline-secondary me-1">Failed</a>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-sparepart" role="tabpanel" aria-labelledby="v-pills-sparepart-tab">
                @if (!empty($order))
                @foreach ($order as $o)
                <div class="card ecommerce-card mt-1">
                    <div class="card-body col-md-12 d-flex flex-column" style="position: sticky; top: 0;">
                        <div class="d-flex align-items-center">
                            <div class="d-flex flex-column flex-sm-row pt-1 mb-1 align-items-center">
                                <p class="mx-1 mb-0">{{ \Carbon\Carbon::parse($o->orderdate)->format('j M Y') }}</p>
                                <div class="d-flex align-items-center mx-5 my-auto">
                                    @if ($o->status === 'Cancelled')
                                    <span class="badge bg-light-danger text-danger">{{ $o->status }}</span>
                                    @elseif ($o->status === 'Waiting for Payment' || $o->status === 'Waiting for Confirmation')
                                    <span class="badge bg-light-warning text-danger">{{ $o->status }}</span>
                                    @else
                                    <span class="badge bg-light-success text-success">{{ $o->status }}</span>
                                    @endif
                                </div>
                                <p class="mx-1 mb-0">{{ $o->invoicenum }}</p>
                                <div class="mx-auto my-auto justify-content-end">
                                    <p class="my-1">Total Price</p>
                                    <p class="my-1">@currency($o->total_price)</p>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex align-items-center">
                            <p class="ms-1">{{ $o->name }}</p>
                        </div>
                        <div class="d-flex justify-content-end me-1">
                            <a data-bs-toggle="modal" href="#modalOrderDetails" onclick="getDetailOrders({{ $o->idorder }})" class="btn btn-flat-success mx-1">
                                Transaction Details
                            </a>
                            @if ($o->status === 'Waiting for Payment')
                            <a href="{{ route('payment_cancel', $o->idorder) }}" class="btn btn-danger me-1">
                                Cancel
                            </a>
                            <a href="{{ url('/payment', $o->idorder) }}" class="btn btn-info">
                                Pay
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
                @else
                    <p class="text-center mt-1">It's quite in here, please make some order🙏</p>
                @endif
                </div>
                <div class="tab-pane fade" id="v-pills-auction" role="tabpanel" aria-labelledby="v-pills-auction-tab">
                    @if (!empty($auctionorder))
                    @foreach ($auctionorder as $ao)
                    <div class="card ecommerce-card mt-1">
                        <div class="card-body col-md-12 d-flex flex-column" style="position: sticky; top: 0;">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-column flex-sm-row pt-1 mt-auto mb-1 align-items-center">
                                    <p class="mx-1 mb-0">#{{ $ao->lot_number }}</p>
                                    <div class="d-flex align-items-center mx-1 my-auto">
                                        @if ($ao->status === 'Waiting for Payment' || $ao->status === 'Waiting for Confirmation')
                                            <span class="badge bg-light-warning text-danger">{{ $ao->status }}</span>
                                        @else
                                            <span class="badge bg-light-success text-success">{{ $ao->status }}</span>
                                        @endif
                                    </div>
                                    <p class="mx-1 mb-0">#{{ $ao->invoicenum }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="item-img text-center">
                                        <a href="{{ route('vehicle.show', $ao->idvehicle) }}">
                                            <img src="{{ asset('/images/vehicle/'.$ao->idvehicle.'/' . $ao->url) }}" class="img-fluid" alt="img-placeholder" width="120" height="120"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="my-1">{{ $ao->brand }} - {{ $ao->vehiclename }}</h5>
                                    <p class="my-1">Last Bid Price: @currency($ao->current_price)</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="my-1">Total Price</p>
                                    <p class="my-1">@currency($ao->total_price)</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end me-1">
                                <a href="{{ route('vehicle.show', $ao->idvehicle) }}" class="btn btn-flat-success">
                                    Vehicle Details
                                </a>
                                <a href="#" class="btn btn-flat-success">
                                    Order Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                    <p class="text-center mt-1">It's quite in here, please make some order🙏</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalOrderDetails" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-wide" style="max-width: 750px">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5" id="orderDetails">

            </div>
        </div>
    </div>
</div>

<script>
    function getDetailOrders(id) {
        $.ajax({
            type:'POST',
            url:'{{route("transaction.details")}}',
            data:'_token= <?php echo csrf_token() ?> &id='+id,
            success:function(data) {
                $("#orderDetails").html(data.msg);
            }
        });
    }
</script>
@endsection
