<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Pesanan';
    protected static ?string $modelLabel = 'Pesanan';
    protected static ?string $pluralModelLabel = 'Pesanan';
    protected static ?string $navigationGroup = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Informasi Pesanan')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Info Pelanggan')
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Nama'),
                                Forms\Components\TextInput::make('email')->label('Email'),
                                Forms\Components\TextInput::make('phone')->label('Telepon'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Alamat Pengiriman')
                            ->schema([
                                Forms\Components\Textarea::make('address')->label('Alamat')->rows(3),
                                Forms\Components\Select::make('province_id')
                                    ->label('Provinsi')
                                    ->relationship('province', 'name'),
                                Forms\Components\Select::make('city_id')
                                    ->label('Kota/Kabupaten')
                                    ->relationship('city', 'name'),
                                Forms\Components\TextInput::make('postal_code')->label('Kode Pos'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Pengiriman')
                            ->schema([
                                Forms\Components\TextInput::make('shipping_courier')->label('Kurir'),
                                Forms\Components\TextInput::make('shipping_service')->label('Layanan'),
                                Forms\Components\TextInput::make('shipping_cost')
                                    ->label('Ongkos Kirim')
                                    ->numeric()
                                    ->prefix('Rp '),
                                Forms\Components\TextInput::make('tracking_number')
                                    ->label('Nomor Resi'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Pembayaran')
                            ->schema([
                                Forms\Components\Select::make('payment_method')
                                    ->label('Metode Pembayaran')
                                    ->options([
                                        'midtrans' => 'Midtrans',
                                        'manual' => 'Transfer Manual',
                                    ]),

                                Forms\Components\Select::make('payment_status')
                                    ->label('Status Pembayaran')
                                    ->options([
                                        'pending' => 'Menunggu',
                                        'paid' => 'Lunas',
                                        'confirmed' => 'Dikonfirmasi',
                                        'cancelled' => 'Dibatalkan',
                                        'refunded' => 'Dikembalikan',
                                    ]),

                                Forms\Components\TextInput::make('midtrans_order_id')->label('Midtrans Order ID'),
                                Forms\Components\TextInput::make('midtrans_transaction_id')->label('Transaction ID'),

                                Forms\Components\Placeholder::make('transfer_receipt_label')
                                    ->label('Bukti Transfer')
                                    ->content(fn ($record) => $record?->transfer_receipt
                                        ? '<a href="' . asset('storage/' . $record->transfer_receipt) . '" target="_blank" class="text-primary-600 underline">Lihat Bukti Transfer</a>'
                                        : 'Belum ada bukti transfer'),

                                Forms\Components\DateTimePicker::make('transfer_date')->label('Tanggal Transfer'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Status Pesanan')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'pending' => 'Menunggu',
                                        'paid' => 'Dibayar',
                                        'processing' => 'Diproses',
                                        'shipped' => 'Dikirim',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                    ]),

                                Forms\Components\Textarea::make('notes')->label('Catatan')->rows(3),
                            ])->columns(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->fontWeight('bold'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->fontWeight('bold'),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Dibayar',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ])
                    ->selectablePlaceholder(false),

                Tables\Columns\SelectColumn::make('payment_status')
                    ->label('Status Bayar')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Batal',
                        'refunded' => 'Refund',
                    ])
                    ->selectablePlaceholder(false),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'midtrans' ? 'Midtrans' : 'Transfer'),

                Tables\Columns\TextColumn::make('items_count')
                    ->label('Item')
                    ->counts('items'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Dibayar',
                        'processing' => 'Diproses',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),

                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Menunggu',
                        'paid' => 'Lunas',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Batal',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('Metode Bayar')
                    ->options([
                        'midtrans' => 'Midtrans',
                        'manual' => 'Transfer Manual',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('confirm_payment')
                    ->label('Konfirmasi Bayar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->payment_status === 'pending' && $record->payment_method === 'manual')
                    ->action(function (Order $record) {
                        $record->update(['payment_status' => 'confirmed', 'status' => 'paid']);
                        $record->decrementStock();
                    }),

                Tables\Actions\Action::make('cancel_order')
                    ->label('Batalkan')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => in_array($record->status, ['pending', 'paid']))
                    ->action(function (Order $record) {
                        if ($record->status === 'paid' || $record->payment_status === 'confirmed') {
                            $record->incrementStock();
                        }
                        $record->update(['status' => 'cancelled', 'payment_status' => 'cancelled']);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}