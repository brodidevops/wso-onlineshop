<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Kategori';
    protected static ?string $modelLabel = 'Kategori';
    protected static ?string $pluralModelLabel = 'Kategori';
    protected static ?string $navigationGroup = 'Katalog';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Left Column - Basic Info
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Informasi Dasar')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Kategori')
                                ->required()
                                ->maxLength(255)
                                ->liveon('slug')
                                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                                ->placeholder('Contoh: Elektronik'),

                            Forms\Components\TextInput::make('slug')
                                ->label('Slug URL')
                                ->required()
                                ->unique(Category::class, 'slug', ignoreRecord: true)
                                ->hint('Akan otomatis terisi dari nama')
                                ->prefixIcon('heroicon-o-link'),
                        ]),

                    Forms\Components\Section::make('Ikon & Gambar')
                        ->schema([
                            Forms\Components\TextInput::make('icon')
                                ->label('Icon (Emoji)')
                                ->placeholder('🛍️')
                                ->maxLength(50)
                                ->prefixIcon('heroicon-o-face-smile'),

                            Forms\Components\FileUpload::make('image')
                                ->label('Gambar Kategori')
                                ->image()
                                ->directory('categories')
                                ->imageEditor()
                                ->imageResizeMode('cover')
                                ->imageCropAspectRatio('16:9')
                                ->imagePreviewHeight('150')
                                ->hint('Upload gambar untuk tampilan lebih menarik'),
                        ]),

                    Forms\Components\Section::make('SEO')
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')
                                ->label('Meta Title')
                                ->maxLength(60)
                                ->placeholder('Judul untuk SEO (max 60 karakter)'),

                            Forms\Components\Textarea::make('meta_description')
                                ->label('Meta Description')
                                ->rows(3)
                                ->maxLength(160)
                                ->placeholder('Deskripsi untuk SEO (max 160 karakter)'),
                        ]),
                ])->columnSpan(['lg' => 2]),

                // Right Column - Settings
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Pengaturan')
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Kategori Aktif')
                                ->default(true)
                                ->helperText('Kategori tidak aktif tidak akan ditampilkan di storefront'),

                            Forms\Components\Select::make('parent_id')
                                ->label('Kategori Induk')
                                ->relationship('parent', 'name', modifyQueryUsing: fn ($query) => $query->where('parent_id', null))
                                ->placeholder('Tidak ada (Kategori Utama)')
                                ->nullable(),
                        ]),

                    Forms\Components\Section::make('Deskripsi')
                        ->schema([
                            Forms\Components\Textarea::make('description')
                                ->label('Deskripsi Kategori')
                                ->rows(4)
                                ->placeholder('Tambahkan deskripsi untuk kategori ini...'),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular(false)
                    ->defaultImageUrl(fn () => 'https://via.placeholder.com/50'),

                Tables\Columns\TextColumn::make('icon')
                    ->label('')
                    ->size('lg')
                    ->formatStateUsing(fn ($state) => $state ?? '📦'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->color('gray')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Induk')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Produk')
                    ->counts('products')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->size('sm')
                    ->color('gray'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->boolean()
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),

                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Kategori Induk')
                    ->relationship('parent', 'name')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->dropdown(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->reorderable('sort')
            ->defaultSort('sort', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}