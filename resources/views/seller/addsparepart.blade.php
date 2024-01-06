@extends('layout.main')
@section('content')
<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/file-uploaders/dropzone.min.css">
<link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-file-uploader.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.0/dropzone.js"></script>

    <div class="col-md-12" style="padding: 3vh;">
        <div class="card">
            <div class="card-body col-md-12">
                <h3>Add New Sparepart</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="col-md-12 mb-1">
                                <div class="col-md-12 mb-1">
                                    <label for="myDropzone" class="form-label">
                                        <h4>Upload Sparepart Image</h4>
                                    </label>
                                    <form action="{{ route('seller.add-sparepart') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="dropzone">
                                        @csrf
                                        <div class="dz-message">Drop images here or click to upload.</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('seller.add-sparepart') }}" method="POST" enctype="multipart/form-data" >
                            <div class="bs-stepper-content row my-2">
                                @csrf
                                <div class="col-md-12">
                                    <div class="col-lg-12 col-md-6 col-12">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="col-md-12">
                                                <label class="form-label" for="vehicle-model">Vehicle Model</label>
                                                <div class="col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="vehicle-model"
                                                    placeholder="Vehicle Model Name" name="model" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-12">
                                                <label class="form-label" for="part-brand">Sparepart Brand</label>
                                                <div class="col-md-12 mb-2">
                                                    <input type="text" class="form-control" id="part-brand"
                                                    placeholder="Sparepart Brand" name="brand" />
                                                </div>
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
                                <div class="d-flex justify-content-end">
                                    <input type="submit" class="btn btn-primary btn-submit" id="submitFile"
                                        value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Note that the name "myDropzone" is the camelized
        // id of the form.
        Dropzone.options.dropzone = {
            paramName: "image", // The name that will be used to transfer the file
            maxFilesize: 10, // MB
            maxFiles:10,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 5000,
            success: function(file, response) {
                console.log(response);
            },
            error: function(file, response){
                return false;
            },
            init: function (){
                document.getElementById("#submitFile").addEventListener("click", function(){
                    dropzone.processQueue();
                });
            }
        };
    </script>
@endsection
