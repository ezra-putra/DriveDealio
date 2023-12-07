@extends('layout.main')
@section('content')
    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">MyVehicle List</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Vehicle Name</th>
                                <th scope="col">Plate Number</th>
                                <th scope="col">Input Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Auction Time Remaining</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicle as $v)
                                <tr>
                                    <td>{{ $v->idvehicle }}</td>
                                    <td>{{ $v->brand }} {{ $v->name }} {{ $v->transmission }}</td>
                                    <td>{{ $v->platenumber }}</td>
                                    <td>{{ $v->inputdate }}</td>
                                    @if (auth()->user()->roles_id === 1)
                                        <td>{{ $v->firstname }}</th>
                                    @endif
                                    <td>{{ $v->adstatus }}</td>
                                    <td id="countdown">{{ $v->duration }}</td>

                                    <td>
                                        @if ($v->adstatus === 'Setup Auction')
                                            <a class="btn btn-icon btn-flat-info"
                                                href="{{ route('auctionSetupBtn', $v->idvehicle) }}">
                                                <i data-feather="edit" class="me-50"></i>
                                                <span>Setup Auction</span>
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
        <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
            <div class="modal-dialog">
                <form class="add-new-user modal-content pt-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
                            <input type="text" class="form-control dt-full-name" id="basic-icon-default-fullname"
                                placeholder="John Doe" name="user-fullname" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-uname">Username</label>
                            <input type="text" id="basic-icon-default-uname" class="form-control dt-uname"
                                placeholder="Web Developer" name="user-name" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-email">Email</label>
                            <input type="text" id="basic-icon-default-email" class="form-control dt-email"
                                placeholder="john.doe@example.com" name="user-email" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-contact">Contact</label>
                            <input type="text" id="basic-icon-default-contact" class="form-control dt-contact"
                                placeholder="+1 (609) 933-44-22" name="user-contact" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="basic-icon-default-company">Company</label>
                            <input type="text" id="basic-icon-default-company" class="form-control dt-contact"
                                placeholder="PIXINVENT" name="user-company" />
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="country">Country</label>
                            <select id="country" class="select2 form-select">
                                <option value="Australia">USA</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Canada">Canada</option>
                                <option value="China">China</option>
                                <option value="France">France</option>
                                <option value="Germany">Germany</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Japan">Japan</option>
                                <option value="Korea">Korea, Republic of</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Russia">Russian Federation</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label class="form-label" for="user-role">User Role</label>
                            <select id="user-role" class="select2 form-select">
                                <option value="subscriber">Subscriber</option>
                                <option value="editor">Editor</option>
                                <option value="maintainer">Maintainer</option>
                                <option value="author">Author</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="user-plan">Select Plan</label>
                            <select id="user-plan" class="select2 form-select">
                                <option value="basic">Basic</option>
                                <option value="enterprise">Enterprise</option>
                                <option value="company">Company</option>
                                <option value="team">Team</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary me-1 data-submit">Submit</button>
                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Ambil data start_date dan end_date dari PHP dan konversi ke UTC
        var startDate = new Date("{{ $vehicle[0]->start_date }}").getTime();
        var endDate = new Date("{{ $vehicle[0]->end_date }}").getTime();

        // Update durasi setiap detik


        function startTimer(status) {
            if ($v->adstatus === "Open to Bid") {
                // Tanggal akhir lelang (gantilah dengan tanggal yang sesuai)
                var endDate = new Date().getTime();

                var x = setInterval(function() {
                    // Dapatkan waktu sekarang dalam UTC
                    var now = new Date().getTime();

                    // Hitung selisih waktu antara sekarang dan end_date
                    var distance = endDate - now;

                    // Hitung hari, jam, menit, dan detik
                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Tampilkan durasi di elemen dengan id "countdown"
                    $("#countdown").html(days + "D " + hours + "H " + minutes + "M " + seconds + "S ");

                    // Jika waktu sudah habis, tampilkan pesan atau lakukan aksi tertentu
                    if (distance < 0) {
                        clearInterval(x);
                        $("#countdown").html("Auction Ended");
                    }
                }, 1000);
            } else {
                // Jika status iklan tidak disetujui, mungkin tampilkan pesan atau lakukan aksi lainnya
                $("#countdown").html("Waiting for approval");
            }
        }

        function updateAdStatus() {
            $.ajax({
                type: 'POST',
                url: '/update-ad-status', // Sesuaikan dengan URL rute yang sesuai di Laravel
                data: {
                    auctionId: "{{ $vehicle[0]->idauction }}"
                },
                success: function(response) {
                    console.log(response); // Tampilkan respons dari server jika diperlukan
                },
                error: function(error) {
                    console.error(error); // Tampilkan pesan kesalahan jika terjadi
                }
            });
        }
    </script>
@endsection
