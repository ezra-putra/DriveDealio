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
                                    <a class="btn btn-flat-info" data-bs-toggle="modal" href="#modalRole" onclick="getModalEditRole({{ $us->iduser }})">
                                        <i data-feather="edit"></i>
                                        <span>Role</span>
                                    </a>
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
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="table-striped">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Courier List</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone Number</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ( $courier as $c )
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $c->email }}</td>
                                <td>{{ $c->firstname }} {{ $c->lastname }}</td>
                                <td>{{ $c->phonenumber }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-8">
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
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalRole" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-sm-5 mx-50 pb-5">
                <h1 class="text-center mb-1" id="addNewCardTitle">User Role Information</h1>
                <div id="inputForm">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getModalEditRole(id) {
        $.ajax({
            type:'POST',
            url:'{{route("edit.role-form")}}',
            data:'_token= <?php echo csrf_token() ?> &id='+id,
            success:function(data) {
                $("#inputForm").html(data.msg);
            }
        });
    }
</script>

@endsection
