<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PesertaDidikTemplateExport implements FromView, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */   
    public function view(): View{
        return view('data_peserta_didik.template');
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,            
            'H' => NumberFormat::FORMAT_TEXT,            
            'K' => NumberFormat::FORMAT_TEXT,            
            'U' => NumberFormat::FORMAT_TEXT,            
            'Y' => NumberFormat::FORMAT_TEXT,            
        ];
    }
}
