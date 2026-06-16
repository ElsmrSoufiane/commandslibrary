<?php

namespace App\Filament\User\Resources\Emails\Tables;

use App\Filament\Exports\EmailExporter;
use App\Notifications\CustomHtmlNotification;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EmailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                IconColumn::make('active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('sendEmail')
                    ->label('Send Email')
                    ->icon('heroicon-o-envelope')
                    ->form([
                        Forms\Components\TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('html_content')
                            ->label('HTML Content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->action(function (array $data, $record) {
                        $record->notify(new CustomHtmlNotification(
                            $data['subject'],
                            $data['html_content']
                        ));

                        Notification::make()
                            ->title('Email sent successfully')
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Send HTML Email')
                    ->modalSubmitActionLabel('Send')
                    ->modalWidth('2xl'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()->exporter(EmailExporter::class),
                ]),
                Action::make('bulkSendEmail')
                    ->label('Send Bulk Email')
                    ->icon('heroicon-o-envelope')
                    ->accessSelectedRecords()
                    ->form([
                        Forms\Components\TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('html_content')
                            ->label('HTML Content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->action(function (array $data, $records) {
                        foreach ($records as $record) {
                            $record->notify(new CustomHtmlNotification(
                                $data['subject'],
                                $data['html_content']
                            ));
                        }

                        Notification::make()
                            ->title('Bulk email sent successfully')
                            ->body('Sent to '.count($records).' recipients')
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Send Bulk HTML Email')
                    ->modalSubmitActionLabel('Send to All Selected')
                    ->modalWidth('2xl')
                    ->deselectRecordsAfterCompletion(),
            ]);
    }
}
