@extends('layout.main')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <script src="https://unpkg.com/autoNumeric/autoNumeric.min.js"></script>
    <h3>Towing</h3>
    <div class="col-md-12 mx-auto" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h4>Add New Towing Package</h4>
                <form method="POST" action="{{ route('distance.post') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="ori">Origin</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" id="ori" name="origin"
                                                class="form-control flatpickr-basic" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="desti">Destination</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" id="desti" name="destination"
                                                class="form-control flatpickr-basic" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label class="form-label" for="towing-name">Towings Package</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="towing-name"
                                            placeholder="Enter Towings Name" name="name" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="arrival-estimation">Estimation Arrival(Days)</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="arrival-estimation"
                                            placeholder="Estimation Arrival" name="eta" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label" for="select-cat">Categories</label>
                                <select class="select2 form-select" id="select-cat" name="categories">
                                    <option value="">--Choose Categories--</option>
                                    @foreach ($cat as $c)
                                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="col-md-12 mb-1">
                                    <div class="col-md-12">
                                        <label class="form-label" for="description">Description</label>
                                        <div class="col-md-12 mb-2">
                                            <textarea name="desc" id="description" class="form-control" placeholder="Package Description" cols="30"
                                                rows="5">
                                            </textarea>
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
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Package List</h4>
                </div>
                <div class="table-responsive mb-1">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Package Name</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Price</th>
                                <th scope="col">ETA</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($towing as $t)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $t->packagename }} ({{ $t->name }})</td>
                                    <td>{{ $t->origin }} - {{ $t->destination }}</td>
                                    <td>@currency($t->price)</td>
                                    <td>{{ $t->eta }} Days</td>
                                    <td>Action</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(empty($towing))
                    <p class="text-center">NO DATA</p>
                @endif
            </div>
        </div>
    </div>
@endsection
