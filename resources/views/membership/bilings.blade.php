@extends('layout.main')
@section('content')
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/modal-create-app.css">

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
        <script type="text/javascript"
          src="https://app.sandbox.midtrans.com/snap/snap.js"
          data-client-key="SB-Mid-client-OHRI34QOyaGdOTJv"></script>
    </head>
    <h3>MyMemberships</h3>
    @if (auth()->user()->roles_id != 1)
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h4>Membership Details</h4>
                <div class="col-md-12 mt-1">
                @if (empty($member))
                    <h4 class="text-center">No Active Membership</h4>
                    <div class="text-center">
                        <a href="/membership/register" class="btn btn-info mt-2">Register Membership</a>
                    </div>
                @else
                    @if ($member[0]->status != 'Not Active')
                    <p>Type: {{ $member[0]->name }}</p>
                    @if ($member[0]->paymentstatus === 'Unpaid')
                        <p>Status: {{ $member[0]->status }}({{ $member[0]->paymentstatus }})</p>
                    @else
                        <p>Status: {{ $member[0]->status }}</p>
                    @endif
                    <p>Valid until: {{ $member[0]->end }}</p>
                    @if ($member[0]->paymentstatus != 'Unpaid')
                        <a href="{{ url('cancel_post', $member[0]->idhasmember) }}" class="btn btn-danger mt-2 float-end">Cancel Membership</a>
                    @else
                    <div class="d-flex justify-content-end">
                        <button id="pay-button" class="btn btn-info mt-2 float-end me-1">Pay</button>
                        <a href="{{ url('cancel_post', $member[0]->idhasmember) }}" class="btn btn-danger mt-2 float-end">Cancel Membership</a>
                    </div>
                    @endif
                    @else
                    <h4 class="text-center">No Active Membership</h4>
                    <div class="text-center">
                        <a href="/membership/register" class="btn btn-info mt-2">Register Membership</a>
                    </div>
                    @endif
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
                    <h4>Transaction History</h4>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Invoice Number</th>
                            <th scope="col">Membership Type</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            @if (auth()->user()->roles_id === 1)
                                <th scope="col">Users</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $m)
                            <tr>
                                <td>
                                    <a href="{{ url('/invoice-membership', $m->idorder) }}" class="text-decoration-none mx-1 mb-0">{{ $m->invoicenum }}</a>
                                </td>
                                <td>{{ $m->name }}</td>
                                <td>{{ $m->start }}</td>
                                <td>{{ $m->end }}</td>
                                <td>{{ $m->status }}</td>
                                @if (auth()->user()->roles_id === 1)
                                    <td>{{ $m->firstname }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(empty($member))
                    <p class="text-center mt-1">NO DATA</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Select Payment --}}
    @if (auth()->user()->roles_id != 1)
    <script type="text/javascript">
        @if (!empty($member))
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $member[0]->snap_token }}', {
            onSuccess: function(result){
                /* You may add your own implementation here */
                window.location.href = '{{ route('payment-post', $member[0]->idorder) }}';
            },
            onPending: function(result){
                /* You may add your own implementation here */
                alert("wating your payment!"); console.log(result);
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("payment failed!"); console.log(result);
            },
            onClose: function(){
                /* You may add your own implementation here */
                alert('you closed the popup without finishing the payment');
            }
            })
        });
        @endif
    </script>
    @endif
@endsection
