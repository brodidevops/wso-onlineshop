<x-filament-panels::page>
    <div class="space-y-6">
        {{-- General Info Section --}}
        <div class="bg-white rounded-xl border border-stone-200 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-stone-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-ink">Informasi Umum</h2>
                    <p class="text-sm text-silver">Pengaturan dasar toko</p>
                </div>
            </div>

            <form wire:submit.prevent="saveSettings" enctype="multipart/form-data" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Nama Toko</label>
                        <input type="text" wire:model="generalData.store_name"
                            class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Tagline</label>
                        <input type="text" wire:model="generalData.store_tagline"
                            class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Deskripsi Toko</label>
                    <textarea wire:model="generalData.store_description" rows="3"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Email Toko</label>
                        <input type="email" wire:model="generalData.store_email"
                            class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Telepon</label>
                        <input type="tel" wire:model="generalData.store_phone"
                            class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">WhatsApp</label>
                        <input type="tel" wire:model="generalData.store_whatsapp" placeholder="6281234567890"
                            class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                    </div>
                </div>
            </form>
        </div>

        {{-- Appearance Section --}}
        <div class="bg-white rounded-xl border border-stone-200 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-stone-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-ink">Tampilan & Branding</h2>
                    <p class="text-sm text-silver">Logo, favicon, dan warna toko</p>
                </div>
            </div>

            <form wire:submit.prevent="saveSettings" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Logo Header --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Logo Header</label>
                    <div class="border-2 border-dashed border-stone-300 rounded-xl p-6 text-center hover:border-stone-400 transition-colors cursor-pointer">
                        @if($appearanceData['logo_header'])
                            <div class="mb-3">
                                <img src="{{ $appearanceData['logo_header'] }}" alt="Logo Header" class="max-h-20 mx-auto">
                            </div>
                        @else
                            <svg class="w-10 h-10 text-stone-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                        <input type="file" wire:model="appearanceData.logo_header" class="hidden" accept="image/*">
                        <p class="text-sm text-stone-500">Klik untuk upload logo</p>
                        <p class="text-xs text-stone-400 mt-1">PNG dengan transparan</p>
                    </div>
                </div>

                {{-- Logo Footer --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Logo Footer</label>
                    <div class="border-2 border-dashed border-stone-300 rounded-xl p-6 text-center hover:border-stone-400 transition-colors cursor-pointer">
                        @if($appearanceData['logo_footer'])
                            <div class="mb-3">
                                <img src="{{ $appearanceData['logo_footer'] }}" alt="Logo Footer" class="max-h-20 mx-auto">
                            </div>
                        @else
                            <svg class="w-10 h-10 text-stone-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                        <input type="file" wire:model="appearanceData.logo_footer" class="hidden" accept="image/*">
                        <p class="text-sm text-stone-500">Klik untuk upload logo</p>
                        <p class="text-xs text-stone-400 mt-1">PNG atau JPG</p>
                    </div>
                </div>

                {{-- Favicon --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Favicon</label>
                    <div class="border-2 border-dashed border-stone-300 rounded-xl p-4 text-center hover:border-stone-400 transition-colors cursor-pointer">
                        @if($appearanceData['favicon'])
                            <img src="{{ $appearanceData['favicon'] }}" alt="Favicon" class="w-10 h-10 mx-auto mb-2">
                        @else
                            <svg class="w-8 h-8 text-stone-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                        <input type="file" wire:model="appearanceData.favicon" class="hidden" accept="image/*">
                        <p class="text-xs text-stone-500">ICO/PNG 32x32 atau 64x64</p>
                    </div>
                </div>

                {{-- OG Image --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Open Graph Image</label>
                    <div class="border-2 border-dashed border-stone-300 rounded-xl p-4 text-center hover:border-stone-400 transition-colors cursor-pointer">
                        @if($appearanceData['og_image'])
                            <div class="mb-3">
                                <img src="{{ $appearanceData['og_image'] }}" alt="OG Image" class="max-h-20 mx-auto rounded-lg">
                            </div>
                        @else
                            <svg class="w-8 h-8 text-stone-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        @endif
                        <input type="file" wire:model="appearanceData.og_image" class="hidden" accept="image/*">
                        <p class="text-xs text-stone-500">1200x630px untuk share sosial media</p>
                    </div>
                </div>

                {{-- Primary Color --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-2">Warna Utama</label>
                    <div class="flex items-center gap-3">
                        <input type="color" wire:model="appearanceData.primary_color"
                            class="w-12 h-12 rounded-lg border-2 border-stone-200 cursor-pointer">
                        <div>
                            <p class="text-sm font-medium text-ink">{{ $appearanceData['primary_color'] ?? '#1A1A1A' }}</p>
                            <p class="text-xs text-silver">Warna default: #1A1A1A</p>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>

        {{-- Contact Section --}}
        <div class="bg-white rounded-xl border border-stone-200 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-stone-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-ink">Kontak & Alamat</h2>
                    <p class="text-sm text-silver">Informasi lokasi dan kontak toko</p>
                </div>
            </div>

            <form wire:submit.prevent="saveSettings" enctype="multipart/form-data">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Alamat Lengkap</label>
                    <textarea wire:model="contactData.store_address" rows="3"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Kota</label>
                        <input type="text" wire:model="contactData.store_city"
                            class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Provinsi</label>
                        <input type="text" wire:model="contactData.store_province"
                            class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Kode Pos</label>
                        <input type="text" wire:model="contactData.store_postal_code"
                            class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Google Maps Embed</label>
                    <textarea wire:model="contactData.store_maps_embed" rows="3"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400 font-mono text-xs"
                        placeholder="<iframe src='...'></iframe>"></textarea>
                </div>
            </div>
            </form>
        </div>

        {{-- Social Media Section --}}
        <div class="bg-white rounded-xl border border-stone-200 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-stone-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-ink">Media Sosial</h2>
                    <p class="text-sm text-silver">Tautan media sosial toko</p>
                </div>
            </div>

            <form wire:submit.prevent="saveSettings" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Facebook</label>
                    <input type="url" wire:model="socialData.social_facebook"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"
                        placeholder="https://facebook.com/yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Instagram</label>
                    <input type="url" wire:model="socialData.social_instagram"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"
                        placeholder="https://instagram.com/yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Twitter/X</label>
                    <input type="url" wire:model="socialData.social_twitter"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"
                        placeholder="https://x.com/yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">TikTok</label>
                    <input type="url" wire:model="socialData.social_tiktok"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"
                        placeholder="https://tiktok.com/@yourpage">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">YouTube</label>
                    <input type="url" wire:model="socialData.social_youtube"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"
                        placeholder="https://youtube.com/yourchannel">
                </div>
            </div>
            </form>
        </div>

        {{-- SEO Section --}}
        <div class="bg-white rounded-xl border border-stone-200 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-stone-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-stone-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-ink">SEO</h2>
                    <p class="text-sm text-silver">Pengaturan untuk search engine optimization</p>
                </div>
            </div>

            <form wire:submit.prevent="saveSettings" enctype="multipart/form-data">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">
                        Meta Title
                        <span class="text-xs text-silver ml-1">({{ strlen($seoData['seo_meta_title'] ?? '') }}/60)</span>
                    </label>
                    <input type="text" wire:model="seoData.seo_meta_title" maxlength="60"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">
                        Meta Description
                        <span class="text-xs text-silver ml-1">({{ strlen($seoData['seo_meta_description'] ?? '') }}/160)</span>
                    </label>
                    <textarea wire:model="seoData.seo_meta_description" rows="2" maxlength="160"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Meta Keywords</label>
                    <input type="text" wire:model="seoData.seo_keywords"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400"
                        placeholder="kata1, kata2, kata3">
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Google Analytics ID</label>
                    <input type="text" wire:model="seoData.seo_google_analytics"
                        class="w-full rounded-lg border-stone-200 px-4 py-2.5 text-sm focus:border-stone-400 focus:ring-stone-400 font-mono"
                        placeholder="G-XXXXXXXXXX">
                </div>
            </div>
            </form>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end">
            <button wire:click="saveSettings"
                class="px-6 py-3 bg-stone-800 text-white font-medium rounded-lg hover:bg-stone-700 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Simpan Pengaturan
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        // File upload preview handlers
        document.addEventListener('livewire:load', function () {
            // Handle file input clicks
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.closest('div').addEventListener('click', function () {
                    input.click();
                });
            });
        });
    </script>
    @endpush
</x-filament-panels::page>