@extends('layout.main')
@section('content')
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/file-uploaders/dropzone.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-file-uploader.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js"></script>

    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Edit Sparepart</h3>
                <form action="{{ route('seller.update-sparepart', $sparepart[0]->idsparepart) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="part">Part Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="part"
                                                placeholder="Part Number" name="partnum" value="{{ $sparepart[0]->partnumber }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="part-name">Part Name</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="part-name"
                                                placeholder="Part Name" name="partname" value="{{ $sparepart[0]->partname }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="col-md-12">
                                        <label class="form-label" for="vehicle-model">Vehicle Model</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehicle-model"
                                                placeholder="Vehicle Model Name" name="model" value="{{ $sparepart[0]->vehiclemodel }}"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <label class="form-label" for="part-brand">Sparepart Brand</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="part-brand"
                                                placeholder="Sparepart Brand" name="brand" value="{{ $sparepart[0]->brand }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="part-price">Sparepart Price</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="number" class="form-control" id="part-price"
                                            placeholder="Sparepart Price" name="price" value="{{ $sparepart[0]->unitprice }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="select-condition">Condition</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="select-condition"
                                            placeholder="Condition" name="condition" value="{{ $sparepart[0]->condition }}" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="build-year">Build Year</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="build-year"
                                            placeholder="Build Year" name="year" value="{{ $sparepart[0]->buildyear }}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="part-colour">Colours</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="part-colour"
                                            placeholder="Colour" name="colour" value="{{ $sparepart[0]->colour }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="select-cat">Categories</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="select-cat"
                                            placeholder="Categories" name="cat" value="{{ $sparepart[0]->categoriname }}" readonly/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label" for="part-stock">Current Stock</label>
                                            <div class="col-md-12 mb-2">
                                                <input type="number" class="form-control" id="part-stock"
                                                    placeholder="Stock" name="stock" value="{{ $sparepart[0]->stock }}" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="part-stock">Update Stock</label>
                                            <div class="col-md-12 mb-2">
                                                <input type="number" class="form-control" id="part-stock"
                                                    placeholder="Stock" name="addstock">
                                            </div>
                                        </div>
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
                                                rows="5">{{ $sparepart[0]->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end">
                            <input type="submit" class="btn btn-primary btn-submit" id="submitFile" value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
