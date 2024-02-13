@extends('layout.main')
@section('content')
<h3>User List</h3>
<div class="col-md-12 mx-auto" style="padding: 3vh;">
    <div class="row" id="table-striped" >
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">All User</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ( $user as $us )
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $us->email }}</td>
                                <td>{{ $us->firstname }} {{ $us->lastname }}</td>
                                <td>{{ $us->phonenumber }}</td>
                                <td>{{ $us->name }}</td>
                                <td>
                                  <div class="dropdown">
                                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                          <i data-feather="more-vertical"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">
                                              <i data-feather="edit-2" class="me-50"></i>
                                              <span>Edit</span>
                                          </a>
                                          <a class="dropdown-item" href="#">
                                              <i data-feather="trash" class="me-50"></i>
                                              <span>Delete</span>
                                          </a>
                                      </div>
                                  </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row" id="table-striped">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Admin List</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ( $useradmin as $ua )
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $ua->email }}</td>
                                <td>{{ $ua->firstname }} {{ $ua->lastname }}</td>
                                <td>
                                  <div class="dropdown">
                                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                          <i data-feather="more-vertical"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">
                                              <i data-feather="edit-2" class="me-50"></i>
                                              <span>Edit</span>
                                          </a>
                                          <a class="dropdown-item" href="#">
                                              <i data-feather="trash" class="me-50"></i>
                                              <span>Delete</span>
                                          </a>
                                      </div>
                                  </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Inspector List</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ( $userinspector as $ui )
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $ui->email }}</td>
                                <td>{{ $ui->firstname }} {{ $ui->lastname }}</td>
                                <td>
                                  <div class="dropdown">
                                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                          <i data-feather="more-vertical"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">
                                              <i data-feather="edit-2" class="me-50"></i>
                                              <span>Edit</span>
                                          </a>
                                          <a class="dropdown-item" href="#">
                                              <i data-feather="trash" class="me-50"></i>
                                              <span>Delete</span>
                                          </a>
                                      </div>
                                  </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="table-striped">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Buyer List</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ( $userbuyer as $ub )
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $ub->email }}</td>
                                <td>{{ $ub->firstname }} {{ $ub->lastname }}</td>
                                <td>{{ $ub->phonenumber }}</td>
                                <td>{{ $ub->name }}</td>
                                <td>
                                  <div class="dropdown">
                                      <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                          <i data-feather="more-vertical"></i>
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-end">
                                          <a class="dropdown-item" href="#">
                                              <i data-feather="edit-2" class="me-50"></i>
                                              <span>Edit</span>
                                          </a>
                                          <a class="dropdown-item" href="#">
                                              <i data-feather="trash" class="me-50"></i>
                                              <span>Delete</span>
                                          </a>
                                      </div>
                                  </div>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- list and filter end -->
@endsection
