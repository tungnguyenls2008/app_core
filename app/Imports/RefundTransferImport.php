<?php

namespace App\Imports;

use App\Http\Controllers\_Backend\BalanceChangeTransferSubMerchantController;
use App\Models\_Backend\OperatorLog;
use App\Models\_Backend\SubMerchantBalance;
use App\Models\BalanceChangeCallback;
use App\Models\BalanceChangeTransfer;
use App\Models\CardIdToNumber;
use App\Models\CollectOnBehalf;
use App\Models\CorpCard;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Row;


class RefundTransferImport implements ToModel, WithHeadingRow, WithUpserts
{


    public function model(array $row)
    {
        $requestId = $row['ma_yeu_cau'];
        $check_transfer = CollectOnBehalf::withoutTrashed()->where(['requestId' => $requestId])->where(['code'=>1])->first();

        if ($check_transfer != null) {

            $balance = SubMerchantBalance::withoutTrashed()->where(['merchant_id' => $check_transfer->merchant_id])->first();
            if ($balance != null) {
                $balance->amount += ($check_transfer->amount + $check_transfer->merchant_fee);
                $balance->save();
            }
            BalanceChangeCallback::create([
                'function' => '{}',
                'request' => '{}',
                'response' => '{}',
                'amount' => $check_transfer->amount + $check_transfer->merchant_fee,
                'merchant_fee' => 0,
                'tranId' => $row['ma_yeu_cau'] . ' (hoàn tiền)',
                'description' => 'Hoàn tiền',
                'merchant_id' => $check_transfer->merchant_id,
                'current_balance' => $balance->amount]);
            OperatorLog::create([
                'operator_id' => Auth::guard('backend')->id(), 'content' => 'Tăng số dư hiện có của HQPAY Merchant '
                    . $check_transfer->merchant_id
                    . ' thêm ' . number_format($check_transfer->amount + $check_transfer->merchant_fee)
                    . 'đ (hoàn tiền), mã đối chiếu: ' . $row['ma_yeu_cau'] . '(Hoàn tiền)'
                    . ', số dư hiện có: ' . number_format($balance->amount),
                'function' => json_encode(
                    [
                        'merchant_id' => $check_transfer->merchant_id,
                        'amount' => $check_transfer->amount + $check_transfer->merchant_fee,
                        'ft_code' => $row['ma_yeu_cau'] . '(Hoàn tiền)',
                        'status' => 'increase',
                        'balance' => $balance->amount
                    ])
            ]);
            //$to_update = [
                //'merchant_fee' => 0,
                //'code' => 300,
                //'message' => 'hoàn tiền'
            //];
            //$check_transfer->update($to_update);

        } else return null;
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function uniqueBy()
    {
        return 'ma_yeu_cau';
    }

}
