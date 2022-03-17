<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CorpCardExport implements FromView,ShouldAutoSize,WithStyles,WithColumnFormatting
{

    public function view(): View
    {
        $corpcards=\App\Models\CardIdToNumber::withoutTrashed()->where(['merchant_id'=>Auth::user()->merchant_id,'card_number'=>null])->where('card_id','not like','FAILED-%')->orderBy('created_at','desc')->get();
        return view('corp_cards.export',['corpCards'=>$corpcards]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the row as bold text.
            2    => ['font' => ['bold' => true]],

        ];
    }
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
