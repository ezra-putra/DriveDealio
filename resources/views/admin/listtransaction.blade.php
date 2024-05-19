@extends('layout.main')
@section('content')
<div class="row" id="table-striped" style="padding: 3vh;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transaction Sparepart</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Buyer Name</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1
                        @endphp
                        @foreach ( $sparepartOrder as $s )
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>
                                <a href="{{ url('/invoice-sparepart', $s->idorder) }}" aria-expanded="false" class="text-decoration-none" target="_blank">
                                    <span class="user-name" style="font-size: 14px">{{ $s->invoicenum }}</span>
                                </a>
                            </td>
                            <td>{{ $s->firstname }}</td>
                            <td>{{ $s->orderdate }}</td>
                            <td>@currency($s->total_price)</td>
                            <td>{{ $s->status }}</td>
                            <td>
                                <a data-bs-toggle="modal" href="#modalOrderDetails" onclick="getDetailOrders({{ $s->idorder }})" class="btn btn-flat-success mx-1">
                                    Details
                                </a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transaction Auction</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Buyer Name</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                                <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1
                        @endphp
                        @foreach ( $auctionOrder as $a )
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>
                                <a href="{{ url('/invoice-auction', $a->idorder) }}" aria-expanded="false" class="text-decoration-none" target="_blank">
                                    <span class="user-name" style="font-size: 14px">{{ $a->invoicenum }}</span>
                                </a>
                            </td>
                            <td>{{ $a->firstname }}</td>
                            <td>{{ $a->orderdate }}</td>
                            <td>@currency($a->total_price)</td>
                            <td>{{ $a->status }}</td>
                            <td>
                                <a data-bs-toggle="modal" href="#modalAuctionDetails" onclick="getAuctionDetails({{ $a->idorder }})" class="btn btn-flat-success mx-1">
                                    Details
                                </a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Transaction Membership</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Buyer Name</th>
                                <th scope="col">Membership</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $counter = 1
                        @endphp
                        @foreach ($member as $m)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>
                                <a href="{{ url('/invoice-membership', $m->idorder) }}" class="text-decoration-none mx-1 mb-0">{{ $m->invoicenum }}</a>
                            </td>
                            <td>{{ $m->firstname }}</td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->created_at }}</td>
                            <td>@currency($m->price)</td>
                            <td>{{ $m->status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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

<div class="modal fade" id="modalAuctionDetails" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-wide" style="max-width: 750px">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5" id="auctionDetails">

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

<script>
    function getAuctionDetails(id) {
        $.ajax({
            type:'POST',
            url:'{{route("auction.details")}}',
            data:'_token= <?php echo csrf_token() ?> &id='+id,
            success:function(data) {
                $("#auctionDetails").html(data.msg);
            }
        });
    }
</script>
@endsection
