<?php

namespace App\Filament\Resources\ReportedStoryResource\Pages;

use App\Filament\Resources\ReportedStoryResource;
use Filament\Resources\Pages\ListRecords;

class ListReportedStories extends ListRecords
{
    protected static string $resource = ReportedStoryResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
