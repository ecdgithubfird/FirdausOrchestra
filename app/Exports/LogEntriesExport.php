<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithMapping;


class LogEntriesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $entries;

    public function __construct($entries)
    {
        $this->entries = $entries;
    }

    public function collection()
    {
        return $this->entries;
    }

    public function headings(): array
    {
        return [
            'ENV',
            'Level',
            'Time',
            'Header',
        ];
    }
    /*
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                ]);
                
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(15);
            },
        ];
    }*/
    
    public function map($entry): array
    {
        return [
            $entry->env,
            $entry->level,
            $entry->datetime->format('H:i:s'),
            $entry->header,
        ];
    }
}