@extends('layout.main')
@section('content')
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/modal-create-app.css">

    <h3>MyMemberships</h3>

    @if (auth()->user()->roles_id != 1)
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h4>Membership Details</h4>
                <div class="col-md-12 mt-1">
                    @if ($member[0]->status != 'Not Active')
                    <p>Type: {{ $member[0]->name }}</p>
                    @if ($member[0]->paymentstatus === 'Unpaid')
                        <p>Status: {{ $member[0]->status }}({{ $member[0]->paymentstatus }})</p>
                    @else
                        <p>Status: {{ $member[0]->status }}</p>
                    @endif
                    <p>Valid until: {{ $member[0]->end }}</p>
                    <div class="progress mt-3">
                        <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%;" aria-valuemin="{{ $progressPercentage }}" aria-valuemax="100"></div>
                    </div>
                    <div class="text-center mt-2">
                        <span>Expires in {{ $daysRemaining }} Days</span>
                    </div>
                    @if ($member[0]->paymentstatus != 'Unpaid')
                        <a href="{{ url('cancel_post', $member[0]->idhasmember) }}" class="btn btn-danger mt-2 float-end">Cancel Membership</a>
                    @else
                    <div class="d-flex justify-content-end">
                        <a href="#modalPayment" data-bs-toggle="modal" class="btn btn-info mt-2 float-end me-1">Pay</a>
                        <a href="{{ url('cancel_post', $member[0]->idhasmember) }}" class="btn btn-danger mt-2 float-end">Cancel Membership</a>
                    </div>
                    @endif
                    @else
                    <h4 class="text-center">No Active Membership</h4>
                    <div class="text-center">
                        <a href="/membership/register" class="btn btn-info mt-2">Register Membership</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Membership History</h4>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Membership Type</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            @if (auth()->user()->roles_id === 1)
                                <th scope="col">Users</th>
                                <th scope="col">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $m)
                            <tr>
                                <td>{{ $m->name }}</td>
                                <td>{{ $m->start }}</td>
                                <td>{{ $m->end }}</td>
                                <td>{{ $m->status }}</td>
                                @if (auth()->user()->roles_id === 1)
                                    <td>{{ $m->firstname }}</td>
                                    <td>
                                        @if ($m->status === 'Pending')
                                            <a href="{{ url('approve_post', $m->idhasmember) }}" class="btn btn-outline-success">Approve</a>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Select Payment --}}
    <div class="modal fade" id="modalPayment" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-sm-5 mx-50 pb-5">
                    <h1 class="text-center mb-1" id="addNewCardTitle">Select Payment Method</h1>
                    <!-- form -->
                    <form action="{{ route('payment.post', $member[0]->idhasmember) }}" method="POST"
                        enctype="multipart/form-data" class="row gy-1 gx-2 mt-75" id="payform">
                        @csrf
                        <div class="col-12">
                            <label class="form-label" for="select-pay">Payment Method</label>
                                <select class="select2 form-select" id="select-pay" name="payment">
                                    <option value="">--Choose Payment Method--</option>
                                    <option value="M-Banking">M-Banking</option>
                                </select>
                        </div>
                        <div class="col-12 text-center">
                            <input type="submit" id="submitBid" class="btn btn-primary me-1 mt-1" value="Pay">
                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var expirationDate = new Date('{{ $member[0]->end }}');
        var currentDate = new Date();
        var daysRemaining = Math.ceil((expirationDate - currentDate) / (1000 * 60 * 60 * 24));
        var progressPercentage = (daysRemaining / 365) * 100;
        var progressBar = document.querySelector('.progress-bar');
        progressBar.style.width = progressPercentage + '%';
    </script>
@endsection
