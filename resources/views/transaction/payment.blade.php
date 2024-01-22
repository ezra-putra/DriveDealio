@extends('layout.main')
@section('content')
<div class="col-md-12" style="padding: 3vh;">
    <h3>Payment</h3>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body col-md-12" style="position: sticky; top: 0;">

                <div class="item-center">
                    <h4  style="text-align: center">Time Remaining</h4>
                    <h3 style="text-align: center; color: #ff6347;" id="countdown">{{ $product[0]->duration }}</h3>
                    <h1>{{ $product[0]->idorder }}</h1>
                    <h1>{{ $product[0]->status }}</h1>
                    <h1>@currency($product[0]->total_price)</h1>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('payment_post', $product[0]->idorder) }}" class="btn btn-primary mx-1">
                        Paid
                    </a>
                    <a href="{{ route('payment_cancel', $product[0]->idorder) }}" class="btn btn-danger">
                        Cancel
                    </a>

                </div>
            </div>


        </div>
    </div>
</div>

<script>
    // Set the date we're counting down to
    var countDownDate = new Date("{{ $product[0]->paymentduedate }}").getTime();

    // Update the countdown every 1 second
    var x = setInterval(function() {
        // Get the current date and time
        var now = new Date().getTime();

        // Calculate the remaining time
        var distance = countDownDate - now;

        // Calculate days, hours, minutes, and seconds
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the countdown in the element with id="countdown"
        document.getElementById("countdown").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

        // If the countdown is over, display a message
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
@endsection
