@extends('layouts.app')

@section('content')
<div class="container my-5 text-center">
    <h1>Selesaikan Pembayaran Anda</h1>
    <p class="lead" style="color: var(--text-muted-custom);">Klik tombol di bawah untuk membuka jendela pembayaran.</p>
    <button id="pay-button" class="btn btn-custom-yellow btn-lg mt-3">Bayar Sekarang</button>
</div>
@endsection

@push('scripts')
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('midtrans.client_key') }}"></script>
    
    <script type="text/javascript">
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            /* === PERUBAHAN DI SINI === */
            // Arahkan ke halaman status pesanan dengan menyertakan kode pesanan.
            window.location.href = '{{ route("order.status", ["order_code" => $transactionCode]) }}';
            /* ========================= */
          },
          onPending: function(result){
            alert("Menunggu pembayaran Anda!"); 
            console.log(result);
          },
          onError: function(result){
            alert("Pembayaran gagal!"); 
            console.log(result);
          },
          onClose: function(){
            alert('Anda menutup pop-up tanpa menyelesaikan pembayaran.');
          }
        })
      });
    </script>
@endpush