<?php

namespace App\Filament\Resources\Siswas;

use App\Filament\Resources\Siswas\SiswaResource\Pages;
use App\Models\Siswa;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

// IMPORT ACTION DI SINI DENGAN BENAR (Tanpa konflik)
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Data Siswa';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Kolom Upload Foto (Bentuk Bulat/Avatar di atas)
                FileUpload::make('foto')
                    ->label('Foto Siswa')
                    ->image()
                    ->avatar()
                    ->circleCropper()
                    ->disk('public')
                    ->directory('siswa-foto')
                    ->columnSpanFull(),

                TextInput::make('nis')
                    ->label('NIS')
                    ->required()
                    ->maxLength(255),

                TextInput::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->maxLength(255),

                DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir'),

                Textarea::make('alamat')
                    ->label('Alamat')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),

                TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),

                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable(),

                TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir'),

                TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}