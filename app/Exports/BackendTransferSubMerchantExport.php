<?php

namespace App\Exports;

use App\Models\BalanceChangeTransfer;
use App\Models\Merchant;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BackendTransferSubMerchantExport implements FromView,ShouldAutoSize,WithStyles,WithColumnFormatting
{


    public function view(): View
    {
        $search= request()->headers->get('referer');
        $search=explode('search?',$search);
        $sub_merchant=Merchant::withoutTrashed()->where(['is_sub_merchant'=>1])->select(['merchant_id'])->get()->toArray();
        $balanceChangeTransfers = BalanceChangeTransfer::where(['deleted_at' => null])->whereIn('merchant_id',$sub_merchant)
            ->where('function','!=','{}')
            ->OrderBy('created_at', 'desc');
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
        return view('_backend.balance_change_transfers_sub_merchants.export',['balanceChangeTransfers'=>$balanceChangeTransfers]);

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
//            'E' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
