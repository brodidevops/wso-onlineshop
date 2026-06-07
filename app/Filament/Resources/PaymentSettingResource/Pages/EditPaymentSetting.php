<?php

namespace App\Filament\Resources\PaymentSettingResource\Pages;

use App\Filament\Resources\PaymentSettingResource;
use App\Models\PaymentSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPaymentSetting extends EditRecord
{
    protected static string $resource = PaymentSettingResource::class;

    public function mount(int | string $record = null): void
    {
        $this->record = PaymentSetting::getSettings();
        $this->fillForm();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Metode Pembayaran')
                    ->description('Aktifkan atau nonaktifkan metode pembayaran yang tersedia untuk pelanggan.')
                    ->schema([
                        Forms\Components\Toggle::make('midtrans_enabled')
                            ->label('Midtrans Payment Gateway')
                            ->helperText('Pembayaran otomatis melalui Midtrans (kartu kredit, e-wallet, bank transfer)')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                if (!$state && !$get('manual_transfer_enabled')) {
                                    Notification::make()
                                        ->warning()
                                        ->title('Peringatan')
                                        ->body('Minimal satu metode pembayaran harus aktif.')
                                        ->send();
                                    $set('midtrans_enabled', true);
                                }
                            }),

                        Forms\Components\Toggle::make('manual_transfer_enabled')
                            ->label('Transfer Manual')
                            ->helperText('Pembayaran manual dengan upload bukti transfer')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                if (!$state && !$get('midtrans_enabled')) {
                                    Notification::make()
                                        ->warning()
                                        ->title('Peringatan')
                                        ->body('Minimal satu metode pembayaran harus aktif.')
                                        ->send();
                                    $set('manual_transfer_enabled', true);
                                }
                            }),
                    ])->columns(2),

                Forms\Components\Section::make('Informasi Rekening Bank')
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Nama Bank')
                            ->required()
                            ->placeholder('Bank BCA'),

                        Forms\Components\TextInput::make('bank_account_number')
                            ->label('Nomor Rekening')
                            ->required()
                            ->placeholder('1234567890'),

                        Forms\Components\TextInput::make('bank_account_holder')
                            ->label('Nama Pemilik Rekening')
                            ->required()
                            ->placeholder('Toko Online'),

                        Forms\Components\Textarea::make('payment_instructions')
                            ->label('Instruksi Pembayaran')
                            ->helperText('Instruksi tambahan untuk pelanggan (opsional)')
                            ->rows(4)
                            ->placeholder('Silakan transfer ke rekening di atas dan upload bukti transfer.'),
                    ])->columns(2),
            ]);
    }

    protected function beforeSave(): void
    {
        $data = $this->form->getState();

        if (!$data['midtrans_enabled'] && !$data['manual_transfer_enabled']) {
            Notification::make()
                ->danger()
                ->title('Gagal Menyimpan')
                ->body('Minimal satu metode pembayaran harus aktif.')
                ->send();

            $this->halt();
        }
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Pengaturan pembayaran berhasil disimpan';
    }
}