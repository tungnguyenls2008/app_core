<?php

namespace App\Exports;

use App\Models\_Backend\OperatorLog;
use App\Models\BalanceChangeCallback;
use App\Models\BalanceChangeTransfer;
use App\Models\CardIdToNumber;
use App\Models\Merchant;
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

class OperatorLogExport implements FromView,ShouldAutoSize,WithStyles,WithColumnFormatting
{


    public function view(): View
    {
        $search= request()->headers->get('referer');
        $search=explode('operatorLogs?',$search);
        $operatorLogs = OperatorLog::Orderby('created_at', 'desc');

        if (isset($search[1])) {
            $search = explode('&', $search[1]);
            $search_params = [];
            foreach ($search as $param) {
                $param = explode('=', $param);
                $search_params[$param[0]] = urldecode($param[1]);
            }
            $operatorLogs=querySearch($search_params,$operatorLogs);
        }
        $operatorLogs = $operatorLogs->get();

        return view('_backend.operator_logs.export',['operatorLogs'=>$operatorLogs]);

    }

    public function styles(Worksheet $sheet)
    {

        return [
            // Style the row as bold text.
            1    => ['font' => ['bold' => true]],

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
