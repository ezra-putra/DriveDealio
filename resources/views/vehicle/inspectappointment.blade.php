@extends('layout.main')
@section('content')
<meta name="csrf_token" content="{{ csrf_token() }}"/>
<h3>Inspection Appointment</h3>
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                @foreach ($vehicle as $v)
                <form method="POST" action="{{ route('appointmentDate', ['id' => $v->idvehicle]) }}">
                @csrf
                @method('PUT')
                <div class="bs-stepper-content row my-2">
                    <div class="col-md-6">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="row">
                                <div class="col-md-12 mb-1">
                                    <label class="form-label" for="select-date">Inspection Date</label>
                                    <select class="select2 form-select" id="select-date" name="inspectiondate">
                                        <option value="">--Choose Inspection Date--</option>
                                        @foreach ($appointment as $a)
                                            <option value="{{ $a->idappointment }}">{{ $a->name }} -
                                                {{ $a->appointmentdate }} - {{ $a->appointmenttime }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="col-12 mb-1">
                                <label class="form-label" for="address">Address</label>
                                <input type="text" name="address" id="address"
                                    class="form-control" placeholder="Address" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="col-12 mb-1">
                            <label class="form-label" for="select-province">Province</label>
                            <select class="form-select" id="select-province" name="province">
                                <option value="">--Choose Province--</option>
                                @foreach ($provinces as $p)
                                    <option value="{{ $p->province_id }}">{{ $p->province_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 mb-1">
                            <label class="form-label" for="select-cities">City</label>
                            <select class="form-select" id="select-cities" name="city">
                                <option value="">--Choose City--</option>
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <input type="submit" class="btn btn-success" value="Confirm">
                        </div>
                    </div>
                </form>
                @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(function () {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content') }
            });

            $(function(){
                $('#select-province').on('change', function() {
                    let province_id = $('#select-province').val();
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('cities') }}",
                        data: { province_id:province_id },
                        cache: false,

                        success: function(params){
                            $('#select-cities').html(params);
                        },
                        error: function(data){
                            console.log(data);
                        }
                    })
                })
            })
        });
    </script>
@endsection
