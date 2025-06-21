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
        // Trigger Snap
        snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            /* === PERUBAHAN DI SINI === */
            // Arahkan ke halaman status pesanan setelah pembayaran berhasil.
            window.location.href = '{{ route("order.status") }}';
            /* ========================= */
          },
          onPending: function(result){
            /* You may add your own implementation here */
            alert("Menunggu pembayaran Anda!"); 
            console.log(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            alert("Pembayaran gagal!"); 
            console.log(result);
          },
          onClose: function(){
            /* You may add your own implementation here */
            alert('Anda menutup pop-up tanpa menyelesaikan pembayaran.');
          }
        })
      });
    </script>
@endpush