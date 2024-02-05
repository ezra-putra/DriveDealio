@extends('layout.main')
@section('content')
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-OHRI34QOyaGdOTJv"></script>
</head>

<div class="col-md-12" style="padding: 3vh;">
    <h3>Payment</h3>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body col-md-12" style="position: sticky; top: 0;">
                <div class="item-center">
                    {{ $product[0]->idorder }}
                    <button id="pay-button">Pay!</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            /* You may add your own implementation here */
            window.location.href = '{{ route('payment_post', $product[0]->idorder) }}'
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("wating your payment!"); console.log(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("payment failed!"); console.log(result);
          },
          onClose: function(){
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
          }
        })
      });
</script>
@endsection
