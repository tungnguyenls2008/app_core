<?php

namespace App\Exports;

use App\Models\BalanceChangeTransfer;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransferExport implements FromView,ShouldAutoSize,WithStyles,WithColumnFormatting
{


    public function view(): View
    {
        $search= request()->headers->get('referer');
        $search=explode('search?',$search);
        $balanceChangeTransfers = BalanceChangeTransfer::withoutTrashed()->where(['deleted_at' => null,'merchant_id'=>Auth::user()->merchant_id])->OrderBy('created_at', 'desc');
        if (isset($search[1])) {
            $search = explode('&', $search[1]);
            $search_params = [];
            foreach ($search as $param) {
                $param = explode('=', $param);
                $search_params[$param[0]] = urldecode($param[1]);
            }

            $balanceChangeTransfers=querySearch($search_params,$balanceChangeTransfers);
        }
        $balanceChangeTransfers=$balanceChangeTransfers->get();
        return view('balance_change_transfers.export',['balanceChangeTransfers'=>$balanceChangeTransfers]);

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
//            'C' => NumberFormat::FORMAT_NUMBER,
//            'D' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
