<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreSettingResource\Pages;
use App\Models\StoreSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StoreSettingResource extends Resource
{
    protected static ?string $model = StoreSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Toko';
    protected static ?string $modelLabel = 'Pengaturan Toko';
    protected static ?string $pluralModelLabel = 'Pengaturan Toko';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 99;
    protected static bool $shouldRegisterNavigation = false; // Hide from navigation, use custom pages

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pengaturan')
                    ->schema([
                        Forms\Components\TextInput::make('group')
                            ->label('Grup')
                            ->required()
                            ->helperText('Contoh: general, appearance, contact, social'),

                        Forms\Components\TextInput::make('key')
                            ->label('Kunci')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Nama unik untuk pengaturan ini'),

                        Forms\Components\TextInput::make('label')
                            ->label('Label')
                            ->required()
                            ->placeholder('Contoh: Nama Toko'),
                    ])->columns(3),

                Forms\Components\Section::make('Nilai Pengaturan')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Tipe Input')
                            ->options([
                                'text' => 'Text',
                                'textarea' => 'Textarea',
                                'number' => 'Number',
                                'boolean' => 'Toggle (Ya/Tidak)',
                                'image' => 'Gambar',
                                'file' => 'File',
                                'select' => 'Dropdown Select',
                                'color' => 'Color Picker',
                                'url' => 'URL',
                                'email' => 'Email',
                                'phone' => 'Telepon',
                            ])
                            ->default('text')
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('value', null)),

                        // Text Input
                        Forms\Components\TextInput::make('value')
                            ->label('Nilai')
                            ->hidden(fn (callable $get) => !in_array($get('type'), ['text', 'number', 'url', 'email', 'phone'])),

                        // Textarea
                        Forms\Components\Textarea::make('value_textarea')
                            ->label('Nilai')
                            ->rows(4)
                            ->hidden(fn (callable $get) => $get('type') !== 'textarea')
                            ->afterStateHydrated(fn ($component, $state, $record) =>
                                $component->state($record?->value)
                            ),

                        // Boolean Toggle
                        Forms\Components\Toggle::make('value_boolean')
                            ->label('Aktif')
                            ->hidden(fn (callable $get) => $get('type') !== 'boolean')
                            ->afterStateHydrated(fn ($component, $state, $record) =>
                                $component->state($record?->value === '1' || $record?->value === 'true')
                            ),

                        // Image Upload
                        Forms\Components\FileUpload::make('value_image')
                            ->label('Gambar')
                            ->image()
                            ->directory('settings')
                            ->hidden(fn (callable $get) => $get('type') !== 'image')
                            ->afterStateHydrated(fn ($component, $state, $record) =>
                                $component->state($record?->value)
                            ),

                        // Color Picker
                        Forms\Components\ColorPicker::make('value_color')
                            ->label('Warna')
                            ->hidden(fn (callable $get) => $get('type') !== 'color')
                            ->afterStateHydrated(fn ($component, $state, $record) =>
                                $component->state($record?->value)
                            ),

                        // Select
                        Forms\Components\KeyValue::make('value_options')
                            ->label('Opsi (Key-Value)')
                            ->hidden(fn (callable $get) => $get('type') !== 'select')
                            ->helperText('Tambahkan opsi untuk dropdown'),

                        // Hidden field for storing processed value
                        Forms\Components\Hidden::make('value')
                            ->afterStateHydrated(function (callable $get, $set, $record) {
                                if ($record) {
                                    $type = $record->type;
                                    $value = $record->value;

                                    $set('value', match($type) {
                                        'boolean' => $value === '1' || $value === 'true',
                                        default => $value,
                                    });
                                }
                            }),
                    ]),

                Forms\Components\Section::make('Deskripsi & Pengaturan Tambahan')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(2)
                            ->placeholder('Tambahkan bantuan atau deskripsi untuk pengaturan ini'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),

                        Forms\Components\TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->color('amber')
                    ->sortable(),

                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('key')
                    ->label('Kunci')
                    ->color('gray')
                    ->fontFamily('mono')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50)
                    ->color(fn ($state) => empty($state) ? 'danger' : 'gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort')
                    ->label('Sort')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Grup')
                    ->options([
                        'general' => 'General',
                        'appearance' => 'Appearance',
                        'contact' => 'Contact',
                        'social' => 'Social Media',
                        'seo' => 'SEO',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStoreSettings::route('/'),
            'edit' => Pages\EditStoreSetting::route('/{record}/edit'),
        ];
    }
}
