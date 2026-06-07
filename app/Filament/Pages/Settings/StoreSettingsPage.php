<?php

namespace App\Filament\Pages\Settings;

use App\Models\StoreSetting;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class StoreSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Pengaturan Toko';
    protected static ?string $title = 'Pengaturan Toko';
    protected static ?string $slug = 'settings/store';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;

    public array $generalData = [];
    public array $appearanceData = [];
    public array $contactData = [];
    public array $socialData = [];
    public array $seoData = [];

    public function mount(): void
    {
        $this->loadAllSettings();
    }

    public function loadAllSettings(): void
    {
        $general = StoreSetting::where('group', 'general')->where('is_active', true)->get();
        $appearance = StoreSetting::where('group', 'appearance')->where('is_active', true)->get();
        $contact = StoreSetting::where('group', 'contact')->where('is_active', true)->get();
        $social = StoreSetting::where('group', 'social')->where('is_active', true)->get();
        $seo = StoreSetting::where('group', 'seo')->where('is_active', true)->get();

        $this->generalData = $this->settingsToArray($general);
        $this->appearanceData = $this->settingsToArray($appearance);
        $this->contactData = $this->settingsToArray($contact);
        $this->socialData = $this->settingsToArray($social);
        $this->seoData = $this->settingsToArray($seo);
    }

    protected function settingsToArray($settings): array
    {
        $data = [];
        foreach ($settings as $setting) {
            $data[$setting->key] = $this->getSettingValue($setting);
        }
        return $data;
    }

    protected function getSettingValue($setting)
    {
        if ($setting->type === 'boolean') {
            return $setting->value === '1' || $setting->value === 'true';
        }
        return $setting->value;
    }

    public function form(Form $form): Form
    {
        return $form->stateful(false)->schema($this->getFormSchema());
    }

    protected function getFormSchema(): array
    {
        return [
            // General Section
            Forms\Components\Section::make('Informasi Umum')
                ->icon('heroicon-o-information-circle')
                ->collapsible()
                ->schema([
                    Forms\Components\TextInput::make('generalData.store_name')
                        ->label('Nama Toko')
                        ->placeholder('Masukkan nama toko'),

                    Forms\Components\TextInput::make('generalData.store_tagline')
                        ->label('Tagline')
                        ->placeholder('Tagline atau slogan toko'),

                    Forms\Components\Textarea::make('generalData.store_description')
                        ->label('Deskripsi Toko')
                        ->rows(3),

                    Forms\Components\TextInput::make('generalData.store_email')
                        ->label('Email Toko')
                        ->email(),

                    Forms\Components\TextInput::make('generalData.store_phone')
                        ->label('Nomor Telepon')
                        ->tel(),

                    Forms\Components\TextInput::make('generalData.store_whatsapp')
                        ->label('WhatsApp')
                        ->tel()
                        ->placeholder('6281234567890'),
                ])->columns(2),

            // Appearance Section
            Forms\Components\Section::make('Tampilan & Branding')
                ->icon('heroicon-o-paint-brush')
                ->collapsible()
                ->schema([
                    Forms\Components\FileUpload::make('appearanceData.logo_header')
                        ->label('Logo Header')
                        ->image()
                        ->directory('settings')
                        ->imagePreviewHeight('100')
                        ->helperText('Logo untuk navbar (PNG dengan transparan disarankan)'),

                    Forms\Components\FileUpload::make('appearanceData.logo_footer')
                        ->label('Logo Footer')
                        ->image()
                        ->directory('settings')
                        ->imagePreviewHeight('100')
                        ->helperText('Logo untuk footer'),

                    Forms\Components\FileUpload::make('appearanceData.favicon')
                        ->label('Favicon')
                        ->image()
                        ->directory('settings')
                        ->imagePreviewHeight('60')
                        ->helperText('Ikon browser (ICO/PNG 32x32 atau 64x64)'),

                    Forms\Components\FileUpload::make('appearanceData.og_image')
                        ->label('Open Graph Image')
                        ->image()
                        ->directory('settings')
                        ->imagePreviewHeight('100')
                        ->helperText('Gambar untuk share ke social media (1200x630px)'),

                    Forms\Components\ColorPicker::make('appearanceData.primary_color')
                        ->label('Warna Utama'),
                ])->columns(2),

            // Contact Section
            Forms\Components\Section::make('Kontak & Alamat')
                ->icon('heroicon-o-map-pin')
                ->collapsible()
                ->schema([
                    Forms\Components\Textarea::make('contactData.store_address')
                        ->label('Alamat Toko')
                        ->rows(3),

                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('contactData.store_city')
                            ->label('Kota'),

                        Forms\Components\TextInput::make('contactData.store_province')
                            ->label('Provinsi'),

                        Forms\Components\TextInput::make('contactData.store_postal_code')
                            ->label('Kode Pos'),
                    ]),

                    Forms\Components\Textarea::make('contactData.store_maps_embed')
                        ->label('Google Maps Embed')
                        ->rows(3)
                        ->placeholder('Kode embed Google Maps'),
                ]),

            // Social Media Section
            Forms\Components\Section::make('Media Sosial')
                ->icon('heroicon-o-share')
                ->collapsible()
                ->schema([
                    Forms\Components\TextInput::make('socialData.social_facebook')
                        ->label('Facebook')
                        ->url()
                        ->prefixIcon('heroicon-o-link'),

                    Forms\Components\TextInput::make('socialData.social_instagram')
                        ->label('Instagram')
                        ->url()
                        ->prefixIcon('heroicon-o-link'),

                    Forms\Components\TextInput::make('socialData.social_twitter')
                        ->label('Twitter/X')
                        ->url()
                        ->prefixIcon('heroicon-o-link'),

                    Forms\Components\TextInput::make('socialData.social_tiktok')
                        ->label('TikTok')
                        ->url()
                        ->prefixIcon('heroicon-o-link'),

                    Forms\Components\TextInput::make('socialData.social_youtube')
                        ->label('YouTube')
                        ->url()
                        ->prefixIcon('heroicon-o-link'),
                ])->columns(2),

            // SEO Section
            Forms\Components\Section::make('SEO')
                ->icon('heroicon-o-globe-alt')
                ->collapsible()
                ->schema([
                    Forms\Components\TextInput::make('seoData.seo_meta_title')
                        ->label('Meta Title')
                        ->maxLength(60)
                        ->helperText('Judul untuk SEO (max 60 karakter)'),

                    Forms\Components\Textarea::make('seoData.seo_meta_description')
                        ->label('Meta Description')
                        ->rows(2)
                        ->maxLength(160)
                        ->helperText('Deskripsi untuk SEO (max 160 karakter)'),

                    Forms\Components\TextInput::make('seoData.seo_keywords')
                        ->label('Meta Keywords')
                        ->placeholder('kata1, kata2, kata3'),

                    Forms\Components\Textarea::make('seoData.seo_google_analytics')
                        ->label('Google Analytics ID')
                        ->placeholder('G-XXXXXXXXXX')
                        ->rows(2),
                ]),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->action('saveSettings')
                ->color('primary'),
        ];
    }

    public function saveSettings(): void
    {
        $this->saveGroupSettings('general', $this->generalData);
        $this->saveGroupSettings('appearance', $this->appearanceData);
        $this->saveGroupSettings('contact', $this->contactData);
        $this->saveGroupSettings('social', $this->socialData);
        $this->saveGroupSettings('seo', $this->seoData);

        Notification::make()
            ->success()
            ->title('Pengaturan Tersimpan')
            ->body('Pengaturan toko berhasil diperbarui.')
            ->send();

        $this->loadAllSettings();
    }

    protected function saveGroupSettings(string $group, array $data): void
    {
        foreach ($data as $key => $value) {
            $setting = StoreSetting::where('group', $group)
                ->where('key', $key)
                ->first();

            if (!$setting) {
                continue;
            }

            if ($setting->type === 'image' && $value) {
                // Handle file upload
                if (is_object($value)) {
                    $path = $value->store('settings', 'public');
                    $setting->update(['value' => $path]);
                }
            } elseif ($setting->type === 'boolean') {
                $setting->update(['value' => $value ? '1' : '0']);
            } elseif (is_array($value)) {
                $setting->update(['value' => json_encode($value)]);
            } else {
                $setting->update(['value' => $value]);
            }
        }
    }

    public function getView(): string
    {
        return 'filament.pages.settings.store-settings-page';
    }
}