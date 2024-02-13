@extends('layout.main')
@section('content')
<div class="row" id="table-striped" style="padding: 3vh;">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Seller List</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Shop Name</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Owner</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $seller as $s )
                        <tr>
                            <td>{{ $s->idshop }}</td>
                            <td>{{ $s->shopname }}</td>
                            <td>{{ $s->address }}</td>
                            <td>{{ $s->phonenumber }}</td>
                            <td>{{ $s->firstname }}</td>
                            <td>{{ $s->status }}</td>
                            <td>
                                @if ($s->status == 'Pending')
                                <a class="btn btn-icon btn-flat-success" href="{{ route('admin.approve', $s->idshop) }}">
                                    <i data-feather="check" class="me-50"></i>
                                    <span>Approve</span>
                                </a>
                                @endif

                                @if ($s->status == 'Active')
                                <a class="btn btn-icon btn-flat-danger" href="{{ route('admin.suspend', $s->idshop) }}">
                                    <i data-feather="x" class="me-50"></i>
                                    <span>Suspend</span>
                                </a>
                                @endif
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- list and filter end -->
@endsection
