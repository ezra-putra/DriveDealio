@extends('layout.main')
@section('content')

<div class="col-md-12" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <h4>Loan Information</h4>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 12px; font-weight: bold">Total Bids</p>
                        </label>
                        <div class="col-sm-6">
                            <p style="font-size: 12px; font-weight: bold" class="mt-1" id="totalPrice">0</p>
                        </div>
                    </div>
                    <div class="row">
                        <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                            <p style="font-size: 12px; font-weight: bold">Total Auction Win</p>
                        </label>
                        <div class="col-sm-5">
                            <p style="font-size: 12px; font-weight: bold" class="mt-1" id="totalPrice" >ANNITAMAXWINN</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body col-md-12" style="position: sticky; top: 0;">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-payable-tab" data-bs-toggle="tab" data-bs-target="#nav-payable" type="button" role="tab" aria-controls="nav-payable" aria-selected="true">Payable Bill</button>
                            <button class="nav-link" id="nav-paid-tab" data-bs-toggle="tab" data-bs-target="#nav-paid" type="button" role="tab" aria-controls="nav-paid" aria-selected="false">Paid Bill</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-payable" role="tabpanel" aria-labelledby="nav-payable-tab">
                            @if (!empty($payableloan))
                            @foreach ($payableloan as $pl)
                            <div class="col-md-12 mt-1">
                                <div class="card border border-3">
                                    <div class="card-body col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h4 style="font-weight: 600;">@currency($pl->total_bill)</h4>
                                                @php
                                                    $tenor = $pl->loantenor * 12;
                                                @endphp
                                                <p class="mt-1">{{ $pl->paymentcount }} out of {{ $tenor }} installments</p>
                                                <p>Type: {{ $pl->type }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex flex-column justify-content-end">
                                                    <div class="d-flex justify-content-end mb-1">
                                                        <span class="badge bg-light-warning text-danger">{{ $pl->status }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <p>{{ \Carbon\Carbon::parse($pl->created_at)->isoFormat('DD MMMM YYYY, HH:mm') }}</p>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <a href="{{ url('/monthly-payment', $pl->idloanpay) }}" class="btn btn-info">Pay</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                                <p class="text-center mt-1" style="font-weight : bold;">No dues to pay currently.</p>
                            @endif

                        </div>
                        <div class="tab-pane fade" id="nav-paid" role="tabpanel" aria-labelledby="nav-paid-tab">
                            @foreach ($paidloan as $pd)
                            <div class="col-md-12 mt-1">
                                <div class="card border border-3">
                                    <div class="card-body col-md-12">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h4 style="font-weight: 600;">@currency($pd->total_bill)</h4>
                                                @php
                                                    $tenor = $pd->loantenor * 12;
                                                @endphp
                                                <p class="mt-1">{{ $pd->paymentcount }} out of {{ $tenor }} installments</p>
                                                <p>Type: {{ $pd->type }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex flex-column justify-content-end">
                                                    <div class="d-flex justify-content-end mb-1">
                                                        <span class="badge bg-light-success text-success">{{ $pd->status }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <p>{{ \Carbon\Carbon::parse($pd->paymentdatetime)->isoFormat('DD MMMM YYYY, HH:mm') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
