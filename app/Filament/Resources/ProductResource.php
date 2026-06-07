<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Produk';
    protected static ?string $modelLabel = 'Produk';
    protected static ?string $pluralModelLabel = 'Produk';
    protected static ?string $navigationGroup = 'Katalog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Informasi Produk')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Produk')
                                ->required()
                                ->liveon('slug')
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->unique(Product::class, 'slug', ignoreRecord: true),

                            Forms\Components\TextInput::make('sku')
                                ->label('SKU')
                                ->unique(Product::class, 'sku', ignoreRecord: true),

                            Forms\Components\Select::make('category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->required(),
                        ])->columns(2),

                    Forms\Components\Section::make('Harga & Stok')
                        ->schema([
                            Forms\Components\TextInput::make('price')
                                ->label('Harga Jual')
                                ->required()
                                ->numeric()
                                ->prefix('Rp ')
                                ->prefixIcon('heroicon-o-currency-dollar'),

                            Forms\Components\TextInput::make('original_price')
                                ->label('Harga Asli (Coret)')
                                ->numeric()
                                ->prefix('Rp '),

                            Forms\Components\TextInput::make('stock')
                                ->label('Stok')
                                ->required()
                                ->numeric()
                                ->minValue(0),

                            Forms\Components\TextInput::make('weight')
                                ->label('Berat')
                                ->required()
                                ->numeric()
                                ->suffix('gram')
                                ->default(100),

                            Forms\Components\TextInput::make('min_order')
                                ->label('Min. Pemesanan')
                                ->numeric()
                                ->minValue(1)
                                ->default(1),
                        ])->columns(2),
                ])->columnSpan(['lg' => 2, 'md' => 1]),

                Forms\Components\Group::make([
                    Forms\Components\Section::make('Status')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Aktif')
                                ->default(true),

                            Forms\Components\Toggle::make('is_featured')
                                ->label('Produk Unggulan')
                                ->default(false),
                        ]),

                    Forms\Components\Section::make('Gambar Produk')
                        ->schema([
                            Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                                ->collection('product_images')
                                ->label('Gambar')
                                ->multiple()
                                ->imageEditor()
                                ->image(),
                        ]),
                ])->columnSpan(['lg' => 1, 'md' => 1]),

                Forms\Components\Section::make('Deskripsi')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat')
                            ->rows(3),

                        Forms\Components\RichEditor::make('content')
                            ->label('Konten Lengkap')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('attachments'),
                    ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Gambar')
                    ->square(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('formatted_price')
                    ->label('Harga')
                    ->sortable(query: function ($query, string $direction) {
                        $query->orderBy('price', $direction);
                    }),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable()
                    ->colors([
                        '' => 'gray',
                        '>=10' => 'success',
                        '<10' => 'warning',
                        '0' => 'danger',
                    ]),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),

                Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Unggulan'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->label('Kategori'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Produk Unggulan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}