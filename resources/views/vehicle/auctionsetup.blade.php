@extends('layout.main')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <script src="https://unpkg.com/autoNumeric/autoNumeric.min.js"></script>
    <h3>Auction Setup</h3>
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Inspection Information</h5>
                        <hr style="height:1px;border-width:0;color:gray;background-color:lightgray">
                        @foreach ($inspection as $i)
                        <div class="row">
                            <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                <p style="font-size: 14px;">Inspection Date</p>
                            </label>
                            <div class="col-sm-6">
                                <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                    {{ $i->inspectiondatetime }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                <p style="font-size: 14px;">Price Recommendation</p>
                            </label>
                            <div class="col-sm-6">
                                <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                    @currency($i->recprice)
                                </p>
                            </div>
                        </div>
                        <h6>Grading</h6>
                        <div class="row">
                            <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                <p style="font-size: 14px;">Exterior</p>
                            </label>
                            <div class="col-sm-6">
                                <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                    {{ $i->exterior }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                <p style="font-size: 14px;">Interior</p>
                            </label>
                            <div class="col-sm-6">
                                <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                    {{ $i->interior }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                <p style="font-size: 14px;">Mechanism</p>
                            </label>
                            <div class="col-sm-6">
                                <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                    {{ $i->mechanism }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <label for="colFormLabelLg" class="col-sm-6 col-form-label-lg">
                                <p style="font-size: 14px;">Engine</p>
                            </label>
                            <div class="col-sm-6">
                                <p style="font-size: 14px; font-weight: bold" class="mt-1" id="countdown">
                                    {{ $i->engine }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @foreach ($vehicle as $v)
                        <form method="POST" action="{{ route('auctionSetup', $v->idvehicle) }}"
                                enctype="multipart/form-data">
                        @endforeach
                            <div class="bs-stepper-content row my-2">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <div class="col-lg-12 col-md-6 col-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label" for="idr-input">Price</label>
                                                <div class="col-md-12 mb-1">
                                                    <input type="text" class="form-control" id="idr-input" placeholder="Set Price"
                                                        name="price" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="dateInput">Auction Start Date</label>
                                                <div class="col-md-12 mb-2">
                                                    <input type="text" id="dateInput" name="startdate"
                                                        class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="dateInput">Auction End Date</label>
                                                <div class="col-md-12 mb-2">
                                                    <input type="text" id="dateInput" name="enddate"
                                                        class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <input type="submit" class="btn btn-info" value="Finish Setup">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script type="text/javascript">

        var today = new Date();
        var minDate = new Date(today);
        minDate.setDate(today.getDate() + 1)
        // Initialize Flatpickr with minDate option
        flatpickr("#dateInput", {
            minDate: minDate,
            dateFormat: "Y-m-d"
        });
    </script>

    <script>
        var idr = document.getElementById("idr-input");
        idr.addEventListener("keyup", function (e) {
            idr.value = formatRupiah(this.value, "Rp. ");
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }
    </script>
@endsection
