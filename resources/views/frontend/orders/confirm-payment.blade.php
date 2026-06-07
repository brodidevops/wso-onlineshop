@extends('frontend.layouts.app')

@section('title', 'Konfirmasi Pembayaran - Toko Online')

@section('content')
<div class="min-h-screen bg-stone-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center gap-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-silver hover:text-ink">Beranda</a></li>
                <li class="text-pearl">/</li>
                <li><a href="{{ route('orders.show', $order) }}" class="text-silver hover:text-ink">Pesanan #{{ $order->order_number }}</a></li>
                <li class="text-pearl">/</li>
                <li class="text-ink font-medium">Konfirmasi Pembayaran</li>
            </ol>
        </nav>

        <!-- Form Card -->
        <div class="bg-white rounded-xl border border-stone-200 p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-stone-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-ink">Konfirmasi Pembayaran</h1>
                <p class="text-silver mt-2">Upload bukti transfer untuk pesanan #{{ $order->order_number }}</p>
            </div>

            <!-- Order Summary -->
            <div class="bg-stone-50 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center">
                    <span class="text-silver">Total Pembayaran</span>
                    <span class="text-xl font-bold text-ink">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-stone-50 border border-stone-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-ink mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-silver" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Cara Pembayaran
                </h3>
                <ol class="text-sm text-graphite space-y-1 ml-5 list-decimal">
                    <li>Transfer ke rekening yang tertera di bawah</li>
                    <li>Jumlah transfer sesuai dengan total pembayaran</li>
                    <li>Simpan bukti transfer (screenshot/foto)</li>
                    <li>Upload bukti transfer melalui form di bawah</li>
                </ol>
            </div>

            <!-- Bank Info -->
            <div class="bg-stone-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-silver mb-1">Transfer ke:</p>
                <p class="text-lg font-bold text-ink">{{ $order->paymentSetting->bank_name ?? 'Bank BCA' }}</p>
                <p class="text-graphite">No. Rekening: <span class="font-mono font-semibold">{{ $order->paymentSetting->bank_account_number ?? '1234567890' }}</span></p>
                <p class="text-graphite">Atas Nama: {{ $order->paymentSetting->bank_account_holder ?? 'Toko Online' }}</p>
            </div>

            <!-- Upload Form -->
            <form action="{{ route('orders.upload-receipt', $order) }}" method="POST" enctype="multipart/form-data" x-data="fileUpload()">
                @csrf

                <!-- Receipt Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-ink mb-2">
                        Bukti Transfer <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-stone-300 rounded-xl transition-colors cursor-pointer"
                         :class="isDragging ? 'border-ink bg-stone-50' : 'hover:border-stone-400'"
                         @dragover.prevent="isDragging = true"
                         @dragleave.window="isDragging = false"
                         @drop.prevent="handleDrop($event)">
                        <div class="space-y-1 text-center">
                            <template x-if="!hasFile">
                                <div>
                                    <svg class="mx-auto h-12 w-12 text-stone-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="text-sm text-graphite mt-2">
                                        <label for="transfer_receipt" class="relative cursor-pointer rounded-md font-medium text-ink hover:text-graphite focus-within:outline-none">
                                            <span>Klik untuk upload</span>
                                            <input id="transfer_receipt"
                                                   name="transfer_receipt"
                                                   type="file"
                                                   class="sr-only"
                                                   accept="image/jpeg,image/png,image/jpg,image/webp"
                                                   required
                                                   @change="handleFileSelect($event)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-silver mt-1">PNG, JPG, WEBP maksimal 2MB</p>
                                </div>
                            </template>
                            <template x-if="hasFile">
                                <div class="relative">
                                    <img :src="previewUrl" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                                    <button type="button" @click="removeImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                    @error('transfer_receipt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transfer Date -->
                <div class="mb-6">
                    <label for="transfer_date" class="block text-sm font-medium text-ink mb-2">
                        Tanggal Transfer <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="transfer_date" id="transfer_date"
                           value="{{ old('transfer_date', now()->format('Y-m-d')) }}"
                           max="{{ now()->format('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-stone-200 rounded-lg focus:outline-none focus:border-ink focus:ring-1 focus:ring-ink transition-colors @error('transfer_date') border-red-500 @enderror"
                           required>
                    @error('transfer_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-ink hover:bg-graphite text-white font-medium py-4 px-6 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Kirim Bukti Transfer
                </button>
            </form>

            <p class="text-center text-sm text-silver mt-4">
                Setelah upload, tim kami akan memverifikasi pembayaran dalam 1x24 jam.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('fileUpload', () => ({
        hasFile: false,
        previewUrl: '',
        isDragging: false,
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.previewUrl = URL.createObjectURL(file);
                this.hasFile = true;
            }
        },
        handleDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                const input = document.getElementById('transfer_receipt');
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                this.previewUrl = URL.createObjectURL(file);
                this.hasFile = true;
            }
        },
        removeImage() {
            const input = document.getElementById('transfer_receipt');
            input.value = '';
            this.previewUrl = '';
            this.hasFile = false;
        }
    }));
});
</script>
@endpush
@endsection
