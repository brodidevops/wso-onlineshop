<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components as InfolistComponents;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('confirm_payment')
                ->label('Konfirmasi Pembayaran')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn ($record) => $record->payment_status === 'pending' && $record->payment_method === 'manual')
                ->action(function (Order $record) {
                    $record->update(['payment_status' => 'confirmed', 'status' => 'paid']);
                    $record->decrementStock();
                    $this->refreshFormData(['payment_status', 'status']);
                }),

            Actions\Action::make('process_order')
                ->label('Proses Pesanan')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('primary')
                ->visible(fn ($record) => $record->status === 'paid' && $record->payment_status === 'confirmed')
                ->action(function (Order $record) {
                    $record->update(['status' => 'processing']);
                    $this->refreshFormData(['status']);
                }),

            Actions\Action::make('ship_order')
                ->label('Kirim Pesanan')
                ->icon('heroicon-o-truck')
                ->color('info')
                ->visible(fn ($record) => $record->status === 'processing')
                ->form([
                    \Filament\Forms\Components\TextInput::make('tracking_number')
                        ->label('Nomor Resi')
                        ->required(),
                ])
                ->action(function (Order $record, array $data) {
                    $record->update([
                        'status' => 'shipped',
                        'tracking_number' => $data['tracking_number'],
                    ]);
                    $this->refreshFormData(['status', 'tracking_number']);
                }),

            Actions\Action::make('complete_order')
                ->label('Selesaikan Pesanan')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn ($record) => $record->status === 'shipped')
                ->action(function (Order $record) {
                    $record->update(['status' => 'completed']);
                    $this->refreshFormData(['status']);
                }),

            Actions\Action::make('cancel_order')
                ->label('Batalkan Pesanan')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn ($record) => in_array($record->status, ['pending', 'paid', 'processing']))
                ->action(function (Order $record) {
                    if (in_array($record->status, ['paid', 'processing']) || $record->payment_status === 'confirmed') {
                        $record->incrementStock();
                    }
                    $record->update(['status' => 'cancelled', 'payment_status' => 'cancelled']);
                    $this->refreshFormData(['status', 'payment_status']);
                }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistComponents\Section::make('Detail Pesanan')
                    ->schema([
                        InfolistComponents\TextEntry::make('order_number')->label('No. Pesanan'),
                        InfolistComponents\TextEntry::make('created_at')->label('Tanggal')->dateTime('d M Y, H:i'),
                        InfolistComponents\TextEntry::make('status')->label('Status')->badge(),
                        InfolistComponents\TextEntry::make('payment_status')->label('Pembayaran')->badge(),
                        InfolistComponents\TextEntry::make('payment_method')->label('Metode')->badge(),
                    ])->columns(2),

                InfolistComponents\Section::make('Pelanggan')
                    ->schema([
                        InfolistComponents\TextEntry::make('name')->label('Nama'),
                        InfolistComponents\TextEntry::make('email')->label('Email'),
                        InfolistComponents\TextEntry::make('phone')->label('Telepon'),
                        InfolistComponents\TextEntry::make('address')->label('Alamat'),
                        InfolistComponents\TextEntry::make('province.name')->label('Provinsi'),
                        InfolistComponents\TextEntry::make('city.full_name')->label('Kota'),
                        InfolistComponents\TextEntry::make('postal_code')->label('Kode Pos'),
                    ])->columns(2),

                InfolistComponents\Section::make('Pengiriman')
                    ->schema([
                        InfolistComponents\TextEntry::make('shipping_courier')->label('Kurir'),
                        InfolistComponents\TextEntry::make('shipping_service')->label('Layanan'),
                        InfolistComponents\TextEntry::make('shipping_cost')->label('Ongkir')->money('IDR'),
                        InfolistComponents\TextEntry::make('tracking_number')->label('No. Resi'),
                    ])->columns(2),

                InfolistComponents\Section::make('Rincian Pesanan')
                    ->schema([
                        InfolistComponents\RepeatableEntry::make('items')
                            ->schema([
                                InfolistComponents\TextEntry::make('product_name')->label('Produk'),
                                InfolistComponents\TextEntry::make('product_sku')->label('SKU'),
                                InfolistComponents\TextEntry::make('qty')->label('Jumlah'),
                                InfolistComponents\TextEntry::make('formatted_price')->label('Harga'),
                                InfolistComponents\TextEntry::make('formatted_subtotal')->label('Subtotal'),
                            ])->columns(5),
                    ]),

                InfolistComponents\Section::make('Pembayaran')
                    ->schema([
                        InfolistComponents\TextEntry::make('subtotal')->label('Subtotal')->money('IDR'),
                        InfolistComponents\TextEntry::make('shipping_cost')->label('Ongkir')->money('IDR'),
                        InfolistComponents\TextEntry::make('total')->label('Total')->money('IDR')->fontWeight('bold'),
                    ]),

                InfolistComponents\Section::make('Bukti Transfer')
                    ->schema([
                        InfolistComponents\ImageEntry::make('transfer_receipt')
                            ->label('Bukti Transfer')
                            ->visible(fn ($record) => $record->transfer_receipt !== null),
                        InfolistComponents\TextEntry::make('transfer_date')->label('Tanggal Transfer')->dateTime(),
                    ])
                    ->visible(fn ($record) => $record->transfer_receipt !== null),
            ]);
    }
}