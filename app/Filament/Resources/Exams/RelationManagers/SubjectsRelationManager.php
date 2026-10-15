<?php

namespace App\Filament\Resources\Exams\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use PhpParser\Node\Stmt\Label;

class SubjectsRelationManager extends RelationManager
{
    protected static string $relationship = 'subjects';

    protected static ?string $title = 'Pelajaran yang Diujiankan';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Pelajaran')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label('Tersedia')
                    ->boolean(),
                TextColumn::make('pivot.qyt')
                    ->label('Jlh. Soal')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Tambah')
                    ->color('info')
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action) => [
                        $action->getRecordSelect(),
                        TextInput::make('qyt')
                            ->label('Jumlah Soal')
                            ->required()
                            ->numeric()
                            ->default(10)
                            ->minValue(1),
                    ]),
            ])
            ->recordActions([
                DetachAction::make()
                    ->Label('Singkirkan'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
