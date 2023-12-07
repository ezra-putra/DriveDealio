@extends('layout.main')
@section('content')
    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Sparepart List</h4>
                    <a href="/seller/add-sparepart" class="btn btn-icon btn-primary">
                        <i data-feather="plus" class="me-50"></i>
                        <span>Add Sparepart</span></a>
                </div>
                <div class="table-responsive mb-1">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Part Name</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sparepart as $s)
                                <tr>
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->partnumber }} - {{ $s->partname }} {{ $s->vehiclemodel }}
                                        {{ $s->buildyear }}, {{ $s->colour }}</td>
                                    <td>{{ $s->stoock }}</td>
                                    <td>{{ $s->unitprice }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(empty($sparepart))
                    <p class="text-center">NO DATA</p>
                @endif
            </div>
        </div>
    </div>
@endsection
