<?php

namespace App\Exports;

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

class BalanceChangeExport implements FromView,ShouldAutoSize,WithStyles,WithColumnFormatting
{


    public function view(): View
    {
        $search= request()->headers->get('referer');
        $search=explode('subMerchantBalances?',$search);
        $sub_merchant = Merchant::withoutTrashed()->where(['is_sub_merchant' => 1])->select(['merchant_id'])->get()->toArray();

        $balanceChangeCallbacks = BalanceChangeCallback::whereIn('merchant_id', $sub_merchant)
            //->orWhere(['account' => env('HQPAY_ACCOUNT')])
            ->orderBy('created_at', 'desc');
        $balanceChangesTransfers = BalanceChangeTransfer::whereIn('merchant_id', $sub_merchant)->orderBy('created_at', 'desc');
        if (isset($search[1])) {
            $search = explode('&', $search[1]);
            $search_params = [];
            foreach ($search as $param) {
                $param = explode('=', $param);
                $search_params[$param[0]] = urldecode($param[1]);
            }

            if (isset($search_params['merchant_id']) && $search_params['merchant_id'] != '') {
                $balanceChangeCallbacks->where(['merchant_id' => $search_params['merchant_id']]);
                $balanceChangesTransfers->where(['merchant_id' => $search_params['merchant_id']]);
            }
            if ((isset($search_params['create_from']) && $search_params['create_from'] != '') || (isset($search_params['create_to']) && $search_params['create_to'] != '')) {
                if (!isset($search_params['create_from'])) {
                    $search_params['create_from'] = '1970-01-01';
                }
                if (!isset($search_params['create_to'])) {
                    $search_params['create_to'] = '2100-12-31';
                }
                //$from = date('Y-m-d H:i:s', strtotime($search['create_from'] . ' 00:00:00'));
                $from = date($search_params['create_from']. ' 00:00:00') ;
                //$to = date('Y-m-d H:i:s', strtotime($search['create_to'] . ' 23:59:59'));
                $to = date($search_params['create_to']. ' 23:59:59');
                $balanceChangeCallbacks->whereBetween('created_at',[$from,$to]);
                $balanceChangesTransfers->whereBetween('created_at', [$from, $to]);

            }
            if (isset($search_params['tranId'])&& $search_params['tranId']!='') {
                $balanceChangeCallbacks->where(['tranId'=>$search_params['tranId']]);
                $balanceChangesTransfers->whereNotNull('deleted_at');
            }

            if (isset($search_params['requestId']) && $search_params['requestId'] != '') {
                $balanceChangesTransfers->where(['requestId' => $search_params['requestId']]);
                $balanceChangeCallbacks->where('tranId','not',null);
            }
            if (isset($search_params['order_number']) && $search_params['order_number'] != '') {
                $balanceChangesTransfers->where(['order_number' => $search_params['order_number']]);
                $balanceChangeCallbacks->whereNotNull('deleted_at');
            }
            if (isset($search_params['status']) && $search_params['status'] != '') {
                if ($search_params['status']=='increase'){
                    $balanceChangesTransfers->whereNotNull('deleted_at');
                }else if ($search_params['status']=='decrease'){
                    $balanceChangeCallbacks->whereNotNull('deleted_at');
                }
            }
        }
        $balanceChangeCallbacks=$balanceChangeCallbacks->get();
        $balanceChangesTransfers=$balanceChangesTransfers->get();
        $balanceChanges = $balanceChangeCallbacks->push(...$balanceChangesTransfers)->sortByDesc('created_at');
        return view('_backend.sub_merchant_balances.export',['subMerchantBalances'=>$balanceChanges]);

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
