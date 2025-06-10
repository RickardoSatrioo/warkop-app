@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bayar Pesanan</h2>
    <p>Total Pembayaran: <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></p>

    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>

    <form id="payment-form" action="{{ route('pembayaran-sukses') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                // alert("Pembayaran berhasil");
                document.getElementById('payment-form').submit();
            },
            onPending: function(result) {
                alert("Menunggu pembayaran.");
            },
            onError: function(result) {
                alert("Pembayaran gagal!");
            },
            onClose: function() {
                alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
            }
        });
    };
</script>
@endsection
