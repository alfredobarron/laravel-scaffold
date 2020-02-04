<?php

namespace App\Exports;

use App\Models\Quotes\Quotes;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class QuotesExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $quotes;

    public function __construct(array $quotes)
    {
        $this->quotes = $quotes;
    }

    public function array(): array
    {
        return $this->quotes;
    }

    public function headings(): array
    {
        return [
            'Fecha',
            'Lugar',
            'Cliente',
            'Telefono',
            'Artista',
            'Costo',
            'Vendedor',
            'Procedencia',
            'Estatus',
            'Comentarios',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }

}
