<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DataGuruTemplateExport implements FromView, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View{
        return view('data-guru.template');
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT,            
            'G' => NumberFormat::FORMAT_TEXT,            
            'S' => NumberFormat::FORMAT_TEXT,            
            'T' => NumberFormat::FORMAT_TEXT,            
            'AJ' => NumberFormat::FORMAT_TEXT,            
            // 'AJ' => NumberFormat::FORMAT_TEXT,            
        ];
    }
}
