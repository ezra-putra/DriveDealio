@extends('layout.main')
@section('content')
<table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Email</th>
        <th scope="col">Name</th>
        <th scope="col">Phone Number</th>
        <th scope="col">Address</th>
        <th scope="col">City, Province</th>
        <th scope="col">Role</th>
      </tr>
    </thead>
    <tbody>
      @foreach ( $users as $us )
        <tr>
            <td>{{ $us->id }}</td>
            <td>{{ $us->email }}</td>
            <td>{{ $us->firstname }} {{ $us->lastname }}</td>
            <td>{{ $us->phonenumber }}</td>
            <td>{{ $us->address }}</td>
            <td>{{ $us->city }}, {{ $us->province }}</td>
            <td>{{ $us->name }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
