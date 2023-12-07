@extends('layout.main')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <script src="https://unpkg.com/autoNumeric/autoNumeric.min.js"></script>
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Add Appointment Schedule</h3>
                <div class="bs-stepper-content row my-2">
                    <form method="POST" action="{{ route('inspector.appointmentCreate') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-1">
                            <div class="col-6">
                                <label class="form-label" for="appointment-date">Appointment Date</label>
                                <div class="input-group input-group-merge">
                                    <input type="date" id="appointment-date" name="appointmentdate"
                                        class="form-control flatpickr-basic" placeholder="YYYY-MM-DD" />
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="appointment-time">Appointment Time</label>
                                <div class="input-group input-group-merge">
                                    <input type="date" id="appointment-time" name="appointmenttime"
                                        class="form-control flatpickr-basic" placeholder="H:i:S" />
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script type="text/javascript">
            // Initialize Flatpickr with minDate option
            flatpickr("#appointment-date", {
                minDate: "today",
                dateFormat: "Y-m-d" // Optional: Set the desired date format
            });

            flatpickr("#appointment-time", {
                enableTime: true, // Aktifkan input waktu
                noCalendar: true, // Hilangkan kalender, karena Anda hanya ingin waktu
                dateFormat: "H:i", // Format waktu dengan detik
                defaultDate: "08:00",
                maxTime: "14:00",

                // Tentukan waktu yang tersedia

            });
        </script>
    @endsection
