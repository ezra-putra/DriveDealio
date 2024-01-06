@extends('layout.main')
@section('content')
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-wizard.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/modal-create-app.css">


    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">MyVehicle List</h4>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Membership Type</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            @if (auth()->user()->roles_id === 1)
                                <th scope="col">Users</th>
                            @endif
                            <th scope="col">Create at</th>
                            <th scope="col">Update at</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $m)
                            <tr>
                                <td>{{ $m->idhasmember }}</td>
                                <td>{{ $m->membershiptype }}</td>
                                <td>{{ $m->start }}</td>
                                <td>{{ $m->end }}</td>
                                <td>{{ $m->status }}</td>
                                @if (auth()->user()->roles_id === 1)
                                    <td>{{ $m->name }}</th>
                                @endif
                                <td>{{ $m->created_at }}</td>
                                <td>{{ $m->updated_at }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                            data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            @if (auth()->user()->roles_id == 1)
                                                <a href="{{ url('approve_post', $m->idhasmember) }}" class="dropdown-item"
                                                    @if ($m->status == 'Cancelled' || $m->status == "Approved") style="cursor:not-allowed; pointer-events: none" @endif>
                                                    <i data-feather="check" class="me-50"></i>
                                                    <span>Approve</span>
                                                </a>
                                                <a href="{{ url('cancel_post', $m->idhasmember) }}" class="dropdown-item"
                                                    @if ($m->status == 'Approved' || $m->status == 'Cancelled') style="cursor:not-allowed; pointer-events: none" @endif>
                                                    <i data-feather="x" class="me-50"></i>
                                                    <span>Cancel</span>
                                                </a>
                                            @else
                                                <a href="{{ url('cancel_post', $m->idhasmember) }}" class="dropdown-item"
                                                    @if ($m->status == 'Approved') style="cursor:not-allowed; pointer-events: none" @endif>
                                                    <i data-feather="x" class="me-50"></i>
                                                    <span>Cancel</span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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

    <script>
        // Make an AJAX request when the page loads
        window.addEventListener('DOMContentLoaded', function () {
            updateMembershipStatuses();
        });

        function updateMembershipStatuses() {
            // Make an AJAX request to the controller method
            fetch('{{ route('expired_post') }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                // Handle the response, e.g., display a message
                document.getElementById('ajax-response').innerText = data.message;
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
