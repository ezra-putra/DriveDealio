@extends('layout.main')
@section('content')
<style>
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    .rate:not(:checked) > input {
        position:absolute;
        display: none;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate > input:checked ~ label {
        color: #ffc700;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked + label:hover,
    .rate > input:checked ~ label:hover,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }
</style>

<h3>Review Order</h3>
<div class="col-md-12" style="padding: 3vh;">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-1">Tell us about your shopping experience with our website!</h6>
                @foreach ($productToReview as $p)
                <form action="{{ route('review.post', $p->idorder) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12 mb-2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="item-img text-center">
                                    <a href="#">
                                        <img src="{{ asset('images/sparepart/'.$s->idsparepart.'/' .$s->url) }}" class="img-fluid" alt="img-placeholder" width="150" height="150"/>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-5 mx-auto my-auto">
                                <h6 class="my-1">{{ $p->item_name }}</h6>
                                <p class="my-1">{{ $p->quantityordered }} Items x @currency($p->unitprice)</p>
                            </div>
                            <div class="col-md-4 mx-auto my-auto text-center justify-content-end">
                                <div class="rate" id="rate-{{ $p->idsparepart }}">
                                    <input type="radio" id="star5-{{ $p->idsparepart }}" class="rate" name="rating_{{ $p->idsparepart }}" value="5"/>
                                    <label for="star5-{{ $p->idsparepart }}" title="text">5 stars</label>
                                    <input type="radio" id="star4-{{ $p->idsparepart }}" class="rate" name="rating_{{ $p->idsparepart }}" value="4"/>
                                    <label for="star4-{{ $p->idsparepart }}" title="text">4 stars</label>
                                    <input type="radio" id="star3-{{ $p->idsparepart }}" class="rate" name="rating_{{ $p->idsparepart }}" value="3"/>
                                    <label for="star3-{{ $p->idsparepart }}" title="text">3 stars</label>
                                    <input type="radio" id="star2-{{ $p->idsparepart }}" class="rate" name="rating_{{ $p->idsparepart }}" value="2"/>
                                    <label for="star2-{{ $p->idsparepart }}" title="text">2 stars</label>
                                    <input type="radio" id="star1-{{ $p->idsparepart }}" class="rate" name="rating_{{ $p->idsparepart }}" value="1"/>
                                    <label for="star1-{{ $p->idsparepart }}" title="text">1 star</label>
                                </div>
                                <div class="form-group mt-1">
                                    <textarea class="form-control" name="comment_{{ $p->idsparepart }}" rows="4 " placeholder="Comment" maxlength="200"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-info">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
