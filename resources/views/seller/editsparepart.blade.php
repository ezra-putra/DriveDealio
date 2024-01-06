@extends('layout.main')
@section('content')
    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Add New Sparepart</h3>
                <form action="{{ route('seller.add-sparepart') }}" method="POST" enctype="multipart/form-data">
                    <div class="bs-stepper-content row my-2">
                        @csrf
                        <div class="col-md-6">
                            <div class="col-lg-12 col-md-6 col-12">
                                <div class="col-md-12 mb-1">
                                    <div class="col-md-12 mb-1">
                                        <label for="dpz-multiple-files" class="form-label">
                                            <h4>Upload Vehicle Image</h4>
                                        </label>
                                        <form action="#" class="dropzone dropzone-area" id="dpz-multiple-files">
                                            <div class="dz-message">Drop images here or click to upload.</div>
                                        </form>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="part">Part Number</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="part"
                                                placeholder="Part Number" name="partnum" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="part-name">Part Name</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="part-name"
                                                placeholder="Part Name" name="partname" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-1">
                                    <div class="col-md-12">
                                        <label class="form-label" for="vehicle-model">Vehicle Model</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="text" class="form-control" id="vehicle-model"
                                            placeholder="Part Name" name="model" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="part-price">Sparepart Price</label>
                                        <div class="col-md-12 mb-2">
                                            <input type="number" class="form-control" id="part-price"
                                                placeholder="Sparepart Price" name="price" />
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
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="col-md-12 mb-1">
                                <div class="col-md-12">
                                    <label class="form-label" for="description">Description</label>
                                    <div class="col-md-12 mb-2">
                                        <textarea name="desc" id="description" class="form-control" placeholder="Product Description" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="build-year">Build Year</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="build-year"
                                            placeholder="Build Year" name="year" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="part-colour">Colours</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="text" class="form-control" id="part-colour"
                                            placeholder="Colour" name="colour" />
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
                                    <label class="form-label" for="part-stock">Stock</label>
                                    <div class="col-md-12 mb-2">
                                        <input type="number" class="form-control" id="part-stock"
                                            placeholder="Stock" name="stock" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-info btn-draft">
                                <i data-feather="file-text" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Save as Draft</span>
                            </button>
                            <input type="submit" class="btn btn-primary btn-submit"
                                value="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
