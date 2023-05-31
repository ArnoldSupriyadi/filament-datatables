<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use App\Models\Section;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->autofocus()
                ->unique(),

                TextInput::make('email')
                    ->required()
                    ->unique(),

                TextInput::make('phone_number')
                    ->required()
                    ->tel()
                    ->unique(),

                TextInput::make('address')
                    ->required(),

                Select::make('class_id')
                    ->relationship('class', 'name')
                    ->reactive(),

                Select::make('section_id')
                ->label('Select Section')
                ->options(function(callable $get){
                    $classId = $get('class_id');

                    if($classId){
                        return Section::where('class_id',$classId)->pluck('name','id')->toArray();
                    }
                }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->sortable()
                ->searchable(),

                TextColumn::make('email')
                ->sortable()
                ->searchable()
                ->toggleable(),

                TextColumn::make('phone_number')
                ->sortable()
                ->searchable()
                ->toggleable(),

                TextColumn::make('address')
                ->sortable()
                ->searchable()
                ->toggleable()
                ->wrap(),

                TextColumn::make('class.name')
                ->sortable()
                ->searchable(),

                TextColumn::make('section.name')
                ->sortable()
                ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }    
}
