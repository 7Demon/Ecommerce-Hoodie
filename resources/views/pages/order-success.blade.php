@extends('layouts.app')

@section('content')
<main class="w-full max-w-3xl mx-auto px-5 sm:px-6 lg:px-12 pt-24 sm:pt-28 lg:pt-32 pb-16 sm:pb-20 lg:pb-28 text-center">

    {{-- Success Icon --}}
    <div class="mb-8">
        <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center">
            <span class="material-symbols-outlined text-green-600 text-[40px]">check_circle</span>
        </div>
    </div>

    <h1 class="font-h1 text-3xl sm:text-4xl text-primary mb-4">Pesanan Berhasil Dibuat!</h1>
    <p class="font-body-lg text-body-lg text-on-surface-variant mb-2">
        Terima kasih atas pesanan Anda. Berikut adalah detail pesanan:
    </p>

    {{-- Order Info Card --}}
    <div class="bg-stone-50 rounded-lg p-8 mt-8 text-left shadow-sm max-w-lg mx-auto">
        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="font-label-caps text-label-caps text-on-surface-variant">NOMOR PESANAN</span>
                <span class="font-label-md text-label-md text-primary font-bold">{{ $order->order_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-label-caps text-label-caps text-on-surface-variant">STATUS</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                    @if($order->status === 'paid') bg-green-100 text-green-800
                    @elseif($order->status === 'pending') bg-amber-100 text-amber-800
                    @else bg-stone-100 text-stone-600
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="font-label-caps text-label-caps text-on-surface-variant">TOTAL</span>
                <span class="font-body-lg text-body-lg text-primary font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-label-caps text-label-caps text-on-surface-variant">EMAIL</span>
                <span class="font-body-md text-body-md text-on-surface">{{ $order->customer_email }}</span>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap Payment Button (if snap_token available) --}}
    @if(session('snap_token'))
    <div class="mt-8">
        <button id="pay-button"
            class="px-8 py-4 bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:opacity-90 active:scale-[0.98] transition-all inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">payments</span>
            LANJUTKAN PEMBAYARAN
        </button>
        <p class="font-body-md text-body-md text-on-surface-variant mt-3">
            Klik tombol di atas untuk melakukan pembayaran melalui Midtrans.
        </p>
    </div>
    @endif

    {{-- Actions --}}
    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('orders.track') }}"
            class="px-6 py-3 border border-outline-variant rounded-lg font-label-md text-label-md text-primary hover:bg-surface-container transition-colors inline-flex items-center gap-2 justify-center">
            <span class="material-symbols-outlined text-[18px]">search</span>
            Lacak Pesanan
        </a>
        <a href="{{ route('collections') }}"
            class="px-6 py-3 border border-outline-variant rounded-lg font-label-md text-label-md text-primary hover:bg-surface-container transition-colors inline-flex items-center gap-2 justify-center">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Lanjut Belanja
        </a>
    </div>
</main>

@push('scripts')
@if(session('snap_token'))
<script src="{{ session('snap_js_url') }}" data-client-key="{{ session('client_key') }}"></script>
<script>
    document.getElementById('pay-button')?.addEventListener('click', function () {
        window.snap.pay('{{ session("snap_token") }}', {
            onSuccess: function(result) {
                window.location.reload();
            },
            onPending: function(result) {
                window.location.reload();
            },
            onError: function(result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function() {
                // User closed popup without finishing
            }
        });
    });
</script>
@endif
@endpush
@endsection
