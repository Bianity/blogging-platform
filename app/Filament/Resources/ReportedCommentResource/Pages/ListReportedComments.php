<?php

namespace App\Filament\Resources\ReportedCommentResource\Pages;

use App\Filament\Resources\ReportedCommentResource;
use Filament\Resources\Pages\ListRecords;

class ListReportedComments extends ListRecords
{
    protected static string $resource = ReportedCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
