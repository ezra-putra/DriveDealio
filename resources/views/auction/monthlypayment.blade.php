@extends('layout.main')
@section('content')
<div class="col-md-12 mx-auto" id="snap-container"></div>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-OHRI34QOyaGdOTJv"></script>
<script type="text/javascript">
    window.addEventListener('load', function () {
        window.snap.embed('{{ $snap_token }}', {
            embedId: 'snap-container',
            onSuccess: function(result){
                window.location.href = '{{ route('monthlypayment.post', $payableloan[0]->idloanpay) }}';
            },
            onPending: function(result){
                window.location.href = '{{ url('/orderhistory') }}';
            },
            onError: function(result){
                window.location.href = '{{ url('/orderhistory') }}';
            },
            onClose: function(){
                window.location.href = '{{ url('/orderhistory') }}';
            }
        });
    });
</script>
@endsection
