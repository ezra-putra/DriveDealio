@extends('layout.main')
@section('content')
<h3>Loan List</h3>
<div class="col-md-12 mx-auto" style="padding: 3vh;">
    <div class="row" id="table-striped">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Applicant List</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Invoice</th>
                                <th scope="col">Monthly Payment</th>
                                <th scope="col">Loan Tenor(Year)</th>
                                <th scope="col">Loan Applicant Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ( $loan as $l )
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $l->invoicenum }}</td>
                                <td>@currency($l->monthlypayment)</td>
                                <td>{{ $l->loantenor }}</td>
                                <td>{{ $l->firstname }} {{ $l->lastname }}</td>
                                <td>{{ $l->phonenumber }}</td>
                                <td>{{ $l->status }}</td>
                                <td>
                                    @if ($l->status === 'Waiting for Approval')
                                        <a href="{{ route('loan.approve', $l->idloan) }}" class="btn btn-icon btn-flat-success mb-1">
                                            <i data-feather="check" class="me-50"></i>
                                            <span>Approve</span>
                                        </a>
                                        <a href="{{ route('loan.reject', $l->idloan) }}" class="btn btn-icon btn-flat-danger">
                                            <i data-feather="x" class="me-50"></i>
                                            <span>Reject</span>
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
</div>
@endsection
