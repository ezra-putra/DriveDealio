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
                                        <a href="{{ route('transaction.details', $o->idorder) }}" aria-expanded="false" class="text-decoration-none">
                                            <span class="user-name" style="font-size: 14px">{{ $o->invoicenum }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $o->firstname }}</td>
                                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s.u', $o->orderdate)->format('d M Y') }}</td>
                                    <td>@currency($o->total_price)</td>
                                    <td>{{ $o->status }}</td>
                                    <td>
                                        @if ($o->status == "Waiting for Confirmation")
                                        <a href="{{ route('approve_post', $o->idorder) }}" class="btn btn-icon btn-flat-info">
                                            <i data-feather="check"></i>
                                        </a>
                                        @endif
                                        @if ($o->status == "On Process")
                                        <a href="#" class="btn btn-icon btn-flat-info">
                                            <i data-feather="truck"></i>
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
@endsection
