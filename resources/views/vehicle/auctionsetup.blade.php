@extends('layout.main')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <script src="https://unpkg.com/autoNumeric/autoNumeric.min.js"></script>
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Auction Setup</h3>
                @foreach ($vehicle as $v)
                    <form method="POST" action="{{ route('auctionSetup', $v->idvehicle) }}"
                        enctype="multipart/form-data">
                @endforeach
                <div class="bs-stepper-content row my-2">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label" for="idr-input">Price</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="number" class="form-control" id="idr-input" placeholder="Set Price"
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
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </div>
                </div>
                </form>
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
@endsection
