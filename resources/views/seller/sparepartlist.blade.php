@extends('layout.main')
@section('content')
<h3>Sparepart</h3>
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Add New Sparepart</h3>
                <form action="{{ route('seller.add-sparepart') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="part">Part Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="part"
                                                placeholder="Part Number" name="partnum" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="part-name">Part Name</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="part-name"
                                                placeholder="Part Name" name="partname" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="form-label" for="vehicle-model">Vehicle Model</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="vehicle-model"
                                            placeholder="Vehicle Model Name" name="model" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="select-cat">Categories</label>
                                    <select class="select2 form-select" id="select-cat" name="categories">
                                        <option value="">--Choose Categories--</option>
                                        @foreach ($cat as $c)
                                            <option value="{{ $c->id }}">{{ $c->categoriname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <label class="form-label" for="part-brand">Sparepart Brand</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="part-brand"
                                                placeholder="Sparepart Brand" name="brand" required/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="part-price">Sparepart Price</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="part-price"
                                            placeholder="Sparepart Price" name="price" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="select-condition">Condition</label>
                                    <div class="col-md-12 mb-2">
                                        <select class="select2 form-select" id="select-condition" name="condition">
                                            <option value="">--Choose Condition--</option>
                                            <option value="New">New</option>
                                            <option value="Used">Used</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="build-year">Build Year</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="build-year"
                                            placeholder="Build Year" name="year" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="part-colour">Colours</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="part-colour"
                                            placeholder="Colour" name="colour" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="part-stock">Weight(Kg)</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="number" class="form-control" id="part-stock"
                                            placeholder="Weight" name="weight" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="part-stock">Stock</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="float" class="form-control" id="part-stock"
                                            placeholder="Stock" name="stock" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-12">
                                <div class="col-md-12 mb-1">
                                    <div class="col-md-12">
                                        <label class="form-label" for="description">Description</label>
                                        <div class="col-md-12 mb-2">
                                            <textarea name="desc" id="description" class="form-control" placeholder="Product Description" cols="30"
                                                rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12 mb-1">
                                    <label for="myDropzone" class="form-label">
                                        <h4>Upload Sparepart Image</h4>
                                    </label>
                                    <input type="file" class="form-control" name="image[]" aaccept=".jpeg, .png, .jpg" multiple>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkbox" name="checkbox" value="true">
                                        <label class="form-check-label" for="checkbox">Pre-Order</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <input type="submit" class="btn btn-primary btn-submit" id="submitFile" value="Submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row" id="table-striped" style="padding: 3vh;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Sparepart List</h4>
                </div>
                <div class="table-responsive mb-1">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Part Name</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Price</th>
                                <th scope="col">Condition</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sparepart as $s)
                                <tr>
                                    <td>{{ $s->id }}</td>
                                    <td>{{ $s->partnumber }} - {{ $s->partname }} {{ $s->vehiclemodel }}
                                        {{ $s->buildyear }}, {{ $s->colour }}</td>
                                    <td>{{ $s->stock }}</td>
                                    <td>@currency($s->unitprice)</td>
                                    <td>{{ $s->condition }}</td>
                                    <td>
                                        <a href="{{ route('sparepart.editform', $s->id) }}" class="btn btn-icon btn-flat-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('sparepart.destroy', $s->id) }}"
                                            style="display: inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-flat-danger"
                                                onclick="return confirm('Do you want to delete this product (ID: {{ $s->id }} - Name: {{ $s->partnumber }} - {{ $s->partname }} {{ $s->vehiclemodel }} {{ $s->buildyear }}, {{ $s->colour }})?');">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </td>
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

    <script>
        var idr = document.getElementById("part-price");
        idr.addEventListener("keyup", function (e) {
            idr.value = formatRupiah(this.value, "Rp. ");
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }
    </script>
@endsection
