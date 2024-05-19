@extends('layout.main')
@section('content')
    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Order List</h4>
                </div>
                <div class="table-responsive mb-1">
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
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1
                            @endphp
                            @foreach ($orderlist as $o)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>
                                        <a href="{{ url('/invoice-sparepart', $o->idorder) }}" aria-expanded="false" class="text-decoration-none" target="_blank">
                                            <span class="user-name" style="font-size: 14px">{{ $o->invoicenum }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $o->firstname }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s.u', $o->orderdate)->format('d M Y') }}</td>
                                    <td>@currency($o->total_price)</td>
                                    <td>{{ $o->status }}</td>
                                    <td>
                                        <a data-bs-toggle="modal" href="#modalOrderDetails" onclick="getDetailOrders({{ $o->idorder }})" class="btn btn-flat-success mx-1">
                                            Details
                                        </a>
                                    </td>
                                    <td>
                                        @if ($o->status == "Waiting for Confirmation")
                                        <a href="{{ route('approve_post', $o->idorder) }}" class="btn btn-icon btn-outline-info">
                                            <i data-feather="check"></i>
                                            <span>Confirm</span>
                                        </a>
                                        @endif
                                        @if ($o->status == "On Process")
                                        <a href="{{ route('delivery_post', $o->idorder) }}" class="btn btn-icon btn-outline-info">
                                            <i data-feather="truck"></i>
                                            <span>Delivery</span>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(empty($orderlist))
                    <p class="text-center">NO DATA</p>
                @endif
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
