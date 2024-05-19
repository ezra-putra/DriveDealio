@extends('layout.main')
@section('content')
<h3>Membership Register</h3>
<form action="{{ route('membership.store') }}" method="POST" enctype="multipart/form-data">
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="bs-stepper-content row my-2">
                        @csrf
                        <div class="col-md-6">
                            @foreach ( $user as $u)
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="username">Name</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="username"
                                                placeholder="Enter Name" name="name" value="{{ $u->name }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" for="phonenum">Phone Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="phonenum"
                                                placeholder="Enter Phone Number" name="phone" value="{{ $u->phonenumber }}" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @if ($document[0]->npwpktpcheck === false)
                                <div class="col-md-12">
                                    <label for="fileKtp" class="form-label">Upload Scan KTP</label>
                                    <input class="form-control" type="file" id="fileKtp" name="ktp" accept=".pdf" required/>
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                        PDF file format is accepted.</p>
                                </div>
                                <div class="col-md-12">
                                    <label for="fileNpwp" class="form-label">Upload Scan NPWP</label>
                                    <input class="form-control" type="file" id="fileNpwp" name="npwp" accept=".pdf" required/>
                                    <p style="color: red; margin-left: 5px; size: 10px;">*Maximum file size is 2MB, and only
                                        PDF file format is accepted.</p>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="row custom-options-checkable g-1">
                                    @foreach ($membership as $m)
                                    <div class="col-md-6 mb-1">
                                        <input class="custom-option-item-check" type="radio" name="member" value="{{ $m->id }}" id="rdomember-{{ $m->id }}" onchange="updateMemberPrice({{ $m->price }})" checked/>
                                        <label class="custom-option-item p-1" for="rdomember-{{ $m->id }}">
                                            <span class="d-flex justify-content-between flex-wrap mb-50">
                                                <span class="fw-bolder">{{ $m->membershiptype }}</span>
                                                <span class="fw-bolder">@currency($m->price)</span>
                                            </span>
                                            <small class="d-block">{{ $m->description }}</small>
                                        </label>
                                    </div>
                                    @endforeach

                                    <div class="col-md-12 border border-1">
                                        <h5 class="mt-1">Order Details</h5>
                                        <div class="row">
                                            <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                                                <p style="font-size: 14px;font-weight:500; ">Sub Total</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <p style="font-size: 14px; font-weight:500;" class="mt-1" id="subtotal">@currency(0)</p>
                                            </div>
                                        </div>
                                        <hr style="height:5px;border-width:0;color:gray;background-color:lightgray">
                                        <div class="row">
                                            <label for="colFormLabelLg" class="col-sm-8 col-form-label-lg">
                                                <p style="font-size: 14px;font-weight:600; ">Total Price</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <p style="font-size: 14px; font-weight:600;" class="mt-1" id="finalprice">@currency(0)</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="d-flex justify-content-end me-1">
                                <input type="hidden" name="totalprice" id="totalPrice" value="">
                                <input type="submit" class="btn btn-info btn-submit" value="Create Order">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>
<script>
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            currencyDisplay: 'symbol'
        }).format(amount);
    }
    function updateMemberPrice(price) {
        var formatedSubTotal = formatCurrency(price);
        document.getElementById('subtotal').innerText = formatedSubTotal;
        var finalPrice = price;
        var formatedFinalPrice = formatCurrency(finalPrice);
        document.getElementById('finalprice').innerText = formatedFinalPrice;

        document.getElementById('totalPrice').value = finalPrice;
    }
</script>
@endsection
