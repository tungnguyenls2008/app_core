<?php

namespace App\Exports;

use App\Models\BalanceChangeCallback;
use App\Models\CardIdToNumber;
use App\Models\MerchantBankAccount;
use App\Repositories\BalanceChangeCallbackRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CallbackExport implements FromView,ShouldAutoSize,WithStyles,WithColumnFormatting
{


    /**
     * @throws \Exception
     */
    public function view(): View
    {
        $search= request()->headers->get('referer');

        $search=explode('search?',$search);
        $balanceChangeCallbacks = BalanceChangeCallback::withoutTrashed()
            ->where(['deleted_at' => null,'merchant_id'=>Auth::user()->merchant_id]);


        if (isset($search[1])) {
            $search = explode('&', $search[1]);
            $search_params = [];
            foreach ($search as $param) {
                $param = explode('=', $param);
                $search_params[$param[0]] = urldecode($param[1]);
            }
            $balanceChangeCallbacks=querySearch($search_params,$balanceChangeCallbacks);

        }
        $balanceChangeCallbacks=$balanceChangeCallbacks->OrderBy('created_at', 'desc')->get();


        return view('balance_change_callbacks.export',['balanceChangeCallbacks'=>$balanceChangeCallbacks]);
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
            //'E' => NumberFormat::FORMAT_NUMBER,
            'F' => NumberFormat::FORMAT_NUMBER,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
